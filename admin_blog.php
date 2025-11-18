<?php
require_once 'includes/admin_auth.php'; // protege con login y trae $mysqli

// ---------- Variables para el formulario ----------
$id = '';
$titulo = '';
$slug = '';
$categoria = '';
$fecha_publicacion = '';
$fecha_visible = '';
$imagen_portada   = '';
$resumen = '';
$contenido_html = '';
$es_destacado = 0;
$mensaje = '';

// ---------- Eliminar artículo ----------
if (isset($_GET['eliminar'])) {
    $borrarId = (int)$_GET['eliminar'];
    $stmt = $mysqli->prepare("DELETE FROM blog_articulos WHERE id = ?");
    $stmt->bind_param('i', $borrarId);
    $stmt->execute();
    $stmt->close();
    header('Location: admin_blog.php');
    exit;
}

// ---------- Cargar artículo para edición ----------
if (isset($_GET['editar'])) {
    $editarId = (int)$_GET['editar'];
    $stmt = $mysqli->prepare("SELECT * FROM blog_articulos WHERE id = ?");
    $stmt->bind_param('i', $editarId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $id                = $row['id'];
        $titulo            = $row['titulo'];
        $slug              = $row['slug'];
        $categoria         = $row['categoria'];
        $fecha_publicacion = $row['fecha_publicacion'];
        $fecha_visible     = $row['fecha_visible'];
        $imagen_portada    = $row['imagen_portada'];
        $resumen           = $row['resumen'];
        $contenido_html    = $row['contenido_html'];
        $es_destacado      = (int)$row['es_destacado'];
    }
    $stmt->close();
}

// ---------- Procesar formulario (alta / modificación) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id                = $_POST['id'] ?? '';
    $titulo            = trim($_POST['titulo'] ?? '');
    $slug              = trim($_POST['slug'] ?? '');
    $categoria         = trim($_POST['categoria'] ?? '');
    $fecha_publicacion = trim($_POST['fecha_publicacion'] ?? '');
    $fecha_visible     = trim($_POST['fecha_visible'] ?? '');
    $imagen_portada    = trim($_POST['imagen_portada'] ?? '');
    $resumen           = trim($_POST['resumen'] ?? '');
    $contenido_html    = trim($_POST['contenido_html'] ?? '');
    $es_destacado      = isset($_POST['es_destacado']) ? 1 : 0;

    // --- Soporte subir imagen desde el explorador (opcional) ---
    if (!empty($_FILES['imagen_file']) && $_FILES['imagen_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName  = $_FILES['imagen_file']['tmp_name'];
        $origName = basename($_FILES['imagen_file']['name']);
        $nombreLimpio = preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);

        $uploadDir = 'imagenes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $destino = $uploadDir . time() . '_' . $nombreLimpio;

        if (move_uploaded_file($tmpName, $destino)) {
            $imagen_portada = $destino;
        }
    }

    if ($id === '') {
        // INSERT
        $stmt = $mysqli->prepare("
            INSERT INTO blog_articulos
            (titulo, slug, categoria, fecha_publicacion, fecha_visible,
             resumen, contenido_html, imagen_portada, es_destacado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'ssssssssi',
            $titulo,
            $slug,
            $categoria,
            $fecha_publicacion,
            $fecha_visible,
            $resumen,
            $contenido_html,
            $imagen_portada,
            $es_destacado
        );
        $stmt->execute();
        $stmt->close();
        $mensaje = 'Artículo creado correctamente.';
    } else {
        // UPDATE
        $stmt = $mysqli->prepare("
            UPDATE blog_articulos
            SET titulo = ?, slug = ?, categoria = ?, fecha_publicacion = ?,
                fecha_visible = ?, resumen = ?, contenido_html = ?,
                imagen_portada = ?, es_destacado = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            'ssssssssii',
            $titulo,
            $slug,
            $categoria,
            $fecha_publicacion,
            $fecha_visible,
            $resumen,
            $contenido_html,
            $imagen_portada,
            $es_destacado,
            $id
        );
        $stmt->execute();
        $stmt->close();
        $mensaje = 'Artículo actualizado correctamente.';
    }

    // Limpiar formulario después de guardar
    $id = '';
    $titulo = $slug = $categoria = $fecha_publicacion = $fecha_visible = '';
    $imagen_portada = $resumen = $contenido_html = '';
    $es_destacado = 0;
}

// ---------- Listado de artículos ----------
$resArticulos = $mysqli->query("SELECT * FROM blog_articulos ORDER BY fecha_publicacion DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog - Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">

    <div class="top-bar">
        <h1>Administración de Blog</h1>
        <div class="top-links">
            <a href="admin_blog_comentarios.php" class="pill">Admin Blog Comentarios</a>
            <a href="admin_proyectos.php" class="pill">Admin Proyectos</a>
            <a href="admin_contactos.php" class="pill">Contactos</a>
            <a href="admin_logout.php" class="pill pill--danger">Cerrar sesión</a>
        </div>
    </div>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <div class="admin-layout">
        <!-- Formulario -->
        <form method="post" class="admin-form" enctype="multipart/form-data">
            <h2><?php echo $id ? 'Editar artículo' : 'Nuevo artículo'; ?></h2>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <label for="titulo">Título</label>
            <input type="text" name="titulo" id="titulo" required
                   value="<?php echo htmlspecialchars($titulo); ?>">

            <div class="fila">
                <div>
                    <label for="categoria">Categoría</label>
                    <input type="text" name="categoria" id="categoria"
                           placeholder="Sostenibilidad, Diseño, Tendencias..."
                           value="<?php echo htmlspecialchars($categoria); ?>">
                </div>
                <div>
                    <label for="slug">Slug (opcional)</label>
                    <input type="text" name="slug" id="slug"
                           placeholder="arquitectura-sostenible"
                           value="<?php echo htmlspecialchars($slug); ?>">
                </div>
            </div>

            <div class="fila">
                <div>
                    <label for="fecha_publicacion">Fecha publicación (real)</label>
                    <input type="date" name="fecha_publicacion" id="fecha_publicacion"
                           value="<?php echo htmlspecialchars($fecha_publicacion); ?>">
                </div>
                <div>
                    <label for="fecha_visible">Fecha visible (texto)</label>
                    <input type="text" name="fecha_visible" id="fecha_visible"
                           placeholder="23 de Septiembre, 2025"
                           value="<?php echo htmlspecialchars($fecha_visible); ?>">
                </div>
            </div>

            <label for="imagen_portada">Imagen portada (ruta)</label>
            <input type="text" name="imagen_portada" id="imagen_portada"
                   placeholder="imagenes/arquitectura_sostenible.jpg"
                   value="<?php echo htmlspecialchars($imagen_portada); ?>">

            <label for="imagen_file">O subir nueva imagen</label>
            <input type="file" name="imagen_file" id="imagen_file" accept="image/*">
            <small class="help-text">
                Si subís un archivo, se guardará la ruta automáticamente y se usará como portada.
            </small>

            <label for="resumen">Resumen (para listado)</label>
            <textarea name="resumen" id="resumen"><?php echo htmlspecialchars($resumen); ?></textarea>

            <label for="contenido_html">Contenido (HTML simple o texto)</label>
            <textarea name="contenido_html" id="contenido_html"><?php echo htmlspecialchars($contenido_html); ?></textarea>

            <div class="check-line">
                <label>
                    <input type="checkbox" name="es_destacado" value="1"
                        <?php echo $es_destacado ? 'checked' : ''; ?>>
                    Marcar como artículo destacado (se mostrará arriba en la página de Blog)
                </label>
            </div>

            <button type="submit"><?php echo $id ? 'Guardar cambios' : 'Crear artículo'; ?></button>
        </form>

        <!-- Listado -->
        <div class="tabla-wrap">
            <h2>Listado de artículos</h2>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Título / Categoría</th>
                    <th>Fecha visible</th>
                    <th>Destacado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($a = $resArticulos->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo (int)$a['id']; ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($a['titulo']); ?></strong><br>
                            <span class="tag-mini"><?php echo htmlspecialchars($a['categoria']); ?></span>
                        </td>
                        <td><?php echo htmlspecialchars($a['fecha_visible']); ?></td>
                        <td><?php echo $a['es_destacado'] ? 'Sí' : 'No'; ?></td>
                        <td>
                            <a class="btn-small btn-small--edit"
                               href="admin_blog.php?editar=<?php echo (int)$a['id']; ?>">Editar</a>
                            <a class="btn-small btn-small--del"
                               href="admin_blog.php?eliminar=<?php echo (int)$a['id']; ?>"
                               onclick="return confirm('¿Seguro que querés eliminar este artículo?');">
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($resArticulos->num_rows === 0): ?>
                    <tr><td colspan="5">No hay artículos cargados.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
