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
        padding: 50px 0;
        font-family: 'Montserrat', sans-serif;
    }

    /* SECTION HEADER STYLE */
    .catalog-header-wrap {
        text-align: center;
        margin-bottom: 35px;
    }

    .catalog-pretitle {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #c8232c;
        display: block;
        margin-bottom: 4px;
    }

    .catalog-main-title {
        font-size: 24px;
        font-weight: 800;
        color: #111111;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin-bottom: 0;
    }

    .catalog-title-underline {
        width: 40px;
        height: 3px;
        background-color: #c8232c;
        margin: 8px auto 12px auto;
        border-radius: 2px;
    }

    .catalog-main-desc {
        max-width: 600px;
        margin: 0 auto;
        color: #555555;
        font-size: 13.5px;
        line-height: 1.6;
    }

    /* COMPACT B2B CATEGORY CARD STRUCTURE */
    .product-category-card {
        border: 1px solid #eef0f2;
        border-radius: 5px;
        overflow: hidden;
        background-color: #ffffff;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    /* TIGHTER ASPECT RATIO (16:9 for smaller vertical footprint) */
    .product-card-media {
        display: block;
        overflow: hidden;
        aspect-ratio: 16 / 9;
        background-color: #ffffff;
        position: relative;
        width: 100%;
    }

    .product-card-media img {
        width: 100%;
        height: 100%;
        object-fit: contain; /* Spans full width & fills box perfectly without stretching */
        object-position: center; /* Keeps the focus centered */
        padding: 0; /* Removed padding to allow edge-to-edge full width */
        transition: transform 0.4s ease;
    }

    .catalog-no-thumb-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #888888;
        background: #f9f9f9;
    }

    .catalog-no-thumb-placeholder i {
        font-size: 32px;
        margin-bottom: 4px;
        color: #c8232c;
    }

    .catalog-no-thumb-placeholder span {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #888888;
    }

    /* SLIM BANNER BAND */
    .product-card-banner {
        padding: 10px 8px;
        text-align: center;
        text-transform: uppercase;
    }

    .product-card-link {
        font-size: 12.5px;
        font-weight: 700;
        color: #ffffff;
        text-decoration: none;
        display: block;
        letter-spacing: 0.04em;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-card-link:hover {
        text-decoration: none;
        color: #ffffff;
    }

    /* COMPACT ACTION BUTTONS */
    .catalog-action-row {
        display: flex;
        border-top: 1px solid #eef0f2;
        background: #ffffff;
        margin-top: auto;
    }

    .catalog-btn-action {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 8px 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }

    .btn-preview-dark {
        background: #ffffff;
        color: #111111;
        border-right: 1px solid #eef0f2;
    }

    .btn-preview-dark:hover {
        background: #111111;
        color: #ffffff;
    }

    .btn-download-red {
        background: #ffffff;
        color: #c8232c;
    }

    .btn-download-red:hover {
        background: #c8232c;
        color: #ffffff;
    }

    /* HOVER EFFECT */
    .product-category-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06);
    }

    .product-category-card:hover .product-card-media img {
        transform: scale(1.05);
    }

    /* PALETTE VARIANT ENGINE */
    .bg-palette-accent {
        background-color: #c8232c;
    }

    .bg-palette-charcoal {
        background-color: #111111;
    }

    /* EMPTY STATE */
    .catalog-empty-wrapper {
        text-align: center;
        padding: 50px 20px;
        background: #fcfbfa;
        border: 1px solid #eef0f2;
        border-radius: 5px;
    }

    .catalog-empty-wrapper i {
        font-size: 40px;
        color: #c8232c;
        margin-bottom: 10px;
    }

    .catalog-empty-wrapper h4 {
        font-size: 18px;
        font-weight: 700;
        color: #111111;
        margin-bottom: 4px;
    }

    .catalog-empty-wrapper p {
        font-size: 13px;
        color: #666666;
        margin-bottom: 0;
    }

    @media(max-width: 767.98px) {
        .catalog-page-section {
            padding: 35px 0;
        }

        .catalog-main-title {
            font-size: 20px;
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

            <!-- COMPACT GRID (4 COLUMNS ON DESKTOP) -->
            <div class="row g-3">

                <?php foreach($catalogs as $index => $catalog): ?>

                    <?php
                    $variantClass = ($index % 2 == 0) ? 'bg-palette-accent' : 'bg-palette-charcoal';
                    $fileUrl = htmlspecialchars($catalog['file_path']);
                    $thumbnailUrl = !empty($catalog['thumbnail']) ? htmlspecialchars($catalog['thumbnail']) : '';
                    ?>

                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">

                        <!-- Compact Product Card Frame -->
                        <div class="product-category-card">

                            <!-- Image Wrapper -->
                            <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer" class="product-card-media">
                                <?php if($thumbnailUrl): ?>
                                    <img src="<?= $thumbnailUrl ?>" 
                                         alt="<?= htmlspecialchars($catalog['title']) ?>" 
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="catalog-no-thumb-placeholder">
                                        <i class="fa-regular fa-file-pdf"></i>
                                        <span>PDF Document</span>
                                    </div>
                                <?php endif; ?>
                            </a>

                            <!-- Slim Banner Band -->
                            <div class="product-card-banner <?= $variantClass ?>">
                                <a href="<?= $fileUrl ?>" target="_blank" rel="noopener noreferrer" class="product-card-link" title="<?= htmlspecialchars($catalog['title']) ?>">
                                    <?= htmlspecialchars($catalog['title']) ?>
                                </a>
                            </div>

                            <!-- Integrated Actions Bar -->
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

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>
</section>

<?php

include 'includes/footer.php';

?>