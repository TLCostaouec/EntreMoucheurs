<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="profil-container">
    
        <!-- infos du profil -->
        <h1>Mon profil</h1>
        
        <p><strong>Pseudo :</strong> <?= htmlspecialchars($user['pseudo']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Inscrit le :</strong> <?= date('d/m/Y à H:i', strtotime($user['created_at'])) ?></p>
        <p><strong>Mis à jour le :</strong> <?= date('d/m/Y à H:i', strtotime($user['updated_at'])) ?></p>
        
        <!-- Supression de compte -->
        <div class="delete-section">
            <button type="button" id="open-delete-modal">Supprimer mon compte</button>
        </div>
        
    
        <!-- modification du compte -->
        <h2>Modifier mes informations</h2>
        <div class="form-wrapper">
    
            <!-- email -->
            <div class="form-section">
                <?php if (!empty($error) && $formType === 'email'): ?>
                    <p class="error" id="email-error" role="alert"><?= htmlspecialchars($error) ?></p>
                <?php elseif (!empty($success) && $formType === 'email'): ?>
                    <p class="success" id="email-success" role="status"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <form method="post" action="profil">
                    <input type="hidden" name="form_type" value="email">

                    <label for="email">Nouvelle adresse email :</label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        required 
                        aria-describedby="<?= 
                            !empty($error) && $formType === 'email' ? 'email-error' : 
                            (!empty($success) && $formType === 'email' ? 'email-success' : '') 
                        ?>"
                    >

                    <button type="submit">Modifier</button>
                </form>
            </div>
            
            <!-- pseudo -->
            <div class="form-section">
                <?php if (!empty($error) && $formType === 'pseudo'): ?>
                    <p class="error" id="pseudo-error" role="alert"><?= htmlspecialchars($error) ?></p>
                <?php elseif (!empty($success) && $formType === 'pseudo'): ?>
                    <p class="success" id="pseudo-success" role="status"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <form method="post" action="profil">
                    <input type="hidden" name="form_type" value="pseudo">

                    <label for="pseudo">Nouveau pseudo :</label>
                    <input 
                        type="text" 
                        name="pseudo" 
                        id="pseudo" 
                        required 
                        aria-describedby="<?= 
                            !empty($error) && $formType === 'pseudo' ? 'pseudo-error' : 
                            (!empty($success) && $formType === 'pseudo' ? 'pseudo-success' : '') 
                        ?>"
                    >

                    <button type="submit">Modifier</button>
                </form>
            </div>
            
            <!-- password -->
            <div class="form-section">
                <?php if (!empty($error) && $formType === 'password'): ?>
                    <p class="error" id="password-error-server" role="alert"><?= htmlspecialchars($error) ?></p>
                <?php elseif (!empty($success) && $formType === 'password'): ?>
                    <p class="success" id="password-success" role="status"><?= htmlspecialchars($success) ?></p>
                <?php endif; ?>

                <p class="error" id="password-error-client" role="alert" hidden>Les mots de passe ne correspondent pas.</p>

                <form method="post" action="profil" id="password-form">
                    <input type="hidden" name="form_type" value="password">

                    <label for="password">Nouveau mot de passe :</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        required 
                        aria-describedby="password-error-client<?= !empty($error) && $formType === 'password' ? ' password-error-server' : '' ?>"
                    >

                    <label for="password-confirm">Confirmer le mot de passe :</label>
                    <input 
                        type="password" 
                        name="password_confirm" 
                        id="password-confirm" 
                        required 
                        aria-describedby="password-error-client"
                    >

                    <button type="submit">Modifier</button>
                </form>
            </div>  
        </div>
    
        <section id="my-spots-section">
            <h2>Mes spots publiés</h2>
    
            <?php if (!empty($_SESSION['success_delete'])): ?>
                <p class="success" role="status"><?= htmlspecialchars($_SESSION['success_delete']) ?></p>
                <?php unset($_SESSION['success_delete']); ?>
            <?php endif; ?>
            <?php if (!empty($_SESSION['success_edit'])): ?>
                <p class="success" role="status"><?= htmlspecialchars($_SESSION['success_edit']) ?></p>
                <?php unset($_SESSION['success_edit']); ?>
            <?php endif; ?>
    
            <?php if (empty($userSpots)): ?>
                <p>Vous n'avez publié aucun spot.</p>
            <?php else: ?>
            <div class="table-wrapper">
                <table aria-label="Mes spots publiés">
                    <thead>
                        <tr>
                            <th>Ouvrir</th>
                            <th>Nom</th>
                            <th>Département</th>
                            <th>Créé le</th>
                            <th>modifié le</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($userSpots as $spot): ?>
                        <tr>
                            <td>
                                <button class="view-more-btn" data-spot-id="<?= $spot['spot_id'] ?>">
                                    <i class="fa-solid fa-circle-plus"></i>
                                </button>
                            </td>
                            <td><?= htmlspecialchars($spot['name']) ?></td>
                            <td><?= htmlspecialchars($spot['department']) ?></td>
                            <td><?= date('d/m/Y', strtotime($spot['created_at'])) ?></td>
                            <td><?= date('d/m/Y', strtotime($spot['updated_at'])) ?></td>
                            <td>
                                <a href="#" 
                                    class="btn open-spot-edit-modal" 
                                    data-id="<?= $spot['spot_id'] ?>" 
                                    data-name="<?= htmlspecialchars($spot['name'], ENT_QUOTES) ?>" 
                                    data-description="<?= htmlspecialchars($spot['description'], ENT_QUOTES) ?>" 
                                    data-department="<?= htmlspecialchars($spot['department'], ENT_QUOTES) ?>" 
                                    data-lat="<?= $spot['latitude'] ?>" 
                                    data-lon="<?= $spot['longitude'] ?>">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </td>
                            <td>
                                <form action="spotDelete" method="post">
                                    <input type="hidden" name="id" value="<?= $spot['spot_id'] ?>">
                                    <button 
                                        type="button" 
                                        class="btn btn-danger open-delete-spot-modal"
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
        </section>
        
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

<!-- confirmation de suppression compte -->
<div class="modal-delete" id="modal-delete" role="dialog" aria-modal="true" aria-labelledby="modal-delete-title" hidden>
    <div class="modal-delete-content">
        <p id="modal-delete-title" class="sr-only">Confirmation de suppression de compte</p>

        <p class="modal-delete-text">
            Êtes-vous sûr de vouloir supprimer votre compte ?<br><strong>Cette action est irréversible.</strong>
        </p>
        <div class="modal-delete-actions">
            <form method="post" action="profil">
                <input type="hidden" name="delete_account" value="1">
                <button type="submit" class="btn btn-danger">Supprimer</button>
            </form>
            <button type="button" class="btn btn-cancel" id="cancel-delete">Annuler</button>
        </div>
    </div>
</div>

<div class="modal-delete" id="modal-delete-spot" role="dialog" aria-modal="true" aria-labelledby="modal-delete-spot-title" hidden>
    <div class="modal-delete-content">
        <p id="modal-delete-spot-title" class="sr-only">Confirmation de suppression de spot</p>

        <p class="modal-delete-text">
            Êtes-vous sûr de vouloir supprimer ce spot ?<br><strong>Cette action est irréversible.</strong>
        </p>
        <div class="modal-delete-actions">
            <form method="post" action="spotDelete">
                <input type="hidden" name="id">
                <button type="submit" class="btn btn-danger">Supprimer</i></button>
            </form>
            <button type="button" class="btn btn-cancel" id="cancel-delete-spot">Annuler</button>
        </div>
    </div>
</div>

<!-- modal édition de spot -->
<div class="modal-create" id="modal-spot-edit" role="dialog" aria-modal="true" aria-labelledby="edit-modal-title" hidden>
    <div class="modal-create-content">
        <h2 id="edit-modal-title">Modifier le spot</h2>

        <form method="post" action="spotEdit" enctype="multipart/form-data">
            <input type="hidden" name="spot_id" value="<?= htmlspecialchars($spot['spot_id']) ?>">

            <!-- nom -->
            <div class="form-group">
                <?php if (!empty($nameError)): ?>
                    <p class="error" id="edit-name-error" role="alert"><?= htmlspecialchars($nameError) ?></p>
                <?php endif; ?>
                <label for="edit-name">Nom du spot :</label>
                <input 
                    type="text" 
                    name="name" 
                    id="edit-name" 
                    maxlength="26" 
                    required 
                    autocomplete="name" 
                    value="<?= htmlspecialchars($spot['name']) ?>"
                    aria-describedby="<?= !empty($nameError) ? 'edit-name-error' : '' ?>"
                >
            </div>

            <!-- description -->
            <div class="form-group">
                <?php if (!empty($descriptionError)): ?>
                    <p class="error" id="edit-description-error" role="alert"><?= htmlspecialchars($descriptionError) ?></p>
                <?php endif; ?>
                <label for="edit-description">Description :</label>
                <textarea 
                    name="description" 
                    id="edit-description" 
                    maxlength="500" 
                    rows="4"
                    aria-describedby="<?= 
                        (!empty($descriptionError) ? 'edit-description-error ' : '') . 'edit-description-counter' 
                    ?>"
                ><?= htmlspecialchars($spot['description']) ?></textarea>
                <p class="description-counter" id="edit-description-counter">
                    <?= mb_strlen($spot['description']) ?> / 500 caractères
                </p>
            </div>

            <!-- département -->
            <div class="form-group">
                <?php if (!empty($departmentError)): ?>
                    <p class="error" id="edit-department-error" role="alert"><?= htmlspecialchars($departmentError) ?></p>
                <?php endif; ?>
                <label for="edit-department">Département :</label>
                <input 
                    type="text" 
                    name="department" 
                    id="edit-department" 
                    maxlength="25" 
                    required 
                    autocomplete="address-level2" 
                    value="<?= htmlspecialchars($spot['department']) ?>"
                    aria-describedby="<?= !empty($departmentError) ? 'edit-department-error' : '' ?>"
                >
            </div>

            <!-- coordonnées -->
            <div class="form-group">
                <?php if (!empty($coordsError)): ?>
                    <p class="error" id="edit-coords-error" role="alert"><?= htmlspecialchars($coordsError) ?></p>
                <?php endif; ?>
                <label for="edit-latitude">Latitude :</label>
                <input 
                    type="text" 
                    name="latitude" 
                    id="edit-latitude" 
                    required 
                    autocomplete="off" 
                    value="<?= htmlspecialchars($spot['latitude']) ?>"
                    aria-describedby="<?= !empty($coordsError) ? 'edit-coords-error' : '' ?>"
                >

                <label for="edit-longitude">Longitude :</label>
                <input 
                    type="text" 
                    name="longitude" 
                    id="edit-longitude" 
                    required 
                    autocomplete="off" 
                    value="<?= htmlspecialchars($spot['longitude']) ?>"
                    aria-describedby="<?= !empty($coordsError) ? 'edit-coords-error' : '' ?>"
                >
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <button type="button" class="btn btn-cancel" id="cancel-spot-edit">Annuler</button>
            </div>
        </form>
    </div>
</div>

<!-- confirmation double mot de passe -->
<script>
    const passwordForm = document.getElementById('password-form');

    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirm = document.getElementById('password-confirm').value;
            const errorMsg = document.getElementById('password-error-client');

            if (password !== confirm) {
                e.preventDefault();
                errorMsg.hidden = false;
            } else {
                errorMsg.hidden = true;
            }
        });
    }
</script>

<?php require ROOT . '/app/views/templates/footer.php'; ?>