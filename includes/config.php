<?php
// Iniciar sesión 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Datos de conexión a MySQL (XAMPP local)
$host       = '127.0.0.1';
$puerto     = 3307;         
$usuario    = 'root';
$clave      = '';
$base_datos = 'ecos_arquitectura';

// Crear el objeto mysqli (conexión a la BD)
$mysqli = new mysqli($host, $usuario, $clave, $base_datos, $puerto);

// Si hay error de conexión, cortar la ejecución y mostrar mensaje
if ($mysqli->connect_errno) {
    die('Error de conexión a la base de datos: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');

// Credenciales simples para admin 
// Se usan en admin_login.php para verificar el acceso
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'ecos123');
