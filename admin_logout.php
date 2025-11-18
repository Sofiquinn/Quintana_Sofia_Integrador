<?php
require_once 'includes/config.php'; // inicia sesión y conexión, si hace falta

// Se marca la variable de sesión como falsa (por claridad)
$_SESSION['admin_logueado'] = false;

// Destruimos toda la sesión (borra todos los datos de $_SESSION)
session_destroy();

// Redirigimos al formulario de login del admin
header('Location: admin_login.php');
exit;
