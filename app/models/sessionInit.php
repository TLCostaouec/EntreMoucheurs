<?php

if (session_status() === PHP_SESSION_NONE) {
    session_name('entremoucheurs_session');
    session_start([
        'cookie_lifetime' => 0, // expire à la fermeture du navigateur
        'cookie_secure' => isset($_SERVER['HTTPS']), // cookies envoyés uniquement en HTTPS
        'cookie_httponly' => true, // inaccessible via JS (protection XSS)
        'cookie_samesite' => 'Strict' // protection CSRF
    ]);
}

?>