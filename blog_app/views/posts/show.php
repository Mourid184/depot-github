<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?></title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

<?php include BASE_PATH . '/views/partials/navbar.php'; ?>

    <article class="post">
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">
            Publié par <?= htmlspecialchars($author['username']) ?> 
            le <?= date('d/m/Y à H:i', strtotime($post['created_at'])) ?>
        </div>
        <?php if ($post['image_path']): ?>
            <div class="post-image">
                <img src="/<?= htmlspecialchars($post['image_path']) ?>" alt="Image du post">
            </div>
        <?php endif; ?>
        <div class="post-content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
        <div class="post-actions">
            <span class="likes-count"><?= $likesCount ?> likes</span>

            <?php if ($isLoggedIn): ?>
        <button class="like-btn <?= $hasLiked ? 'liked' : '' ?>" data-post-id="<?= $post['id'] ?>">
            <?= $hasLiked ? 'Unlike' : 'Like' ?>
        </button>
             <?php endif; ?>

            <?php if ($canDelete): ?>
                <form action="index.php?action=delete&id=<?= $post['id'] ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                    <button type="submit" class="delete-btn">Supprimer l'article</button>
                </form>
            <?php endif; ?>
        </div>
    </article>

    <section class="comments">
        <h2>Commentaires</h2>
        <?php if ($isLoggedIn): ?>
            <form action="index.php?action=addComment&id=<?= $post['id'] ?>" method="POST" class="comment-form">
                <textarea name="content" required placeholder="Votre commentaire"></textarea>
                <button type="submit">Ajouter un commentaire</button>
            </form>
        <?php else: ?>
            <p><a href="index.php?action=login">Connectez-vous</a> pour ajouter un commentaire.</p>
        <?php endif; ?>

        <?php foreach ($comments as $comment): ?>
            <div class="comment">
                <p class="comment-meta">
                    Par <?= htmlspecialchars($comment['username']) ?> 
                    le <?= date('d/m/Y à H:i', strtotime($comment['created_at'])) ?>
                </p>
                <p class="comment-content"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
            </div>
        <?php endforeach; ?>
    </section>

    <a href="index.php" class="back-link">Retour à la liste des articles</a>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.like-btn').click(function() {
        var button = $(this);
        var postId = button.data('post-id');
        $.ajax({
            url: 'index.php?action=toggleLike&id=' + postId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.hasLiked) {
                    button.addClass('liked').text('Unlike');
                } else {
                    button.removeClass('liked').text('Like');
                }
                $('.likes-count').text(response.likesCount + ' likes');
            }
        });
    });
});
</script>


</body>
</html>
