<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Mon Blog' ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php include BASE_PATH . '/views/partials/navbar.php'; ?>
    
    <main>
        <?= $content ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> Mon Blog. Tous droits réservés.</p>
    </footer>
</body>
</html>
