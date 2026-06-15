<?php

require 'includes/db.php';

/*
|--------------------------------------------------------------------------
| GET SLUG
|--------------------------------------------------------------------------
*/

$slug = trim($_GET['slug'] ?? '');

if(empty($slug)){

    http_response_code(404);

    die('Page not found');
}

/*
|--------------------------------------------------------------------------
| PAGE
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM pages
    WHERE slug = ?
    AND status = 'published'
    LIMIT 1
");

$stmt->execute([$slug]);

$page = $stmt->fetch();

if(!$page){

    http_response_code(404);

    include '404.php';
    exit;
}

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$pageTitle = !empty($page['meta_title'])
    ? $page['meta_title']
    : $page['title'];

$pageDescription =
    $page['meta_description'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($pageTitle) ?>
    </title>

    <meta
        name="description"
        content="<?= htmlspecialchars($pageDescription) ?>"
    >

    

</head>

<body>

<?php include 'includes/header.php'; ?>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-sm border-0">

                <div class="card-body p-4 p-md-5">

                    <h1 class="mb-4">

                        <?= htmlspecialchars($page['title']) ?>

                    </h1>

                    <div class="page-content">

                        <?= $page['content'] ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>

</body>
</html>