<?php
// Protección para páginas de administración
require_once __DIR__ . '/config.php';

if (empty($_SESSION['admin_logueado']) || $_SESSION['admin_logueado'] !== true) {
    header('Location: admin_login.php');
    exit;
}
