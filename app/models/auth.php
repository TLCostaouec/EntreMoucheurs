<?php

require_once ROOT . '/app/models/sessionInit.php';

/**
 * Vérifie si l'utilisateur est connecté.
 *
 * @return bool True si l'utilisateur est connecté, sinon false.
 */
function isLoggedIn(): bool {
    return isset($_SESSION['entremoucheurs_user_id']);
}

/**
 * Vérifie si l'utilisateur connecté a le rôle administrateur.
 *
 * @return bool True si l'utilisateur est administrateur, sinon false.
 */
function isAdmin(): bool {
    return isset($_SESSION['entremoucheurs_role']) && $_SESSION['entremoucheurs_role'] === 'admin';
}

/**
 * Désactive la mise en cache des pages pour assurer une actualisation à chaque chargement.
 *
 * @return void
 */
function disableCache() {
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}

/**
 * Redirige vers la page de connexion si l'utilisateur n'est pas connecté.
 *
 * @return void
 */
function requireLogin() {
    disableCache();
    if (!isLoggedIn()) {
        header('Location: login');
        exit;
    }
}

/**
 * Redirige vers une page d'erreur si l'utilisateur n'est pas administrateur.
 *
 * @return void
 */
function requireAdmin() {
    disableCache();
    if (!isAdmin()) {
        header('Location: error403');
        exit;
    }
}