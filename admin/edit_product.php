<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| GET PRODUCT
|--------------------------------------------------------------------------
*/

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM products
    WHERE id = ?
");

$stmt->execute([$id]);

$product = $stmt->fetch();

if(!$product){

    die("Product not found");

}

/*
|--------------------------------------------------------------------------
| FETCH CATEGORIES
|--------------------------------------------------------------------------
*/

$categories = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY name ASC
")->fetchAll();

/*
|--------------------------------------------------------------------------
| UPDATE PRODUCT
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $categoryId =
        $_POST['category_id'];

    $name =
        trim($_POST['name']);

    $slug =
        trim($_POST['slug']);

    $sku =
        trim($_POST['sku']);

    $price =
        $_POST['price'];

    $stock =
        $_POST['stock'];

    $description =
        $_POST['description'];

    $shortDescription =
        $_POST['short_description'];

    $gstPercent =
        $_POST['gst_percent'];

    $sellingType =
        $_POST['selling_type'];

    $piecesPerBox =
        $_POST['pieces_per_box'];

    $minOrderQty =
        $_POST['min_order_qty'];
    
    $weight = 
        $_POST['weight'];
    $dimensions = 
        trim($_POST['dimensions']);
    $status = 
        $_POST['status'];

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    $imageName = $product['image'];

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time() . '_' .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../storage/media/" . $fileName
        );

        $imageName =
            "storage/media/" . $fileName;
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE QUERY
    |--------------------------------------------------------------------------
    */

    $updateStmt = $pdo->prepare("
        UPDATE products
        SET
            category_id = ?,
            name = ?,
            slug = ?,
            sku = ?,
            short_description = ?,
            description = ?,
            price = ?,
            stock = ?,
            image = ?,
            weight = ?,
            dimensions = ?,
            status = ?,
            gst_percent = ?,
            selling_type = ?,
            pieces_per_box = ?,
            min_order_qty = ?
        WHERE id = ?
    ");

    $updateStmt->execute([
        $categoryId,
        $name,
        $slug,
        $sku,
        $shortDescription,
        $description,
        $price,
        $stock,
        $imageName,
        $weight,
        $dimensions,
        $status,
        $gstPercent,
        $sellingType,
        $piecesPerBox,
        $minOrderQty,
        $id
    ]);

    header("Location: products.php");
    exit;
}

?>

<h2 class="mb-4">
    Edit Product
</h2>

<div class="card-box p-4">

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Category</label>

                    <select
                        name="category_id"
                        class="form-control"
                        required
                    >

                        <?php foreach($categories as $category): ?>

                            <option
                                value="<?= $category['id'] ?>"
                                <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>
                            >

                                <?= htmlspecialchars($category['name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </div>

            <div class="col-md-6">

                <div class="form-group">

                    <label>SKU</label>

                    <input
                        type="text"
                        name="sku"
                        class="form-control"
                        value="<?= htmlspecialchars($product['sku']) ?>"
                    >

                </div>

            </div>

        </div>

        <div class="form-group">

            <label>Product Name</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= htmlspecialchars($product['name']) ?>"
                required
            >

        </div>

        <div class="form-group">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control"
                value="<?= htmlspecialchars($product['slug']) ?>"
                required
            >

        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="form-group">

                    <label>Price</label>

                    <input
                        type="number"
                        step="0.01"
                        name="price"
                        class="form-control"
                        value="<?= $product['price'] ?>"
                        required
                    >

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <label>GST %</label>

                    <input
                        type="number"
                        step="0.01"
                        name="gst_percent"
                        class="form-control"
                        value="<?= $product['gst_percent'] ?>"
                    >

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <label>Stock</label>

                    <input
                        type="number"
                        name="stock"
                        class="form-control"
                        value="<?= $product['stock'] ?>"
                    >

                </div>

            </div>

        </div>
        <div class="row">

            <div class="col-md-4">

                <div class="form-group">

                    <label>Weight (kg)</label>

                    <input
                        type="number"
                        step="0.01"
                        name="weight"
                        class="form-control"
                        value="<?= $product['weight'] ?>"
                    >

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <label>Dimensions</label>

                    <input
                        type="text"
                        name="dimensions"
                        class="form-control"
                        value="<?= htmlspecialchars($product['dimensions']) ?>"
                        placeholder="10x20x30 cm"
                    >

                </div>

            </div>

        </div>

        <div class="row">

            <div class="col-md-4">

                <div class="form-group">

                    <label>Selling Type</label>

                    <select
                        name="selling_type"
                        class="form-control"
                    >

                        <option
                            value="piece"
                            <?= $product['selling_type'] == 'piece' ? 'selected' : '' ?>
                        >
                            Piece Only
                        </option>

                        <option
                            value="box"
                            <?= $product['selling_type'] == 'box' ? 'selected' : '' ?>
                        >
                            Box Only
                        </option>

                        <option
                            value="both"
                            <?= $product['selling_type'] == 'both' ? 'selected' : '' ?>
                        >
                            Both
                        </option>

                    </select>

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <label>Pieces Per Box</label>

                    <input
                        type="number"
                        name="pieces_per_box"
                        class="form-control"
                        value="<?= $product['pieces_per_box'] ?>"
                    >

                </div>

            </div>

            <div class="col-md-4">

                <div class="form-group">

                    <label>Minimum Order Qty</label>

                    <input
                        type="number"
                        name="min_order_qty"
                        class="form-control"
                        value="<?= $product['min_order_qty'] ?>"
                    >

                </div>

            </div>

        </div>
        <div class="row">

            <div class="col-md-6">

                <div class="form-group">

                    <label>Status</label>

                    <select
                        name="status"
                        class="form-control"
                    >

                        <option
                            value="active"
                            <?= $product['status'] == 'active' ? 'selected' : '' ?>
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            <?= $product['status'] == 'inactive' ? 'selected' : '' ?>
                        >
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

        </div>

        <div class="form-group">

            <label>Short Description</label>

            <textarea
                name="short_description"
                rows="3"
                class="form-control"
            ><?= htmlspecialchars($product['short_description']) ?></textarea>

        </div>

        <div class="form-group">

            <label>Description</label>

            <textarea
                name="description"
                rows="6"
                class="form-control"
            ><?= htmlspecialchars($product['description']) ?></textarea>

        </div>

        <div class="form-group">

            <label>Current Image</label>

            <br>

            <img
                src="../<?= htmlspecialchars($product['image']) ?>"
                style="
                    width:120px;
                    border-radius:8px;
                "
            >

        </div>

        <div class="form-group">

            <label>Replace Image</label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <button class="btn btn-dark">

            Update Product

        </button>

    </form>

</div>

</div>

</body>
</html>