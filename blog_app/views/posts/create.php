<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouveau post</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
<?php include BASE_PATH . '/views/partials/navbar.php'; ?>

    <h1>Créer un nouveau post</h1>
    <form action="index.php?action=create" method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Titre :</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="content">Contenu :</label>
            <textarea id="content" name="content" required></textarea>
        </div>
        <div>
            <label for="image">Image :</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        <button type="submit">Créer le post</button>
    </form>
    <a href="index.php" class="back-link">Retour à la liste des articles</a>
</body>
</html>
