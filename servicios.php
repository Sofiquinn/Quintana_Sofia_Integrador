<?php
// Incluye el archivo de configuración general del sitio (conexión a BD, constantes, etc.).
require_once 'includes/config.php';

$pagina_actual = 'servicios';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Servicios</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/servicios.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <!-- Sección hero de la página de servicios, con imagen de fondo y eslogan -->
    <section class="hero-pagina hero-pagina--imagen" style="--hero-img: url('../imagenes/servicios.jpg')">
      <div class="contenedor">
        <div class="hero-pagina-contenido animar-al-desplazar">
          <h1>Servicios</h1>
          <p>
            Acompañamos cada etapa del proyecto: desde la idea inicial,
            el diseño y la documentación técnica, hasta la dirección de obra
            y el interiorismo, integrando estética, funcionalidad y sostenibilidad.
          </p>
        </div>
      </div>
    </section>

    <!-- Sección con el detalle de cada servicio ofrecido -->
    <section class="servicios-detalle">
      <h2 class="visually-hidden">Detalle de servicios</h2>
      <div class="contenedor">

        <!-- Servicio: Diseños Personalizados -->
        <article class="servicio-item animar-al-desplazar">
          <div class="servicio-contenido">
            <div class="servicio-texto">
              <div class="servicio-header">
                <div class="servicio-icono-grande">
                  <img src="imagenes/diseno_personalizado.jpg" alt="Diseños Personalizados" loading="lazy">
                </div>
                <div class="servicio-titulo-seccion">
                  <h2>Diseños Personalizados</h2>
                  <p class="servicio-subtitulo">Soluciones a medida para tu estilo, tus necesidades y tu presupuesto</p>
                </div>
              </div>

              <!-- Descripción detallada del servicio -->
              <div class="servicio-descripcion">
                <p>
                  Trabajamos con vos para transformar ideas en espacios únicos. Partimos de tus objetivos y hábitos
                  de uso para definir un concepto, explorar alternativas y materializarlas en propuestas claras,
                  funcionales y estéticas. Cada decisión —distribución, materiales, iluminación y detalles—
                  se ajusta a tu identidad y al contexto del proyecto.
                </p>

                <!-- Listado de características concretas que incluye el servicio -->
                <div class="servicio-caracteristicas">
                  <h4>Incluye:</h4>
                  <ul>
                    <li>Análisis del terreno y contexto</li>
                    <li>Diseño conceptual y desarrollo del proyecto</li>
                    <li>Planos arquitectónicos ejecutivos</li>
                    <li>Visualizaciones 3D y renders</li>
                    <li>Especificaciones técnicas</li>
                    <li>Tramitación de permisos</li>
                  </ul>
                </div>

                <!-- Tipos de proyectos a los que se puede aplicar este servicio -->
                <div class="servicio-proyectos">
                  <h4>Aplicable a:</h4>
                  <div class="tipos-proyecto">
                    <span class="tag-proyecto">Viviendas y refacciones</span>
                    <span class="tag-proyecto">Interiorismo</span>
                    <span class="tag-proyecto">Locales y vidrieras</span>
                    <span class="tag-proyecto">Mobiliario a medida</span>
                  </div>
                </div>
              </div>
              <a href="contacto.php" class="btn-primario">Solicitar Consulta</a>
            </div>
            <div class="servicio-imagen">
              <img src="imagenes/colegio.jpg" alt="Diseño Personalizado" loading="lazy">
            </div>
          </div>
        </article>

        <!-- Servicio: Dirección de Obra -->
        <article class="servicio-item animar-al-desplazar">
          <div class="servicio-contenido">
            <div class="servicio-texto">
              <div class="servicio-header">
                <div class="servicio-icono-grande">
                  <img src="imagenes/direccion_obra.jpg" alt="Dirección de Obra" loading="lazy">
                </div>
                <div class="servicio-titulo-seccion">
                  <h2>Dirección de Obra</h2>
                  <p class="servicio-subtitulo">Supervisión integral del proceso constructivo</p>
                </div>
              </div>

              <!-- Descripción general del alcance del servicio -->
              <div class="servicio-descripcion">
                <p>
                  Gestionamos y supervisamos todo el proceso de construcción desde la planificación hasta la entrega final.
                  Garantizamos calidad, cumplimiento de plazos y control presupuestario en cada etapa del proyecto.
                </p>

                <!-- Listado de tareas y responsabilidades que incluye la dirección de obra -->
                <div class="servicio-caracteristicas">
                  <h4>Incluye:</h4>
                  <ul>
                    <li>Planificación y programación de obra</li>
                    <li>Coordinación de contratistas y proveedores</li>
                    <li>Control de calidad y supervisión técnica</li>
                    <li>Seguimiento presupuestario</li>
                    <li>Informes periódicos de avance</li>
                    <li>Resolución de imprevistos</li>
                  </ul>
                </div>

                <!-- Tipos de proyectos para los que se ofrece este servicio -->
                <div class="servicio-proyectos">
                  <h4>Tipos de Proyectos:</h4>
                  <div class="tipos-proyecto">
                    <span class="tag-proyecto">Viviendas Unifamiliares</span>
                    <span class="tag-proyecto">Edificios Residenciales</span>
                    <span class="tag-proyecto">Espacios Comerciales</span>
                    <span class="tag-proyecto">Oficinas Corporativas</span>
                  </div>
                </div>
              </div>
              <a href="contacto.php" class="btn-primario">Solicitar Consulta</a>
            </div>

            <div class="servicio-imagen">
              <img src="imagenes/planificacion.jpg" alt="Dirección de Obra" loading="lazy">
            </div>
          </div>
        </article>

        <!-- Servicio: Diseño Interior -->
        <article class="servicio-item animar-al-desplazar">
          <div class="servicio-contenido">
            <div class="servicio-texto">
              <div class="servicio-header">
                <div class="servicio-icono-grande">
                  <img src="imagenes/arquitectura_interior.jpg" alt="Diseño Interior" loading="lazy">
                </div>
                <div class="servicio-titulo-seccion">
                  <h2>Diseño Interior</h2>
                  <p class="servicio-subtitulo">Espacios interiores que inspiran y funcionan</p>
                </div>
              </div>

              <!-- Descripción general del enfoque de diseño interior -->
              <div class="servicio-descripcion">
                <p>
                  Creamos ambientes interiores únicos que combinan funcionalidad, confort y estilo.
                  Trabajamos en sintonía con la arquitectura para lograr espacios coherentes y atemporales.
                </p>

                <!-- Listado de tareas incluidas en el servicio de diseño interior -->
                <div class="servicio-caracteristicas">
                  <h4>Incluye:</h4>
                  <ul>
                    <li>Análisis de necesidades y estilo de vida</li>
                    <li>Conceptualización y mood boards</li>
                    <li>Planos de distribución y mobiliario</li>
                    <li>Selección de materiales y acabados</li>
                    <li>Especificación de mobiliario y decoración</li>
                    <li>Coordinación con proveedores</li>
                  </ul>
                </div>

                <!-- Estilos de diseño interior que se trabajan de manera específica -->
                <div class="servicio-proyectos">
                  <h4>Estilos Especializados:</h4>
                  <div class="styles-grid">
                    <span class="tag-proyecto">Minimalista</span>
                    <span class="tag-proyecto">Contemporáneo</span>
                    <span class="tag-proyecto">Industrial</span>
                    <span class="tag-proyecto">Escandinavo</span>
                    <span class="tag-proyecto">Mediterráneo</span>
                    <span class="tag-proyecto">Ecléctico</span>
                  </div>
                </div>
              </div>
              <a href="contacto.php" class="btn-primario">Solicitar Consulta</a>
            </div>

            <div class="servicio-imagen">
              <img src="imagenes/casa_interior.jpg" alt="Diseño Interior" loading="lazy">
            </div>
          </div>
        </article>

        <!-- Servicio: Paisajismo -->
        <article class="servicio-item animar-al-desplazar">
          <div class="servicio-contenido">
            <div class="servicio-texto">
              <div class="servicio-header">
                <div class="servicio-icono-grande">
                  <img src="imagenes/paisajismo.jpg" alt="Paisajismo" loading="lazy">
                </div>
                <div class="servicio-titulo-seccion">
                  <h2>Paisajismo</h2>
                  <p class="servicio-subtitulo">Naturaleza integrada: diseño, biodiversidad y confort exterior</p>
                </div>
              </div>

              <!-- Descripción general del servicio de diseño de espacios exteriores -->
              <div class="servicio-descripcion">
                <p>
                  Diseñamos espacios exteriores vivos y sostenibles que mejoran el bienestar y valorizan cada proyecto.
                  Seleccionamos especies adecuadas al clima local, priorizamos bajo mantenimiento y optimizamos agua,
                  suelos e iluminación para lograr jardines armónicos y duraderos en cualquier escala.
                </p>

                <!-- Detalle de los componentes del servicio de paisajismo -->
                <div class="servicio-caracteristicas">
                  <h4>Incluye:</h4>
                  <ul>
                    <li>Relevamiento del sitio (asoleamiento, vientos, vistas, suelos y escorrentía)</li>
                    <li>Concepto paisajístico y zonificación de usos (estar, huerta, juegos, circulación)</li>
                    <li>Selección de especies nativas y adaptadas (paleta botánica y plan de plantación)</li>
                    <li>Diseño de riego eficiente y drenajes</li>
                    <li>Proyecto de iluminación exterior</li>
                    <li>Detalles de canteros, bordes, solados y mobiliario</li>
                    <li>Plan de mantenimiento estacional</li>
                  </ul>
                </div>

                <!-- Estilos posibles para la composición paisajística -->
                <div class="servicio-proyectos">
                  <h4>Estilos Especializados:</h4>
                  <div class="styles-grid">
                    <span class="tag-proyecto">Minimalista</span>
                    <span class="tag-proyecto">Contemporáneo</span>
                    <span class="tag-proyecto">Industrial</span>
                    <span class="tag-proyecto">Escandinavo</span>
                    <span class="tag-proyecto">Mediterráneo</span>
                    <span class="tag-proyecto">Ecléctico</span>
                  </div>
                </div>
              </div>
              <a href="contacto.php" class="btn-primario">Solicitar Consulta</a>
            </div>

            <div class="servicio-imagen">
              <img src="imagenes/balcon.jpg" alt="Paisajismo" loading="lazy">
            </div>
          </div>
        </article>

      </div>
    </section>

    <!-- Sección que explica, de forma resumida, el proceso de trabajo -->
    <section class="proceso-seccion">
      <div class="contenedor">
        <h2 class="seccion-titulo animar-al-desplazar">Nuestro Proceso de Trabajo</h2>
        <div class="proceso-linea-tiempo">
          <div class="proceso-paso animar-al-desplazar">
            <div class="paso-numero">01</div>
            <div class="paso-contenido">
              <h3>Consulta Inicial</h3>
              <p>Reunión para entender sus necesidades, visión y presupuesto. Análisis del sitio y objetivos.</p>
            </div>
          </div>

          <div class="proceso-paso animar-al-desplazar">
            <div class="paso-numero">02</div>
            <div class="paso-contenido">
              <h3>Conceptualización</h3>
              <p>Ideas preliminares y propuestas conceptuales que reflejen su visión.</p>
            </div>
          </div>

          <div class="proceso-paso animar-al-desplazar">
            <div class="paso-numero">03</div>
            <div class="paso-contenido">
              <h3>Desarrollo del Proyecto</h3>
              <p>Planos detallados, especificaciones técnicas y documentación completa.</p>
            </div>
          </div>

          <div class="proceso-paso animar-al-desplazar">
            <div class="paso-numero">04</div>
            <div class="paso-contenido">
              <h3>Ejecución</h3>
              <p>Dirección de obra y seguimiento constante hasta la entrega final.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Sección final de llamada a la acción para iniciar un proyecto -->
  <section class="cta-seccion">
    <div class="contenedor">
      <div class="cta-contenido animar-al-desplazar">
        <h2>¿Querés Comenzar tu Proyecto?</h2>
        <p>Conversemos sobre cómo podemos hacer realidad tu visión arquitectónica</p>
        <div class="cta-botones">
          <a href="contacto.php" class="btn-primario">Contactar Ahora</a>
          <a href="proyectos.php" class="btn-secundario">Ver Proyectos</a>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

  <script src="js/main.js"></script>
</body>
</html>
