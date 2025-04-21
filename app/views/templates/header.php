<?php require_once ROOT . '/app/models/auth.php'; ?>
<?php require ROOT . '/app/views/templates/head.php'; ?>

<body class="<?= (isAdmin()) ? 'admin' : '' ?>">

<div class="site-wrapper"> <!-- ouverture du site-wrapper -->
<header>

    <div class="banner">
        <div class="banner-content">
            <h1 class="logo-title"><a href="home">EntreMoucheurs</a></h1>
        </div>
        <button class="burger" id="burger-menu" aria-controls="main-nav" aria-expanded="false" aria-label="Menu de navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
    
    <nav class="menu" id="main-nav" aria-label="Menu principal">
        <ul>
            <li><a href="home" class="<?= ($_GET['action'] ?? 'home') === 'home' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="spot" class="<?= ($_GET['action'] ?? '') === 'spot' ? 'active' : '' ?>">Spots</a></li>

            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                    <li><a href="admin" class="<?= ($_GET['action'] ?? '') === 'admin' ? 'active' : '' ?>">Admin</a></li>
                <?php else: ?>
                    <li><a href="profil" class="<?= ($_GET['action'] ?? '') === 'profil' ? 'active' : '' ?>">Mon profil</a></li>
                <?php endif; ?>
                <li><a href="logout">Déconnexion</a></li>
            <?php else: ?>
                <li><a href="login" class="<?= ($_GET['action'] ?? '') === 'login' ? 'active' : '' ?>">Connexion</a></li>
                <li><a href="register" class="<?= ($_GET['action'] ?? '') === 'register' ? 'active' : '' ?>">Inscription</a></li>
            <?php endif; ?>
        </ul>
    </nav>

</header>