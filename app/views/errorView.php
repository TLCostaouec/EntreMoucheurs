<?php require ROOT . '/app/views/templates/header.php'; ?>

<main>
    <div class="error-container">
        <h1>Une erreur est survenue</h1>
        <p><?= htmlspecialchars($errorMessage) ?></p>
    </div>
</main>

<?php require ROOT . '/app/views/templates/footer.php'; ?>