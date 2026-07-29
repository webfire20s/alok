<?php

require 'includes/auth.php';
require '../includes/db.php';

$stmt = $pdo->query("
    SELECT *
    FROM tour_images
    ORDER BY
        FIELD(section,'entrance','processing','decoration'),
        display_order ASC,
        id ASC
");

$images = $stmt->fetchAll();

include 'includes/admin_header.php';
include 'includes/admin_sidebar.php';

?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>Factory Tour Images</h3>

        <a href="add_tour_images.php" class="btn btn-primary">
            + Upload Images
        </a>

    </div>

    <?php if(isset($_GET['success'])): ?>

        <div class="alert alert-success">
            Images uploaded successfully.
        </div>

    <?php endif; ?>

    <?php

    $currentSection='';

    foreach($images as $image):

        if($currentSection!=$image['section']):

            if($currentSection!=''){
                echo "</div>";
            }

            $currentSection=$image['section'];

    ?>

        <h4 class="mt-5 mb-3 text-capitalize">

            <?= htmlspecialchars($currentSection) ?>

        </h4>

        <div class="row">

    <?php endif; ?>

        <div class="col-lg-2 col-md-3 col-6 mb-4">

            <div class="card h-100">

                <img
                    src="../storage/tour/<?= htmlspecialchars($image['image']) ?>"
                    class="card-img-top"
                    style="
                        height:180px;
                        object-fit:cover;
                    "
                >

                <div class="card-body p-2">

                    <small class="text-muted d-block">

                        Order :
                        <?= $image['display_order'] ?>

                    </small>

                    <a
                        href="delete_tour_image.php?id=<?= $image['id'] ?>"
                        class="btn btn-danger btn-sm mt-2 w-100"
                        onclick="return confirm('Delete this image?')"
                    >
                        Delete
                    </a>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

    </div>

</div>

