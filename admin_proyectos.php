<?php
require_once 'includes/admin_auth.php';

// Campos del formulario
$id = '';
$titulo = '';
$categoria = '';
$tipo_slug = '';
$ubicacion = '';
$superficie = '';
$anio = '';
$resumen = '';
$descripcion_detallada = '';
$imagen_listado = '';
$imagen_detalle1 = '';
$imagen_detalle2 = '';
$mensaje = '';

// Carpeta para imágenes
$uploadDir = 'imagenes/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Helper subida de imagen
function subir_imagen_admin($campoFile, $uploadDir) {
    if (empty($_FILES[$campoFile]) || $_FILES[$campoFile]['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $tmpName  = $_FILES[$campoFile]['tmp_name'];
    $origName = basename($_FILES[$campoFile]['name']);
    $nombreLimpio = preg_replace('/[^a-zA-Z0-9._-]/', '_', $origName);
    $destino = $uploadDir . time() . '_' . $nombreLimpio;
    if (move_uploaded_file($tmpName, $destino)) {
        return $destino;
    }
    return null;
}

// Editar
if (isset($_GET['editar'])) {
    $editarId = (int)$_GET['editar'];
    $stmt = $mysqli->prepare("SELECT * FROM proyectos WHERE id = ?");
    $stmt->bind_param('i', $editarId);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $id                    = $row['id'];
        $titulo                = $row['titulo'];
        $categoria             = $row['categoria'];
        $tipo_slug             = $row['tipo_slug'];
        $ubicacion             = $row['ubicacion'];
        $superficie            = $row['superficie'];
        $anio                  = $row['anio'];
        $resumen               = $row['resumen'];
        $descripcion_detallada = $row['descripcion_detallada'];
        $imagen_listado        = $row['imagen_listado'];
        $imagen_detalle1       = $row['imagen_detalle1'];
        $imagen_detalle2       = $row['imagen_detalle2'];
    }
    $stmt->close();
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $borrarId = (int)$_GET['eliminar'];
    $stmt = $mysqli->prepare("DELETE FROM proyectos WHERE id = ?");
    $stmt->bind_param('i', $borrarId);
    $stmt->execute();
    $stmt->close();
    header('Location: admin_proyectos.php');
    exit;
}

// Alta / edición
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id                    = $_POST['id'] ?? '';
    $titulo                = trim($_POST['titulo'] ?? '');
    $categoria             = trim($_POST['categoria'] ?? '');
    $tipo_slug             = trim($_POST['tipo_slug'] ?? '');
    $ubicacion             = trim($_POST['ubicacion'] ?? '');
    $superficie            = trim($_POST['superficie'] ?? '');
    $anio                  = $_POST['anio'] !== '' ? (int)$_POST['anio'] : null;
    $resumen               = trim($_POST['resumen'] ?? '');
    $descripcion_detallada = trim($_POST['descripcion_detallada'] ?? '');
    $imagen_listado        = trim($_POST['imagen_listado'] ?? '');
    $imagen_detalle1       = trim($_POST['imagen_detalle1'] ?? '');
    $imagen_detalle2       = trim($_POST['imagen_detalle2'] ?? '');

    $tipo = $categoria !== '' ? $categoria : 'Otro';

    // Imagen listado
    $nuevaListado = subir_imagen_admin('imagen_file_listado', $uploadDir);
    if ($nuevaListado !== null) {
        $imagen_listado = $nuevaListado;
        if ($imagen_detalle1 === '') $imagen_detalle1 = $nuevaListado;
        if ($imagen_detalle2 === '') $imagen_detalle2 = $nuevaListado;
    }

    // Imagen detalle 1
    $nuevaDet1 = subir_imagen_admin('imagen_file_detalle1', $uploadDir);
    if ($nuevaDet1 !== null) {
        $imagen_detalle1 = $nuevaDet1;
    }

    // Imagen detalle 2
    $nuevaDet2 = subir_imagen_admin('imagen_file_detalle2', $uploadDir);
    if ($nuevaDet2 !== null) {
        $imagen_detalle2 = $nuevaDet2;
    }

    if ($id === '') {
        // Insert
        $stmt = $mysqli->prepare("
            INSERT INTO proyectos
            (titulo, categoria, tipo, tipo_slug, ubicacion, superficie, anio,
             resumen, descripcion_detallada, imagen_listado, imagen_detalle1, imagen_detalle2)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'ssssssisssss',
            $titulo,
            $categoria,
            $tipo,
            $tipo_slug,
            $ubicacion,
            $superficie,
            $anio,
            $resumen,
            $descripcion_detallada,
            $imagen_listado,
            $imagen_detalle1,
            $imagen_detalle2
        );
        $stmt->execute();
        $stmt->close();
        $mensaje = 'Proyecto creado correctamente.';
    } else {
        // Update
        $stmt = $mysqli->prepare("
            UPDATE proyectos
            SET titulo = ?, categoria = ?, tipo = ?, tipo_slug = ?, ubicacion = ?,
                superficie = ?, anio = ?, resumen = ?, descripcion_detallada = ?,
                imagen_listado = ?, imagen_detalle1 = ?, imagen_detalle2 = ?
            WHERE id = ?
        ");
        $stmt->bind_param(
            'ssssssisssssi',
            $titulo,
            $categoria,
            $tipo,
            $tipo_slug,
            $ubicacion,
            $superficie,
            $anio,
            $resumen,
            $descripcion_detallada,
            $imagen_listado,
            $imagen_detalle1,
            $imagen_detalle2,
            $id
        );
        $stmt->execute();
        $stmt->close();
        $mensaje = 'Proyecto actualizado correctamente.';
    }

    // Limpiar formulario
    $id = '';
    $titulo = $categoria = $tipo_slug = $ubicacion = $superficie = '';
    $anio = '';
    $resumen = $descripcion_detallada = '';
    $imagen_listado = $imagen_detalle1 = $imagen_detalle2 = '';
}

// Listado
$resProyectos = $mysqli->query("SELECT * FROM proyectos ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin Proyectos - Ecos Arquitectura</title>
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
            <a href="admin_proyectos.php" class="activo">
                <span>Proyectos</span>
            </a>
            <a href="admin_blog.php">
                <span>Blog</span>
            </a>
            <a href="admin_blog_comentarios.php">
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
            <h1>Administración de Proyectos</h1>
            <div class="top-bar-actions">
                <a href="admin_logout.php" class="top-pill logout-link">Cerrar sesión</a>
            </div>
        </div>

        <?php if ($mensaje): ?>
            <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
        <?php endif; ?>

        <div class="admin-layout">
            <form method="post" class="admin-form" enctype="multipart/form-data">
                <h2><?php echo $id ? 'Editar proyecto' : 'Nuevo proyecto'; ?></h2>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" required
                       value="<?php echo htmlspecialchars($titulo); ?>">

                <div class="fila">
                    <div>
                        <label for="categoria">Categoría (texto)</label>
                        <input type="text" name="categoria" id="categoria"
                               placeholder="Residencial, Comercial, Paisajismo..."
                               value="<?php echo htmlspecialchars($categoria); ?>">
                    </div>
                    <div>
                        <label for="tipo_slug">Tipo slug (para filtro)</label>
                        <input type="text" name="tipo_slug" id="tipo_slug"
                               placeholder="residencial, comercial, paisajismo..."
                               value="<?php echo htmlspecialchars($tipo_slug); ?>">
                    </div>
                </div>

                <div class="fila">
                    <div>
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" name="ubicacion" id="ubicacion"
                               value="<?php echo htmlspecialchars($ubicacion); ?>">
                    </div>
                    <div>
                        <label for="superficie">Superficie (texto)</label>
                        <input type="text" name="superficie" id="superficie"
                               placeholder="320m²"
                               value="<?php echo htmlspecialchars($superficie); ?>">
                    </div>
                </div>

                <div class="fila">
                    <div>
                        <label for="anio">Año</label>
                        <input type="number" name="anio" id="anio"
                               value="<?php echo htmlspecialchars($anio); ?>">
                    </div>
                    <div></div>
                </div>

                <label for="imagen_listado">Imagen listado (ruta)</label>
                <input type="text" name="imagen_listado" id="imagen_listado"
                       placeholder="imagenes/casa.jpg"
                       value="<?php echo htmlspecialchars($imagen_listado); ?>">

                <label for="imagen_file_listado">O subir nueva imagen para listado</label>
                <input type="file" name="imagen_file_listado" id="imagen_file_listado" accept="image/*">

                <label for="imagen_detalle1">Imagen detalle 1 (ruta)</label>
                <input type="text" name="imagen_detalle1" id="imagen_detalle1"
                       placeholder="imagenes/casa_detalle1.jpg"
                       value="<?php echo htmlspecialchars($imagen_detalle1); ?>">

                <label for="imagen_file_detalle1">O subir imagen detalle 1</label>
                <input type="file" name="imagen_file_detalle1" id="imagen_file_detalle1" accept="image/*">

                <label for="imagen_detalle2">Imagen detalle 2 (ruta)</label>
                <input type="text" name="imagen_detalle2" id="imagen_detalle2"
                       placeholder="imagenes/casa_detalle2.jpg"
                       value="<?php echo htmlspecialchars($imagen_detalle2); ?>">

                <label for="imagen_file_detalle2">O subir imagen detalle 2</label>
                <input type="file" name="imagen_file_detalle2" id="imagen_file_detalle2" accept="image/*">

                <?php if ($imagen_listado || $imagen_detalle1 || $imagen_detalle2): ?>
                    <div class="admin-preview-grid">
                        <?php if ($imagen_listado): ?>
                            <div class="admin-preview">
                                <span>Listado</span>
                                <img src="<?php echo htmlspecialchars($imagen_listado); ?>" alt="Imagen listado">
                            </div>
                        <?php endif; ?>
                        <?php if ($imagen_detalle1): ?>
                            <div class="admin-preview">
                                <span>Detalle 1</span>
                                <img src="<?php echo htmlspecialchars($imagen_detalle1); ?>" alt="Imagen detalle 1">
                            </div>
                        <?php endif; ?>
                        <?php if ($imagen_detalle2): ?>
                            <div class="admin-preview">
                                <span>Detalle 2</span>
                                <img src="<?php echo htmlspecialchars($imagen_detalle2); ?>" alt="Imagen detalle 2">
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <label for="resumen">Resumen (para tarjetas)</label>
                <textarea name="resumen" id="resumen"><?php
                    echo htmlspecialchars($resumen);
                ?></textarea>

                <label for="descripcion_detallada">Descripción detallada (para página de proyecto)</label>
                <textarea name="descripcion_detallada" id="descripcion_detallada"><?php
                    echo htmlspecialchars($descripcion_detallada);
                ?></textarea>

                <button type="submit"><?php echo $id ? 'Guardar cambios' : 'Crear proyecto'; ?></button>
            </form>

            <div class="tabla-wrap">
                <h2>Listado de proyectos</h2>
                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Miniatura</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th>Ubicación</th>
                        <th>Año</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php while ($p = $resProyectos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo (int)$p['id']; ?></td>
                            <td>
                                <?php if (!empty($p['imagen_listado'])): ?>
                                    <img class="thumb-mini"
                                         src="<?php echo htmlspecialchars($p['imagen_listado']); ?>"
                                         alt="<?php echo htmlspecialchars($p['titulo']); ?>">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($p['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                            <td><?php echo htmlspecialchars($p['ubicacion']); ?></td>
                            <td><?php echo htmlspecialchars($p['anio']); ?></td>
                            <td>
                                <a class="btn-small btn-small--edit"
                                   href="admin_proyectos.php?editar=<?php echo (int)$p['id']; ?>">Editar</a>
                                <a class="btn-small btn-small--del"
                                   href="admin_proyectos.php?eliminar=<?php echo (int)$p['id']; ?>"
                                   onclick="return confirm('¿Seguro que querés eliminar este proyecto?');">
                                    Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($resProyectos->num_rows === 0): ?>
                        <tr><td colspan="7">No hay proyectos cargados.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
</body>
</html>
