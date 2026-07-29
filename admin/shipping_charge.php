<?php

require 'includes/auth.php';
require '../includes/db.php';

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

/*
|--------------------------------------------------------------------------
| GET SHIPPING RULES
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT
        shipping_rates.*,
        states.name AS state_name,
        shipping_methods.name AS method_name
    FROM shipping_rates

    INNER JOIN states
        ON shipping_rates.state_id = states.id

    INNER JOIN shipping_methods
        ON shipping_rates.shipping_method_id = shipping_methods.id

    ORDER BY
        states.sort_order ASC,
        shipping_methods.sort_order ASC
");

$shippingRates = $stmt->fetchAll();

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
    background:rgba(56,189,248,.45);
}

.btn-glow-transition{
    transition:
        transform .2s,
        box-shadow .2s !important;
}

.btn-glow-transition:hover{
    transform:translateY(-1px);
    box-shadow:
        0 6px 20px rgba(56,189,248,.35) !important;
}

.premium-table{
    min-width:1100px;
}

</style>

<div class="container-fluid py-4">

    <div
        class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-5"
    >

        <div>

            <h2
                class="mb-1"
                style="
                    font-weight:700;
                    letter-spacing:-.02em;
                    color:#ffffff;
                "
            >
                Shipping Charges
            </h2>

            <p
                style="
                    color:#64748b;
                    font-size:14px;
                    margin:0;
                "
            >
                Configure shipping rules state wise.
            </p>

        </div>

        <a
            href="add_shipping_charge.php"
            class="btn px-4 py-2 btn-glow-transition"
            style="
                background:
                    linear-gradient(
                        135deg,
                        #38bdf8,
                        #0284c7
                    );

                color:#fff;

                border:none;

                border-radius:8px;

                font-weight:600;

                box-shadow:
                    0 4px 12px
                    rgba(56,189,248,.25);
            "
        >

            + Add Shipping Rule

        </a>

    </div>

    <div
        class="card border-0"
        style="
            border-radius:14px;

            background:
                rgba(21,25,34,.6);

            backdrop-filter:blur(12px);

            border:
                1px solid
                rgba(255,255,255,.05);

            box-shadow:
                0 20px 40px
                rgba(0,0,0,.25);

            overflow:hidden;
        "
    >

        <div class="card-body p-0">

            <div
                class="table-responsive custom-table-scroll"
            >

                <table
                    class="table premium-table align-middle mb-0"
                    style="
                        color:#e2e8f0;
                        border-color:
                        rgba(255,255,255,.03);
                    "
                >

                    <thead
                        style="
                            background:
                            rgba(255,255,255,.02);

                            border-bottom:
                            2px solid
                            rgba(255,255,255,.05);
                        "
                    >

                        <tr>

                            <th
                                class="px-4 py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                Sr.
                            </th>

                            <th
                                class="py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                State
                            </th>

                            <th
                                class="py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                Shipping Method
                            </th>

                            <th
                                class="py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                Shipping Charge
                            </th>

                            <th
                                class="py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                Status
                            </th>

                            <th
                                class="text-center py-3"
                                style="
                                    font-size:11px;
                                    text-transform:uppercase;
                                    letter-spacing:.05em;
                                    color:#64748b;
                                "
                            >
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php
                        $sr = 1;
                        foreach($shippingRates as $charge):
                        ?>

                        <tr
                            style="
                                border-bottom:
                                1px solid rgba(255,255,255,.03);
                            "
                        >

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

                            <td>

                                <div
                                    style="
                                        font-weight:600;
                                        color:#ffffff;
                                        font-size:15px;
                                    "
                                >

                                    <?= htmlspecialchars($charge['state_name']) ?>

                                </div>

                            </td>

                            <td>

                                <span
                                    class="badge px-3 py-2"
                                    style="
                                        background:rgba(56,189,248,.10);
                                        color:#38bdf8;
                                        border:1px solid rgba(56,189,248,.18);
                                        font-size:12px;
                                        border-radius:6px;
                                    "
                                >

                                    <?= htmlspecialchars($charge['method_name']) ?>

                                </span>

                            </td>

                            <td>

                                <span
                                    style="
                                        font-size:15px;
                                        color:#38bdf8;
                                        font-weight:700;
                                    "
                                >

                                    ₹<?= number_format($charge['charge'],2) ?>

                                </span>

                            </td>

                            <td>

                                <?php if($charge['status']): ?>

                                    <span
                                        class="badge px-3 py-2"
                                        style="
                                            background:rgba(16,185,129,.10);
                                            color:#10b981;
                                            border:1px solid rgba(16,185,129,.18);
                                        "
                                    >

                                        Active

                                    </span>

                                <?php else: ?>

                                    <span
                                        class="badge px-3 py-2"
                                        style="
                                            background:rgba(239,68,68,.10);
                                            color:#f87171;
                                            border:1px solid rgba(239,68,68,.18);
                                        "
                                    >

                                        Disabled

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="text-center">

                                <div
                                    class="d-flex justify-content-center"
                                    style="gap:8px;"
                                >

                                    <a
                                        href="edit_shipping_charge.php?id=<?= $charge['id'] ?>"
                                        class="btn btn-sm px-3 py-1"
                                        style="
                                            background:rgba(255,255,255,.03);
                                            color:#e2e8f0;
                                            border:1px solid rgba(255,255,255,.08);
                                        "
                                    >

                                        Edit

                                    </a>

                                    <a
                                        href="delete_shipping_charge.php?id=<?= $charge['id'] ?>"
                                        class="btn btn-sm px-3 py-1"
                                        style="
                                            background:rgba(239,68,68,.05);
                                            color:#f87171;
                                            border:1px solid rgba(239,68,68,.12);
                                        "
                                        onclick="return confirm('Delete this shipping rate?');"
                                    >

                                        Delete

                                    </a>

                                </div>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                        <?php if(empty($shippingRates)): ?>

                        <tr>

                            <td colspan="6" class="text-center py-5">

                                <div
                                    style="
                                        color:#64748b;
                                        font-size:15px;
                                    "
                                >

                                    No shipping rates found.

                                </div>

                            </td>

                        </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>