<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="auth-container">
    
        <h1>Connexion</h1>
        
        <?php if (!empty($error)): ?>
            <p class="error" id="login-error" role="alert"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        
        <form method="post" action="login">
            <div class="field-group">
                <div class="label-wrapper">
                    <label for="email">Email :</label>
                </div>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    autocomplete="email"
                    aria-describedby="<?= !empty($error) ? 'login-error' : '' ?>"
                >
            </div>
            <div class="field-group">
                <div class="label-wrapper">
                    <label for="password">Mot de passe :</label>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    required 
                    autocomplete="current-password"
                    aria-describedby="<?= !empty($error) ? 'login-error' : '' ?>"
                >
            </div>    
    
            <button type="submit">Se connecter</button>
        </form>
    
        <p>Pas encore inscrit ? 
            <a href="register" aria-label="Aller à la page de création de compte">Créer un compte</a>
        </p>
    
    </div>
</main>

<?php require ROOT . '/app/views/templates/footer.php'; ?>
