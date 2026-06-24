<?php

require 'includes/db.php';
include 'includes/header.php';

/*
|--------------------------------------------------------------------------
| CATEGORY FILTER
|--------------------------------------------------------------------------
*/

$category =
trim($_GET['category'] ?? '');

/*
|--------------------------------------------------------------------------
| GALLERY
|--------------------------------------------------------------------------
*/

if($category){

    $stmt = $pdo->prepare("
        SELECT *
        FROM gallery
        WHERE category = ?
        ORDER BY id DESC
    ");

    $stmt->execute([$category]);

}else{

    $stmt = $pdo->query("
        SELECT *
        FROM gallery
        ORDER BY id DESC
    ");
}

$gallery = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| CATEGORIES
|--------------------------------------------------------------------------
*/

$catStmt = $pdo->query("
    SELECT DISTINCT category
    FROM gallery
    WHERE category IS NOT NULL
    AND category != ''
    ORDER BY category ASC
");

$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

?>

<style>
    /* Premium Minimalist Gallery Framework */
    .gallery-hero {
        background: linear-gradient(rgba(17, 20, 26, 0.75), rgba(17, 20, 26, 0.85)),
                    url('assets/images/about/about-banner.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #ffffff;
        padding: 100px 0;
        font-family: 'Montserrat', sans-serif;
    }

    .gallery-card {
        overflow: hidden;
        border: 1px solid #eeeeee;
        border-radius: 4px;
        background-color: #ffffff;
        transition: border-color 0.25s ease-in-out;
        box-shadow: none !important; /* Stripping default shadow for flat geometry */
    }

    .gallery-card:hover {
        border-color: #111111;
        transform: none; /* Removing floating behavior for high-end aesthetic */
    }

    .gallery-card img {
        height: 280px;
        width: 100%;
        object-fit: cover;
        transition: transform 0.4s ease-in-out;
    }

    .gallery-card:hover img {
        transform: scale(1.03);
    }

    /* Architectural Structured Filter Menu */
    .gallery-filter a {
        margin: 5px;
        border-radius: 4px !important; /* Swapping pill style for clean squares */
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        padding: 10px 20px;
        transition: all 0.2s ease-in-out;
    }

    /* Lightbox Modal System Overrides */
    .lightbox {
        display: none;
        position: fixed;
        z-index: 9999;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(11, 13, 16, 0.95);
    }

    .lightbox img {
        max-width: 90%;
        max-height: 85%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border: 1px solid #222222;
        border-radius: 2px;
    }

    .lightbox-close {
        position: absolute;
        top: 25px;
        right: 35px;
        color: #ffffff;
        font-size: 36px;
        font-weight: 300;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .lightbox-close:hover {
        color: #c8232c;
    }
</style>

<section class="gallery-hero">
    <div class="container text-center py-3">

        <h1 class="text-uppercase mb-3" style="font-size: 32px; font-weight: 800; letter-spacing: 0.08em; display: inline-block; position: relative; padding-bottom: 14px;">
            Gallery
            <span style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 40px; height: 3px; background-color: #c8232c;"></span>
        </h1>

        <p class="mx-auto mt-3 mb-0" style="max-width: 600px; font-size: 14px; line-height: 1.7; color: #cccccc; font-weight: 400; letter-spacing: 0.02em;">
            Explore our products, manufacturing facilities, packaging solutions and company events.
        </p>

    </div>
</section>
<!-- FILTERS -->

<section class="py-4" style="background-color: #fafafa; border-bottom: 1px solid #eeeeee;">
    <div class="container text-center gallery-filter">

        <a href="gallery.php" 
           class="btn text-uppercase"
           style="font-size: 11px; font-weight: 700; letter-spacing: 0.08em; padding: 10px 22px; border-radius: 4px; border: 1px solid #111111; transition: all 0.2s ease-in-out; <?= !isset($_GET['category']) ? 'background-color: #111111; color: #ffffff;' : 'background-color: transparent; color: #111111;' ?>"
           onmouseover="this.style.backgroundColor='#111111'; this.style.color='#ffffff';"
           onmouseout="<?= !isset($_GET['category']) ? '' : 'this.style.backgroundColor=\'transparent\'; this.style.color=\'#111111\';' ?>">
            All
        </a>

        <?php foreach($categories as $cat): 
            $isActive = (isset($_GET['category']) && $_GET['category'] === $cat);
        ?>
            <a href="gallery.php?category=<?= urlencode($cat) ?>" 
               class="btn text-uppercase"
               style="font-size: 11px; font-weight: 700; letter-spacing: 0.08em; padding: 10px 22px; border-radius: 4px; border: 1px solid <?= $isActive ? '#c8232c' : '#e1e1e1' ?>; transition: all 0.2s ease-in-out; <?= $isActive ? 'background-color: #c8232c; color: #ffffff;' : 'background-color: transparent; color: #444444;' ?>"
               onmouseover="this.style.borderColor='#111111'; this.style.color='#111111'; <?php if(!$isActive) echo "this.style.backgroundColor='#ffffff';"; ?>"
               onmouseout="this.style.borderColor='<?= $isActive ? '#c8232c' : '#e1e1e1' ?>'; this.style.color='<?= $isActive ? '#ffffff' : '#444444' ?>'; <?php if(!$isActive) echo "this.style.backgroundColor='transparent';"; ?>">
                <?= htmlspecialchars($cat) ?>
            </a>
        <?php endforeach; ?>

    </div>
</section>

<section class="py-5" style="background-color: #ffffff; font-family: 'Montserrat', sans-serif;">
    <div class="container py-2">

        <?php if(empty($gallery)): ?>

            <div class="alert text-center py-4" style="background: #fafafa; border: 1px dashed #e1e1e1; color: #666666; border-radius: 4px; font-size: 14px; letter-spacing: 0.02em;">
                No images found in this classification.
            </div>

        <?php else: ?>

            <div class="row">
                <?php foreach($gallery as $item): ?>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card gallery-card" style="border: 1px solid #eeeeee; border-radius: 4px; background-color: #ffffff; box-shadow: none; overflow: hidden; height: 100%; display: flex; flex-direction: column;">
                            
                            <a href="javascript:void(0)" 
                               onclick="openLightbox('<?= htmlspecialchars($item['image']) ?>')"
                               style="display: block; overflow: hidden; background-color: #0b0d10;">
                                <img src="<?= htmlspecialchars($item['image']) ?>" 
                                     alt="<?= htmlspecialchars($item['title']) ?>"
                                     class="img-fluid"
                                     style="width: 100%; height: 240px; object-fit: cover; display: block; transition: transform 0.4s ease-in-out;"
                                     onmouseover="this.style.transform='scale(1.04)';"
                                     onmouseout="this.style.transform='scale(1.0)';">
                            </a>

                            <?php if(!empty($item['title']) || !empty($item['description'])): ?>
                                <div class="card-body p-3" style="border-top: 1px solid #fafafa; flex-grow: 1; display: flex; flex-direction: column; justify-content: center;">
                                    
                                    <?php if(!empty($item['title'])): ?>
                                        <h5 style="font-size: 13px; font-weight: 700; color: #c8232c; text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 4px; word-wrap: break-word;">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </h5>
                                    <?php endif; ?>

                                    <?php if(!empty($item['description'])): ?>
                                        <p class="mb-0" style="font-size: 12px; line-height: 1.5; color: #777777; font-weight: 400; word-wrap: break-word;">
                                            <?= htmlspecialchars($item['description']) ?>
                                        </p>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    </div>
</section>
<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    
    <img id="lightbox-image" src="" alt="Enlarged View Presentation">
</div>

<script>
/**
 * Triggers modal visibility displaying selected image resource
 * @param {string} image - Target image system path url
 */
function openLightbox(image) {
    document.getElementById('lightbox-image').src = image;
    document.getElementById('lightbox').style.display = 'block';
}

/**
 * Resets targeting states and visually hides modal system elements
 */
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
}

/**
 * Event Listener targeting overlay backdrop layout structures
 * to allow direct backdrop click dismissal triggers
 */
document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLightbox();
    }
});
</script>

<?php include 'includes/footer.php'; ?>