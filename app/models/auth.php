<?php

require_once ROOT . '/app/models/sessionInit.php';

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