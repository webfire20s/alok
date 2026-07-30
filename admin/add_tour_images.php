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

            <div style="
                background: rgba(15, 23, 42, 0.65);
                backdrop-filter: blur(12px);
                border: 1px solid rgba(255, 255, 255, 0.08);
                border-radius: 12px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35);
                overflow: hidden;
            ">

                <!-- Card Header -->
                <div style="
                    padding: 20px 24px;
                    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
                    background: rgba(255, 255, 255, 0.02);
                ">
                    <h4 class="mb-0" style="
                        font-size: 18px;
                        font-weight: 700;
                        color: #ffffff;
                        letter-spacing: -0.01em;
                    ">
                        Upload Factory Tour Images
                    </h4>
                </div>

                <!-- Card Body -->
                <div style="padding: 24px;">

                    <form
                        method="POST"
                        enctype="multipart/form-data"
                    >

                        <!-- Section Select Dropdown -->
                        <div class="mb-4">

                            <label class="form-label" style="
                                font-size: 12px;
                                font-weight: 600;
                                text-transform: uppercase;
                                letter-spacing: 0.05em;
                                color: #94a3b8;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                Section
                            </label>

                            <select
                                name="section"
                                class="form-select"
                                required
                                style="
                                    background-color: rgba(15, 17, 21, 0.75);
                                    color: #e2e8f0;
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    border-radius: 8px;
                                    padding: 10px 14px;
                                    font-size: 13.5px;
                                    width: 100%;
                                    outline: none;
                                    transition: all 0.2s ease-in-out;
                                "
                                onfocus="this.style.borderColor='rgba(56, 189, 248, 0.5)'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.15)';"
                                onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)'; this.style.boxShadow='none';"
                            >

                                <option value="" style="background: #1e293b; color: #ffffff;">
                                    Select Section
                                </option>

                                <option value="entrance" style="background: #1e293b; color: #ffffff;">
                                    Entrance
                                </option>

                                <option value="processing" style="background: #1e293b; color: #ffffff;">
                                    Processing
                                </option>

                                <option value="decoration" style="background: #1e293b; color: #ffffff;">
                                    Decoration
                                </option>

                            </select>

                        </div>

                        <!-- Image File Input -->
                        <div class="mb-4">

                            <label class="form-label" style="
                                font-size: 12px;
                                font-weight: 600;
                                text-transform: uppercase;
                                letter-spacing: 0.05em;
                                color: #94a3b8;
                                margin-bottom: 8px;
                                display: block;
                            ">
                                Images
                            </label>

                            <input
                                type="file"
                                name="images[]"
                                multiple
                                required
                                accept=".jpg,.jpeg,.png,.webp"
                                class="form-control"
                                style="
                                    background-color: rgba(15, 17, 21, 0.75);
                                    color: #94a3b8;
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    border-radius: 8px;
                                    padding: 9px 12px;
                                    font-size: 13.5px;
                                    width: 100%;
                                    outline: none;
                                    transition: all 0.2s ease-in-out;
                                "
                                onfocus="this.style.borderColor='rgba(56, 189, 248, 0.5)'; this.style.boxShadow='0 0 0 3px rgba(56, 189, 248, 0.15)';"
                                onblur="this.style.borderColor='rgba(255, 255, 255, 0.08)'; this.style.boxShadow='none';"
                            >

                            <small style="color: #64748b; font-size: 12px; display: block; margin-top: 6px;">
                                You can select dozens of images together.
                            </small>

                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex align-items-center" style="gap: 12px;">

                            <button
                                type="submit"
                                class="btn px-4 py-2"
                                style="
                                    background: linear-gradient(135deg, #38bdf8, #0284c7);
                                    color: #ffffff;
                                    font-weight: 600;
                                    font-size: 13.5px;
                                    border: none;
                                    border-radius: 8px;
                                    box-shadow: 0 4px 12px rgba(56, 189, 248, 0.25);
                                    transition: transform 0.2s ease, box-shadow 0.2s ease;
                                "
                                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 16px rgba(56, 189, 248, 0.35)';"
                                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(56, 189, 248, 0.25)';"
                            >
                                Upload Images
                            </button>

                            <a
                                href="tour_images.php"
                                class="btn px-4 py-2"
                                style="
                                    background: rgba(255, 255, 255, 0.03);
                                    color: #94a3b8;
                                    border: 1px solid rgba(255, 255, 255, 0.08);
                                    font-weight: 500;
                                    font-size: 13.5px;
                                    border-radius: 8px;
                                    text-decoration: none;
                                    transition: all 0.2s ease;
                                "
                                onmouseover="this.style.background='rgba(255, 255, 255, 0.08)'; this.style.color='#ffffff';"
                                onmouseout="this.style.background='rgba(255, 255, 255, 0.03)'; this.style.color='#94a3b8';"
                            >
                                Back
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>