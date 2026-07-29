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

/*----------------------------------------------------------
| SEARCH + PAGINATION
----------------------------------------------------------*/

$search = trim($_GET['search'] ?? '');

$page = max(1, (int)($_GET['page'] ?? 1));

$perPage = 25;

$where = [];

$params = [];

if ($categoryFilter > 0) {
    $where[] = "products.category_id = ?";
    $params[] = $categoryFilter;
}

if ($search != '') {

    if (is_numeric($search)) {

        $where[] = "(products.id = ? OR products.name LIKE ? OR products.sku LIKE ? OR products.slug LIKE ?)";

        $params[] = (int)$search;
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";

    } else {

        $where[] = "(products.name LIKE ? OR products.sku LIKE ? OR products.slug LIKE ?)";

        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
    }
}

$whereSql = '';

if ($where) {
    $whereSql = ' WHERE ' . implode(' AND ', $where);
}

/* TOTAL PRODUCTS */

$countSql = "
SELECT COUNT(*)
FROM products
LEFT JOIN categories
ON products.category_id = categories.id
{$whereSql}
";

$countStmt = $pdo->prepare($countSql);

$countStmt->execute($params);

$totalProducts = (int)$countStmt->fetchColumn();

$totalPages = max(1, ceil($totalProducts / $perPage));

$page = min($page, $totalPages);

$offset = ($page - 1) * $perPage;

/* PRODUCTS */

$sql = "
SELECT
    products.*,
    categories.name AS category_name
FROM products
LEFT JOIN categories
ON products.category_id = categories.id
{$whereSql}
ORDER BY
products.category_id ASC,
products.display_order ASC
LIMIT {$offset}, {$perPage}
";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$products = $stmt->fetchAll();

/* SERIAL */

$sr = $offset + 1;

?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-5">
        <div>
            <h2 class="mb-1" style="font-weight: 700; letter-spacing: -0.02em; color: #ffffff;"> 
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
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            "
            onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.35)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.25)';"
        >
            + Add New Design
        </a>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <form method="GET" class="d-flex align-items-center" style="gap: 10px;">

            <div style="position: relative;">
                <input
                    type="text"
                    name="search"
                    value="<?= htmlspecialchars($search) ?>"
                    placeholder="Search name, SKU, slug or ID..."
                    class="form-control"
                    style="
                        width: 320px;
                        background: rgba(15, 17, 21, 0.6);
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        border-radius: 8px;
                        color: #ffffff;
                        font-size: 13.5px;
                        padding: 8px 14px;
                        outline: none;
                        transition: all 0.2s ease-in-out;
                    "
                    onfocus="this.style.background='rgba(15, 17, 21, 0.8)'; this.style.borderColor='rgba(56, 189, 248, 0.5)'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.15)';"
                    onblur="this.style.background='rgba(15, 17, 21, 0.6)'; this.style.borderColor='rgba(255, 255, 255, 0.08)'; this.style.boxShadow='none';"
                >
            </div>

            <?php if($categoryFilter): ?>
                <input type="hidden" name="category" value="<?= $categoryFilter ?>">
            <?php endif; ?>

            <button 
                type="submit" 
                class="btn px-3 py-2"
                style="
                    background: rgba(56, 189, 248, 0.1);
                    color: #38bdf8;
                    border: 1px solid rgba(56, 189, 248, 0.25);
                    font-weight: 600;
                    font-size: 13.5px;
                    border-radius: 8px;
                    transition: all 0.2s ease;
                "
                onmouseover="this.style.background='rgba(56, 189, 248, 0.2)'; this.style.borderColor='rgba(56, 189, 248, 0.4)';"
                onmouseout="this.style.background='rgba(56, 189, 248, 0.1)'; this.style.borderColor='rgba(56, 189, 248, 0.25)';"
            >
                Search
            </button>

            <?php if($search!=''): ?>
                <a
                    href="products.php<?= $categoryFilter ? '?category='.$categoryFilter : '' ?>"
                    class="btn px-3 py-2"
                    style="
                        background: rgba(255, 255, 255, 0.03);
                        color: #94a3b8;
                        border: 1px solid rgba(255, 255, 255, 0.08);
                        font-weight: 500;
                        font-size: 13.5px;
                        border-radius: 8px;
                        transition: all 0.2s ease;
                    "
                    onmouseover="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#ffffff';"
                    onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.color='#94a3b8';"
                >
                    Clear
                </a>
            <?php endif; ?>

        </form>

        <div style="
            color: #94a3b8;
            font-size: 13px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 6px 14px;
            border-radius: 20px;
        ">
            <span style="color: #38bdf8; font-weight: 700;"><?= number_format($totalProducts) ?></span> Products Found
        </div>

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

                            <th class="py-3" style="min-width: 160px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="
                                        font-size: 11px;
                                        text-transform: uppercase;
                                        letter-spacing: .05em;
                                        color: #64748b;
                                        font-weight: 600;
                                    ">
                                        Category
                                    </span>

                                    <form method="GET" class="mb-0">
                                        <select
                                            id="categoryFilter"
                                            name="category"
                                            onchange="this.form.submit()"
                                            style="
                                                background: rgba(15, 17, 21, 0.75);
                                                color: #e2e8f0;
                                                border: 1px solid rgba(255, 255, 255, 0.08);
                                                border-radius: 6px;
                                                padding: 4px 8px;
                                                font-size: 11px;
                                                width: 50%;
                                                outline: none;
                                                cursor: pointer;
                                                transition: all 0.2s ease-in-out;
                                            "
                                            onfocus="this.style.borderColor='rgba(56, 189, 248, 0.5)'; this.style.boxShadow='0 0 0 2px rgba(56, 189, 248, 0.15)';"
                                            onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)'; this.style.boxShadow='none';"
                                        >
                                            <option value="0" style="background: #1e293b; color: #ffffff;">
                                                Categories
                                            </option>

                                            <?php foreach($categories as $cat): ?>
                                                <option
                                                    value="<?= $cat['id'] ?>"
                                                    <?= $categoryFilter == $cat['id'] ? 'selected' : '' ?>
                                                    style="background: #1e293b; color: #ffffff;"
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

                                    <div class="d-flex justify-content-center align-items-center" style=" gap: 8px; " >
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm px-3 py-1.5"
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

                                        <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm px-3 py-1.5"
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
            <?php if($totalPages > 1): ?>

            <div class="d-flex justify-content-between align-items-center p-3">
                <div style="color:#94a3b8;font-size:13px;">
                    Showing
                    <?= $offset + 1 ?>
                    -
                    <?= min($offset + $perPage, $totalProducts) ?>
                    of
                    <?= number_format($totalProducts) ?>
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <?php if($page > 1): ?>
                        <li class="page-item">
                            <a
                                class="page-link"
                                href="?page=<?= $page-1 ?>&category=<?= $categoryFilter ?>&search=<?= urlencode($search) ?>">
                                Previous
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php
                        for($i=1;$i<=$totalPages;$i++):

                            if( $i==1 || $i==$totalPages || abs($i-$page)<=2 ):

                        ?>

                        <li class="page-item <?= $i==$page?'active':'' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&category=<?= $categoryFilter ?>&search=<?= urlencode($search) ?>"> <?= $i ?> </a>
                        </li>

                        <?php endif; endfor; ?>

                        <?php if($page < $totalPages): ?>

                        <li class="page-item">

                            <a class="page-link" href="?page=<?= $page+1 ?>&category=<?= $categoryFilter ?>&search=<?= urlencode($search) ?>"> Next </a>

                        </li>

                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
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