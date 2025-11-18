<?php
// Incluye el archivo de configuración general del sitio (conexión a la base de datos, sesión, constantes, etc.).
require_once 'includes/config.php';

$pagina_actual = 'blog';

// Estas variables almacenan mensajes temporales para informar al usuario sobre likes y comentarios.
$like_mensaje   = '';
$coment_mensaje = '';

// Solo se leen y limpian los mensajes flash cuando la petición es de tipo GET.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_SESSION['flash_like'])) {
        $like_mensaje = $_SESSION['flash_like'];
        unset($_SESSION['flash_like']);
    }
    if (isset($_SESSION['flash_coment'])) {
        $coment_mensaje = $_SESSION['flash_coment'];
        unset($_SESSION['flash_coment']);
    }
}

// Se toma el parámetro "id" de la URL y se fuerza a entero para mayor seguridad.
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$articulo = null;

// Si el id es válido, se intenta obtener el artículo correspondiente desde la base de datos.
if ($id > 0) {
    $stmt = $mysqli->prepare("SELECT * FROM blog_articulos WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows === 1) {
        $articulo = $res->fetch_assoc();
    }
    $stmt->close();
}

// Variables para formularios de comentario y contadores
$errores_comentario = [];
$nombre_coment      = '';
$email_coment       = '';
$texto_coment       = '';
$likes_total        = 0;
$comentarios        = [];

// Si el artículo existe, se habilita el manejo de likes, comentarios y listados asociados.
if ($articulo) {
    $articulo_id = (int)$articulo['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Se obtiene la IP del visitante para control de "me gusta" y registro de comentarios.
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        // Acción: registrar "me gusta"
        if (!empty($_POST['accion']) && $_POST['accion'] === 'like') {

            // 1) Verifica si esta IP ya dio "me gusta" a este artículo
            $stmtCheck = $mysqli->prepare("
                SELECT id
                FROM blog_likes
                WHERE articulo_id = ? AND ip = ?
                LIMIT 1
            ");

            if ($stmtCheck) {
                $stmtCheck->bind_param('is', $articulo_id, $ip);
                $stmtCheck->execute();
                $stmtCheck->store_result();

                // Si ya existe un registro, se informa al usuario y se redirige con mensaje flash.
                if ($stmtCheck->num_rows > 0) {
                    $_SESSION['flash_like'] = 'Ya registramos tu "me gusta" para este artículo.';
                    $stmtCheck->close();
                    header('Location: articulo.php?id=' . $articulo_id);
                    exit;
                }
                $stmtCheck->close();

                // 2) Inserta un nuevo "me gusta" para este artículo y IP
                $stmtLike = $mysqli->prepare("
                    INSERT INTO blog_likes (articulo_id, ip)
                    VALUES (?, ?)
                ");
                if ($stmtLike) {
                    $stmtLike->bind_param('is', $articulo_id, $ip);
                    if ($stmtLike->execute()) {
                        $_SESSION['flash_like'] = '¡Gracias por tu "me gusta"! ❤️';
                    } else {
                        $_SESSION['flash_like'] = 'No se pudo registrar el "me gusta". Intentá más tarde.';
                    }
                    $stmtLike->close();
                } else {
                    $_SESSION['flash_like'] = 'No se pudo preparar la consulta de "me gusta".';
                }

                // Se aplica PRG (Post-Redirect-Get) para evitar reenvío del formulario.
                header('Location: articulo.php?id=' . $articulo_id);
                exit;
            } else {
                // Si falla la preparación de la consulta, se informa en el mismo request.
                $like_mensaje = 'No se pudo preparar la verificación del "me gusta".';
            }
        }

        // Acción: enviar comentario
        if (!empty($_POST['accion']) && $_POST['accion'] === 'comentar') {
            // Se toman los valores enviados en el formulario de comentario.
            $nombre_coment = trim($_POST['nombre_coment'] ?? '');
            $email_coment  = trim($_POST['email_coment'] ?? '');
            $texto_coment  = trim($_POST['mensaje_coment'] ?? '');

            // Validaciones básicas de campos obligatorios y formato de email.
            if ($nombre_coment === '') {
                $errores_comentario['nombre_coment'] = 'El nombre es obligatorio.';
            }
            if ($texto_coment === '') {
                $errores_comentario['mensaje_coment'] = 'El comentario no puede estar vacío.';
            }
            if ($email_coment !== '' && !filter_var($email_coment, FILTER_VALIDATE_EMAIL)) {
                $errores_comentario['email_coment'] = 'Ingresá un email válido o dejalo en blanco.';
            }

            // Si no hay errores de validación, se intenta guardar el comentario en la base de datos.
            if (empty($errores_comentario)) {
                $stmt = $mysqli->prepare("
                    INSERT INTO blog_comentarios (articulo_id, nombre, email, mensaje, ip)
                    VALUES (?, ?, ?, ?, ?)
                ");
                if ($stmt) {
                    $stmt->bind_param(
                        'issss',
                        $articulo_id,
                        $nombre_coment,
                        $email_coment,
                        $texto_coment,
                        $ip
                    );
                    $ok = $stmt->execute();
                    $stmt->close();

                    // Si el guardado fue correcto, se configura un mensaje flash y se redirige.
                    if ($ok) {
                        $_SESSION['flash_coment'] = '¡Gracias por tu comentario!';
                        header('Location: articulo.php?id=' . $articulo_id . '#comentarios');
                        exit;
                    } else {
                        $coment_mensaje = 'Ocurrió un error al guardar tu comentario. Intentá más tarde.';
                    }
                } else {
                    $coment_mensaje = 'No se pudo preparar el guardado del comentario.';
                }
            }
            // Si hay errores de validación, no se redirige: se muestran en la misma carga de página.
        }
    }

    // Se calcula el total de "me gusta" asociados a este artículo.
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS total FROM blog_likes WHERE articulo_id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $articulo_id);
        $stmt->execute();
        $resLikes = $stmt->get_result();
        if ($resLikes && $rowLikes = $resLikes->fetch_assoc()) {
            $likes_total = (int)$rowLikes['total'];
        }
        $stmt->close();
    }

    // Se obtienen únicamente los comentarios aprobados, ordenados desde el más reciente.
    $stmt = $mysqli->prepare("
        SELECT nombre, mensaje, fecha_alta
        FROM blog_comentarios
        WHERE articulo_id = ? AND aprobado = 1
        ORDER BY fecha_alta DESC
    ");
    if ($stmt) {
        $stmt->bind_param('i', $articulo_id);
        $stmt->execute();
        $resCom = $stmt->get_result();
        // Se recorre el resultado y se almacena cada comentario en el arreglo $comentarios.
        while ($rowCom = $resCom->fetch_assoc()) {
            $comentarios[] = $rowCom;
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php echo $articulo
      ? htmlspecialchars($articulo['titulo']) . ' - Ecos Arquitectura'
      : 'Artículo no encontrado - Ecos Arquitectura'; ?>
  </title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/articulo.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <!-- Hero interno del artículo: título y subtítulo del blog -->
  <section class="hero-pagina">
    <div class="contenedor">
      <div class="hero-pagina-contenido animar-al-desplazar">
        <?php if ($articulo): ?>
          <h1 id="tituloHeroe"><?php echo htmlspecialchars($articulo['titulo']); ?></h1>
          <p id="subtituloHeroe">Lecturas y reflexiones de Ecos Arquitectura</p>
        <?php else: ?>
          <h1 id="tituloHeroe">Artículo no encontrado</h1>
          <p id="subtituloHeroe">Revisá el enlace o volvé al blog.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Contenedor principal del contenido del artículo y sus interacciones -->
  <main class="articulo-wrap">
    <div class="contenedor">
      <?php if ($articulo): ?>
        <article class="articulo activo" data-id="<?php echo (int)$articulo['id']; ?>">
          <header class="articulo-encabezado">
            <span class="articulo-categoria">
              <?php echo htmlspecialchars($articulo['categoria']); ?>
            </span>
            <span class="articulo-fecha">
              <?php echo htmlspecialchars($articulo['fecha_visible']); ?>
            </span>
            <h2 class="articulo-titulo">
              <?php echo htmlspecialchars($articulo['titulo']); ?>
            </h2>
            <figure class="articulo-figura">
              <img src="<?php echo htmlspecialchars($articulo['imagen_portada']); ?>"
                   alt="<?php echo htmlspecialchars($articulo['titulo']); ?>" loading="lazy">
            </figure>
          </header>

          <div class="articulo-contenido">
            <?php
              echo $articulo['contenido_html'];
            ?>
          </div>

          <!-- Bloque de acciones relacionadas al artículo (like y contador) -->
          <div class="articulo-acciones">
            <?php if ($like_mensaje): ?>
              <p class="estado-like"><?php echo htmlspecialchars($like_mensaje); ?></p>
            <?php endif; ?>

            <!-- Formulario para registrar un "me gusta" al artículo -->
            <form method="post" class="form-like">
              <input type="hidden" name="accion" value="like">
              <button type="submit" class="btn-like">
                ❤️ Me gusta
              </button>
              <span class="like-count">
                <?php echo $likes_total; ?> me gusta
              </span>
            </form>
          </div>

          <!-- Sección de comentarios: listado y formulario para nuevos comentarios -->
          <section class="comentarios-seccion" id="comentarios">
            <h3>Comentarios (<?php echo count($comentarios); ?>)</h3>

            <?php if ($coment_mensaje): ?>
              <!-- Mensaje informativo sobre el estado del último intento de comentar -->
              <p class="estado-comentario">
                <?php echo htmlspecialchars($coment_mensaje); ?>
              </p>
            <?php endif; ?>

            <!-- Listado de comentarios ya aprobados para este artículo -->
            <?php if (count($comentarios) > 0): ?>
              <ul class="lista-comentarios">
                <?php foreach ($comentarios as $c): ?>
                  <li class="comentario-item">
                    <p class="comentario-meta">
                      <strong><?php echo htmlspecialchars($c['nombre']); ?></strong>
                      <span class="comentario-fecha">
                        <?php echo htmlspecialchars($c['fecha_alta']); ?>
                      </span>
                    </p>
                    <p class="comentario-texto">
                      <?php echo nl2br(htmlspecialchars($c['mensaje'])); ?>
                    </p>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <!-- Mensaje cuando aún no hay comentarios registrados -->
              <p class="sin-comentarios">Todavía no hay comentarios. ¡Sé el primero en comentar!</p>
            <?php endif; ?>

            <!-- Formulario para que el usuario envíe un nuevo comentario -->
            <form method="post" class="form-comentario">
              <input type="hidden" name="accion" value="comentar">

              <div class="fila-formulario">
                <label for="nombre_coment">Nombre <span class="req">*</span></label>
                <input
                  type="text"
                  id="nombre_coment"
                  name="nombre_coment"
                  value="<?php echo htmlspecialchars($nombre_coment); ?>"
                  required
                >
                <?php if (!empty($errores_comentario['nombre_coment'])): ?>
                  <small class="msg-error">
                    <?php echo htmlspecialchars($errores_comentario['nombre_coment']); ?>
                  </small>
                <?php endif; ?>
              </div>

              <div class="fila-formulario">
                <label for="email_coment">Email (opcional)</label>
                <input
                  type="email"
                  id="email_coment"
                  name="email_coment"
                  value="<?php echo htmlspecialchars($email_coment); ?>"
                  placeholder="tu@correo.com"
                >
                <?php if (!empty($errores_comentario['email_coment'])): ?>
                  <small class="msg-error">
                    <?php echo htmlspecialchars($errores_comentario['email_coment']); ?>
                  </small>
                <?php endif; ?>
              </div>

              <div class="fila-formulario">
                <label for="mensaje_coment">Comentario <span class="req">*</span></label>
                <textarea
                  id="mensaje_coment"
                  name="mensaje_coment"
                  rows="4"
                  required
                ><?php echo htmlspecialchars($texto_coment); ?></textarea>
                <?php if (!empty($errores_comentario['mensaje_coment'])): ?>
                  <small class="msg-error">
                    <?php echo htmlspecialchars($errores_comentario['mensaje_coment']); ?>
                  </small>
                <?php endif; ?>
              </div>

              <button type="submit" class="btn-primario">
                Enviar comentario
              </button>
            </form>
          </section>
        </article>
      <?php else: ?>
        <!-- Mensaje de fallback cuando el artículo no existe en la base de datos -->
        <p>El artículo solicitado no existe.</p>
      <?php endif; ?>
    </div>
  </main>

  <section class="cta-seccion cta-post">
    <div class="contenedor">
      <div class="cta-contenido animar-al-desplazar">
        <h2>¿Te gustó este artículo?</h2>
        <p>Tenemos más notas que pueden interesarte, y si querés, también podemos charlar de tu proyecto.</p>
        <div class="cta-botones">
          <a href="blog.php" class="btn-secundario">Ver Blog</a>
          <a href="contacto.php" class="btn-primario">Contacto</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="js/main.js"></script>
</body>
</html>
