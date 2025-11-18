<?php
require_once 'includes/config.php';
$pagina_actual = 'contacto';

// Valores por defecto
$nombre   = '';
$email    = '';
$telefono = '';
$mensaje  = '';

$errores = [];
$estado_formulario = '';

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Tomar y limpiar datos
    $nombre   = trim($_POST['nombre']   ?? '');
    $email    = trim($_POST['email']    ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $mensaje  = trim($_POST['mensaje']  ?? '');

    // Validaciones simples del lado servidor
    if ($nombre === '') {
        $errores['nombre'] = 'El nombre es obligatorio.';
    }

    if ($email === '') {
        $errores['email'] = 'El email es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = 'Ingresá un email válido.';
    }

    if ($telefono === '') {
        $errores['telefono'] = 'El teléfono es obligatorio.';
    }

    if ($mensaje === '') {
        $errores['mensaje'] = 'El mensaje es obligatorio.';
    }

    // Si no hay errores, se guarda en la BD y se envía mail
    if (empty($errores)) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';

        // 1) Guardar en la tabla contactos
        $stmt = $mysqli->prepare(
            "INSERT INTO contactos (nombre, email, telefono, mensaje, ip)
             VALUES (?, ?, ?, ?, ?)"
        );
        if ($stmt) {
            $stmt->bind_param('sssss', $nombre, $email, $telefono, $mensaje, $ip);
            $ok_bd = $stmt->execute();
            $stmt->close();
        } else {
            $ok_bd = false;
        }

        // 2) Enviar mail al estudio
        $destinatario = 'infoecosarquitectura@gmail.com'; 
        $asunto = 'Nuevo mensaje desde la web - Ecos Arquitectura';

        $cuerpo = "Nuevo mensaje desde el formulario de contacto:\n\n" .
                  "Nombre:   {$nombre}\n" .
                  "Email:    {$email}\n" .
                  "Teléfono: {$telefono}\n" .
                  "IP:       {$ip}\n\n" .
                  "Mensaje:\n{$mensaje}\n";

        $cabeceras  = "From: Ecos Arquitectura <no-reply@localhost>\r\n";
        $cabeceras .= "Reply-To: {$email}\r\n";
        $cabeceras .= "X-Mailer: PHP/" . phpversion();

        // En XAMPP puede que el mail no salga si no está configurado,
        // pero el código queda listo para subir a hosting.
        $mail_enviado = @mail($destinatario, $asunto, $cuerpo, $cabeceras);

        if ($ok_bd) {
            $estado_formulario = '¡Gracias! Recibimos tu mensaje y te vamos a responder a la brevedad.';
            // Limpiar campos del formulario luego del envío
            $nombre = $email = $telefono = $mensaje = '';
        } else {
            $estado_formulario = 'Ocurrió un error al guardar tu mensaje. Intentá nuevamente más tarde.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto - Ecos Arquitectura</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/contacto.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <section class="hero-pagina hero-pagina--imagen" style="--hero-img: url('../imagenes/contacto.jpg')">
    <div class="contenedor">
      <div class="hero-pagina-contenido animar-al-desplazar">
        <h1>Contacto</h1>
        <p>
          Contanos sobre tu proyecto, tus tiempos y tus necesidades.
          Trabajamos a medida para acompañarte desde la primera idea
          hasta la entrega de la obra terminada.
        </p>
      </div>
    </div>
  </section>

  <main class="seccion-contacto">
    <div class="contenedor">
      <div class="contacto-grid">
        <section class="contacto-card animar-al-desplazar">
          <h2>Escribinos</h2>
          <p class="contacto-intro">
            Completá el formulario y te contactamos. Los campos con <span aria-hidden="true">*</span> son obligatorios.
          </p>
          <form id="formulario-contacto" method="post" novalidate>
            <div class="fila-formulario">
              <label for="nombre">Nombre <span class="req">*</span></label>
              <input
                type="text"
                id="nombre"
                name="nombre"
                placeholder="Tu nombre"
                value="<?php echo htmlspecialchars($nombre); ?>"
                required
              >
              <small class="msg-error" id="err-nombre">
                <?php echo $errores['nombre'] ?? ''; ?>
              </small>
            </div>
            <div class="fila-formulario">
              <label for="email">Email <span class="req">*</span></label>
              <input
                type="email"
                id="email"
                name="email"
                placeholder="tu@correo.com"
                value="<?php echo htmlspecialchars($email); ?>"
                required
              >
              <small class="msg-error" id="err-email">
                <?php echo $errores['email'] ?? ''; ?>
              </small>
            </div>
            <div class="fila-formulario">
              <label for="telefono">Teléfono <span class="req">*</span></label>
              <input
                type="tel"
                id="telefono"
                name="telefono"
                placeholder="Ej: +54 9 376 468 6785"
                value="<?php echo htmlspecialchars($telefono); ?>"
                required
              >
              <small class="msg-error" id="err-telefono">
                <?php echo $errores['telefono'] ?? ''; ?>
              </small>
            </div>
            <div class="fila-formulario">
              <label for="mensaje">Mensaje <span class="req">*</span></label>
              <textarea
                id="mensaje"
                name="mensaje"
                rows="5"
                placeholder="Contanos sobre tu proyecto"
                required
              ><?php echo htmlspecialchars($mensaje); ?></textarea>
              <small class="msg-error" id="err-mensaje">
                <?php echo $errores['mensaje'] ?? ''; ?>
              </small>
            </div>

            <div class="acciones-formulario">
              <button type="submit" class="btn-primario" id="btn-enviar">Enviar</button>
              <button type="reset" class="btn-secundario">Limpiar</button>
            </div>

            <p class="estado-formulario" id="estado-formulario" role="status" aria-live="polite">
              <?php echo htmlspecialchars($estado_formulario); ?>
            </p>
          </form>
        </section>

        <aside class="contacto-info animar-al-desplazar">
          <h3>Datos de contacto</h3>
          <ul class="lista-info">
            <li><strong>Email:</strong> infoecosarquitectura@gmail.com</li>
            <li><strong>Instagram:</strong> <a href="https://instagram.com/ecosarquitectura" target="_blank" rel="noopener noreferrer">@ecosarquitectura</a></li>
          </ul>
          <p>Atendemos proyectos en distintas ciudades. ¡Hablemos! </p>
        </aside>
      </div>
    </div>
  </main>

  <section class="cta-seccion">
    <div class="contenedor">
      <div class="cta-contenido animar-al-desplazar">
        <h2>¿Listo para empezar?</h2>
        <p>Creamos un espacio que te represente.</p>
        <div class="cta-botones">
          <a href="proyectos.php" class="btn-secundario">Ver Proyectos</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="js/main.js"></script> 
  <script src="js/contacto.js"></script>
</body>
</html>
