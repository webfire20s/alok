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
                        Net Mass / Weight (kg)
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