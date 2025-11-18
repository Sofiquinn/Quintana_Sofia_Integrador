<?php
// Incluye el archivo de configuración general (conexión a la base de datos, constantes, etc.).
require_once 'includes/config.php';

$pagina_actual = 'proyectos';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proyectos - Ecos Arquitectura</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/proyectos.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <section class="hero-pagina hero-pagina--imagen" style="--hero-img: url('../imagenes/proyectos.jpg')">
      <div class="contenedor">
        <div class="hero-pagina-contenido animar-al-desplazar">
          <h1>Proyectos</h1>
          <p>
            Diseñamos procesos arquitectónicos que transforman la realidad,
            generando espacios que combinan deseo, función y contexto.
            Buscamos constantemente la innovación para concretar
            construcciones sostenibles y con valor.
          </p>
        </div>
      </div>
    </section>

    <!-- Sección de filtros para clasificar los proyectos por categoría -->
    <section class="proyectos-filtro">
      <h2 class="visually-hidden">Filtros de proyectos</h2>
      <div class="contenedor">
        <div class="controles-filtro animar-al-desplazar">
          <!-- Botones de filtro; el atributo data-filter se utiliza en JavaScript para filtrar el mosaico -->
          <button class="btn-filtro activo" data-filter="all">Todos</button>
          <button class="btn-filtro" data-filter="residencial">Residencial</button>
          <button class="btn-filtro" data-filter="comercial">Comercial</button>
          <button class="btn-filtro" data-filter="institucional">Institucional</button>
          <button class="btn-filtro" data-filter="paisajismo">Paisajismo</button>
        </div>
      </div>
    </section>

    <!-- Sección principal que muestra la galería/mosaico de proyectos -->
    <section class="proyectos-galeria">
      <h2 class="visually-hidden">Galería de proyectos</h2>
      <div class="contenedor">
        <div class="proyectos-mosaico" id="gridProyectos">
          <?php
          // Consulta que obtiene todos los proyectos ordenados por su ID.
          $sql = "SELECT * FROM proyectos ORDER BY id";
          $resultado = $mysqli->query($sql);

          // Verifica si la consulta devolvió resultados.
          if ($resultado && $resultado->num_rows > 0):
              // Recorre cada proyecto y genera su tarjeta en la grilla.
              while ($proy = $resultado->fetch_assoc()):
          ?>
            <!-- Cada proyecto se representa como un artículo con categoría para el filtrado -->
            <article class="proyecto-item animar-al-desplazar"
                    data-category="<?php echo htmlspecialchars($proy['tipo_slug']); ?>">
              <div class="proyecto-imagen">
                <img src="<?php echo htmlspecialchars($proy['imagen_listado']); ?>"
                    alt="<?php echo htmlspecialchars($proy['titulo']); ?>" loading="lazy">
                <div class="superposicion-proyecto">
                  <div class="proyecto-info">
                    <a href="proyectos_detalle.php?id=<?php echo (int)$proy['id']; ?>" class="btn-ver">Ver Proyecto</a>
                  </div>
                </div>
              </div>
              <div class="proyecto-detalles">
                <span class="proyecto-categoria">
                  <?php echo htmlspecialchars($proy['categoria']); ?>
                </span>
                <h3><?php echo htmlspecialchars($proy['titulo']); ?></h3>
                <p><?php echo htmlspecialchars($proy['resumen']); ?></p>
                <div class="proyecto-meta">
                  <span><?php echo htmlspecialchars($proy['ubicacion']); ?></span>
                  <span><?php echo htmlspecialchars($proy['superficie']); ?></span>
                  <span><?php echo htmlspecialchars($proy['anio']); ?></span>
                </div>
              </div>
            </article>
          <?php
              endwhile;
          else:
          ?>
            <!-- Mensaje mostrado cuando no hay proyectos cargados en la base de datos -->
            <p>No hay proyectos cargados todavía.</p>
          <?php endif; ?>
        </div>

      </div>
    </section>
  </main>

  <section class="cta-seccion">
    <div class="contenedor">
      <div class="cta-contenido animar-al-desplazar">
        <h2>¿Querés comenzar un proyecto?</h2>
        <p>Contactanos para hacer realidad tu visión arquitectónica</p>
        <div class="cta-botones">
          <a href="contacto.php" class="btn-primario">Comenzar Proyecto</a>
          <a href="servicios.php" class="btn-secundario">Ver Servicios</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="js/main.js"></script>
  <script src="js/proyectos.js"></script>
</body>
</html>
