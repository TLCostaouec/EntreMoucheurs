<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="contact-container">
        <h1>Contactez-nous</h1>
        
        <p class="intro">
            Une question, un souci, ou juste envie de nous faire un coucou ?
            N'hésitez pas à nous écrire via ce formulaire.
        </p>
    
        <form action="index.php?action=contact" method="post" class="contact-form">
            <?php if (!empty($successMessage)): ?>
                <p class="success" role="status"><?= htmlspecialchars($successMessage) ?></p>
            <?php elseif (!empty($errorMessage)): ?>
                <p class="error" role="alert"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="email">Votre adresse email :</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    required 
                    autocomplete="email"
                    aria-describedby="contact-email-help"
                >
                <small id="contact-email-help" class="sr-only">Champ requis pour pouvoir vous répondre</small>
            </div>
    
            <div class="form-group">
                <label for="message">Votre message :</label>
                <textarea 
                    name="message" 
                    id="message" 
                    rows="6" 
                    required 
                    autocomplete="off"
                    aria-describedby="message-help"
                ></textarea>
                <small id="message-help" class="sr-only">Décrivez votre demande de manière claire. Champ obligatoire.</small>
            </div>
    
            <button type="submit" class="btn btn-validate">Envoyer</button>
        </form>
    </div>
</main>

<?php require ROOT . '/app/views/templates/footer.php'; ?>
