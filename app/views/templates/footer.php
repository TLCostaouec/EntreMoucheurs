    <footer class="footer">
        <div class="footer-content">
            <div class="footer-links">
                <a href="privacy">Mentions légales</a>
            </div>

            <div class="footer-logo">
                <a href="home"><img src="public/assets/img/logoEntreMoucheurs.webp" alt="Logo EntreMoucheurs" loading="lazy" decoding="async"></a>
            </div>

            <div class="footer-links">
                <a href="contact">Nous contacter</a>
            </div>
        </div>

        <p class="copyright">&copy; <?= date('Y') ?> EntreMoucheurs. Tous droits réservés.</p>
    </footer>

    <div class="cookie-banner" id="cookie-banner" hidden>
        <p>
            Ce site utilise des cookies nécessaires à son bon fonctionnement et à la diffusion de contenus externes (YouTube).
            <a href="privacy">En savoir plus</a>.
        </p>
        <div class="cookie-actions">
            <button id="accept-cookies">J'accepte</button>
            <button id="reject-cookies">Je refuse</button>
        </div>
    </div>

    <div class="modal-delete" id="modal-cookies" hidden>
        <div class="modal-delete-content">
            <p class="modal-delete-text">
                Ce site utilise des cookies pour assurer son bon fonctionnement et afficher du contenu externe (YouTube).<br>
                <strong>Souhaitez-vous les activer ?</strong>
            </p>
            <div class="modal-delete-actions">
                <button class="btn btn-danger" id="accept-cookies-from-modal">J'accepte</button>
                <button class="btn btn-cancel" id="close-cookies-modal">Je refuse</button>
            </div>
        </div>
    </div>

</div> <!-- fermeture du site-wrapper -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('cookie-banner');
    const acceptBtn = document.getElementById('accept-cookies');
    const rejectBtn = document.getElementById('reject-cookies');
    const hasMadeChoice = localStorage.getItem('cookiesChoiceMade');

    if (!hasMadeChoice) {
        banner.removeAttribute('hidden');
    }

    acceptBtn.addEventListener('click', () => {
        localStorage.setItem('cookiesAccepted', 'true');
        localStorage.setItem('cookiesChoiceMade', 'true');
        banner.setAttribute('hidden', '');
    });

    rejectBtn.addEventListener('click', () => {
        localStorage.setItem('cookiesAccepted', 'false');
        localStorage.setItem('cookiesChoiceMade', 'true');
        banner.setAttribute('hidden', '');
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/perfect-scrollbar@1.5.5/dist/perfect-scrollbar.min.js"></script>
<script src="public/assets/js/scripts.js"></script>
</body>

</html>

<?php
ob_end_flush();
?>