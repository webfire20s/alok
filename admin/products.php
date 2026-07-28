<?php

require 'includes/auth.php';
require '../includes/db.php';

$categoryFilter = (int)($_GET['category'] ?? 0);

$catStmt = $pdo->query("
    SELECT id,name
    FROM categories
    ORDER BY name
");

$categories = $catStmt->fetchAll();

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

// $stmt = $pdo->query("
//     SELECT products.*, categories.name AS category_name
//     FROM products
//     LEFT JOIN categories
//     ON products.category_id = categories.id
//     ORDER BY products.category_id ASC,
//          products.display_order ASC
// ");

$sql = "
SELECT
    products.*,
    categories.name AS category_name
FROM products
LEFT JOIN categories
ON products.category_id = categories.id
";

$params = [];

if($categoryFilter > 0){

    $sql .= " WHERE products.category_id = ?";

    $params[] = $categoryFilter;

}

$sql .= " ORDER BY products.category_id ASC,
         products.display_order ASC";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$products = $stmt->fetchAll();

?>

<div class="container-fluid py-4">

    <div
        class="d-flex flex-wrap justify-content-between align-items-center mb-5"
    >

        <div>

            <h2
                class="mb-1"
                style="
                    font-weight: 700;
                    letter-spacing: -0.02em;
                    color: #ffffff;
                "
            >
                Mould Inventory
            </h2>

            <p style="color: #64748b; font-size: 14px; margin: 0;">
                Configure, update, and manage all glass bottle manufacturing product lines.
            </p>

        </div>

        <a
            href="add_product.php"
            class="btn px-4 py-2"
            style="
                background: linear-gradient(135deg, #38bdf8, #0284c7);
                color: #ffffff;
                font-weight: 600;
                font-size: 14px;
                border: none;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(56, 189, 248, 0.25);
                transition: transform 0.2s ease;
            "
            onmouseover="this.style.transform='translateY(-1px)'"
            onmouseout="this.style.transform='translateY(0)'"
        >
            + Add New Design
        </a>

    </div>

    <div
        class="card border-0"
        style="
            border-radius: 14px;
            background: rgba(21, 25, 34, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        "
    >

        <div class="card-body p-0">

            <div class="table-responsive">

                <table
                    class="table align-middle mb-0"
                    style="color: #e2e8f0; border-color: rgba(255, 255, 255, 0.03);"
                >

                    <thead
                        style="
                            background: rgba(255, 255, 255, 0.02);
                            border-bottom: 2px solid rgba(255, 255, 255, 0.05);
                        "
                    >

                        <tr>

                            <th class="px-4 py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                ID
                            </th>

                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                Silhouette
                            </th>

                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                Product Specifications
                            </th>

                            <th class="py-3">

                                <div style="display:flex;flex-direction:ROW;gap:8px;">

                                    <span style="
                                        font-size:11px;
                                        text-transform:uppercase;
                                        letter-spacing:.05em;
                                        color:#64748b;
                                        font-weight:600;
                                    ">
                                        Category
                                    </span>

                                    <form method="GET">

                                        <select
                                            id="categoryFilter"
                                            name="category"
                                            onchange="this.form.submit()"
                                            style="
                                                background:rgba(0, 0, 0, 0.75);
                                                color:#fff;
                                                border:1px solid rgba(255,255,255,.08);
                                                border-radius:6px;
                                                padding:6px 10px;
                                                font-size:12px;
                                                width:20px;
                                            "
                                        >

                                            <option value="0">
                                                
                                            </option>

                                            <?php foreach($categories as $cat): ?>

                                                <option
                                                    value="<?= $cat['id'] ?>"
                                                    <?= $categoryFilter == $cat['id'] ? 'selected' : '' ?>
                                                >
                                                    <?= htmlspecialchars($cat['name']) ?>
                                                </option>

                                            <?php endforeach; ?>

                                        </select>

                                    </form>

                                </div>

                            </th>

                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                Base Unit Price
                            </th>

                            <th class="py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                Batch Stock
                            </th>

                            <th class="text-center py-3" style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; font-weight: 600;">
                                Control Panel
                            </th>

                        </tr>

                    </thead>

                    <tbody id="sortableProducts">

                        <?php 
                        $sr = 1;
                        foreach($products as $product): 
                        ?>

                            <tr
                                data-id="<?= $product['id'] ?>"
                                data-category="<?= $product['category_id'] ?>"
                                style="border-bottom: 1px solid rgba(255,255,255,.03);cursor:move;"
                            >

                                <td class="px-4">

                                    <span style="font-size: 13px; font-family: monospace; color: #475569; font-weight: 600;">
                                        #<?= $sr++ ?>
                                    </span>

                                </td>

                                <td width="110">

                                    <div
                                        style="
                                            width: 64px;
                                            height: 64px;
                                            overflow: hidden;
                                            border-radius: 8px;
                                            border: 1px solid rgba(255, 255, 255, 0.05);
                                            background: rgba(15, 17, 21, 0.8);
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            padding: 4px;
                                        "
                                    >

                                        <img
                                            src="../<?= htmlspecialchars($product['image']) ?>"
                                            class="product-thumb"
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                            style="
                                                width: 100%;
                                                height: 100%;
                                                object-fit: contain;
                                                filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
                                            "
                                        >

                                    </div>

                                </td>

                                <td>

                                    <div
                                        style="
                                            font-weight: 600;
                                            font-size: 15px;
                                            color: #ffffff;
                                            line-height: 1.4;
                                        "
                                    >

                                        <?= htmlspecialchars($product['name']) ?>

                                    </div>

                                    <?php if(!empty($product['sku'])): ?>

                                        <div style="font-size: 11px; color: #475569; margin-top: 2px; font-family: monospace; letter-spacing: 0.02em;">

                                            REF-ID: <?= htmlspecialchars($product['sku']) ?>

                                        </div>

                                    <?php endif; ?>

                                </td>

                                <td>

                                    <span
                                        class="badge px-3 py-2"
                                        style="
                                            font-size: 12px;
                                            background: rgba(255, 255, 255, 0.03);
                                            color: #94a3b8;
                                            border: 1px solid rgba(255, 255, 255, 0.05);
                                            font-weight: 500;
                                            border-radius: 6px;
                                        "
                                    >

                                        <?= htmlspecialchars($product['category_name']) ?>

                                    </span>

                                </td>

                                <td>

                                    <strong
                                        style="
                                            font-size: 15px;
                                            color: #ffffff;
                                            font-weight: 600;
                                        "
                                    >

                                        ₹<?= number_format($product['price'], 2) ?>

                                    </strong>

                                </td>

                                <td>

                                    <?php if($product['stock'] > 0): ?>

                                        <span
                                            class="badge px-3 py-2"
                                            style="
                                                font-size: 12px;
                                                background: rgba(16, 185, 129, 0.1);
                                                color: #10b981;
                                                border: 1px solid rgba(16, 185, 129, 0.15);
                                                font-weight: 500;
                                                border-radius: 6px;
                                            "
                                        >
                                            <?= $product['stock'] ?> Units
                                        </span>

                                    <?php else: ?>

                                        <span
                                            class="badge px-3 py-2"
                                            style="
                                                font-size: 12px;
                                                background: rgba(239, 68, 68, 0.1);
                                                color: #f87171;
                                                border: 1px solid rgba(239, 68, 68, 0.15);
                                                font-weight: 500;
                                                border-radius: 6px;
                                            "
                                        >
                                            Depleted
                                        </span>

                                    <?php endif; ?>

                                </td>

                                <td class="text-center">

                                    <div
                                        class="d-flex justify-content-center align-items-center"
                                        style="
                                            gap: 8px;
                                        "
                                    >

                                        <a
                                            href="edit_product.php?id=<?= $product['id'] ?>"
                                            class="btn btn-sm px-3 py-1.5"
                                            style="
                                                background: rgba(255,255,255,0.03);
                                                color: #e2e8f0;
                                                border: 1px solid rgba(255,255,255,0.08);
                                                font-weight: 500;
                                                font-size: 13px;
                                                border-radius: 6px;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.background='rgba(255,255,255,0.08)'; this.style.color='#ffffff';"
                                            onmouseout="this.style.background='rgba(255,255,255,0.03)'; this.style.color='#e2e8f0';"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="delete_product.php?id=<?= $product['id'] ?>"
                                            class="btn btn-sm px-3 py-1.5"
                                            style="
                                                background: rgba(239, 68, 68, 0.05);
                                                color: #f87171;
                                                border: 1px solid rgba(239, 68, 68, 0.1);
                                                font-weight: 500;
                                                font-size: 13px;
                                                border-radius: 6px;
                                                transition: all 0.2s;
                                            "
                                            onmouseover="this.style.background='rgba(239, 68, 68, 0.15)'"
                                            onmouseout="this.style.background='rgba(239, 68, 68, 0.05)'"
                                            onclick="return confirm('Delete this product?')"
                                        >
                                            Delete
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</div> </div> 
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>

const tbody = document.getElementById("sortableProducts");

const sortable = new Sortable(tbody,{
    animation:200,

    onEnd:function(){

        const selectedCategory =
            document.getElementById("categoryFilter").value;

        let order=[];

        let index=1;

        tbody.querySelectorAll("tr").forEach(function(row){

            order.push({

                id: row.dataset.id,
                order: index++

            });

        });

        fetch("update_product_order.php",{

            method:"POST",

            headers:{
                "Content-Type":"application/json"
            },

            body:JSON.stringify(order)

        });

    }

});

</script>
</body>
</html>