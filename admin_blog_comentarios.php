<?php
require_once 'includes/admin_auth.php';

$mensaje = '';

// Si se recibe el parámetro "aprobar", se marca el comentario como aprobado.
if (isset($_GET['aprobar'])) {
    $id = (int)$_GET['aprobar'];
    $stmt = $mysqli->prepare("UPDATE blog_comentarios SET aprobado = 1 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Comentario aprobado.';
}

// Si se recibe el parámetro "desaprobar", se marca el comentario como no aprobado.
if (isset($_GET['desaprobar'])) {
    $id = (int)$_GET['desaprobar'];
    $stmt = $mysqli->prepare("UPDATE blog_comentarios SET aprobado = 0 WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Comentario marcado como no aprobado.';
}

// Si se recibe el parámetro "eliminar", se elimina definitivamente el comentario.
if (isset($_GET['eliminar'])) {
    $id = (int)$_GET['eliminar'];
    $stmt = $mysqli->prepare("DELETE FROM blog_comentarios WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    $mensaje = 'Comentario eliminado.';
}

// Se determina el filtro actual a partir del parámetro recibido por la URL.
$filtro = $_GET['filtro'] ?? 'todos';

// Consulta base que obtiene los comentarios junto con el título del artículo al que corresponden.
$sql = "
  SELECT c.*, a.titulo AS titulo_articulo
  FROM blog_comentarios c
  INNER JOIN blog_articulos a ON a.id = c.articulo_id
";

// Se arma un arreglo de condiciones según el filtro elegido.
$where = [];
if ($filtro === 'pendientes') {
    $where[] = "c.aprobado = 0";
} elseif ($filtro === 'aprobados') {
    $where[] = "c.aprobado = 1";
}

// Si existen condiciones, se agregan a la consulta mediante cláusula WHERE.
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

// Se ordenan los comentarios por fecha de alta y, en caso de empate, por ID descendente.
$sql .= " ORDER BY c.fecha_alta DESC, c.id DESC";

// Se ejecuta la consulta y se obtiene el listado de comentarios según el filtro.
$resComentarios = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Comentarios Blog - Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div class="admin-sidebar-title">Ecos Arquitectura</div>
            <div class="admin-sidebar-sub">Panel de administración</div>
        </div>

        <nav class="admin-sidebar-nav">
            <a href="admin_proyectos.php">
                <span>Proyectos</span>
            </a>
            <a href="admin_blog.php">
                <span>Blog</span>
            </a>
            <a href="admin_blog_comentarios.php" class="activo">
                <span>Comentarios</span>
            </a>
            <a href="admin_contactos.php">
                <span>Contactos</span>
            </a>
        </nav>

        <div class="admin-sidebar-footer">
            Sesión iniciada · Admin
        </div>
    </aside>

    <main class="admin-main">
        <div class="top-bar">
            <h1>Comentarios del Blog</h1>
            <div class="top-bar-actions">
                <a href="admin_logout.php" class="top-pill logout-link">Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <div class="tabla-wrap">
            <div class="filtros">
                Ver:
                <?php $urlBase = 'admin_blog_comentarios.php'; ?>
                <a href="<?php echo $urlBase; ?>?filtro=todos"
                   class="<?php echo ($filtro === 'todos' ? 'activo' : ''); ?>">
                    Todos
                </a>
                <a href="<?php echo $urlBase; ?>?filtro=pendientes"
                   class="<?php echo ($filtro === 'pendientes' ? 'activo' : ''); ?>">
                    Pendientes
                </a>
                <a href="<?php echo $urlBase; ?>?filtro=aprobados"
                   class="<?php echo ($filtro === 'aprobados' ? 'activo' : ''); ?>">
                    Aprobados
                </a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Artículo</th>
                        <th>Autor</th>
                        <th>Comentario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($resComentarios && $resComentarios->num_rows > 0): ?>
                    <?php while ($c = $resComentarios->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo (int)$c['id']; ?></td>
                            <td>
                                <?php echo htmlspecialchars($c['fecha_alta']); ?><br>
                                <?php if (!empty($c['ip'])): ?>
                                    <span class="muted">
                                        IP: <?php echo htmlspecialchars($c['ip']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($c['titulo_articulo']); ?></strong><br>
                                <a href="articulo.php?id=<?php echo (int)$c['articulo_id']; ?>" target="_blank">
                                    Ver en sitio
                                </a>
                            </td>
                            <td>
                                <strong><?php echo htmlspecialchars($c['nombre']); ?></strong><br>
                                <?php if (!empty($c['email'])): ?>
                                    <a href="mailto:<?php echo htmlspecialchars($c['email']); ?>">
                                        <?php echo htmlspecialchars($c['email']); ?>
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="col-mensaje">
                                <p><?php echo nl2br(htmlspecialchars($c['mensaje'])); ?></p>
                            </td>
                            <td>
                                <?php if ((int)$c['aprobado'] === 1): ?>
                                    <span class="tag-leido tag-leido--si">Aprobado</span>
                                <?php else: ?>
                                    <span class="tag-leido tag-leido--no">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ((int)$c['aprobado'] === 0): ?>
                                    <!-- Botón para aprobar un comentario pendiente -->
                                    <a class="btn-small btn-small--leer"
                                       href="admin_blog_comentarios.php?aprobar=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>">
                                       Aprobar
                                    </a>
                                <?php else: ?>
                                    <!-- Botón para marcar como no aprobado un comentario ya publicado -->
                                    <a class="btn-small btn-small--noleer"
                                       href="admin_blog_comentarios.php?desaprobar=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>">
                                       Desaprobar
                                    </a>
                                <?php endif; ?>

                                <!-- Botón para eliminar el comentario de forma definitiva, con confirmación -->
                                <a class="btn-small btn-small--del"
                                   href="admin_blog_comentarios.php?eliminar=<?php echo (int)$c['id']; ?>&filtro=<?php echo urlencode($filtro); ?>"
                                   onclick="return confirm('¿Seguro que querés eliminar este comentario?');">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <!-- Mensaje mostrado cuando no existen comentarios para listar -->
                    <tr><td colspan="7">No hay comentarios registrados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
