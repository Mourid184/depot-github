<nav class="navbar">
    <div class="navbar-brand">
        <a href="index.php">Mon Blog</a>
    </div>
    <div class="navbar-menu">
        <a href="index.php" class="navbar-item">Accueil</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span class="navbar-item">Bienvenue, <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="index.php?action=create" class="navbar-item">Créer un article</a>
            <a href="index.php?action=logout" class="navbar-item">Déconnexion</a>
        <?php else: ?>
            <a href="index.php?action=login" class="navbar-item">Connexion</a>
            <a href="index.php?action=register" class="navbar-item">Inscription</a>
        <?php endif; ?>
    </div>
</nav>
