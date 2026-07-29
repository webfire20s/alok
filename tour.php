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

/**
 * Assigns asymmetric grid layout classes based on image index
 */
function getLayoutClass($i, $pattern = 'A') {
    $mod = $i % 3;
    
    if ($pattern === 'A') {
        // Pattern A: First image is featured (large left), next two are stacked right
        if ($mod === 1) return 'feat-box';
        if ($mod === 0) return 'side-box-1';
        return 'side-box-2';
    } 
    elseif ($pattern === 'B') {
        // Pattern B: Center image is featured
        if ($mod === 0) return 'side-box-1';
        if ($mod === 1) return 'feat-box';
        return 'side-box-2';
    } 
    else {
        // Pattern C: Last image is featured (large right)
        if ($mod === 0) return 'side-box-1';
        if ($mod === 1) return 'side-box-2';
        return 'feat-box';
    }
}
?>

<!-- PERFORMANCE DEPENDENCIES -->
<link rel="stylesheet" href="tourstyle.css">
<style>
    /* Content visibility hint prevents browser layout thrashing on long image pages */
    .tour-section {
        content-visibility: auto;
        contain-intrinsic-size: 1000px;
    }
</style>

<!-- FACTORY TOUR CONTAINER MAIN FRAME -->
<div class="tour-wrapper">
    <div class="container">

        <!-- Master Section Title Unit -->
        <div class="tour-hero-header">
            <h1>Factory Showcase</h1>
            <p>Take an exclusive inside look at our advanced manufacturing infrastructure, raw processing spaces, and final quality control operations.</p>
        </div>

        <!-- STAGE 1: MAIN ENTRANCE (Pattern A Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">01</span> Factory Entrance & Corporate Showroom
            </h2>
            <div class="tour-grid grid-pattern-a">
            <?php foreach($entranceImages as $i => $img): ?>
                <div class="tour-media-frame <?= getLayoutClass($i, 'A') ?>">
                    <img
                        src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                        alt="<?= htmlspecialchars($img['alt_text']) ?>"
                        loading="lazy"
                        decoding="async"
                    >
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-frame-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

        <!-- STAGE 2: PROCESSING FLOORS (Pattern B Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">02</span> Advanced Processing Yards
            </h2>
            <div class="tour-grid grid-pattern-b">
            <?php foreach($processingImages as $i => $img): ?>
                <div class="tour-media-frame <?= getLayoutClass($i, 'B') ?>">
                    <img
                        src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                        alt="<?= htmlspecialchars($img['alt_text']) ?>"
                        loading="lazy"
                        decoding="async"
                    >
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-frame-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

        <!-- STAGE 3: QUALITY ASSURANCE & PACKAGING (Pattern C Layout) -->
        <div class="tour-section reveal-item">
            <h2 class="tour-section-title">
                <span class="tour-step-num">03</span> Decorations & Packaging
            </h2>
            <div class="tour-grid grid-pattern-c">
            <?php foreach($decorationImages as $i => $img): ?>
                <div class="tour-media-frame <?= getLayoutClass($i, 'C') ?>">
                    <img
                        src="storage/tour/<?= htmlspecialchars($img['image']) ?>"
                        alt="<?= htmlspecialchars($img['alt_text']) ?>"
                        loading="lazy"
                        decoding="async"
                    >
                    <?php if(!empty($img['alt_text'])): ?>
                        <div class="tour-frame-caption"><?= htmlspecialchars($img['alt_text']) ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>

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