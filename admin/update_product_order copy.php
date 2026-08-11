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
            'message' => 'Invalid request data.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | EXTRACT DATA
    |--------------------------------------------------------------------------
    */

    $products = $data['products'] ?? [];

    $category = (int)($data['category'] ?? 0);

    $subcategory = (int)($data['subcategory'] ?? 0);

    $search = trim($data['search'] ?? '');


    if (empty($products)) {

        echo json_encode([
            'success' => false,
            'message' => 'No products received.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | GET THE CURRENT FILTERED PRODUCT SET
    |--------------------------------------------------------------------------
    */

    $where = [];

    $params = [];


    /*
    |--------------------------------------------------------------------------
    | CATEGORY FILTER
    |--------------------------------------------------------------------------
    */

    if ($category > 0) {

        $where[] = "category_id = ?";

        $params[] = $category;
    }


    /*
    |--------------------------------------------------------------------------
    | SUBCATEGORY FILTER
    |--------------------------------------------------------------------------
    */

    if ($subcategory > 0) {

        $where[] = "subcategory_id = ?";

        $params[] = $subcategory;
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH FILTER
    |--------------------------------------------------------------------------
    */

    if ($search !== '') {

        if (is_numeric($search)) {

            $where[] = "
                (
                    id = ?
                    OR name LIKE ?
                    OR sku LIKE ?
                    OR slug LIKE ?
                )
            ";

            $params[] = (int)$search;
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";

        } else {

            $where[] = "
                (
                    name LIKE ?
                    OR sku LIKE ?
                    OR slug LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
    }


    /*
    |--------------------------------------------------------------------------
    | BUILD WHERE
    |--------------------------------------------------------------------------
    */

    $whereSql = '';

    if (!empty($where)) {

        $whereSql = 'WHERE ' . implode(' AND ', $where);

    }


    /*
    |--------------------------------------------------------------------------
    | FETCH ALL PRODUCTS MATCHING CURRENT FILTER
    |--------------------------------------------------------------------------
    |
    | We intentionally do NOT use the current page here.
    |
    | The database needs the complete filtered set so that products
    | outside the current pagination page keep their relative order.
    |
    */

    $stmt = $pdo->prepare("
        SELECT id, display_order
        FROM products
        {$whereSql}
        ORDER BY display_order ASC, id ASC
    ");

    $stmt->execute($params);

    $allProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);


    /*
    |--------------------------------------------------------------------------
    | CURRENT DRAGGED ORDER
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
    | VALIDATE DRAGGED PRODUCTS
    |--------------------------------------------------------------------------
    */

    if (empty($draggedIds)) {

        echo json_encode([
            'success' => false,
            'message' => 'Invalid product IDs.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE ORDER MAP
    |--------------------------------------------------------------------------
    */

    $existingIds = [];

    foreach ($allProducts as $product) {

        $existingIds[] = (int)$product['id'];

    }


    /*
    |--------------------------------------------------------------------------
    | ONLY ALLOW PRODUCTS FROM CURRENT FILTER
    |--------------------------------------------------------------------------
    */

    $draggedIds = array_values(
        array_intersect(
            $draggedIds,
            $existingIds
        )
    );


    if (empty($draggedIds)) {

        echo json_encode([
            'success' => false,
            'message' => 'Products do not match the current filter.'
        ]);

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | REBUILD ORDER
    |--------------------------------------------------------------------------
    |
    | Start with the products in their existing database order.
    |
    | Then replace their positions with the new dragged order.
    |
    */

    $finalOrder = [];

    $draggedLookup = array_flip($draggedIds);

    $dragIndex = 0;


    foreach ($existingIds as $id) {

        if (isset($draggedLookup[$id])) {

            $finalOrder[] = $draggedIds[$dragIndex];

            $dragIndex++;

        } else {

            $finalOrder[] = $id;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SAVE ORDER
    |--------------------------------------------------------------------------
    */

    $pdo->beginTransaction();


    $updateStmt = $pdo->prepare("
        UPDATE products
        SET display_order = ?
        WHERE id = ?
    ");


    foreach ($finalOrder as $index => $productId) {

        $updateStmt->execute([
            $index + 1,
            $productId
        ]);

    }


    $pdo->commit();


    /*
    |--------------------------------------------------------------------------
    | SUCCESS
    |--------------------------------------------------------------------------
    */

    echo json_encode([
        'success' => true,
        'message' => 'Product order saved successfully.'
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