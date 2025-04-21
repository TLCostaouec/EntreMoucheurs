<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="auth-container">
    
        <h1>Créer un compte</h1>
        
        <?php if (!empty($globalError)): ?>
            <p class="error" role="alert"><?= htmlspecialchars($globalError) ?></p>
        <?php endif; ?>
        
        <form method="post" action="register">
            <!-- Email -->
            <div class="field-group">
                <?php if (!empty($emailError)): ?>
                    <p class="error" id="email-error" role="alert"><?= htmlspecialchars($emailError) ?></p>
                <?php endif; ?>
                <div class="label-wrapper">
                    <label for="email">Email :</label>
                </div>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                    required 
                    autocomplete="email"
                    aria-describedby="<?= !empty($emailError) ? 'email-error' : '' ?>"
                >
            </div>

            <!-- Pseudo -->
            <div class="field-group">
                <?php if (!empty($pseudoError)): ?>
                    <p class="error" id="pseudo-error" role="alert"><?= htmlspecialchars($pseudoError) ?></p>
                <?php endif; ?>
                <div class="label-wrapper">
                    <label for="pseudo">Pseudo :</label>
                </div>
                <input 
                    type="text" 
                    name="pseudo" 
                    id="pseudo" 
                    value="<?= htmlspecialchars($_POST['pseudo'] ?? '') ?>" 
                    required 
                    autocomplete="username"
                    aria-describedby="<?= !empty($pseudoError) ? 'pseudo-error' : '' ?>"
                >
            </div>

            <!-- Mot de passe -->
            <div class="field-group">
                <?php if (!empty($passwordError)): ?>
                    <p class="error" id="password-error-php" role="alert"><?= htmlspecialchars($passwordError) ?></p>
                <?php endif; ?>
                <?php if (!empty($passwordConfirmError)): ?>
                    <p class="error" id="password-confirm-error-php" role="alert"><?= htmlspecialchars($passwordConfirmError) ?></p>
                <?php endif; ?>
                <p class="error" id="password-error" role="alert" hidden>
                    Les mots de passe ne correspondent pas.
                </p>
                <div class="label-wrapper">
                    <label for="password">Mot de passe :</label>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    autocomplete="new-password"
                    aria-describedby="<?= 
                        (!empty($passwordError) ? 'password-error-php ' : '') .
                        (!empty($passwordConfirmError) ? 'password-confirm-error-php ' : '') .
                        'password-error'
                    ?>"
                >
            </div>

            <!-- Confirmation -->
            <div class="field-group">
                <div class="label-wrapper">
                    <label for="password-confirm">Confirmer le mot de passe :</label>
                </div>
                <input 
                    type="password" 
                    name="password_confirm" 
                    id="password-confirm" 
                    required 
                    autocomplete="new-password"
                    aria-describedby="password-error"
                >
            </div>
        
            <button type="submit">S'inscrire</button>
        </form>
        
        <p>Déjà inscrit ? <a href="login">Se connecter</a></p>
    
    </div>
</main>

<?php require ROOT . '/app/views/templates/footer.php'; ?>
