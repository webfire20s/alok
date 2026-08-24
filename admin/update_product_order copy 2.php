<?php

require 'includes/auth.php';
require '../includes/db.php';

header('Content-Type: application/json');

try {

    /*
    |--------------------------------------------------------------------------
    | READ REQUEST
    |--------------------------------------------------------------------------
    */

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    if (!is_array($data)) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid request.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | REQUEST VALUES
    |--------------------------------------------------------------------------
    */

    $products = $data['products'] ?? [];

    $category = (int)($data['category'] ?? 0);

    $subcategory = (int)($data['subcategory'] ?? 0);

    $search = trim($data['search'] ?? '');

    $page = max(
        1,
        (int)($data['page'] ?? 1)
    );


    /*
    |--------------------------------------------------------------------------
    | PRODUCTS PER PAGE
    |--------------------------------------------------------------------------
    |
    | Must match products.php
    |
    */

    $perPage = 50;


    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (!is_array($products) || empty($products)) {

        echo json_encode([
            'success' => false,
            'message' => 'No products received.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY REQUIRED
    |--------------------------------------------------------------------------
    |
    | Products are sorted within their category.
    |
    */

    if ($category <= 0) {

        echo json_encode([
            'success' => false,
            'message' => 'Please select a category before sorting products.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH SORTING NOT ALLOWED
    |--------------------------------------------------------------------------
    |
    | A search result is only a subset of the category.
    | Reordering it would not provide enough information to safely
    | determine the complete category order.
    |
    */

    if ($search !== '') {

        echo json_encode([
            'success' => false,
            'message' => 'Please clear the search before sorting products.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD FILTER
    |--------------------------------------------------------------------------
    */

    $where = [
        "products.category_id = ?"
    ];

    $params = [
        $category
    ];


    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORY
    |--------------------------------------------------------------------------
    */

    if ($subcategory > 0) {

        $where[] = "products.subcategory_id = ?";

        $params[] = $subcategory;
    }


    $whereSql = 'WHERE ' . implode(
        ' AND ',
        $where
    );


    /*
    |--------------------------------------------------------------------------
    | GET COMPLETE SORTING LIST
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        SELECT
            products.id,
            products.category_id,
            products.subcategory_id,
            products.display_order
        FROM products
        {$whereSql}
        ORDER BY
            products.display_order ASC,
            products.id ASC
    ");

    $stmt->execute($params);

    $allProducts = $stmt->fetchAll(
        PDO::FETCH_ASSOC
    );


    /*
    |--------------------------------------------------------------------------
    | CHECK PRODUCTS
    |--------------------------------------------------------------------------
    */

    if (empty($allProducts)) {

        echo json_encode([
            'success' => false,
            'message' => 'No products found.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL PRODUCTS / PAGES
    |--------------------------------------------------------------------------
    */

    $totalProducts = count($allProducts);

    $totalPages = max(
        1,
        (int)ceil(
            $totalProducts / $perPage
        )
    );


    if ($page > $totalPages) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid page. Please refresh the page.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CURRENT PAGE
    |--------------------------------------------------------------------------
    */

    $offset = ($page - 1) * $perPage;

    $currentPageProducts = array_slice(
        $allProducts,
        $offset,
        $perPage
    );


    /*
    |--------------------------------------------------------------------------
    | CURRENT PAGE IDS
    |--------------------------------------------------------------------------
    */

    $currentPageIds = [];

    foreach ($currentPageProducts as $product) {

        $currentPageIds[] = (int)$product['id'];
    }


    /*
    |--------------------------------------------------------------------------
    | DRAGGED IDS
    |--------------------------------------------------------------------------
    */

    $draggedIds = [];

    foreach ($products as $product) {

        $id = (int)($product['id'] ?? 0);

        if ($id > 0) {

            $draggedIds[] = $id;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE DUPLICATES
    |--------------------------------------------------------------------------
    */

    $draggedIds = array_values(
        array_unique($draggedIds)
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDATE EXACT PAGE
    |--------------------------------------------------------------------------
    |
    | The browser must send exactly the products currently displayed.
    |
    */

    $expectedIds = $currentPageIds;

    $receivedIds = $draggedIds;

    sort($expectedIds);

    sort($receivedIds);


    if ($expectedIds !== $receivedIds) {

        echo json_encode([
            'success' => false,
            'message' => 'The product list has changed. Please refresh the page and try again.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | TEMPORARY VALUES
    |--------------------------------------------------------------------------
    |
    | We first move the current page products to temporary negative
    | values. This prevents any accidental conflicts while assigning
    | the final positions.
    |
    */

    $tempStmt = $pdo->prepare("
        UPDATE products
        SET display_order = ?
        WHERE id = ?
          AND category_id = ?
    ");


    foreach ($draggedIds as $index => $productId) {

        $temporaryOrder = -($index + 1);

        $tempStmt->execute([
            $temporaryOrder,
            $productId,
            $category
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | FINAL ORDER
    |--------------------------------------------------------------------------
    */

    /*
     * IMPORTANT:
     *
     * The page starts at $offset.
     *
     * Therefore the first product on page 1 gets order 1.
     * The first product on page 2 gets order 51.
     * The first product on page 3 gets order 101.
     *
     */

    $updateStmt = $pdo->prepare("
        UPDATE products
        SET display_order = ?
        WHERE id = ?
          AND category_id = ?
    ");


    foreach ($draggedIds as $index => $productId) {

        $newOrder = $offset + $index + 1;

        $updateStmt->execute([
            $newOrder,
            $productId,
            $category
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | COMMIT
    |--------------------------------------------------------------------------
    */

    $pdo->commit();


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'message' => 'Product order saved successfully.',
        'page' => $page
    ]);

} catch (Throwable $e) {

    if ($pdo->inTransaction()) {

        $pdo->rollBack();
    }

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Unable to save product order.'
    ]);
}