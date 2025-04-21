<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
<h1 class="sr-only">Page d'accueil EntreMoucheurs</h1>
<div class="home-container">
    <div class="intro">
        <img src="public/assets/img/logoEntreMoucheurs.webp" alt="Logo EntreMoucheurs" class="home-logo" decoding="async">
        <p class="intro-text">
            Bienvenue sur <strong>EntreMoucheurs</strong>, la plateforme dédiée aux passionnés de pêche à la mouche. 
            Explorez, partagez, et découvrez les meilleurs spots à travers la France.
        </p>
    </div>

    <div class="home-highlight">
        <button class="home-video" aria-label="Lire la vidéo">
            <img 
                src="https://img.youtube.com/vi/c2-qMmPE5X0/hqdefault.jpg" 
                alt="Miniature vidéo EntreMoucheurs" 
                class="video-thumbnail"
                decoding="async"
            >
            <div class="play-button"><i class="fa-solid fa-play"></i></div>
        </button>
    
        <div class="home-stats">
            <h2>Rejoignez nous</h2>
            <!-- liste de définitions pour l'accessibilité -->
            <dl class="stat-content">
                <div class="stat">
                    <dd><?= $totalSpots ?></dd>
                    <dt>Spots</dt>
                </div>
                <div class="stat">
                    <dd><?= $totalUsers ?></dd>
                    <dt>Membres</dt>
                </div>
            </dl>
        </div>
    </div>

    <div class="last-spots-section">
        <h2>Derniers spots ajoutés</h2>

        <?php if (!empty($latestSpots)): ?>
            <div class="carousel" aria-label="Carousel des derniers spots ajoutés">
                <?php foreach ($latestSpots as $spot): ?>
                    <article class="spot-card">
                        <div class="thumbnail">
                            <img src="<?= htmlspecialchars(getFirstMediaPath($spot['spot_id'])) ?>" alt="Photo du spot <?= htmlspecialchars($spot['name']) ?>">
                        </div>
                        <div class="spot-info">
                            <h2><?= htmlspecialchars($spot['name']) ?></h2>
                            <p><strong>Auteur :</strong> <?= htmlspecialchars($spot['pseudo']) ?></p>
                            <p><strong>Département :</strong> <?= htmlspecialchars($spot['department']) ?></p>
                            <p><strong>Description :</strong> <?= htmlspecialchars(mb_substr($spot['description'], 0, 100)) ?>...</p>
                            <p><strong><em>Ajouté le <?= date('d/m/Y', strtotime($spot['created_at'])) ?></em></strong></p>
        
                            <div class="spot-card-actions">
                                <button class="view-more-btn" data-spot-id="<?= $spot['spot_id'] ?>" aria-label="Voir plus sur le spot <?= htmlspecialchars($spot['name']) ?>">Voir plus</button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="carousel-nav">
                <button class="carousel-prev" aria-label="Voir le spot précédent"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="carousel-next" aria-label="Voir le spot suivant"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        <?php endif; ?>
    </div>
</div>

</main>

<!-- modal spot détaillé -->
<div id="modal-spot" class="modal-spot" role="dialog" aria-modal="true" aria-labelledby="modal-spot-title" hidden>
    <div class="modal-spot-content ps" id="modal-scroll-target">
        <div id="modal-spot-body">
        <!-- contenu injecté ici -->
        </div>
    </div>
</div>

<script>
function loadVideo(container) {
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', 'https://www.youtube-nocookie.com/embed/c2-qMmPE5X0?autoplay=1');
    iframe.setAttribute('title', 'YouTube video player');
    iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share');
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
    iframe.setAttribute('frameborder', '0');
    iframe.style.width = '100%';
    iframe.style.height = '100%';
    
    container.innerHTML = '';
    container.appendChild(iframe);
}
</script>


<?php require ROOT . '/app/views/templates/footer.php'; ?>