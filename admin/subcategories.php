<?php

require 'includes/auth.php';
require '../includes/db.php';

$search = trim($_GET['search'] ?? '');

$categoryFilter = (int)($_GET['category'] ?? 0);

$page = max(1, (int)($_GET['page'] ?? 1));

$perPage = 25;

$where = [];
$params = [];


/*
|--------------------------------------------------------------------------
| CATEGORY FILTER
|--------------------------------------------------------------------------
*/

if($categoryFilter > 0){

    $where[] = "sc.category_id = ?";
    $params[] = $categoryFilter;

}


/*
|--------------------------------------------------------------------------
| SEARCH FILTER
|--------------------------------------------------------------------------
*/

if($search != ''){

    if(is_numeric($search)){

        $where[] = "(
            sc.id = ?
            OR sc.name LIKE ?
            OR sc.slug LIKE ?
            OR c.name LIKE ?
        )";

        $params[] = (int)$search;
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";

    }else{

        $where[] = "(
            sc.name LIKE ?
            OR sc.slug LIKE ?
            OR c.name LIKE ?
        )";

        $params[] = "%{$search}%";
        $params[] = "%{$search}%";
        $params[] = "%{$search}%";

    }

}

$whereSql = '';

if($where){

    $whereSql = ' WHERE '.implode(' AND ',$where);

}


/*
|--------------------------------------------------------------------------
| GET CATEGORIES
|--------------------------------------------------------------------------
*/

$categoryStmt = $pdo->query("
    SELECT id, name
    FROM categories
    ORDER BY name ASC
");

$categories = $categoryStmt->fetchAll();



/* TOTAL */

$countSql = "
SELECT COUNT(*)
FROM subcategories sc
LEFT JOIN categories c
ON sc.category_id=c.id
{$whereSql}
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);

$totalRows = $countStmt->fetchColumn();

$totalPages = max(1,ceil($totalRows/$perPage));

$page=min($page,$totalPages);

$offset=($page-1)*$perPage;

/* DATA */

$sql="
SELECT
sc.*,
c.name AS category_name
FROM subcategories sc
LEFT JOIN categories c
ON sc.category_id=c.id
{$whereSql}
ORDER BY
sc.display_order ASC,
sc.id ASC
LIMIT {$offset},{$perPage}
";

$stmt=$pdo->prepare($sql);
$stmt->execute($params);

$subcategories=$stmt->fetchAll();

$sr=$offset+1;

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<style>

    .custom-table-scroll::-webkit-scrollbar{
        height:6px;
    }

    .custom-table-scroll::-webkit-scrollbar-track{
        background:rgba(255,255,255,.02);
        border-radius:10px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb{
        background:rgba(56,189,248,.20);
        border-radius:10px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb:hover{
        background:rgba(56,189,248,.40);
    }

    .btn-glow-transition{
        transition:transform .2s ease,box-shadow .2s ease!important;
    }

    .btn-glow-transition:hover{
        transform:translateY(-1px);
        box-shadow:0 6px 20px rgba(56,189,248,.40)!important;
    }

    .premium-table{
        min-width:900px;
    }

</style>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <div>
            <h2 class="mb-1" style="font-weight:700;color:#fff;"> Sub Categories </h2>
            <p style="color:#64748b;margin:0;"> Manage product subcategories. </p>
        </div>

        <div class="d-flex gap-2 flex-wrap">

            <!-- SEARCH -->
            <form method="GET" class="d-flex gap-2">

                <?php if($categoryFilter > 0): ?>

                    <input type="hidden" name="category" value="<?= $categoryFilter ?>" >

                <?php endif; ?>

                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search..." class="form-control" style=" width:250px; background:#111827; color:#fff; border:1px solid #374151; " >

                <button type="submit" class="btn btn-info" >
                    Search
                </button>

            </form>


            <!-- CATEGORY FILTER -->

            <form method="GET">

                <?php if($search != ''): ?>

                    <input
                        type="hidden"
                        name="search"
                        value="<?= htmlspecialchars($search) ?>"
                    >

                <?php endif; ?>

                <select
                    name="category"
                    onchange="this.form.submit()"
                    class="form-control"
                    style="
                        width:220px;
                        background:#111827;
                        color:#fff;
                        border:1px solid #374151;
                        cursor:pointer;
                    "
                >

                    <option value="0">
                        All Categories
                    </option>

                    <?php foreach($categories as $category): ?>

                        <option
                            value="<?= $category['id'] ?>"
                            <?= $categoryFilter == $category['id'] ? 'selected' : '' ?>
                        >
                            <?= htmlspecialchars($category['name']) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </form>


            <!-- ADD SUBCATEGORY -->

            <a
                href="add_subcategory.php"
                class="btn btn-info"
            >
                Add Subcategory
            </a>

        </div>
    </div>

    <div class="card border-0" style=" border-radius:14px; background:rgba(21,25,34,.60); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.05); box-shadow:0 20px 40px rgba(0,0,0,.25); overflow:hidden; ">
         <?php if($categoryFilter <= 0): ?>

        <div
            class="mb-1  px-3 py-2"
            style="
                background: rgba(56, 189, 248, 0.08);
                border: 1px solid rgba(56, 189, 248, 0.15);
                color: #7dd3fc;
                border-radius: 8px;
                font-size: 13px;
            "
        >
            Select a category to enable drag sorting.
        </div>
        <?php endif;?>
        <div class="card-body p-0">
            <div class="table-responsive custom-table-scroll">

            <table class="table premium-table align-middle mb-0" style=" color:#e2e8f0; border-color:rgba(255,255,255,.03); ">
                <thead style=" background:rgba(255,255,255,.02); border-bottom:2px solid rgba(255,255,255,.05); ">

                    <tr data-id="<?= $subcategory['id'] ?>">
                        <th class="px-4 py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> ID </th>
                        <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Image </th>
                        <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Sub Category </th>
                        <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Category </th>
                        <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Slug </th>
                        <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Featured </th>
                        <th class="text-center py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; "> Action </th>
                    </tr>

                </thead>

                <tbody id="sortableSubcategories">

                    <?php foreach($subcategories as $subcategory): ?>

                    <tr data-id="<?= $subcategory['id'] ?>" style=" border-bottom:1px solid rgba(255,255,255,.03); ">

                        <td class="px-4">
                            <span style=" font-size:13px; font-family:monospace; color:#475569; font-weight:600; ">
                                #<?= $sr++ ?>
                            </span>
                        </td>

                        <td width="120">

                            <?php if(!empty($subcategory['image'])): ?>

                            <div style=" width:80px; height:80px; overflow:hidden; border-radius:8px; border:1px solid rgba(255,255,255,.05); background:rgba(15,17,21,.80); ">

                                <img src="../<?= htmlspecialchars($subcategory['image']) ?>" style=" width:100%; height:100%; object-fit:cover; ">

                            </div>

                            <?php else: ?>

                            <div style=" width:80px; height:80px; display:flex; align-items:center; justify-content:center; border-radius:8px; border:1px dashed rgba(255,255,255,.10); background:rgba(255,255,255,.02); font-size:11px; color:#64748b; "> No Image </div>

                            <?php endif; ?>

                        </td>

                        <td>

                            <div style=" font-weight:600; font-size:15px; color:#fff; ">
                                <?= htmlspecialchars($subcategory['name']) ?>
                            </div>

                        </td>

                        <td>
                            <span class="badge px-3 py-2" style=" background:rgba(56,189,248,.10); color:#38bdf8; border:1px solid rgba(56,189,248,.20); "> <?= htmlspecialchars($subcategory['category_name']) ?> </span>
                        </td>

                        <td>
                            <span style=" font-family:monospace; color:#94a3b8; "> <?= htmlspecialchars($subcategory['slug']) ?> </span>
                        </td>

                        <td>

                            <?php if($subcategory['featured']): ?>

                            <span class="badge px-3 py-2" style=" background:rgba(16,185,129,.10); color:#10b981; border:1px solid rgba(16,185,129,.15); "> Featured </span>

                            <?php else: ?>

                            <span class="badge px-3 py-2" style=" background:rgba(255,255,255,.03); color:#64748b; border:1px solid rgba(255,255,255,.05); "> Standard </span>

                            <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <div class="d-flex justify-content-center align-items-center gap-2">
                                <a href="edit_subcategory.php?id=<?= $subcategory['id'] ?>" class="btn btn-sm px-3 py-1" style=" background:rgba(255,255,255,.03); color:#e2e8f0; border:1px solid rgba(255,255,255,.08); " > Edit </a>
                                <a href="delete_subcategory.php?id=<?= $subcategory['id'] ?>" class="btn btn-sm px-3 py-1" style=" background:rgba(239,68,68,.05); color:#f87171; border:1px solid rgba(239,68,68,.10); " onclick="return confirm('Delete subcategory?')" > Delete </a>
                            </div>

                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>
            </table>
            <?php if($totalPages>1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <?php for($i=1;$i<=$totalPages;$i++): ?>
                    <li class="page-item <?= $page==$i?'active':'' ?>">
                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= $categoryFilter ?>" >
                            <?= $i ?>
                        </a>
                    </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>

        </div>
    </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

<script>

new Sortable(document.getElementById('sortableSubcategories'),{

    animation:150,

    ghostClass:'table-warning',

    onEnd:function(){

        let order=[];

        document.querySelectorAll('#sortableSubcategories tr').forEach(function(row,index){

            order.push({

                id:row.dataset.id,

                order:index+1

            });

        });

        fetch('update_subcategory_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(order)
        })
        .then(res => res.text())
        .then(res => {
            console.log(res);
        })
        .catch(err => {
            console.log(err);
        });

    }

});

</script>

</body>
</html>