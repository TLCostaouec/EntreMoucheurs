<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="spot-container">
    
        <div class="spot-title-wrapper">
            <h1>Liste des spots de pêche</h1>
        </div>
        
        <div class="spot-actions">
            <!-- formulaire de recherche -->
             <div class="search-content">
                 <form method="get" action="spot" role="search" aria-label="Recherche de spot">
        
                    <label for="search" class="sr-only">Rechercher un spot</label>
                    <input type="text" id="search" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" placeholder="Nom, auteur, ou département..." autocomplete="off">
                 
                     <button type="submit" aria-label="Rechercher un spot"><i class="fa-solid fa-magnifying-glass"></i></button>
                 </form>
             </div>
    
            <?php if (isLoggedIn() && !isAdmin()): ?>
                <div class="create-spot-content">
                    <button class="btn btn-validate" id="open-create-modal">Ajouter un spot</button>
                </div>
            <?php endif; ?>
        </div>
        
        <?php if (!empty($_SESSION['success_create'])): ?>
            <p class="success" role="status"><?= htmlspecialchars($_SESSION['success_create']) ?></p>
            <?php unset($_SESSION['success_create']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success_delete'])): ?>
            <p class="success" role="alert"><?= htmlspecialchars($_SESSION['success_delete']) ?></p>
            <?php unset($_SESSION['success_delete']); ?>
        <?php endif; ?>
        
        <!-- liens de tri -->
        <div class="sort-links">
            <p><strong>Trier :</strong></p>
            <a href="spot<?= isset($search) ? '&search=' . urlencode($search) : '' ?>&order=DESC" class="<?= ($order === 'DESC') ? 'active' : '' ?>"> Plus récents</a>
            <a href="spot<?= isset($search) ? '&search=' . urlencode($search) : '' ?>&order=ASC" class="<?= ($order === 'ASC') ? 'active' : '' ?>"> Plus anciens</a>
        </div>
        
        <!-- liste des spots -->
        <?php if (!empty($spots)): ?>
            <div class="spot-list">
                <?php foreach ($spots as $spot): ?>
                    <article class="spot-card" data-spot-id="<?= $spot['spot_id'] ?>">
                        <div class="thumbnail">
                            <img src="<?= htmlspecialchars(getFirstMediaPath($spot['spot_id'])) ?>" alt="Photo du spot <?= htmlspecialchars($spot['name']) ?>">
                        </div>
                        <div class="spot-info">
                            <div class="spot-title-wrapper">
                                <h2><?= htmlspecialchars($spot['name']) ?></h2>
                            </div>
                            <p><strong>Auteur :</strong> <?= htmlspecialchars($spot['pseudo']) ?></p>
                            <p><strong>Département :</strong> <?= htmlspecialchars($spot['department']) ?></p>
                            <p><strong>Description :</strong> <?= htmlspecialchars(mb_substr($spot['description'], 0, 100)) ?>...</p>
                            <p><strong><em>Ajouté le <?= date('d/m/Y', strtotime($spot['created_at'])) ?></em></strong></p>
        
                            <div class="spot-card-actions">
                                <button class="view-more-btn" data-spot-id="<?= $spot['spot_id'] ?>" aria-label="Voir plus d'informations sur le spot <?= htmlspecialchars($spot['name']) ?>">Voir plus</button>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>Aucun spot trouvé.</p>
        <?php endif; ?>
        
        <!-- pagination -->
        <?php if ($totalPages > 1): ?>
            <nav class="pagination" aria-label="pagination">
                <?php
                    $range = 2;
                    $baseUrl = 'spot';
                    if (isset($search)) $baseUrl .= '&search=' . urlencode($search);
                    if (isset($order)) $baseUrl .= '&order=' . htmlspecialchars($order);
                ?>
    
                <!-- Précédent -->
                <?php if ($currentPage > 1): ?>
                    <a href="<?= $baseUrl . '&page=' . ($currentPage - 1) ?>" aria-label="Page précédente">
                        <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
    
                <!-- Pages -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if (
                        $i == 1 ||
                        $i == $totalPages ||
                        ($i >= $currentPage - $range && $i <= $currentPage + $range)
                    ): ?>
                        <a href="<?= $baseUrl . '&page=' . $i ?>" class="<?= $i == $currentPage ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                        <?php $lastDisplayed = $i; ?>
                    <?php elseif (!isset($lastDisplayed) || $lastDisplayed !== 'dots'): ?>
                        <span class="dots">...</span>
                        <?php $lastDisplayed = 'dots'; ?>
                    <?php endif; ?>
                <?php endfor; ?>
    
                <!-- Suivant -->
                <?php if ($currentPage < $totalPages): ?>
                    <a href="<?= $baseUrl . '&page=' . ($currentPage + 1) ?>" aria-label="Page suivante">
                        <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                    </a>
                <?php endif; ?>
            </nav>
        <?php endif; ?>
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
    
    <!-- modal création spot -->
    <div class="modal-create" id="modal-create" role="dialog" aria-modal="true" aria-labelledby="modal-create-title" hidden>
        <div class="modal-create-content">
            <h2 id="modal-create-title">Ajouter un nouveau spot</h2>
    
            <!-- enctype="multipart/form-data" attribut obligatoire lors de l'utilisation de <input type="file"> pour l'envoie de fichier -->
            <form method="post" action="spot" enctype="multipart/form-data">

                <!-- nom du spot -->
                <div class="form-group">
                    <?php if (!empty($nameError)): ?>
                        <p class="error" id="name-error" role="alert"><?= htmlspecialchars($nameError) ?></p>
                    <?php endif; ?>
                    <label for="name">Nom du spot :</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        maxlength="26" 
                        value="<?= htmlspecialchars($name ?? '') ?>" 
                        required 
                        autocomplete="name"
                        aria-describedby="<?= !empty($nameError) ? 'name-error' : '' ?>"
                    >
                </div>

                <!-- description -->
                <div class="form-group">
                    <?php if (!empty($descriptionError)): ?>
                        <p class="error" id="description-error" role="alert"><?= htmlspecialchars($descriptionError) ?></p>
                    <?php endif; ?>
                    <label for="description">Description :</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        maxlength="500" 
                        rows="4"
                        aria-describedby="<?= !empty($descriptionError) ? 'description-error' : '' ?>"
                    ><?= htmlspecialchars($description ?? '') ?></textarea>
                    <p class="description-counter" id="description-counter">0 / 500 caractères</p>
                </div>

                <!-- département -->
                <div class="form-group">
                    <?php if (!empty($departmentError)): ?>
                        <p class="error" id="department-error" role="alert"><?= htmlspecialchars($departmentError) ?></p>
                    <?php endif; ?>
                    <label for="department">Département :</label>
                    <input 
                        type="text" 
                        name="department" 
                        id="department" 
                        maxlength="25" 
                        value="<?= htmlspecialchars($department ?? '') ?>" 
                        required 
                        autocomplete="address-level2"
                        aria-describedby="<?= !empty($departmentError) ? 'department-error' : '' ?>"
                    >
                </div>

                <!-- coordonnées -->
                <div class="form-group">
                    <?php if (!empty($coordsError)): ?>
                        <p class="error" id="coords-error" role="alert"><?= htmlspecialchars($coordsError) ?></p>
                    <?php endif; ?>
                    <label for="latitude">Latitude :</label>
                    <input 
                        type="text" 
                        name="latitude" 
                        id="latitude" 
                        value="<?= htmlspecialchars($latitude ?? '') ?>" 
                        required 
                        autocomplete="off"
                        aria-describedby="<?= !empty($coordsError) ? 'coords-error' : '' ?>"
                    >

                    <label for="longitude">Longitude :</label>
                    <input 
                        type="text" 
                        name="longitude" 
                        id="longitude" 
                        value="<?= htmlspecialchars($longitude ?? '') ?>" 
                        required 
                        autocomplete="off"
                        aria-describedby="<?= !empty($coordsError) ? 'coords-error' : '' ?>"
                    >
                </div>

                <!-- crédit photo -->
                <div class="form-group">
                    <?php if (!empty($creditError)): ?>
                        <p class="error" id="credit-error" role="alert"><?= htmlspecialchars($creditError) ?></p>
                    <?php endif; ?>
                    <label for="credit">Crédit photo :</label>
                    <input 
                        type="text" 
                        name="credit" 
                        id="credit" 
                        maxlength="50" 
                        value="<?= htmlspecialchars($credit ?? '') ?>" 
                        required 
                        autocomplete="off"
                        aria-describedby="<?= !empty($creditError) ? 'credit-error' : '' ?>"
                    >
                </div>

                <!-- upload d'images -->
                <div class="form-group">
                    <?php if (!empty($imageError)): ?>
                        <p class="error" id="image-error" role="alert"><?= htmlspecialchars($imageError) ?></p>
                    <?php endif; ?>
                    <p class="error" id="image-error-js" role="alert" hidden></p>

                    <label for="images">Ajouter jusqu'à 3 images (JPEG, PNG, WebP, max 500Ko) :</label>
                    <div class="custom-file-upload">
                        <label for="images" class="btn btn-upload">Sélectionner</label>
                        <input 
                            type="file" 
                            name="images[]" 
                            id="images" 
                            multiple 
                            accept=".jpg,.jpeg,.png,.webp"
                            aria-describedby="<?= 
                                (!empty($imageError) ? 'image-error ' : '') . 'image-error-js' 
                            ?>"
                        >
                        <p class="file-count" id="file-count">0/3 images ajoutées</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-success">Publier</button>
                    <button type="button" class="btn btn-cancel" id="cancel-create-spot">Annuler</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (
        !empty($nameError) || !empty($descriptionError) || !empty($departmentError) ||
        !empty($coordsError) || !empty($creditError) || !empty($imageError)
    ): ?>
    <script>
        window.addEventListener('load', () => {
            const modal = document.getElementById('modal-create');
            if (modal) {
                modal.removeAttribute('hidden');
                document.body.style.overflow = 'hidden';
            }
        });
    </script>
    <?php endif; ?>

<?php require ROOT . '/app/views/templates/footer.php'; ?>