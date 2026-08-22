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

    $rawData = file_get_contents("php://input");

    $data = json_decode($rawData, true);

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

    if ($search !== '') {

        echo json_encode([
            'success' => false,
            'message' => 'Please clear the search before sorting products.'
        ]);

        exit;
    }

    $page = max(
        1,
        (int)($data['page'] ?? 1)
    );


    /*
    |--------------------------------------------------------------------------
    | IMPORTANT
    |--------------------------------------------------------------------------
    | Must match products.php
    */

    $perPage = 50;


    /*
    |--------------------------------------------------------------------------
    | VALIDATE PRODUCT LIST
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
    | CATEGORY IS REQUIRED FOR SAFE SORTING
    |--------------------------------------------------------------------------
    |
    | display_order belongs to the category ordering.
    |
    | If "All Categories" is selected, products from different categories
    | are mixed in the same draggable list and their display_order values
    | cannot safely be exchanged.
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
    | BUILD FILTERS
    |--------------------------------------------------------------------------
    */

    $where = [];

    $params = [];


    /*
    | CATEGORY
    */

    $where[] = "products.category_id = ?";

    $params[] = $category;


    /*
    | SUBCATEGORY
    */

    if ($subcategory > 0) {

        $where[] = "products.subcategory_id = ?";

        $params[] = $subcategory;
    }


    /*
    | SEARCH
    |
    | Search is intentionally included here so the visible page is
    | calculated exactly from the same filtering rules as products.php.
    */

    if ($search !== '') {

        if (is_numeric($search)) {

            $where[] = "
                (
                    products.id = ?
                    OR products.name LIKE ?
                    OR products.sku LIKE ?
                    OR products.slug LIKE ?
                )
            ";

            $params[] = (int)$search;
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";

        } else {

            $where[] = "
                (
                    products.name LIKE ?
                    OR products.sku LIKE ?
                    OR products.slug LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
    }


    $whereSql = 'WHERE ' . implode(' AND ', $where);


    /*
    |--------------------------------------------------------------------------
    | GET COMPLETE SORTING SCOPE
    |--------------------------------------------------------------------------
    |
    | No LIMIT here.
    |
    | We need the complete filtered list to determine the exact
    | display_order positions occupied by the current page.
    |
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

    $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | CHECK WHETHER PRODUCTS EXIST
    |--------------------------------------------------------------------------
    */

    if (empty($allProducts)) {

        echo json_encode([
            'success' => false,
            'message' => 'No products found for the selected filters.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | TOTAL PAGES
    |--------------------------------------------------------------------------
    */

    $totalProducts = count($allProducts);

    $totalPages = max(
        1,
        (int)ceil($totalProducts / $perPage)
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDATE PAGE
    |--------------------------------------------------------------------------
    */

    if ($page > $totalPages) {

        echo json_encode([
            'success' => false,
            'message' => 'The page has changed. Please refresh the page and try again.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | GET CURRENT PAGE
    |--------------------------------------------------------------------------
    */

    $pageOffset = ($page - 1) * $perPage;

    $currentPageProducts = array_slice(
        $allProducts,
        $pageOffset,
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
    | READ DRAGGED IDS
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
    | REMOVE DUPLICATE IDS
    |--------------------------------------------------------------------------
    */

    $draggedIds = array_values(
        array_unique($draggedIds)
    );


    /*
    |--------------------------------------------------------------------------
    | VALIDATE EXACT PAGE CONTENT
    |--------------------------------------------------------------------------
    */

    $expectedIds = $currentPageIds;

    $receivedIds = $draggedIds;

    sort($expectedIds);
    sort($receivedIds);

    if ($expectedIds !== $receivedIds) {

        echo json_encode([
            'success' => false,
            'message' => 'The displayed product list has changed. Please refresh the page and try again.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD CURRENT PAGE ORDER VALUES
    |--------------------------------------------------------------------------
    */

    $pageOrders = [];

    foreach ($currentPageProducts as $product) {

        $pageOrders[] = (int)$product['display_order'];
    }


    /*
    |--------------------------------------------------------------------------
    | PRESERVE ORDER POSITIONS
    |--------------------------------------------------------------------------
    */

    /*
     * The browser gives us the desired product sequence.
     *
     * We assign the existing display_order values in that sequence.
     *
     * Example:
     *
     * Existing:
     * Product A -> 10
     * Product B -> 20
     * Product C -> 30
     *
     * Dragged:
     * Product C
     * Product A
     * Product B
     *
     * Result:
     * Product C -> 10
     * Product A -> 20
     * Product B -> 30
     *
     * No arbitrary values are generated.
     */


    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */

    $pdo->beginTransaction();


    /*
    |--------------------------------------------------------------------------
    | UPDATE ORDER
    |--------------------------------------------------------------------------
    */

    $updateStmt = $pdo->prepare("
        UPDATE products
        SET display_order = ?
        WHERE id = ?
          AND category_id = ?
    ");


    foreach ($draggedIds as $index => $productId) {

        if (!isset($pageOrders[$index])) {

            throw new RuntimeException(
                'Invalid product order received.'
            );
        }

        $updateStmt->execute([
            $pageOrders[$index],
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