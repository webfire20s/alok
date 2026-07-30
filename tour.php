<?php include 'includes/header.php';
/*
|--------------------------------------------------------------------------
| FACTORY TOUR IMAGES
|--------------------------------------------------------------------------
*/

$tourStmt = $pdo->query("
    SELECT *
    FROM tour_images
    ORDER BY
        FIELD(section,'entrance','processing','decoration'),
        display_order ASC,
        id ASC
");

$tourSections = [
    'entrance'   => [],
    'processing' => [],
    'decoration' => []
];

while($row = $tourStmt->fetch(PDO::FETCH_ASSOC)){
    $tourSections[$row['section']][] = $row;
}

$entranceImages   = $tourSections['entrance'];
$processingImages = $tourSections['processing'];
$decorationImages = $tourSections['decoration'];
?>

<!-- PERFORMANCE DEPENDENCIES -->
<link rel="stylesheet" href="tourstyle.css">

<style>
    .tour-section {
        content-visibility: auto;
        contain-intrinsic-size: 1000px;
        margin-bottom: 4rem;
    }

    /* Clean 3-Column Standard Grid */
    .tour-standard-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-top: 1.5rem;
    }

    /* Standard Card Box */
    .tour-card {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: transform 0.35s ease, box-shadow 0.35s ease;
        display: flex;
        flex-direction: column;
    }

    .tour-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    }

    /* Uniform Image Frame (16:10 Ratio) */
    .tour-card-img-wrap {
        width: 100%;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background-color: #f7f7f7;
    }

    .tour-card-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }

    .tour-card:hover .tour-card-img-wrap img {
        transform: scale(1.05);
    }

    /* Caption Styling */
    .tour-card-caption {
        padding: 12px 16px;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #333333;
        line-height: 1.4;
        text-align: center;
        border-top: 1px solid #f2f4f6;
        background: #ffffff;
    }

    /* Responsive Breakpoints */
    @media (max-width: 991px) {
        .tour-standard-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 575px) {
        .tour-standard-grid {
            grid-template-columns: repeat(1, 1fr);
            gap: 16px;
        }
    }
</style>

<!-- FACTORY TOUR CONTAINER MAIN FRAME -->
<div class="tour-wrapper py-5">
    <div class="container">

        <!-- Master Section Title Unit -->
        <div class="tour-hero-header text-center mb-5">
            <h1>Factory Showcase</h1>
            <p>Take an exclusive inside look at our advanced manufacturing infrastructure, raw processing spaces, and final quality control operations.</p>
        </div>

        <!-- STAGE 1: MAIN ENTRANCE -->
        <?php if(!empty($entranceImages)): ?>
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">01</span> Factory Entrance & Corporate Showroom
            </h2>
            <div class="tour-standard-grid">
            <?php foreach($entranceImages as $img): ?>
                <div class="tour-card">
                    <div class="tour-card-img-wrap">
                        <img
                            src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                            alt="<?= htmlspecialchars($img['alt_text']) ?>"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-card-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- STAGE 2: PROCESSING FLOORS -->
        <?php if(!empty($processingImages)): ?>
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">02</span> Advanced Processing Yards
            </h2>
            <div class="tour-standard-grid">
            <?php foreach($processingImages as $img): ?>
                <div class="tour-card">
                    <div class="tour-card-img-wrap">
                        <img
                            src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                            alt="<?= htmlspecialchars($img['alt_text']) ?>"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-card-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- STAGE 3: QUALITY ASSURANCE & PACKAGING -->
        <?php if(!empty($decorationImages)): ?>
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">03</span> Decorations & Packaging
            </h2>
            <div class="tour-standard-grid">
            <?php foreach($decorationImages as $img): ?>
                <div class="tour-card">
                    <div class="tour-card-img-wrap">
                        <img
                            src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                            alt="<?= htmlspecialchars($img['alt_text']) ?>"
                            loading="lazy"
                            decoding="async"
                        >
                    </div>
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-card-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<!-- HIGH PERFORMANCE INTERSECTION CONTROLLER ENGINE -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const revealItems = document.querySelectorAll('.reveal-item');
        
        const revealOptions = {
            root: null,
            threshold: 0.02,
            rootMargin: "0px 0px 100px 0px"
        };

        const revealObserver = new IntersectionObserver(function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    observer.unobserve(entry.target); 
                }
            });
        }, revealOptions);

        revealItems.forEach(item => {
            revealObserver.observe(item);
        });
    });
</script>
<?php include 'includes/footer.php';?>