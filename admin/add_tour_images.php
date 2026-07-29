<?php

require 'includes/auth.php';
require '../includes/db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $section = $_POST['section'] ?? '';

    if(
        in_array($section, ['entrance','processing','decoration'])
        && !empty($_FILES['images']['name'][0])
    ){

        $uploadDir = "../storage/tour/";

        if(!is_dir($uploadDir)){
            mkdir($uploadDir,0755,true);
        }

        /*
        |--------------------------------------------------------------------------
        | START DISPLAY ORDER
        |--------------------------------------------------------------------------
        */

        $stmt = $pdo->prepare("
            SELECT COALESCE(MAX(display_order),0)
            FROM tour_images
            WHERE section=?
        ");

        $stmt->execute([$section]);

        $displayOrder = (int)$stmt->fetchColumn();

        /*
        |--------------------------------------------------------------------------
        | LOOP IMAGES
        |--------------------------------------------------------------------------
        */

        foreach($_FILES['images']['tmp_name'] as $key=>$tmpName){

            if(empty($tmpName)){
                continue;
            }

            $extension = strtolower(
                pathinfo(
                    $_FILES['images']['name'][$key],
                    PATHINFO_EXTENSION
                )
            );

            $allowed = ['jpg','jpeg','png','webp'];

            if(!in_array($extension,$allowed)){
                continue;
            }

            $imageName =
                uniqid('tour_',true).'.'.$extension;

            move_uploaded_file(
                $tmpName,
                $uploadDir.$imageName
            );

            $displayOrder++;

            $insert = $pdo->prepare("
                INSERT INTO tour_images
                (
                    section,
                    image,
                    display_order
                )
                VALUES
                (
                    ?,
                    ?,
                    ?
                )
            ");

            $insert->execute([
                $section,
                $imageName,
                $displayOrder
            ]);

        }

        header("Location: tour_images.php?success=1");
        exit;

    }

}

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card">

                <div class="card-header">

                    <h4 class="mb-0">
                        Upload Factory Tour Images
                    </h4>

                </div>

                <div class="card-body">

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <div class="mb-4">

                            <label class="form-label">
                                Section
                            </label>

                            <select
                                name="section"
                                class="form-select"
                                required
                            >

                                <option value="">
                                    Select Section
                                </option>

                                <option value="entrance">
                                    Entrance
                                </option>

                                <option value="processing">
                                    Processing
                                </option>

                                <option value="decoration">
                                    Decoration
                                </option>

                            </select>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Images
                            </label>

                            <input
                                type="file"
                                name="images[]"
                                multiple
                                required
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control"
                            >

                            <small class="text-muted">
                                You can select dozens of images together.
                            </small>

                        </div>

                        <button
                            class="btn btn-primary"
                        >
                            Upload Images
                        </button>

                        <a
                            href="tour_images.php"
                            class="btn btn-secondary"
                        >
                            Back
                        </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

