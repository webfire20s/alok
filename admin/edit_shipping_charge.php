<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM shipping_rates
    WHERE id=?
");
$stmt->execute([$id]);

$rate = $stmt->fetch();

if(!$rate){
    die("Shipping rate not found.");
}

$states = $pdo->query("
    SELECT *
    FROM states
    WHERE status=1
    ORDER BY sort_order,name
")->fetchAll();

$methods = $pdo->query("
    SELECT *
    FROM shipping_methods
    WHERE status=1
    ORDER BY sort_order,name
")->fetchAll();

if($_SERVER['REQUEST_METHOD']=="POST"){

    $state_id = (int)$_POST['state_id'];
    $shipping_method_id = (int)$_POST['shipping_method_id'];
    $charge = (float)$_POST['charge'];
    $status = (int)$_POST['status'];

    $stmt = $pdo->prepare("
        UPDATE shipping_rates
        SET
            state_id=?,
            shipping_method_id=?,
            charge=?,
            status=?
        WHERE id=?
    ");

    $stmt->execute([
        $state_id,
        $shipping_method_id,
        $charge,
        $status,
        $id
    ]);

    header("Location: shipping_charge.php");
    exit;
}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="mb-5">

        <h2
            style="
                color:#ffffff;
                font-weight:700;
                letter-spacing:-.02em;
            "
        >
            Edit Shipping Rate
        </h2>

        <p
            style="
                color:#64748b;
                margin:0;
            "
        >
            Update state wise shipping charges.
        </p>

    </div>

    <div
        class="card border-0"
        style="
            background:rgba(21,25,34,.6);
            border-radius:14px;
            backdrop-filter:blur(12px);
            border:1px solid rgba(255,255,255,.05);
            box-shadow:0 20px 40px rgba(0,0,0,.25);
        "
    >

        <div class="card-body p-4">

            <form method="POST">

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label
                            class="mb-2"
                            style="
                                color:#94a3b8;
                                font-size:12px;
                                text-transform:uppercase;
                                font-weight:600;
                            "
                        >
                            State
                        </label>

                        <select
                            name="state_id"
                            class="form-control text-white"
                            required
                            style="
                                background:#151922;
                                border:1px solid rgba(255,255,255,.08);
                                height:45px;
                            "
                        >

                            <?php foreach($states as $state): ?>

                                <option
                                    value="<?= $state['id'] ?>"
                                    <?= $rate['state_id']==$state['id']?'selected':'' ?>
                                >
                                    <?= htmlspecialchars($state['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label
                            class="mb-2"
                            style="
                                color:#94a3b8;
                                font-size:12px;
                                text-transform:uppercase;
                                font-weight:600;
                            "
                        >
                            Shipping Method
                        </label>

                        <select
                            name="shipping_method_id"
                            class="form-control text-white"
                            required
                            style="
                                background:#151922;
                                border:1px solid rgba(255,255,255,.08);
                                height:45px;
                            "
                        >

                            <?php foreach($methods as $method): ?>

                                <option
                                    value="<?= $method['id'] ?>"
                                    <?= $rate['shipping_method_id']==$method['id']?'selected':'' ?>
                                >
                                    <?= htmlspecialchars($method['name']) ?>
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="col-md-6 mb-4">

                        <label
                            class="mb-2"
                            style="
                                color:#94a3b8;
                                font-size:12px;
                                text-transform:uppercase;
                                font-weight:600;
                            "
                        >
                            Shipping Charge (₹)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            min="0"
                            name="charge"
                            class="form-control text-white"
                            value="<?= $rate['charge'] ?>"
                            required
                            style="
                                background:#151922;
                                border:1px solid rgba(255,255,255,.08);
                                height:45px;
                            "
                        >

                    </div>

                    <div class="col-md-6 mb-4">

                        <label
                            class="mb-2"
                            style="
                                color:#94a3b8;
                                font-size:12px;
                                text-transform:uppercase;
                                font-weight:600;
                            "
                        >
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-control text-white"
                            style="
                                background:#151922;
                                border:1px solid rgba(255,255,255,.08);
                                height:45px;
                            "
                        >

                            <option
                                value="1"
                                <?= $rate['status']?'selected':'' ?>
                            >
                                Active
                            </option>

                            <option
                                value="0"
                                <?= !$rate['status']?'selected':'' ?>
                            >
                                Disabled
                            </option>

                        </select>

                    </div>

                </div>

                <hr
                    style="
                        border-color:
                        rgba(255,255,255,.06);
                    "
                >

                <button
                    type="submit"
                    class="btn px-4 py-2"
                    style="
                        background:
                        linear-gradient(
                            135deg,
                            #38bdf8,
                            #0284c7
                        );

                        color:#fff;

                        border:none;

                        font-weight:600;
                    "
                >
                    Update Shipping Rate
                </button>

                <a
                    href="shipping_charge.php"
                    class="btn btn-secondary px-4 py-2 ms-2"
                >
                    Cancel
                </a>

            </form>

        </div>

    </div>

</div>

</body>
</html>