<?php

require 'includes/auth.php';
require '../includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    foreach($_FILES['images']['tmp_name'] as $key => $tmpName){

        if(empty($tmpName)){
            continue;
        }

        $name =
            time()
            .
            rand(1000,9999)
            .
            '_'
            .
            basename(
                $_FILES['images']['name'][$key]
            );

        $path =
            'uploads/gallery/'
            .
            $name;

        move_uploaded_file(
            $tmpName,
            '../' . $path
        );

        $stmt = $pdo->prepare("
            INSERT INTO gallery
            (
                image,
                category
            )
            VALUES
            (?,?)
        ");

        $stmt->execute([
            $path,
            $_POST['category']
        ]);
    }

    header("Location: gallery.php");
    exit;
}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';
?>

<div class="content-wrapper">
<div class="container-fluid">

    <h3 class="mb-4">
        Add Gallery Images
    </h3>

    <form
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="form-group">

            <label>
                Category
            </label>

            <select
                name="category"
                class="form-control"
            >

                <option value="">
                    Select Category
                </option>

                <option>
                    Factory
                </option>

                <option>
                    Products
                </option>

                <option>
                    Packaging
                </option>

                <option>
                    Events
                </option>

                <option>
                    Certificates
                </option>

            </select>

        </div>

        <div class="form-group">

            <label>
                Images
            </label>

            <input
                type="file"
                name="images[]"
                multiple
                class="form-control"
                required
            >

        </div>

        <button class="btn btn-primary">

            Upload

        </button>

    </form>

</div>
</div>

