<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="admin-container">
    
        <h1>Espace Administrateur</h1>
        
        <p class="welcome">Bienvenue, <?= htmlspecialchars($_SESSION['entremoucheurs_email']) ?> !</p>
        
        <!-- GESTION UTILISATEURS -->
        <section id="users-section">
            <h2>Liste des utilisateurs</h2>
        
            <form method="get" action="admin" class="search-admin">
                <input type="text" name="searchUser" placeholder="Rechercher par email ou pseudo..." value="<?= htmlspecialchars($searchUser) ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                <?php if (!empty($_SESSION['success_delete'])): ?>
                    <p class="success"><?= htmlspecialchars($_SESSION['success_delete']) ?></p>
                    <?php unset($_SESSION['success_delete']); ?>
                <?php endif; ?>
            </form>
        
            <?php if (empty($users)): ?>
                <p>Aucun utilisateur trouvé.</p>
            <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Pseudo</th>
                            <th>Rôle</th>
                            <th>Créé le</th>
                            <th>MAJ le</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['pseudo']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td><?= date('d/m/Y', strtotime($user['created_at'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($user['updated_at'])) ?></td>
                            <td>
                                <?php if ($_SESSION['entremoucheurs_user_id'] != $user['user_id']): ?>
                                    <form action="deleteUser" method="post">
                                        <input type="hidden" name="id" value="<?= $user['user_id'] ?>">
                                        <button 
                                            type="button" 
                                            class="btn btn-danger open-modal-delete" 
                                            data-action="deleteUser" 
                                            data-id="<?= $user['user_id'] ?>">
                                                <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <i class="fa-solid fa-lock"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        
            <!-- Pagination Users -->
            <?php if ($totalPagesUser > 1): ?>
                <nav class="pagination">
                    <?php for ($i = 1; $i <= $totalPagesUser; $i++): ?>
                        <a href="admin&pageUser=<?= $i ?>#users-section" class="<?= $i == $pageUser ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        </section>
        
        <!-- GESTION SPOTS -->
        <section id="spots-section">
            <h2>Liste des spots</h2>
        
            <form method="get" action="admin" class="search-admin">
                <input type="text" name="searchSpot" placeholder="Rechercher par nom ou auteur..." value="<?= htmlspecialchars($searchSpot) ?>">
                <button type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
            <?php if (!empty($_SESSION['success_delete'])): ?>
                <p class="success"><?= htmlspecialchars($_SESSION['success_delete']) ?></p>
                <?php unset($_SESSION['success_delete']); ?>
            <?php endif; ?>
        
            <?php if (empty($spots)): ?>
                <p>Aucun spot trouvé.</p>
            <?php else: ?>
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Ouvrir</th>
                            <th>Nom</th>
                            <th>Auteur</th>
                            <th>Département</th>
                            <th>Créé le</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($spots as $spot): ?>
                        <tr>
                            <td>
                                <button class="view-more-btn" data-spot-id="<?= $spot['spot_id'] ?>">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                            </td>
                            <td><?= htmlspecialchars($spot['name']) ?></td>
                            <td><?= htmlspecialchars($spot['pseudo']) ?></td>
                            <td><?= htmlspecialchars($spot['department']) ?></td>
                            <td><?= date('d/m/Y', strtotime($spot['created_at'])) ?></td>
                            <td>
                                <form action="spotDelete" method="post">
                                    <input type="hidden" name="id" value="<?= $spot['spot_id'] ?>">
                                    <button 
                                        type="button" 
                                        class="btn btn-danger open-modal-delete" 
                                        data-action="spotDelete" 
                                        data-id="<?= $spot['spot_id'] ?>">
                                            <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        
            <!-- Pagination Spots -->
            <?php if ($totalPagesSpot > 1): ?>
                <nav class="pagination">
                    <?php for ($i = 1; $i <= $totalPagesSpot; $i++): ?>
                        <a href="admin&pageSpot=<?= $i ?>#spots-section" class="<?= $i == $pageSpot ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </nav>
            <?php endif; ?>
        </section>
    
    </div>
</main>

<!-- modal spot détaillé -->
<div id="modal-spot" class="modal-spot" hidden>
    <div class="modal-spot-content ps" id="modal-scroll-target">
        <div id="modal-spot-body">
        <!-- contenu injecté ici -->
        </div>
    </div>
</div>

<!-- confirmation de suppression -->
<div class="modal-delete" id="modal-delete-user" hidden>
    <div class="modal-delete-content">
        <p class="modal-delete-text">
            Êtes-vous sûr de vouloir supprimer cet élément ?<br><strong>Cette action est irréversible.</strong>
        </p>
        <div class="modal-delete-actions">
            <form method="post" id="delete-form">
                <!-- Dynamique via JS -->
            </form>
            <button type="button" class="btn btn-cancel" id="cancel-delete">Annuler</button>
        </div>
    </div>
</div>

<?php require ROOT . '/app/views/templates/footer.php'; ?>
