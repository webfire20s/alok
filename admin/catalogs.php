<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';


/*
|--------------------------------------------------------------------------
| FETCH CATALOGS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM catalogs
    ORDER BY display_order ASC, id DESC
");

$catalogs = $stmt->fetchAll();

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
        min-width:1000px;
    }

    .sortable-row{
        cursor:move;
    }

    .sortable-row:hover{
        background:rgba(255,255,255,.015);
    }

</style>


<div class="container-fluid py-4">
    <!-- PAGE HEADER -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5">
        <div>
            <h2 class="mb-1" style=" font-weight:700; letter-spacing:-.02em; color:#fff; " >
                Catalogs
            </h2>

            <p style=" color:#64748b; font-size:14px; margin:0; " >
                Upload, manage and organize your product catalogs.
            </p>

        </div>
        <a href="add_catalog.php" class="btn px-4 py-2 btn-glow-transition" style=" background:linear-gradient(135deg,#38bdf8,#0284c7); color:#fff; font-weight:600; border:none; border-radius:8px; box-shadow:0 4px 12px rgba(56,189,248,.25); " >
            + Add Catalog
        </a>
    </div>

    <!-- CATALOG TABLE -->
    <div class="card border-0" style=" border-radius:14px; background:rgba(21,25,34,.60); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.05)!important; box-shadow:0 20px 40px rgba(0,0,0,.25); overflow:hidden; " >
        <div class="card-body p-0">
            <div class="table-responsive custom-table-scroll" style=" overflow-x:auto; -webkit-overflow-scrolling:touch; " >
                <table class="table premium-table align-middle mb-0" style=" color:#e2e8f0; border-color:rgba(255,255,255,.03); " >
                    <thead style=" background:rgba(255,255,255,.02); border-bottom:2px solid rgba(255,255,255,.05); " >
                        <tr>

                            <th class="px-4 py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                #
                            </th>

                            <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                Thumbnail
                            </th>

                            <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                Catalog
                            </th>

                            <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                File
                            </th>

                            <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                Size
                            </th>

                            <th class="py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                Status
                            </th>

                            <th class="text-center py-3" style=" font-size:11px; text-transform:uppercase; letter-spacing:.05em; color:#64748b; font-weight:600; " >
                                Action
                            </th>

                        </tr>

                    </thead>


                    <tbody id="sortableCatalogs">


                    <?php if(empty($catalogs)): ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center py-5"
                                style="color:#64748b;"
                            >
                                No catalogs found.
                            </td>

                        </tr>

                    <?php else: ?>


                        <?php
                        $sr = 1;

                        foreach($catalogs as $catalog):
                        ?>


                        <tr
                            class="sortable-row"
                            data-id="<?= (int)$catalog['id'] ?>"
                            style="
                                border-bottom:1px solid rgba(255,255,255,.03);
                            "
                        >


                            <!-- SERIAL -->

                            <td class="px-4">

                                <span
                                    style="
                                        font-size:13px;
                                        font-family:monospace;
                                        color:#475569;
                                        font-weight:600;
                                    "
                                >
                                    #<?= $sr++ ?>
                                </span>

                            </td>



                            <!-- THUMBNAIL -->

                            <td width="120">

                                <div
                                    style="
                                        width:80px;
                                        height:80px;
                                        overflow:hidden;
                                        border-radius:8px;
                                        border:1px solid rgba(255,255,255,.05);
                                        background:rgba(15,17,21,.8);
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                    "
                                >

                                    <?php if(!empty($catalog['thumbnail'])): ?>

                                        <img
                                            src="../<?= htmlspecialchars($catalog['thumbnail']) ?>"
                                            alt="<?= htmlspecialchars($catalog['title']) ?>"
                                            style="
                                                width:100%;
                                                height:100%;
                                                object-fit:cover;
                                            "
                                        >

                                    <?php else: ?>

                                        <span
                                            style="
                                                font-size:10px;
                                                color:#475569;
                                            "
                                        >
                                            No Image
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </td>



                            <!-- CATALOG DETAILS -->

                            <td>

                                <div
                                    style="
                                        font-weight:600;
                                        font-size:15px;
                                        color:#fff;
                                        line-height:1.4;
                                    "
                                >
                                    <?= htmlspecialchars($catalog['title']) ?>
                                </div>


                                <?php if(!empty($catalog['description'])): ?>

                                    <div
                                        style="
                                            font-size:12px;
                                            color:#64748b;
                                            margin-top:4px;
                                            max-width:300px;
                                        "
                                    >
                                        <?= htmlspecialchars(
                                            substr(
                                                strip_tags($catalog['description']),
                                                0,
                                                100
                                            )
                                        ) ?>
                                        <?= strlen(strip_tags($catalog['description'])) > 100 ? '...' : '' ?>
                                    </div>

                                <?php endif; ?>

                            </td>



                            <!-- FILE -->
                            <td>

                                <span style=" font-family:monospace; color:#94a3b8; font-size:12px; " >
                                    <?= htmlspecialchars($catalog['file_name']) ?>
                                </span>

                            </td>

                            <!-- SIZE -->
                            <td>

                                <?php

                                $fileSize = (int)$catalog['file_size'];

                                if($fileSize >= 1048576){
                                    $sizeText = number_format( $fileSize / 1048576, 2 ) . ' MB';
                                }else{
                                    $sizeText = number_format( $fileSize / 1024, 2 ) . ' KB';
                                }

                                ?>

                                <span style=" color:#94a3b8; font-size:13px; " >
                                    <?= $sizeText ?>
                                </span>

                            </td>



                            <!-- STATUS -->

                            <td>

                                <?php if($catalog['status']): ?>

                                    <span class="badge px-3 py-2" style=" font-size:12px; background:rgba(16,185,129,.10); color:#10b981; border:1px solid rgba(16,185,129,.15); font-weight:500; border-radius:6px; " >
                                        Active
                                    </span>

                                <?php else: ?>

                                    <span class="badge px-3 py-2" style=" font-size:12px; background:rgba(239,68,68,.10); color:#f87171; border:1px solid rgba(239,68,68,.15); font-weight:500; border-radius:6px; " >
                                        Disabled
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- ACTIONS -->
                            <td class="text-center">

                                <div class="d-flex justify-content-center align-items-center" style="gap:8px;" >

                                    <a href="../<?= htmlspecialchars($catalog['file_path']) ?>" target="_blank" class="btn btn-sm px-3 py-1" style=" background:rgba(56,189,248,.08); color:#38bdf8; border:1px solid rgba(56,189,248,.20); font-weight:500; font-size:13px; border-radius:6px; " >
                                        Preview
                                    </a>

                                    <a href="edit_catalog.php?id=<?= (int)$catalog['id'] ?>" class="btn btn-sm px-3 py-1" style=" background:rgba(255,255,255,.03); color:#e2e8f0; border:1px solid rgba(255,255,255,.08); font-weight:500; font-size:13px; border-radius:6px; " >
                                        Edit
                                    </a>

                                    <a href="delete_catalog.php?id=<?= (int)$catalog['id'] ?>" class="btn btn-sm px-3 py-1" style=" background:rgba(239,68,68,.05); color:#f87171; border:1px solid rgba(239,68,68,.10); font-weight:500; font-size:13px; border-radius:6px; " onclick="return confirm('Delete this catalog?')" >
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- SORTABLE JS -->

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>

document.addEventListener("DOMContentLoaded", function(){

    const tbody = document.getElementById("sortableCatalogs");

    if(!tbody){
        return;
    }
    new Sortable(tbody, {
        animation: 200,
        ghostClass: "table-warning",
        onEnd: function(){
            let order = [];
            tbody.querySelectorAll("tr[data-id]").forEach(function(row, index){
                order.push({
                    id: row.dataset.id,
                    order: index + 1
                });
            });

            fetch("update_catalog_order.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(order)
            })
            .then(response => response.json())
            .then(data => {
                if(!data.success){
                    alert("Unable to save catalog order.");
                }
            })
            .catch(error => {
                console.error(error);
                alert("An error occurred while saving the catalog order.");
            });
        }
    });
});
</script>
</body>
</html>