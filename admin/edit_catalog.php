<?php

require 'includes/auth.php';
require '../includes/db.php';

$error = '';
$catalog = null;

/*
|--------------------------------------------------------------------------
| GET CATALOG
|--------------------------------------------------------------------------
*/

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if($id <= 0){

    header('Location: catalogs.php');
    exit;

}

$stmt = $pdo->prepare("
    SELECT *
    FROM catalogs
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$id]);
$catalog = $stmt->fetch();

if(!$catalog){

    header('Location: catalogs.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| UPDATE CATALOG
|--------------------------------------------------------------------------
*/

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $status = isset($_POST['status']) ? 1 : 0;
    $showOnHome = isset($_POST['show_on_home']) ? 1 : 0;


    /*
    |--------------------------------------------------------------------------
    | BASIC VALIDATION
    |--------------------------------------------------------------------------
    */

    if($title === ''){
        $error = 'Catalog title is required.';
    }

    /*
    |--------------------------------------------------------------------------
    | OLD FILE PATHS
    |--------------------------------------------------------------------------
    */

    $oldFilePath = '../' . ltrim(
        $catalog['file_path'],
        '/'
    );

    $oldThumbnailPath = '../' . ltrim(
        $catalog['thumbnail'],
        '/'
    );


    /*
    |--------------------------------------------------------------------------
    | NEW VALUES
    |--------------------------------------------------------------------------
    */

    $newFileName = $catalog['file_name'];
    $newFilePath = $catalog['file_path'];
    $newFileSize = (int)$catalog['file_size'];

    $newThumbnail = $catalog['thumbnail'];


    $newUploadedFile = null;
    $newUploadedThumbnail = null;


    /*
    |--------------------------------------------------------------------------
    | PDF REPLACEMENT
    |--------------------------------------------------------------------------
    */

    if(
        $error === '' &&
        isset($_FILES['catalog_file']) &&
        $_FILES['catalog_file']['error'] !== UPLOAD_ERR_NO_FILE
    ){

        $file = $_FILES['catalog_file'];


        if($file['error'] !== UPLOAD_ERR_OK){
            $error = 'There was a problem uploading the catalog PDF.';
        }


        if($error === ''){

            $extension = strtolower(
                pathinfo(
                    $file['name'],
                    PATHINFO_EXTENSION
                )
            );

            if($extension !== 'pdf'){
                $error = 'Only PDF files are allowed.';
            }
        }


        if($error === ''){

            if($file['size'] <= 0){
                $error = 'The selected PDF file is empty.';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VERIFY PDF MIME TYPE
        |--------------------------------------------------------------------------
        */

        if($error === ''){

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

        /*
        |--------------------------------------------------------------------------
        | SAVE NEW PDF
        |--------------------------------------------------------------------------
        */

        if($error === ''){

            $directory =
                '../storage/catalogs/files/';

            if(!is_dir($directory)){
                mkdir(
                    $directory,
                    0755,
                    true
                );
            }

            $uniqueName =
                time() . '_' .
                bin2hex(random_bytes(5));

            $newFileName =
                $uniqueName . '.pdf';

            $physicalPath =
                $directory . $newFileName;

            if(!move_uploaded_file(
                $file['tmp_name'],
                $physicalPath
            )){

                $error =
                    'Unable to upload the new catalog PDF.';

            }else{

                $newFilePath =
                    'storage/catalogs/files/' .
                    $newFileName;

                $newFileSize =
                    (int)$file['size'];

                $newUploadedFile =
                    $physicalPath;

            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | THUMBNAIL REPLACEMENT
    |--------------------------------------------------------------------------
    */

    if(
        $error === '' &&
        isset($_FILES['thumbnail']) &&
        $_FILES['thumbnail']['error'] !== UPLOAD_ERR_NO_FILE
    ){

        $thumbnail = $_FILES['thumbnail'];


        if($thumbnail['error'] !== UPLOAD_ERR_OK){

            $error =
                'There was a problem uploading the thumbnail.';

        }


        $thumbnailExtension = strtolower(
            pathinfo(
                $thumbnail['name'],
                PATHINFO_EXTENSION
            )
        );


        $allowedExtensions = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];


        if(
            $error === '' &&
            !in_array(
                $thumbnailExtension,
                $allowedExtensions,
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

                $error =
                    'Invalid thumbnail image.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | SAVE NEW THUMBNAIL
        |--------------------------------------------------------------------------
        */

        if($error === ''){

            $directory =
                '../storage/catalogs/thumbnails/';


            if(!is_dir($directory)){

                mkdir(
                    $directory,
                    0755,
                    true
                );

            }


            $uniqueName =
                time() . '_' .
                bin2hex(random_bytes(5));


            $thumbnailFileName =
                $uniqueName . '.' .
                $thumbnailExtension;


            $physicalPath =
                $directory .
                $thumbnailFileName;


            if(!move_uploaded_file(
                $thumbnail['tmp_name'],
                $physicalPath
            )){

                $error =
                    'Unable to upload the new thumbnail.';

            }else{

                $newThumbnail =
                    'storage/catalogs/thumbnails/' .
                    $thumbnailFileName;

                $newUploadedThumbnail =
                    $physicalPath;

            }

        }

    }


    /*
    |--------------------------------------------------------------------------
    | DATABASE UPDATE
    |--------------------------------------------------------------------------
    */

    if($error === ''){

        try{

            $stmt = $pdo->prepare("
                UPDATE catalogs

                SET
                    title = ?,
                    description = ?,
                    file_name = ?,
                    file_path = ?,
                    file_size = ?,
                    thumbnail = ?,
                    status = ?,
                    show_on_home = ?

                WHERE id = ?
            ");


            $stmt->execute([

                $title,
                $description !== '' ? $description : null,
                $newFileName,
                $newFilePath,
                $newFileSize,
                $newThumbnail,
                $status,
                $showOnHome,

                $id

            ]);


            /*
            |--------------------------------------------------------------------------
            | REMOVE OLD FILE
            |--------------------------------------------------------------------------
            */

            if(
                $newUploadedFile !== null &&
                $oldFilePath !== $newUploadedFile &&
                file_exists($oldFilePath)
            ){

                unlink($oldFilePath);

            }


            /*
            |--------------------------------------------------------------------------
            | REMOVE OLD THUMBNAIL
            |--------------------------------------------------------------------------
            */

            if(
                $newUploadedThumbnail !== null &&
                $oldThumbnailPath !== $newUploadedThumbnail &&
                file_exists($oldThumbnailPath)
            ){

                unlink($oldThumbnailPath);

            }


            /*
            |--------------------------------------------------------------------------
            | REDIRECT
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

            if(
                $newUploadedFile !== null &&
                file_exists($newUploadedFile)
            ){
                unlink($newUploadedFile);
            }


            if(
                $newUploadedThumbnail !== null &&
                file_exists($newUploadedThumbnail)
            ){
                unlink($newUploadedThumbnail);
            }

            $error =
                'Unable to update catalog. Please try again.';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | REFRESH VALUES FOR FORM
    |--------------------------------------------------------------------------
    */

    if($error !== ''){

        $catalog['title'] = $title;
        $catalog['description'] = $description;
        $catalog['status'] = $status;

    }

}


include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>


<div class="container-fluid py-4">


    <!-- HEADER -->

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1" style=" font-weight:700; color:#fff; " > Edit Catalog </h2>
            <p style=" color:#64748b; font-size:14px; margin:0; " > Update catalog details, PDF or thumbnail. </p>
        </div>

        <a href="catalogs.php" class="btn" style=" background:rgba(255,255,255,.05); color:#e2e8f0; border:1px solid rgba(255,255,255,.08); border-radius:8px; " > ← Back </a>
    </div>

    <?php if($error !== ''): ?>
        <div class="alert" style=" background:rgba(239,68,68,.10); color:#f87171; border:1px solid rgba(239,68,68,.20); border-radius:8px; " > <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>



    <div class="card border-0" style=" max-width:850px; border-radius:14px; background:rgba(21,25,34,.65); border:1px solid rgba(255,255,255,.05)!important; box-shadow:0 20px 40px rgba(0,0,0,.25); " >

        <div class="card-body p-4">
            <form method="POST" enctype="multipart/form-data" >

                <!-- TITLE -->

                <div class="mb-4">
                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " > Catalog Title </label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($catalog['title']) ?>" required style=" background:rgba(15,17,21,.7); color:#fff; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >
                </div>



                <!-- DESCRIPTION -->

                <div class="mb-4">
                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " > Description </label>
                    <textarea name="description" rows="4" class="form-control" style=" background:rgba(15,17,21,.7); color:#fff; border:1px solid rgba(255,255,255,.08); border-radius:8px; " ><?= htmlspecialchars($catalog['description'] ?? '') ?></textarea>
                </div>



                <!-- CURRENT PDF -->

                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " > Current Catalog </label>

                    <div style=" background:rgba(255,255,255,.03); border:1px solid rgba(255,255,255,.06); border-radius:8px; padding:12px; " >
                        <span style=" color:#94a3b8; font-size:13px; " > <?= htmlspecialchars($catalog['file_name']) ?> </span>
                        <a href="../<?= htmlspecialchars($catalog['file_path']) ?>" target="_blank" class="btn btn-sm ms-2" style=" background:rgba(56,189,248,.08); color:#38bdf8; border:1px solid rgba(56,189,248,.20); border-radius:6px; " > Preview </a>
                    </div>

                </div>



                <!-- REPLACE PDF -->

                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        Replace Catalog PDF
                        <span style="color:#64748b;font-weight:400;">
                            (optional)
                        </span>
                    </label>

                    <input type="file" name="catalog_file" class="form-control" accept=".pdf,application/pdf" style=" background:rgba(15,17,21,.7); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >
                    <small style=" color:#64748b; font-size:12px; " > Leave empty to keep the current PDF. </small>

                </div>

                <!-- CURRENT THUMBNAIL -->

                <div class="mb-4">
                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " > Current Thumbnail </label>

                    <div>
                        <?php if(!empty($catalog['thumbnail'])): ?>
                            <img src="../<?= htmlspecialchars($catalog['thumbnail']) ?>" alt="<?= htmlspecialchars($catalog['title']) ?>" style=" width:140px; height:100px; object-fit:cover; border-radius:8px; border:1px solid rgba(255,255,255,.08); background:#fff; padding:3px; " >
                        <?php else: ?>
                            <div style=" width:140px; height:100px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.03); border:1px dashed rgba(255,255,255,.10); border-radius:8px; color:#64748b; font-size:12px; " > No Thumbnail </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- REPLACE THUMBNAIL -->

                <div class="mb-4">

                    <label class="form-label" style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        Replace Thumbnail
                        <span style="color:#64748b;font-weight:400;">
                            (optional)
                        </span>
                    </label>

                    <input type="file" name="thumbnail" class="form-control" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" style=" background:rgba(15,17,21,.7); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " >
                    <small style=" color:#64748b; font-size:12px; " > Leave empty to keep the current thumbnail. </small>

                </div>

                <!-- STATUS -->

                <div class="mb-4">
                    <label style=" color:#e2e8f0; font-weight:600; font-size:13px; " >
                        <input type="checkbox" name="status" value="1" <?= !empty($catalog['status']) ? 'checked' : '' ?> style="margin-right:6px;" >
                        Active
                    </label>
                </div>

                <!-- SHOW ON HOME -->
                <div class="mb-4">
                    <label style="color:#e2e8f0; font-weight:600; font-size:13px;">
                        <input
                            type="checkbox"
                            name="show_on_home"
                            value="1"
                            <?= !empty($catalog['show_on_home']) ? 'checked' : '' ?>
                            style="margin-right:6px;"
                        >
                        Show on Home
                    </label>

                    <div style="color:#64748b; font-size:12px; margin-top:6px;">
                        Enable this to display this catalog on the homepage.
                    </div>
                </div>

                <!-- BUTTONS -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn px-4" style=" background:linear-gradient( 135deg, #38bdf8, #0284c7 ); color:#fff; font-weight:600; border:none; border-radius:8px; " > Save Changes </button>
                    <a href="catalogs.php" class="btn px-4" style=" background:rgba(255,255,255,.04); color:#94a3b8; border:1px solid rgba(255,255,255,.08); border-radius:8px; " > Cancel </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>