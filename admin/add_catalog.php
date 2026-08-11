<?php

require 'includes/auth.php';
require '../includes/db.php';

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = isset($_POST['status']) ? 1 : 0;


    /*
    |--------------------------------------------------------------------------
    | BASIC VALIDATION
    |--------------------------------------------------------------------------
    */

    if($title === ''){

        $error = 'Catalog title is required.';

    }elseif(
        empty($_FILES['catalog_file']['name']) ||
        $_FILES['catalog_file']['error'] !== UPLOAD_ERR_OK
    ){

        $error = 'Please select a catalog PDF file.';

    }elseif(
        empty($_FILES['thumbnail']['name']) ||
        $_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK
    ){

        $error = 'Please select a thumbnail image.';

    }


    /*
    |--------------------------------------------------------------------------
    | CATALOG PDF
    |--------------------------------------------------------------------------
    */

    if($error === ''){

        $file = $_FILES['catalog_file'];

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );


        if($extension !== 'pdf'){

            $error = 'Only PDF catalog files are allowed.';

        }

        /*
        |--------------------------------------------------------------------------
        | FILE SIZE
        |--------------------------------------------------------------------------
        */

        elseif($file['size'] <= 0){

            $error = 'The selected PDF file is empty.';

        }

        /*
        |--------------------------------------------------------------------------
        | MIME TYPE
        |--------------------------------------------------------------------------
        */

        else{

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            $mime = finfo_file(
                $finfo,
                $file['tmp_name']
            );

            finfo_close($finfo);


            if($mime !== 'application/pdf'){

                $error = 'Invalid PDF file.';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL VALIDATION
    |--------------------------------------------------------------------------
    */

    if($error === ''){

        $thumbnail = $_FILES['thumbnail'];

        $thumbnailExtension = strtolower(
            pathinfo(
                $thumbnail['name'],
                PATHINFO_EXTENSION
            )
        );


        $allowedThumbnailExtensions = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if(
            !in_array(
                $thumbnailExtension,
                $allowedThumbnailExtensions,
                true
            )
        ){

            $error =
                'Thumbnail must be JPG, JPEG, PNG or WEBP.';

        }


        /*
        |--------------------------------------------------------------------------
        | VERIFY IMAGE
        |--------------------------------------------------------------------------
        */

        if($error === ''){

            $imageInfo = @getimagesize(
                $thumbnail['tmp_name']
            );

            if($imageInfo === false){

                $error = 'Invalid thumbnail image.';

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SAVE FILES
    |--------------------------------------------------------------------------
    */

    if($error === ''){

        $catalogDirectory =
            '../storage/catalogs/files/';

        $thumbnailDirectory =
            '../storage/catalogs/thumbnails/';


        /*
        |--------------------------------------------------------------------------
        | CREATE DIRECTORIES IF REQUIRED
        |--------------------------------------------------------------------------
        */

        if(!is_dir($catalogDirectory)){

            mkdir(
                $catalogDirectory,
                0755,
                true
            );

        }

        if(!is_dir($thumbnailDirectory)){

            mkdir(
                $thumbnailDirectory,
                0755,
                true
            );

        }


        /*
        |--------------------------------------------------------------------------
        | UNIQUE FILE NAMES
        |--------------------------------------------------------------------------
        */

        $uniqueName =
            time() . '_' .
            bin2hex(random_bytes(5));


        $catalogFileName =
            $uniqueName . '.pdf';


        $thumbnailFileName =
            $uniqueName . '.' .
            $thumbnailExtension;


        $catalogPath =
            $catalogDirectory .
            $catalogFileName;


        $thumbnailPath =
            $thumbnailDirectory .
            $thumbnailFileName;


        /*
        |--------------------------------------------------------------------------
        | MOVE PDF
        |--------------------------------------------------------------------------
        */

        if(!move_uploaded_file(
            $file['tmp_name'],
            $catalogPath
        )){

            $error =
                'Unable to upload the catalog PDF.';

        }


        /*
        |--------------------------------------------------------------------------
        | MOVE THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if(
            $error === '' &&
            !move_uploaded_file(
                $thumbnail['tmp_name'],
                $thumbnailPath
            )
        ){

            /*
            |--------------------------------------------------------------------------
            | CLEAN UP PDF IF THUMBNAIL FAILED
            |--------------------------------------------------------------------------
            */

            if(file_exists($catalogPath)){

                unlink($catalogPath);

            }

            $error =
                'Unable to upload the thumbnail.';

        }


        /*
        |--------------------------------------------------------------------------
        | DATABASE INSERT
        |--------------------------------------------------------------------------
        */

        if($error === ''){

            try{

                /*
                |--------------------------------------------------------------------------
                | GET NEXT DISPLAY ORDER
                |--------------------------------------------------------------------------
                */

                $orderStmt = $pdo->query("
                    SELECT COALESCE(
                        MAX(display_order),
                        0
                    ) + 1
                    FROM catalogs
                ");

                $displayOrder =
                    (int)$orderStmt->fetchColumn();


                /*
                |--------------------------------------------------------------------------
                | DATABASE PATHS
                |--------------------------------------------------------------------------
                */

                $dbFilePath =
                    'storage/catalogs/files/' .
                    $catalogFileName;


                $dbThumbnailPath =
                    'storage/catalogs/thumbnails/' .
                    $thumbnailFileName;


                /*
                |--------------------------------------------------------------------------
                | INSERT
                |--------------------------------------------------------------------------
                */

                $stmt = $pdo->prepare("
                    INSERT INTO catalogs
                    (
                        title,
                        description,
                        file_name,
                        file_path,
                        file_size,
                        thumbnail,
                        display_order,
                        status
                    )
                    VALUES
                    (
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?
                    )
                ");


                $stmt->execute([

                    $title,

                    $description !== ''
                        ? $description
                        : null,

                    $file['name'],

                    $dbFilePath,

                    (int)$file['size'],

                    $dbThumbnailPath,

                    $displayOrder,

                    $status

                ]);


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                header(
                    'Location: catalogs.php'
                );

                exit;


            }catch(Exception $e){

                /*
                |--------------------------------------------------------------------------
                | DATABASE FAILED
                |--------------------------------------------------------------------------
                */

                if(file_exists($catalogPath)){

                    unlink($catalogPath);

                }

                if(file_exists($thumbnailPath)){

                    unlink($thumbnailPath);

                }

                $error =
                    'Unable to save catalog. Please try again.';

            }

        }

    }

}


include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>


<div class="container-fluid py-4">


    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2
                class="mb-1"
                style="
                    font-weight:700;
                    color:#fff;
                "
            >
                Add Catalog
            </h2>

            <p
                style="
                    color:#64748b;
                    font-size:14px;
                    margin:0;
                "
            >
                Upload a product catalog with its thumbnail.
            </p>

        </div>


        <a
            href="catalogs.php"
            class="btn"
            style="
                background:rgba(255,255,255,.05);
                color:#e2e8f0;
                border:1px solid rgba(255,255,255,.08);
                border-radius:8px;
            "
        >
            ← Back
        </a>

    </div>



    <?php if($error !== ''): ?>

        <div
            class="alert"
            style="
                background:rgba(239,68,68,.10);
                color:#f87171;
                border:1px solid rgba(239,68,68,.20);
                border-radius:8px;
            "
        >
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>



    <div
        class="card border-0"
        style="
            max-width:850px;
            border-radius:14px;
            background:rgba(21,25,34,.65);
            border:1px solid rgba(255,255,255,.05)!important;
            box-shadow:0 20px 40px rgba(0,0,0,.25);
        "
    >

        <div class="card-body p-4">


            <form
                method="POST"
                enctype="multipart/form-data"
            >


                <!-- TITLE -->

                <div class="mb-4">

                    <label
                        class="form-label"
                        style="
                            color:#e2e8f0;
                            font-weight:600;
                            font-size:13px;
                        "
                    >
                        Catalog Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        class="form-control"
                        value="<?= htmlspecialchars($_POST['title'] ?? '') ?>"
                        placeholder="Enter catalog title"
                        required
                        style="
                            background:rgba(15,17,21,.7);
                            color:#fff;
                            border:1px solid rgba(255,255,255,.08);
                            border-radius:8px;
                        "
                    >

                </div>

                <!-- DESCRIPTION -->
                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        Description
                    </label>

                    <textarea name="description" rows="4" class="form-control" placeholder="Optional catalog description" style=" background:rgba(15,17,21,.7); color:#fff; border:1px solid rgba(255,255,255,.08); border-radius:8px; " ><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>

                </div>

                <!-- PDF -->
                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        Catalog PDF
                    </label>

                    <input type="file" name="catalog_file" class="form-control" accept=".pdf,application/pdf" required style=" background:rgba(15,17,21,.7); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >

                    <small style=" color:#64748b; font-size:12px; " >
                        Only PDF files are allowed.
                    </small>
                </div>

                <!-- THUMBNAIL -->
                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        Catalog Thumbnail
                    </label>

                    <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required style=" background:rgba(15,17,21,.7); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >

                    <small style=" color:#64748b; font-size:12px; " >
                        JPG, JPEG, PNG or WEBP.
                    </small>
                </div>

                <!-- STATUS -->
                <div class="mb-4">

                    <label style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        <input type="checkbox" name="status" value="1" <?= !isset($_POST['status']) || $_POST['status'] ? 'checked' : '' ?> style="margin-right:6px;" >
                        Active
                    </label>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2">

                    <button type="submit" class="btn px-4" style=" background:linear-gradient( 135deg, #38bdf8, #0284c7 ); color:#fff; font-weight:600; border:none; border-radius:8px; " >
                        Upload Catalog
                    </button>


                    <a href="catalogs.php" class="btn px-4" style=" background:rgba(255,255,255,.04); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>