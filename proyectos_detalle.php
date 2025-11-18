<?php
require_once 'includes/config.php';

$pagina_actual = 'proyectos';

// Obtiene el parámetro "id" desde la URL y lo convierte a entero.
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Variable donde se almacenarán los datos del proyecto, si se encuentran.
$proyecto = null;

// Si el id es válido, se realiza la consulta preparada.
if ($id > 0) {
    // Prepara la consulta para obtener un único proyecto según su ID.
    $stmt = $mysqli->prepare("SELECT * FROM proyectos WHERE id = ?");
    // Enlaza el parámetro de tipo entero.
    $stmt->bind_param('i', $id);
    // Ejecuta la consulta.
    $stmt->execute();
    // Obtiene el resultado de la consulta.
    $resultado = $stmt->get_result();
    // Verifica que se haya encontrado exactamente un proyecto.
    if ($resultado && $resultado->num_rows === 1) {
        // Asigna los datos del proyecto a la variable $proyecto.
        $proyecto = $resultado->fetch_assoc();
    }
    // Cierra el statement para liberar recursos.
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    <?php
      echo $proyecto
        ? htmlspecialchars($proyecto['titulo']) . ' - Ecos Arquitectura'
        : 'Proyecto no encontrado - Ecos Arquitectura';
    ?>
  </title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/proyectos_detalle.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <section class="hero-pagina proyecto-hero">
    <div class="contenedor">
      <div class="hero-pagina-contenido animar-al-desplazar">
        <?php if ($proyecto): ?>
          <h1 id="tituloProyecto">
            <?php echo htmlspecialchars($proyecto['titulo']); ?>
          </h1>
          <p id="subtituloProyecto">
            <?php
              // Ejemplo de formato: "Residencial · 320m² · 2023 · Buenos Aires"
              echo htmlspecialchars($proyecto['categoria'])
                   . ' · ' . htmlspecialchars($proyecto['superficie'])
                   . ' · ' . htmlspecialchars($proyecto['anio'])
                   . ' · ' . htmlspecialchars($proyecto['ubicacion']);
            ?>
          </p>
        <?php else: ?>
          <!-- Mensaje cuando no se encuentra el proyecto -->
          <h1 id="tituloProyecto">Proyecto no encontrado</h1>
          <p id="subtituloProyecto">Revisá el enlace o volvé al listado de proyectos.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Contenido principal del detalle del proyecto -->
  <main class="proyecto-detalles-wrap">
    <?php if ($proyecto): ?>
      <article class="proyecto-detalle animar-al-desplazar">
        <div class="contenedor">
          <div class="detalle-grid">
            <div class="detalle-media">
              <img src="<?php echo htmlspecialchars($proyecto['imagen_detalle1']); ?>"
                   alt="<?php echo htmlspecialchars($proyecto['titulo']); ?>" loading="lazy">
              <div class="miniaturas">
                <img src="<?php echo htmlspecialchars($proyecto['imagen_detalle1']); ?>"
                     alt="Vista 1" loading="lazy">
                <img src="<?php echo htmlspecialchars($proyecto['imagen_detalle2']); ?>"
                     alt="Vista 2" loading="lazy">
              </div>
            </div>
            <div class="detalle-info">
              <span class="etiqueta">
                <?php echo htmlspecialchars($proyecto['categoria']); ?>
              </span>
              <h2><?php echo htmlspecialchars($proyecto['titulo']); ?></h2>
              <p>
                <?php echo nl2br(htmlspecialchars($proyecto['descripcion_detallada'])); ?>
              </p>
              <ul class="meta">
                <li><strong>Ubicación:</strong> <?php echo htmlspecialchars($proyecto['ubicacion']); ?></li>
                <li><strong>Superficie:</strong> <?php echo htmlspecialchars($proyecto['superficie']); ?></li>
                <li><strong>Año:</strong> <?php echo htmlspecialchars($proyecto['anio']); ?></li>
              </ul>
              <!-- Acciones disponibles: volver al listado o ir a contacto -->
              <div class="acciones">
                <a class="btn-secundario" href="proyectos.php">← Ver todos los proyectos</a>
                <a class="btn-primario" href="contacto.php">Contacto</a>
              </div>
            </div>
          </div>
        </div>
      </article>
    <?php else: ?>
      <!-- Bloque que se muestra cuando el proyecto no existe o no se encontró -->
      <section class="no-encontrado contenedor animar-al-desplazar">
        <h2 class="nf-titulo">Proyecto no encontrado</h2>
        <p>Revisá el enlace o volvé al listado de proyectos.</p>
        <div class="acciones">
          <a class="btn-secundario" href="proyectos.php">← Ver proyectos</a>
          <a class="btn-primario" href="contacto.php">Contacto</a>
        </div>
      </section>
    <?php endif; ?>
  </main>

  <section class="cta-seccion post-cta">
    <div class="contenedor">
      <div class="cta-contenido animar-al-desplazar">
        <h2>¿Te gustó este proyecto?</h2>
        <p>Podemos ayudarte a crear algo a tu medida.</p>
        <div class="cta-botones">
          <a href="proyectos.php" class="btn-secundario">Ver más proyectos</a>
          <a href="contacto.php" class="btn-primario">Contacto</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="js/main.js"></script>
  <script src="js/proyectos_detalle.js"></script> 
</body>
</html>
