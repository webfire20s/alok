<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| GET STATES
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT *
    FROM states
    ORDER BY sort_order ASC,
             name ASC
");

$states = $stmt->fetchAll();

?>

<style>

    .custom-table-scroll::-webkit-scrollbar{
        height:6px;
    }

    .custom-table-scroll::-webkit-scrollbar-track{
        background:rgba(255,255,255,.02);
    }

    .custom-table-scroll::-webkit-scrollbar-thumb{
        background:rgba(56,189,248,.25);
        border-radius:10px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb:hover{
        background:rgba(56,189,248,.45);
    }

    .btn-glow-transition{
        transition:.2s;
    }

    .btn-glow-transition:hover{
        transform:translateY(-1px);
    }

    .premium-table{
        min-width:850px;
    }

</style>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h2 class="mb-1" style=" color:#fff; font-weight:700; " >
                States
            </h2>

            <p style=" color:#64748b; margin:0; font-size:14px; " >
                Manage destination states for shipping.
            </p>

        </div>

        <a href="add_state.php" class="btn px-4 py-2 btn-glow-transition" style=" background:linear-gradient(135deg,#38bdf8,#0284c7); color:#fff; border:none; border-radius:8px; font-weight:600; " >
            + Add State
        </a>

    </div>

    <div class="card border-0" style=" border-radius:14px; background:rgba(21,25,34,.60); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,.05); " >

        <div class="card-body p-0">
            <div class="table-responsive custom-table-scroll" >

                <table class="table premium-table align-middle mb-0" style=" color:#e2e8f0; ">

                    <thead style=" background:rgba(255,255,255,.02); " >

                        <tr>
                            <th class="px-4 py-3"> # </th>
                            <th> State </th>
                            <th> Code </th>
                            <th> Status </th>
                            <th class="text-center"> Action </th>
                        </tr>

                    </thead>

                    <tbody id="sortableStates">

                    <?php

                    $sr=1;

                    foreach($states as $state):

                    ?>

                    <tr
                        data-id="<?= $state['id'] ?>"
                        style="
                            cursor:move;
                            border-bottom:1px solid rgba(255,255,255,.03);
                        "
                    >

                        <td class="px-4">

                            <span
                                style="
                                    font-family:monospace;
                                    color:#64748b;
                                "
                            >

                                #<?= $sr++ ?>

                            </span>

                        </td>

                        <td>

                            <strong>

                                <?= htmlspecialchars($state['name']) ?>

                            </strong>

                        </td>

                        <td>

                            <?= htmlspecialchars($state['code']) ?>

                        </td>

                        <td>

                        <?php if($state['status']): ?>

                            <span
                                class="badge"
                                style="
                                    background:rgba(16,185,129,.15);
                                    color:#10b981;
                                "
                            >

                                Active

                            </span>

                        <?php else: ?>

                            <span
                                class="badge"
                                style="
                                    background:rgba(239,68,68,.15);
                                    color:#ef4444;
                                "
                            >

                                Inactive

                            </span>

                        <?php endif; ?>

                        </td>

                        <td class="text-center">

                            <a
                                href="edit_state.php?id=<?= $state['id'] ?>"
                                class="btn btn-sm"
                            >

                                Edit

                            </a>

                            <a
                                href="delete_state.php?id=<?= $state['id'] ?>"
                                class="btn btn-sm btn-danger"
                                onclick="return confirm('Delete this state?')"
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

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>

<script>

const tbody=document.getElementById("sortableStates");

new Sortable(tbody,{

    animation:200,

    onEnd:function(){

        let order=[];

        let i=1;

        tbody.querySelectorAll("tr").forEach(function(row){

            order.push({

                id:row.dataset.id,

                order:i++

            });

        });

        fetch("update_state_order.php",{

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