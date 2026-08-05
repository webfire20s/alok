<?php

require 'includes/auth.php';
require '../includes/db.php';

/*
|--------------------------------------------------------------------------
| SEARCH + PAGINATION
|--------------------------------------------------------------------------
*/

$search = trim($_GET['search'] ?? '');

$page = max(1, (int)($_GET['page'] ?? 1));

$perPage = 20;

$where = [];
$params = [];

if($search != ''){

    if(is_numeric($search)){

        $where[] = "(id = ? OR name LIKE ?)";

        $params[] = (int)$search;
        $params[] = "%{$search}%";

    }else{

        $where[] = "name LIKE ?";

        $params[] = "%{$search}%";

    }

}

$whereSql = '';

if($where){

    $whereSql = ' WHERE '.implode(' AND ', $where);

}

/* TOTAL */

$countSql = "
SELECT COUNT(*)
FROM closure_options
{$whereSql}
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);

$totalRecords = (int)$countStmt->fetchColumn();

$totalPages = max(1, ceil($totalRecords / $perPage));

$page = min($page, $totalPages);

$offset = ($page - 1) * $perPage;

/* DATA */

$sql = "
SELECT *
FROM closure_options
{$whereSql}
ORDER BY
sort_order ASC,
id DESC
LIMIT {$offset}, {$perPage}
";

$stmt = $pdo->prepare($sql);

$stmt->execute($params);

$closureOptions = $stmt->fetchAll();

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1" style="font-weight:700;color:#ffffff;">
                Closure Options
            </h2>

            <p style="color:#94a3b8;font-size:14px;margin:0;">
                Manage bottle caps, droppers, pumps and other closure options.
            </p>
        </div>

        <a
            href="add_closure_option.php"
            class="btn"
            style="
                background:linear-gradient(135deg,#38bdf8,#0284c7);
                color:#fff;
                font-weight:600;
                border-radius:8px;
                padding:10px 20px;
            "
        >
            + Add Closure Option
        </a>

    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <form method="GET">
                <div class="input-group">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search by ID or Name..."
                        value="<?= htmlspecialchars($search) ?>"
                    >
                    <button class="btn btn-primary">
                        Search
                    </button>
                    <?php if($search!=''): ?>
                        <a
                            href="closure_options.php"
                            class="btn btn-secondary"
                        >
                            Clear
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <div
        class="card border-0 shadow-sm"
        style="
            background:rgba(21,25,34,.65);
            border-radius:14px;
            backdrop-filter:blur(12px);
        "
    >

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-dark align-middle mb-0">

                    <thead>

                        <tr>

                            <th width="80">Image</th>

                            <th>Name</th>

                            <th width="130">Price</th>

                            <th width="120">Sort</th>

                            <th width="120">Status</th>

                            <th width="170" class="text-end">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if(empty($closureOptions)): ?>

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                No Closure Options Found.

                            </td>

                        </tr>

                    <?php endif; ?>

                    <?php foreach($closureOptions as $closure): ?>

                        <tr>

                            <td>

                                <?php if(!empty($closure['image'])): ?>

                                    <img
                                        src="../<?= htmlspecialchars($closure['image']) ?>"
                                        style="
                                            width:60px;
                                            height:60px;
                                            object-fit:contain;
                                            background:#fff;
                                            border-radius:8px;
                                            padding:4px;
                                        "
                                    >

                                <?php else: ?>

                                    <div
                                        style="
                                            width:60px;
                                            height:60px;
                                            background:#1f2937;
                                            border-radius:8px;
                                        "
                                    ></div>

                                <?php endif; ?>

                            </td>

                            <td>

                                <strong>

                                    <?= htmlspecialchars($closure['name']) ?>

                                </strong>

                            </td>

                            <td>

                                ₹<?= number_format($closure['price'],2) ?>

                            </td>

                            <td>

                                <?= $closure['sort_order'] ?>

                            </td>

                            <td>

                                <?php if($closure['status']): ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#10b981;
                                            color:#fff;
                                        "
                                    >
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge"
                                        style="
                                            background:#ef4444;
                                            color:#fff;
                                        "
                                    >
                                        Disabled
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="text-end">

                                <a
                                    href="edit_closure_option.php?id=<?= $closure['id'] ?>"
                                    class="btn btn-sm btn-info"
                                >
                                    Edit
                                </a>

                                <a
                                    href="delete_closure_option.php?id=<?= $closure['id'] ?>"
                                    class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this closure option?')"
                                >
                                    Delete
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>
                <?php if($totalPages > 1): ?>

                <div class="d-flex justify-content-between align-items-center p-3">
                    <small style="color:#94a3b8;">
                        Showing page <?= $page ?> of <?= $totalPages ?>
                    </small>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a
                                        class="page-link"
                                        href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>"
                                    >
                                        Previous
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php
                            for($i=1;$i<=$totalPages;$i++):
                            ?>
                                <li class="page-item <?= $page==$i?'active':'' ?>">
                                    <a
                                        class="page-link"
                                        href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"
                                    >
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                            <?php if($page < $totalPages): ?>
                                <li class="page-item">
                                    <a
                                        class="page-link"
                                        href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>"
                                    >
                                        Next
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


</div>

</body>
</html>