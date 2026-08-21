<?php

require 'includes/auth.php';
require '../includes/db.php';



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
    
    $hasClosureOptions =
        isset($_POST['has_closure_options'])
            ? 1
            : 0;

    $selectedClosures =
        $_POST['closure_options'] ?? [];

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
            subcategory_id,
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
            featured,
            has_closure_options

        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([

        $categoryId,
        $_POST['subcategory_id'] ?: null,
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
        $featured,
        $hasClosureOptions

    ]);

    $productId = $pdo->lastInsertId();

    if($hasClosureOptions && !empty($selectedClosures)){

        $mapStmt = $pdo->prepare("
            INSERT INTO product_closure_options
            (
                product_id,
                closure_option_id
            )
            VALUES (?,?)
        ");

        foreach($selectedClosures as $closureId){

            $mapStmt->execute([
                $productId,
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

<div class="container-fluid py-4">

    <div class="mb-5">
        <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;">
            Initialize Product Line
        </h2>
        <p style="color: #64748b; font-size: 14px; margin: 0;">
            Register a new manufactured blueprint, configure baseline variables, and deploy to catalog node.
        </p>
    </div>

    <div 
        class="card border-0 shadow-sm" 
        style="
            border-radius: 14px; 
            background: rgba(21, 25, 34, 0.6); 
            backdrop-filter: blur(12px); 
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        "
    >
        <div class="card-body p-4">

            <form method="POST" enctype="multipart/form-data">
                <div class="row">

                    <div class="col-lg-8">

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                Segment Category
                            </label>
                            <select 
                                name="category_id" 
                                class="form-control text-white" 
                                required
                                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 45px; font-size: 14px; box-shadow: none;"
                                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                            >
                                <option value="" style="background: #151922; color: #64748b;">Select Category</option>
                                <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" style="background: #151922; color: #ffffff;">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                                    font-size:14px;
                                "
                            >

                                <option value="">
                                    Select Sub Category
                                </option>

                                <?php foreach($subcategories as $sub): ?>

                                    <option
                                        value="<?= $sub['id'] ?>"
                                        data-category="<?= $sub['category_id'] ?>"
                                        style="display:none;background:#151922;color:#fff;"
                                    >
                                        <?= htmlspecialchars($sub['name']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                Design Nomenclature / Product Name
                            </label>
                            <input 
                                type="text" 
                                name="name" 
                                id="productName" 
                                class="form-control text-white" 
                                required
                                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 45px; font-size: 14px;"
                                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                            >
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                URL Node Token / Slug
                            </label>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slugField" 
                                class="form-control text-white" 
                                required
                                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 45px; font-size: 14px; font-family: monospace;"
                                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                            >
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                Excerpt Summary (Short Description)
                            </label>
                            <textarea 
                                name="short_description" 
                                rows="3" 
                                class="form-control text-white"
                                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 14px; line-height: 1.5;"
                                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                            ></textarea>
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                Master Specifications Sheet (Full Description)
                            </label>
                            <textarea 
                                name="description" 
                                rows="8" 
                                class="form-control text-white"
                                style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 14px; line-height: 1.6;"
                                onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                            ></textarea>
                        </div>

                    </div>

                    <div class="col-lg-4">
                        <div 
                            class="p-4" 
                            style="
                                background: rgba(15, 17, 21, 0.4); 
                                border: 1px solid rgba(255, 255, 255, 0.04); 
                                border-radius: 10px;
                            "
                        >

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Product Silhouette File
                                </label>
                                <input 
                                    type="file" 
                                    name="image" 
                                    class="form-control text-white" 
                                    required
                                    style="background: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; font-size: 13px; height: auto; padding: 10px;"
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Internal Code / SKU
                                </label>
                                <input 
                                    type="text" 
                                    name="sku" 
                                    class="form-control text-white"
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px; font-family: monospace;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Standard Price (₹)
                                </label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="price" 
                                    class="form-control text-white" 
                                    required
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px; font-weight: 600;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <!-- <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    High-Volume Contract Price (₹)
                                </label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="sale_price" 
                                    class="form-control text-white"
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px; font-weight: 600; color: #10b981 !important;"
                                    onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 1px #10b981';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div> -->

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Initial Allocation Stock
                                </label>
                                <input 
                                    type="number" 
                                    name="stock" 
                                    class="form-control text-white" 
                                    required
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Regulatory GST Rate (%)
                                </label>
                                <input 
                                    type="number" 
                                    step="0.01" 
                                    name="gst_percent" 
                                    class="form-control text-white" 
                                    value="18" 
                                    required
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Dispatch Form Factors
                                </label>
                                <select 
                                    name="selling_type" 
                                    class="form-control text-white" 
                                    id="sellingType"
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                                    <option value="piece" style="background: #151922; color: #ffffff;">Piece Only</option>
                                    <option value="box" style="background: #151922; color: #ffffff;">Box Only</option>
                                    <option value="both" style="background: #151922; color: #ffffff;">Both Piece & Box</option>
                                </select>
                            </div>

                            <div class="form-group mb-4" id="piecesPerBoxWrap">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Volumetric Packaging (Pieces Per Box)
                                </label>
                                <input 
                                    type="number" 
                                    name="pieces_per_box" 
                                    class="form-control text-white"
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <div class="form-group mb-4">
                                <label style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; font-weight: 600; margin-bottom: 8px;">
                                    Minimum Order Threshold (MOQ)
                                </label>
                                <input 
                                    type="number" 
                                    name="min_order_qty" 
                                    class="form-control text-white" 
                                    value="1" 
                                    required
                                    style="background: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 8px; height: 42px; font-size: 14px;"
                                    onfocus="this.style.borderColor='#38bdf8'; this.style.boxShadow='0 0 0 1px #38bdf8';"
                                    onblur="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.boxShadow='none';"
                                >
                            </div>

                            <div class="form-group mb-4 pt-2">
                                <div class="form-check d-flex align-items-center" style="gap: 4px;">
                                    <input 
                                        type="checkbox" 
                                        name="featured" 
                                        class="form-check-input" 
                                        id="featuredCheck"
                                        style="cursor: pointer; width: 16px; height: 16px; margin: 0; background-color: rgba(15, 17, 21, 0.5); border: 1px solid rgba(255, 255, 255, 0.2);"
                                    >
                                    <label 
                                        class="form-check-label text-white-50 pl-2" 
                                        for="featuredCheck" 
                                        style="font-size: 13px; font-weight: 500; cursor: pointer; user-select: none;"
                                    >
                                        Highlight on Prime Showroom Showcases
                                    </label>
                                </div>
                            </div>
                            <div class="form-group mb-4 pt-2">

                                <div class="form-check d-flex align-items-center">

                                    <input
                                        type="checkbox"
                                        id="closureCheck"
                                        name="has_closure_options"
                                        class="form-check-input"
                                    >

                                    <label
                                        for="closureCheck"
                                        class="form-check-label text-white-50 ms-2">

                                        Enable Closure Options

                                    </label>

                                </div>

                            </div>

                            <div
                                id="closureContainer"
                                class="form-group mb-4"
                                style="display:none;">

                                <label
                                    style="
                                    font-size:12px;
                                    text-transform:uppercase;
                                    color:#94a3b8;
                                    font-weight:600;">

                                    Available Closures

                                </label>

                                <div
                                    style="
                                    max-height:220px;
                                    overflow:auto;
                                    padding:12px;
                                    background:rgba(15,17,21,.5);
                                    border:1px solid rgba(255,255,255,.08);
                                    border-radius:8px;">

                                    <?php foreach($closureOptions as $closure): ?>

                                        <div class="form-check mb-2">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="closure_options[]"
                                                value="<?= $closure['id'] ?>"
                                                id="closure<?= $closure['id'] ?>">

                                            <label
                                                class="form-check-label text-white"
                                                for="closure<?= $closure['id'] ?>">

                                                <?= htmlspecialchars($closure['name']) ?>

                                                <?php if($closure['price']>0): ?>

                                                    (+₹<?= number_format($closure['price'],2) ?>)

                                                <?php endif; ?>

                                            </label>

                                        </div>

                                    <?php endforeach; ?>

                                </div>

                            </div>

                            <button 
                                class="btn btn-block py-2.5 mt-2"
                                style="
                                    background: linear-gradient(135deg, #38bdf8, #0284c7);
                                    color: #ffffff;
                                    font-weight: 600;
                                    font-size: 14px;
                                    border: none;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.2);
                                    transition: all 0.2s;
                                "
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.3)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.2)';"
                            >
                                Save Production Blueprint
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

        piecesWrap.style.display = "block";

    }
}

togglePiecesField();

sellingType.addEventListener(
    "change",
    togglePiecesField
);

const closureCheck =
document.getElementById("closureCheck");

const closureContainer =
document.getElementById("closureContainer");

function toggleClosures(){

    closureContainer.style.display =
        closureCheck.checked
            ? "block"
            : "none";

}

toggleClosures();

closureCheck.addEventListener(
    "change",
    toggleClosures
);

</script>
<script>

const categorySelect = document.querySelector('[name="category_id"]');
const subSelect = document.getElementById("subcategory_id");

function loadSubCategories(){

    const cat = categorySelect.value;

    subSelect.value = "";

    Array.from(subSelect.options).forEach(function(opt){

        if(opt.value===""){

            opt.style.display="block";
            return;

        }

        if(opt.dataset.category===cat){

            opt.style.display="block";

        }else{

            opt.style.display="none";

        }

    });

}

categorySelect.addEventListener("change",loadSubCategories);

loadSubCategories();

</script>
</div>

</body>
</html>