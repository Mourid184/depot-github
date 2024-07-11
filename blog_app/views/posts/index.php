<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des articles</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
<?php include  '../views/partials/navbar.php'; ?>

    <h1>Liste des articles</h1>
    <?php foreach ($posts as $post): ?>
        <article class="post">
            <h2><?= htmlspecialchars($post['title']) ?></h2>

            <?php if ($post['image_path']): ?>
            <div class="post-image">
                <img src="/<?= htmlspecialchars($post['image_path']) ?>" alt="Image du post">
            </div>
        <?php endif; ?>

            <div class="post-meta">
                Publié le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
            </div>
            <div class="post-excerpt">
                <p><?= htmlspecialchars(substr($post['content'], 0, 200)) ?>...</p>
            </div>
            <a href="index.php?action=show&id=<?= $post['id'] ?>" class="read-more">Lire la suite</a>
        </article>
    <?php endforeach; ?>
</body>
</html>
