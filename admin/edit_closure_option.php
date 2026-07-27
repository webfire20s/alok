<?php

require 'includes/auth.php';
require '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT *
    FROM closure_options
    WHERE id = ?
");
$stmt->execute([$id]);

$closure = $stmt->fetch();

if(!$closure){
    die("Closure Option not found.");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $name = trim($_POST['name']);

    $price = !empty($_POST['price'])
        ? $_POST['price']
        : 0;

    $sortOrder = !empty($_POST['sort_order'])
        ? $_POST['sort_order']
        : 0;

    $status = isset($_POST['status'])
        ? 1
        : 0;

    /*
    |--------------------------------------------------------------------------
    | IMAGE
    |--------------------------------------------------------------------------
    */

    $image = $closure['image'];

    if(!empty($_FILES['image']['name'])){

        $fileName =
            time() . "_" .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../storage/media/".$fileName
        );

        $image = "storage/media/".$fileName;

    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    $update = $pdo->prepare("
        UPDATE closure_options
        SET
            name=?,
            price=?,
            image=?,
            status=?,
            sort_order=?
        WHERE id=?
    ");

    $update->execute([
        $name,
        $price,
        $image,
        $status,
        $sortOrder,
        $id
    ]);

    header("Location: closure_options.php");
    exit;

}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="mb-4">

        <h2
            style="
                color:#ffffff;
                font-weight:700;
            "
        >
            Edit Closure Option
        </h2>

        <p
            style="
                color:#94a3b8;
                margin:0;
            "
        >
            Update the selected closure option.
        </p>

    </div>

    <div
        class="card border-0 shadow-sm"
        style="
            background:rgba(21,25,34,.65);
            border-radius:14px;
            backdrop-filter:blur(12px);
        "
    >

        <div class="card-body p-4">

            <form
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="row">

                    <div class="col-lg-8">

                        <div class="form-group mb-4">

                            <label class="mb-2 text-white-50">

                                Closure Name

                            </label>

                            <input
                                type="text"
                                name="name"
                                required
                                value="<?= htmlspecialchars($closure['name']) ?>"
                                class="form-control text-white"
                                style="
                                    background:rgba(15,17,21,.5);
                                    border:1px solid rgba(255,255,255,.08);
                                    height:45px;
                                "
                            >

                        </div>

                        <div class="form-group mb-4">

                            <label class="mb-2 text-white-50">

                                Additional Price (₹)

                            </label>

                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                value="<?= $closure['price'] ?>"
                                class="form-control text-white"
                                style="
                                    background:rgba(15,17,21,.5);
                                    border:1px solid rgba(255,255,255,.08);
                                    height:45px;
                                "
                            >

                        </div>

                        <div class="form-group mb-4">

                            <label class="mb-2 text-white-50">

                                Sort Order

                            </label>

                            <input
                                type="number"
                                name="sort_order"
                                value="<?= $closure['sort_order'] ?>"
                                class="form-control text-white"
                                style="
                                    background:rgba(15,17,21,.5);
                                    border:1px solid rgba(255,255,255,.08);
                                    height:45px;
                                "
                            >

                        </div>

                    </div>

                    <div class="col-lg-4">

                        <div
                            class="p-4"
                            style="
                                background:rgba(15,17,21,.4);
                                border-radius:10px;
                            "
                        >

                            <?php if(!empty($closure['image'])): ?>

                                <div class="mb-3 text-center">

                                    <img
                                        src="../<?= htmlspecialchars($closure['image']) ?>"
                                        style="
                                            max-width:140px;
                                            border-radius:8px;
                                            background:#fff;
                                            padding:5px;
                                        "
                                    >

                                </div>

                            <?php endif; ?>

                            <div class="form-group mb-4">

                                <label class="mb-2 text-white-50">

                                    Replace Image

                                </label>

                                <input
                                    type="file"
                                    name="image"
                                    class="form-control text-white"
                                >

                            </div>

                            <div class="form-check mb-4">

                                <input
                                    type="checkbox"
                                    name="status"
                                    id="status"
                                    class="form-check-input"
                                    <?= $closure['status'] ? 'checked' : '' ?>
                                >

                                <label
                                    for="status"
                                    class="form-check-label text-white"
                                >

                                    Active

                                </label>

                            </div>

                            <button
                                class="btn btn-block"
                                style="
                                    background:linear-gradient(135deg,#38bdf8,#0284c7);
                                    color:#fff;
                                    font-weight:600;
                                    border:none;
                                    border-radius:8px;
                                    padding:10px;
                                "
                            >

                                Update Closure Option

                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>