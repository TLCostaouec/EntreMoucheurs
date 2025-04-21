<?php

/**
*	Controleur : deconnexion
*/

require_once ROOT . '/app/models/auth.php';
require_once ROOT . '/app/models/authService.php';

requireLogin();

logout();

?>