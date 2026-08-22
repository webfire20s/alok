<?php

require 'includes/auth.php';
require '../includes/db.php';



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


$stmt = $pdo->prepare("
    SELECT closure_option_id
    FROM product_closure_options
    WHERE product_id = ?
");

$stmt->execute([$product['id']]);

$selectedClosures = array_column(
    $stmt->fetchAll(),
    'closure_option_id'
);
/*
|--------------------------------------------------------------------------
| FETCH CATEGORIES AND SUB CATEGORIES ANDCLOSURE OPTIONS
|--------------------------------------------------------------------------
*/

$categories = $pdo->query("
    SELECT *
    FROM categories
    ORDER BY name ASC
")->fetchAll();

$subCategoryStmt = $pdo->query("
    SELECT
        id,
        category_id,
        name
    FROM subcategories
    WHERE status = 1
    ORDER BY display_order ASC, name ASC
");

$subcategories = $subCategoryStmt->fetchAll();

$closureOptions = $pdo->query("
    SELECT *
    FROM closure_options
    WHERE status = 1
    ORDER BY sort_order ASC, name ASC
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

    $showOnHome = 
        isset($_POST['show_on_home']) ? 1 : 0;

    $hasClosureOptions =
        isset($_POST['has_closure_options']) ? 1 : 0;

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
            subcategory_id=?,
            name = ?,
            slug = ?,
            sku = ?,
            show_on_home = ?,
            has_closure_options = ?,
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
        $_POST['subcategory_id'] ?: null,
        $name,
        $slug,
        $sku,
        $showOnHome,
        $hasClosureOptions,
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

    /*
    |--------------------------------------------------------------------------
    | SAVE CLOSURE OPTIONS
    |--------------------------------------------------------------------------
    */

    $pdo->prepare("
        DELETE FROM product_closure_options
        WHERE product_id = ?
    ")->execute([$id]);

    if (
        $hasClosureOptions == 1 &&
        !empty($_POST['closure_options'])
    ) {

        $insert = $pdo->prepare("
            INSERT INTO product_closure_options
            (
                product_id,
                closure_option_id
            )
            VALUES (?, ?)
        ");

        foreach ($_POST['closure_options'] as $closureId) {

            $insert->execute([
                $id,
                $closureId
            ]);

        }

    }

    header("Location: products.php");
    exit;
}
include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<h2 class="mb-4" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff; font-size: calc(1.4rem + 0.6vw);">
    Modify Product Profile
</h2>

<div 
    class="card-box p-3 p-sm-4" 
    style="
        border-radius: 14px; 
        background: rgba(21, 25, 34, 0.6); 
        backdrop-filter: blur(12px); 
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.05);
    "
>

    <form method="POST" enctype="multipart/form-data">

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Segment Category
                    </label>
                    <select 
                        name="category_id" 
                        class="form-control text-white" 
                        required
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px; box-shadow: none;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                        <?php foreach($categories as $category): ?>
                            <option 
                                value="<?= $category['id'] ?>" 
                                <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>
                                style="background: #151922; color: #ffffff;"
                            >
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group mb-4">

                <label
                    style="
                        font-size:12px;
                        text-transform:uppercase;
                        letter-spacing:.05em;
                        color:#94a3b8;
                        font-weight:600;
                        margin-bottom:8px;
                    "
                >
                    Sub Category
                </label>

                <select
                    name="subcategory_id"
                    id="subcategory_id"
                    class="form-control text-white"
                    style="
                        background:rgba(15,17,21,.5);
                        border:1px solid rgba(255,255,255,.08);
                        border-radius:8px;
                        height:45px;
                    "
                >

                    <option value="">
                        Select Sub Category
                    </option>

                    <?php foreach($subcategories as $sub): ?>

                        <option
                            value="<?= $sub['id'] ?>"
                            data-category="<?= $sub['category_id'] ?>"
                            <?= $product['subcategory_id']==$sub['id'] ? 'selected' : '' ?>
                            style="display:none;background:#151922;color:#fff;"
                        >
                            <?= htmlspecialchars($sub['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="col-12 col-md-6">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Stock Keeping Unit (SKU)
                    </label>
                    <input 
                        type="text" 
                        name="sku" 
                        class="form-control text-white" 
                        value="<?= htmlspecialchars($product['sku']) ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px; font-family: monospace;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>
            <div class="mb-4">

                <label style=" display:block; font-size:11px; font-weight:700; text-transform:uppercase; color:#94a3b8; letter-spacing:.05em; margin-bottom:10px; " >
                    Homepage Display
                </label>

                <label style=" display:flex; align-items:center; gap:10px; cursor:pointer; color:#e2e8f0; font-size:14px; " >

                    <input
                        type="checkbox"
                        name="show_on_home"
                        value="1"
                        <?= !empty($product['show_on_home']) ? 'checked' : '' ?>
                        style="
                            width:18px;
                            height:18px;
                            cursor:pointer;
                        "
                    >

                    Show this product on homepage

                </label>

                <small
                    style="
                        display:block;
                        margin-top:6px;
                        color:#64748b;
                        font-size:12px;
                    "
                >
                    Selected products can appear in their category's homepage showcase.
                </small>

            </div>
        </div>
        <div class="form-group mt-4">

            <div class="form-check mb-3">

                <input
                    type="checkbox"
                    id="hasClosureOptions"
                    name="has_closure_options"
                    value="1"
                    class="form-check-input"
                    <?= $product['has_closure_options'] ? 'checked' : '' ?>
                >

                <label
                    class="form-check-label"
                    for="hasClosureOptions"
                >
                    Enable Closure Options
                </label>

            </div>

        </div>


        <div
            id="closureOptionsWrap"
            style="<?= $product['has_closure_options'] ? '' : 'display:none;' ?>"
        >

            <label class="mb-2">
                Available Closure Options
            </label>


            <!-- Closure Search -->
            <div class="mb-3">

                <input
                    type="text"
                    id="editClosureSearch"
                    class="form-control"
                    placeholder="Search closures..."
                    autocomplete="off"
                    style="
                        background:rgba(15,17,21,.7);
                        border:1px solid rgba(255,255,255,.08);
                        color:#fff;
                        font-size:13px;
                        border-radius:7px;
                        padding:9px 12px;
                    "
                >

            </div>


            <div
                id="editClosureList"
                style="
                    max-height:220px;
                    overflow:auto;
                    padding:12px;
                    background:rgba(15,17,21,.5);
                    border:1px solid rgba(255,255,255,.08);
                    border-radius:8px;
                "
            >

                <?php foreach($closureOptions as $closure): ?>

                    <div
                        class="form-check mb-2 edit-closure-item"
                        data-closure-name="<?= htmlspecialchars(strtolower($closure['name'])) ?>"
                    >

                        <input
                            type="checkbox"
                            class="form-check-input"
                            name="closure_options[]"
                            value="<?= $closure['id'] ?>"
                            id="editClosure<?= $closure['id'] ?>"

                            <?= in_array(
                                    $closure['id'],
                                    $selectedClosures
                                )
                                ? 'checked'
                                : ''
                            ?>
                        >

                        <label
                            class="form-check-label"
                            for="editClosure<?= $closure['id'] ?>"
                        >

                            <?= htmlspecialchars($closure['name']) ?>

                            <?php if($closure['price'] > 0): ?>

                                (+₹<?= number_format($closure['price'],2) ?>)

                            <?php endif; ?>

                        </label>

                    </div>

                <?php endforeach; ?>


                <!-- No Results -->

                <div
                    id="editClosureNoResults"
                    style="
                        display:none;
                        color:#94a3b8;
                        font-size:12px;
                        text-align:center;
                        padding:10px;
                    "
                >
                    No closures found.
                </div>

            </div>

        </div>

        <div class="form-group mb-4">
            <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                Product Nomenclature
            </label>
            <input 
                type="text" 
                name="name" 
                class="form-control text-white" 
                value="<?= htmlspecialchars($product['name']) ?>" 
                required
                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
        </div>

        <div class="form-group mb-4">
            <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                Web Routing Token (Slug)
            </label>
            <input 
                type="text" 
                name="slug" 
                class="form-control text-white" 
                value="<?= htmlspecialchars($product['slug']) ?>" 
                required
                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px; font-family: monospace;"
                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
            >
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Base Valuation Price (₹)
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="price" 
                        class="form-control text-white" 
                        value="<?= $product['price'] ?>" 
                        required
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px; font-weight: 600;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Regulatory GST Rate (%)
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="gst_percent" 
                        class="form-control text-white" 
                        value="<?= $product['gst_percent'] ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Available Units Stock
                    </label>
                    <input 
                        type="number" 
                        name="stock" 
                        class="form-control text-white" 
                        value="<?= $product['stock'] ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Net Mass / Weight (g)
                    </label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="weight" 
                        class="form-control text-white" 
                        value="<?= $product['weight'] ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Dimensions Matrix
                    </label>
                    <input 
                        type="text" 
                        name="dimensions" 
                        class="form-control text-white" 
                        value="<?= htmlspecialchars($product['dimensions']) ?>" 
                        placeholder="10x20x30 cm"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Distribution Channels
                    </label>
                    <select 
                        name="selling_type" 
                        class="form-control text-white"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                        <option value="piece" <?= $product['selling_type'] == 'piece' ? 'selected' : '' ?> style="background: #151922; color: #ffffff;">Piece Only</option>
                        <option value="box" <?= $product['selling_type'] == 'box' ? 'selected' : '' ?> style="background: #151922; color: #ffffff;">Box Only</option>
                        <option value="both" <?= $product['selling_type'] == 'both' ? 'selected' : '' ?> style="background: #151922; color: #ffffff;">Both</option>
                    </select>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Volumetric Unit/Box Ratio
                    </label>
                    <input 
                        type="number" 
                        name="pieces_per_box" 
                        class="form-control text-white" 
                        value="<?= $product['pieces_per_box'] ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-4">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Minimum Procurement Order (MOQ)
                    </label>
                    <input 
                        type="number" 
                        name="min_order_qty" 
                        class="form-control text-white" 
                        value="<?= $product['min_order_qty'] ?>"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group mb-4">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Visibility Node State
                    </label>
                    <select 
                        name="status" 
                        class="form-control text-white"
                        style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 46px; font-size: 14px;"
                        onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                        onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                    >
                        <option value="active" <?= $product['status'] == 'active' ? 'selected' : '' ?> style="background: #151922; color: #10b981;">Active / Deployable</option>
                        <option value="inactive" <?= $product['status'] == 'inactive' ? 'selected' : '' ?> style="background: #151922; color: #ef4444;">Inactive / Vaulted</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                Excerpt Summary (Short Description)
            </label>
            <textarea 
                name="short_description" 
                rows="3" 
                class="form-control text-white"
                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 14px; line-height: 1.5;"
                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
            ><?= htmlspecialchars($product['short_description']) ?></textarea>
        </div>

        <div class="form-group mb-4">
            <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                Master Blueprint Specifications (Full Description)
            </label>
            <textarea 
                name="description" 
                rows="6" 
                class="form-control text-white"
                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 14px; line-height: 1.6;"
                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
            ><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="row align-items-center mb-4">
            <div class="col-12 col-sm-auto mb-3 mb-sm-0 text-center text-sm-left">
                <div class="form-group mb-0">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block; text-align: left;">
                        Registered Silhouette
                    </label>
                    <div style="background: rgba(15, 17, 21, 0.4); padding: 10px; border: 1px solid rgba(255,255,255,0.06); border-radius: 10px; display: inline-block;">
                        <img 
                            src="../<?= htmlspecialchars($product['image']) ?>" 
                            style="width: 110px; height: 110px; object-fit: cover; border-radius: 6px; display: block;"
                        >
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm">
                <div class="form-group mb-0">
                    <label style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px; display: block;">
                        Overwriting Target File (Replace Image)
                    </label>
                    <input 
                        type="file" 
                        name="image" 
                        class="form-control text-white"
                        style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 13px; height: auto; padding: 10px;"
                    >
                </div>
            </div>
        </div>

        <div class="pt-2 text-right">
            <button 
                class="btn py-2.5 w-100 w-sm-auto"
                style="
                    background: linear-gradient(135deg, #38bdf8, #0284c7);
                    color: #ffffff;
                    font-weight: 600;
                    font-size: 14px;
                    border: none;
                    border-radius: 8px;
                    padding-left: 28px;
                    padding-right: 28px;
                    height: 46px;
                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2);
                    transition: all 0.2s;
                "
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.2)';"
            >
                Commit Architecture Shifts
            </button>
        </div>

    </form>

</div>

<script>
    const closureToggle =
document.getElementById("hasClosureOptions");

const closureWrap =
document.getElementById("closureOptionsWrap");

closureToggle.addEventListener("change",function(){

    closureWrap.style.display =
        this.checked
            ? "block"
            : "none";

});
</script>
<script>

const categorySelect=document.querySelector('[name="category_id"]');
const subSelect=document.getElementById("subcategory_id");

function loadSubCategories(){

    let cat=categorySelect.value;

    Array.from(subSelect.options).forEach(function(option){

        if(option.value===""){

            option.style.display="block";
            return;

        }

        option.style.display=
            option.dataset.category===cat
            ? "block"
            : "none";

    });

}

categorySelect.addEventListener("change",function(){

    subSelect.value="";
    loadSubCategories();

});

loadSubCategories();

</script>
<script>

document.addEventListener('DOMContentLoaded', function(){

    const search =
        document.getElementById('editClosureSearch');

    const items =
        document.querySelectorAll('.edit-closure-item');

    const noResults =
        document.getElementById('editClosureNoResults');

    if(!search) return;

    search.addEventListener('input', function(){

        const value =
            this.value.trim().toLowerCase();

        let visibleCount = 0;

        items.forEach(function(item){

            const name =
                item.dataset.closureName || '';

            if(name.includes(value)){
                item.style.display = '';
                visibleCount++;
            }else{
                item.style.display = 'none';
            }
        });

        if(noResults){
            noResults.style.display =
                visibleCount === 0
                ? 'block'
                : 'none';
        }
    });
});
</script>