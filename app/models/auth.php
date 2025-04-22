<?php

session_name('entremoucheurs_session');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['entremoucheurs_user_id']);
}

function isAdmin(): bool {
    return isset($_SESSION['entremoucheurs_role']) && $_SESSION['entremoucheurs_role'] === 'admin';
}

function disableCache() {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}

function requireLogin() {
    disableCache();

    if (!isLoggedIn()) {
        header('Location: login');
        exit;
    }
}

function requireAdmin() {
    disableCache();

    if (!isAdmin()) {
        header('Location: error403');
        exit;
    }
}

?>