<?php
// Carga la configuración general: conexión BD, constantes, sesión, etc.
require_once 'includes/config.php';

// Si el admin ya está logueado, lo redirige directo al panel principal
if (!empty($_SESSION['admin_logueado'])) {
    header('Location: admin_proyectos.php');
    exit;
}

$error = '';

// Si el formulario se envió por POST, se procesa el login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Se toma el usuario y contraseña enviados desde el formulario
    $user = $_POST['usuario'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Se compara contra las credenciales definidas en config.php
    if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
        // Se marca en la sesión que el admin está logueado
        $_SESSION['admin_logueado'] = true;

        // Redirige al panel de proyectos
        header('Location: admin_proyectos.php');
        exit;
    } else {
        // Mensaje de error si las credenciales no coinciden
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-login-body">
    <div class="login-admin">
        <h1>Acceso administración</h1>
        <p class="login-admin-subtitle">
            Panel interno para gestionar proyectos, blog y contactos.
        </p>

        <?php if ($error): ?>
            <!-- Muestra el mensaje de error si las credenciales no son válidas -->
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <!-- Formulario de acceso al panel admin -->
        <form method="post" action="admin_login.php">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Ingresar</button>
        </form>

        <p class="login-admin-footer">
            Ecos Arquitectura · Panel de administración
        </p>
    </div>
</body>
</html>
