<?php
require_once 'includes/admin_auth.php'; // protege con login y trae $mysqli

$mensaje = '';

// Acciones: marcar leído / no leído / eliminar
if (isset($_GET['leer'])) {
    // Marcar como leído
    $id = (int)$_GET['leer'];
    $stmt = $mysqli->prepare("UPDATE contactos SET leido = 1 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Mensaje marcado como leído.';
}

if (isset($_GET['no_leer'])) {
    // Marcar como no leído
    $id = (int)$_GET['no_leer'];
    $stmt = $mysqli->prepare("UPDATE contactos SET leido = 0 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Mensaje marcado como no leído.';
}

if (isset($_GET['eliminar'])) {
    // Eliminar mensaje
    $id = (int)$_GET['eliminar'];
    $stmt = $mysqli->prepare("DELETE FROM contactos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Mensaje eliminado.';
}

// Filtros simples (todos/solo no leídos)
$filtro = $_GET['filtro'] ?? 'todos'; 

$sql = "SELECT * FROM contactos";
if ($filtro === 'no_leidos') {
    // Solo los que no están leídos
    $sql .= " WHERE leido = 0";
}
$sql .= " ORDER BY fecha_envio DESC, id DESC"; 

$resContactos = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Contactos - Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <div class="top-bar">
            <h1>Mensajes de Contacto</h1>
            <div>
                <!-- Navegación entre módulos del panel admin -->
                <a href="admin_proyectos.php">Admin Proyectos</a>
                <a href="admin_blog.php">Admin Blog</a>
                <a class="logout-link" href="admin_logout.php">Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <!-- Mensaje de feedback luego de una acción -->
            <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <div class="tabla-wrap">
            <div class="filtros">
                Ver:
                <?php $urlBase = 'admin_contactos.php'; ?>
                <!-- Link para ver todos -->
                <a href="<?php echo $urlBase; ?>?filtro=todos"
                   class="<?php echo ($filtro === 'todos' ? 'activo' : ''); ?>">
                    Todos
                </a>
                <!-- Link para ver solo no leídos -->
                <a href="<?php echo $urlBase; ?>?filtro=no_leidos"
                   class="<?php echo ($filtro === 'no_leidos' ? 'activo' : ''); ?>">
                    Solo no leídos
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha envío</th>
                        <th>Datos</th>
                        <th>Mensaje</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($resContactos && $resContactos->num_rows > 0): ?>
                    <?php while ($c = $resContactos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo (int)$c['id']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($c['fecha_envio']); ?><br>
                                <?php if (!empty($c['ip'])): ?>
                                    <span class="muted">
                                        IP: <?php echo htmlspecialchars($c['ip']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($c['nombre']); ?></strong><br>
                                <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>">
                                    <?php echo htmlspecialchars($c['email']); ?>
                                </a><br>
                                <span class="muted"><?php echo htmlspecialchars($c['telefono']); ?></span>
                            </td>
                            <td class="col-mensaje">
                                <p><?php echo nl2br(htmlspecialchars($c['mensaje'])); ?></p>
                            </td>
                            <td>
                                <?php if (!empty($c['leido'])): ?>
                                    <span class="tag-leido tag-leido--si">Leído</span>
                                <?php else: ?>
                                    <span class="tag-leido tag-leido--no">No leído</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (empty($c['leido'])): ?>
                                    <!-- Se mantiene el filtro actual en la URL para no perder el contexto -->
                                    <a class="btn-small btn-small--leer"
                                       href="admin_contactos.php?leer=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>">
                                       Marcar leído
                                    </a>
                                <?php else: ?>
                                    <a class="btn-small btn-small--noleer"
                                       href="admin_contactos.php?no_leer=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>">
                                       Marcar no leído
                                    </a>
                                <?php endif; ?>

                                <a class="btn-small btn-small--del"
                                   href="admin_contactos.php?eliminar=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>"
                                   onclick="return confirm('¿Seguro que querés eliminar este mensaje?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Mensaje cuando no hay registros -->
                    <tr><td colspan="6">No hay mensajes de contacto registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
