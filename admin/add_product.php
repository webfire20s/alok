<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

$categories = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY name ASC
")->fetchAll();

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $categoryId = $_POST['category_id'];

    $name = trim($_POST['name']);

    $slug = trim($_POST['slug']);

    $sku = trim($_POST['sku']);

    $price = $_POST['price'];

    $salePrice = !empty($_POST['sale_price'])
        ? $_POST['sale_price']
        : null;

    $stock = $_POST['stock'];

    $gstPercent = $_POST['gst_percent'];

    $sellingType = $_POST['selling_type'];

    $piecesPerBox = !empty($_POST['pieces_per_box'])
        ? $_POST['pieces_per_box']
        : null;

    $minOrderQty = $_POST['min_order_qty'];

    $featured = isset($_POST['featured'])
        ? 1
        : 0;

    $shortDescription =
        trim($_POST['short_description']);

    $description =
        trim($_POST['description']);

    /*
    /*
|--------------------------------------------------------------------------
| IMAGE UPLOAD
|--------------------------------------------------------------------------
*/

    $imageName = '';

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time() . '_' .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../storage/media/" . $fileName
        );

        // STORE FULL PATH IN DATABASE
        $imageName = "storage/media/" . $fileName;
    }
    /*
    |--------------------------------------------------------------------------
    | INSERT PRODUCT
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO products (

            category_id,
            name,
            slug,
            sku,
            short_description,
            description,
            price,
            sale_price,
            stock,
            image,
            gst_percent,
            selling_type,
            pieces_per_box,
            min_order_qty,
            featured

        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([

        $categoryId,
        $name,
        $slug,
        $sku,
        $shortDescription,
        $description,
        $price,
        $salePrice,
        $stock,
        $imageName,
        $gstPercent,
        $sellingType,
        $piecesPerBox,
        $minOrderQty,
        $featured

    ]);

    header("Location: products.php");
    exit;
}

?>

<div class="container-fluid py-4">

    <div class="mb-4">

        <h2 class="mb-1">
            Add Product
        </h2>

        <p class="text-muted mb-0">
            Create a new ecommerce product
        </p>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body p-4">

            <form
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="row">

                    <!-- LEFT -->

                    <div class="col-lg-8">

                        <!-- CATEGORY -->

                        <div class="form-group mb-4">

                            <label class="font-weight-bold">
                                Category
                            </label>

                            <select
                                name="category_id"
                                class="form-control"
                                required
                            >

                                <option value="">
                                    Select Category
                                </option>

                                <?php foreach($categories as $category): ?>

                                    <option value="<?= $category['id'] ?>">

                                        <?= htmlspecialchars($category['name']) ?>

                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <!-- PRODUCT NAME -->

                        <div class="form-group mb-4">

                            <label class="font-weight-bold">
                                Product Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="productName"
                                class="form-control"
                                required
                            >

                        </div>

                        <!-- SLUG -->

                        <div class="form-group mb-4">

                            <label class="font-weight-bold">
                                Slug
                            </label>

                            <input
                                type="text"
                                name="slug"
                                id="slugField"
                                class="form-control"
                                required
                            >

                        </div>

                        <!-- SHORT DESCRIPTION -->

                        <div class="form-group mb-4">

                            <label class="font-weight-bold">
                                Short Description
                            </label>

                            <textarea
                                name="short_description"
                                rows="3"
                                class="form-control"
                            ></textarea>

                        </div>

                        <!-- FULL DESCRIPTION -->

                        <div class="form-group mb-4">

                            <label class="font-weight-bold">
                                Full Description
                            </label>

                            <textarea
                                name="description"
                                rows="8"
                                class="form-control"
                            ></textarea>

                        </div>

                    </div>

                    <!-- RIGHT -->

                    <div class="col-lg-4">

                        <div class="border rounded p-3 bg-light">

                            <!-- IMAGE -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Product Image
                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control"
                                    required
                                >

                            </div>

                            <!-- SKU -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    SKU
                                </label>

                                <input
                                    type="text"
                                    name="sku"
                                    class="form-control"
                                >

                            </div>

                            <!-- PRICE -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Price
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="price"
                                    class="form-control"
                                    required
                                >

                            </div>

                            <!-- SALE PRICE -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Sale Price
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="sale_price"
                                    class="form-control"
                                >

                            </div>

                            <!-- STOCK -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Stock
                                </label>

                                <input
                                    type="number"
                                    name="stock"
                                    class="form-control"
                                    required
                                >

                            </div>

                            <!-- GST -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    GST %
                                </label>

                                <input
                                    type="number"
                                    step="0.01"
                                    name="gst_percent"
                                    class="form-control"
                                    value="18"
                                    required
                                >

                            </div>

                            <!-- SELLING TYPE -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Selling Type
                                </label>

                                <select
                                    name="selling_type"
                                    class="form-control"
                                    id="sellingType"
                                >

                                    <option value="piece">
                                        Piece Only
                                    </option>

                                    <option value="box">
                                        Box Only
                                    </option>

                                    <option value="both">
                                        Both Piece & Box
                                    </option>

                                </select>

                            </div>

                            <!-- PIECES PER BOX -->

                            <div
                                class="form-group mb-4"
                                id="piecesPerBoxWrap"
                            >

                                <label class="font-weight-bold">
                                    Pieces Per Box
                                </label>

                                <input
                                    type="number"
                                    name="pieces_per_box"
                                    class="form-control"
                                >

                            </div>

                            <!-- MOQ -->

                            <div class="form-group mb-4">

                                <label class="font-weight-bold">
                                    Minimum Order Quantity
                                </label>

                                <input
                                    type="number"
                                    name="min_order_qty"
                                    class="form-control"
                                    value="1"
                                    required
                                >

                            </div>

                            <!-- FEATURED -->

                            <div class="form-group mb-4">

                                <div class="form-check">

                                    <input
                                        type="checkbox"
                                        name="featured"
                                        class="form-check-input"
                                        id="featuredCheck"
                                    >

                                    <label
                                        class="form-check-label"
                                        for="featuredCheck"
                                    >
                                        Featured Product
                                    </label>

                                </div>

                            </div>

                            <!-- BUTTON -->

                            <button
                                class="btn btn-dark btn-block py-2"
                            >
                                Save Product
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<script>

/*
|--------------------------------------------------------------------------
| AUTO SLUG
|--------------------------------------------------------------------------
*/

const productName =
    document.getElementById("productName");

const slugField =
    document.getElementById("slugField");

productName.addEventListener("keyup", function(){

    slugField.value =
        this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');

});

/*
|--------------------------------------------------------------------------
| SHOW/HIDE PIECES PER BOX
|--------------------------------------------------------------------------
*/

const sellingType =
    document.getElementById("sellingType");

const piecesWrap =
    document.getElementById("piecesPerBoxWrap");

function togglePiecesField(){

    if(
        sellingType.value === "box" ||
        sellingType.value === "both"
    ){

        piecesWrap.style.display = "block";

    }else{

        piecesWrap.style.display = "none";

    }
}

togglePiecesField();

sellingType.addEventListener(
    "change",
    togglePiecesField
);

</script>

</div>

</body>
</html>