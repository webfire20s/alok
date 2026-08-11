<?php

require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| FETCH ACTIVE CATALOGS
|--------------------------------------------------------------------------
*/

$stmt = $pdo->query("
    SELECT
        id,
        title,
        description,
        file_name,
        file_path,
        file_size,
        thumbnail,
        created_at
    FROM catalogs
    WHERE status = 1
    ORDER BY created_at DESC, id DESC
");

$catalogs = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| PAGE HEADER
|--------------------------------------------------------------------------
*/

include 'includes/header.php';

?>

<style>
    .catalog-page-section {
        background-color: #ffffff;
        padding: 60px 0;
        font-family: 'Montserrat', sans-serif;
    }

    /* SECTION HEADER STYLE */
    .catalog-header-wrap {
        text-align: center;
        margin-bottom: 45px;
    }

    .catalog-pretitle {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #c8232c;
        display: block;
        margin-bottom: 6px;
    }

    .catalog-main-title {
        font-size: 28px;
        font-weight: 800;
        color: #111111;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0;
    }

    .catalog-title-underline {
        width: 50px;
        height: 3px;
        background-color: #c8232c;
        margin: 10px auto 16px auto;
        border-radius: 2px;
    }

    .catalog-main-desc {
        max-width: 680px;
        margin: 0 auto;
        color: #555555;
        font-size: 14.5px;
        line-height: 1.7;
    }

    /* CARD ARCHITECTURE */
    .catalog-item-card {
        background: #161616;
        border: 1px solid #262626;
        border-radius: 12px;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                    border-color 0.35s ease, 
                    box-shadow 0.35s ease;
    }

    .catalog-item-card:hover {
        transform: translateY(-5px);
        border-color: #c8232c;
        box-shadow: 0 12px 30px rgba(200, 35, 44, 0.15);
    }

    /* THUMBNAIL BOX */
    .catalog-thumbnail-box {
        position: relative;
        height: 220px;
        background: #222222;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #262626;
    }

    .catalog-thumbnail-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .catalog-item-card:hover .catalog-thumbnail-box img {
        transform: scale(1.05);
    }

    .catalog-no-thumb {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #888888;
        background: linear-gradient(135deg, #1c1c1c 0%, #111111 100%);
    }

    .catalog-no-thumb i {
        font-size: 42px;
        margin-bottom: 8px;
        color: #c8232c;
    }

    .catalog-no-thumb span {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #aaaaaa;
    }

    /* CONTENT PANEL */
    .catalog-card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .catalog-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #ffffff !important;
        margin-bottom: 8px;
        line-height: 1.35;
    }

    .catalog-card-desc {
        font-size: 13px;
        line-height: 1.6;
        color: #aaaaaa;
        margin-bottom: 20px;
        flex-grow: 1;
    }

    /* ACTIONS BUTTONS */
    .catalog-action-row {
        display: flex;
        gap: 10px;
        margin-top: auto;
    }

    .catalog-btn-action {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 10px 14px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-decoration: none !important;
        transition: all 0.25s ease;
    }

    .btn-preview-dark {
        background: transparent;
        color: #ffffff;
        border: 1px solid #333333;
    }

    .btn-preview-dark:hover {
        background: #ffffff;
        color: #111111;
        border-color: #ffffff;
    }

    .btn-download-red {
        background: #c8232c;
        color: #ffffff;
        border: 1px solid #c8232c;
    }

    .btn-download-red:hover {
        background: #a91d25;
        border-color: #a91d25;
        color: #ffffff;
    }

    /* EMPTY STATE */
    .catalog-empty-wrapper {
        text-align: center;
        padding: 60px 20px;
        background: #fcfbfa;
        border: 1px solid #eef0f2;
        border-radius: 12px;
    }

    .catalog-empty-wrapper i {
        font-size: 48px;
        color: #c8232c;
        margin-bottom: 12px;
    }

    .catalog-empty-wrapper h4 {
        font-size: 20px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 6px;
    }

    .catalog-empty-wrapper p {
        font-size: 14px;
        color: #666666;
        margin-bottom: 0;
    }

    @media(max-width: 767.98px) {
        .catalog-page-section {
            padding: 40px 0;
        }

        .catalog-main-title {
            font-size: 22px;
        }

        .catalog-thumbnail-box {
            height: 180px;
        }

        .catalog-action-row {
            flex-direction: column;
        }

        .catalog-btn-action {
            width: 100%;
        }
    }
</style>

<section class="catalog-page-section">
    <div class="container">

        <!-- PAGE HEADER -->
        <div class="catalog-header-wrap">
            <span class="catalog-pretitle">Downloads &amp; Media</span>
            <h1 class="catalog-main-title">Product Catalogs</h1>
            <div class="catalog-title-underline"></div>
            <p class="catalog-main-desc">
                Explore our official product catalogs, technical documentation, and range guides. Preview them online or download high-resolution PDF copies for detailed specifications.
            </p>
        </div>

        <?php if(empty($catalogs)): ?>

            <!-- EMPTY STATE -->
            <div class="catalog-empty-wrapper">
                <i class="fa-regular fa-folder-open"></i>
                <h4>No Catalogs Available</h4>
                <p>New product catalogs and media guides will be uploaded soon.</p>
            </div>

        <?php else: ?>

            <!-- CATALOGS MATRIX GRID -->
            <div class="row g-4">

                <?php foreach($catalogs as $catalog): ?>

                    <?php
                    $fileUrl = htmlspecialchars($catalog['file_path']);
                    $thumbnailUrl = !empty($catalog['thumbnail']) ? htmlspecialchars($catalog['thumbnail']) : '';
                    ?>

                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                        <div class="catalog-item-card w-100">

                            <!-- THUMBNAIL -->
                            <div class="catalog-thumbnail-box">
                                <?php if($thumbnailUrl): ?>
                                    <img src="<?= $thumbnailUrl ?>" 
                                         alt="<?= htmlspecialchars($catalog['title']) ?>" 
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="catalog-no-thumb">
                                        <i class="fa-regular fa-file-pdf"></i>
                                        <span>PDF Document</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- CONTENT -->
                            <div class="catalog-card-body">
                                <h3 class="catalog-card-title">
                                    <?= htmlspecialchars($catalog['title']) ?>
                                </h3>

                                <?php if(!empty($catalog['description'])): ?>
                                    <p class="catalog-card-desc">
                                        <?= nl2br(htmlspecialchars($catalog['description'])) ?>
                                    </p>
                                <?php else: ?>
                                    <!-- <p class="catalog-card-desc">
                                        View and download our technical catalog for complete specifications.
                                    </p> -->
                                <?php endif; ?>

                                <!-- ACTIONS -->
                                <div class="catalog-action-row">
                                    <a href="<?= $fileUrl ?>" 
                                       target="_blank" 
                                       rel="noopener noreferrer" 
                                       class="catalog-btn-action btn-preview-dark">
                                        <i class="fa-regular fa-eye me-1"></i> Preview
                                    </a>

                                    <a href="<?= $fileUrl ?>" 
                                       download="<?= htmlspecialchars($catalog['file_name']) ?>" 
                                       class="catalog-btn-action btn-download-red">
                                        <i class="fa-solid fa-download me-1"></i> Download
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>
</section>

<?php

include 'includes/footer.php';

?>