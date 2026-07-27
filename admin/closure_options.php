<?php

require 'includes/auth.php';
require '../includes/db.php';

$stmt = $pdo->query("
    SELECT *
    FROM closure_options
    ORDER BY sort_order ASC, id DESC
");

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

            </div>

        </div>

    </div>

</div>

</body>
</html>