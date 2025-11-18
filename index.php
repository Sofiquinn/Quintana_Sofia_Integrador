<?php
// Incluye el archivo de configuración general del sitio (conexión a la base de datos, constantes, etc.).
require_once 'includes/config.php';

$pagina_actual = 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <section class="hero">
            <div class="hero-contenido">
                <div class="hero-texto animar-al-desplazar">
                    <p class="hero-eslogan">"Llevamos a la realidad tus sueños"</p>
                    <h1 class="hero-titulo">Ecos Arquitectura</h1>
                    <p class="hero-mensaje">
                        Trabajamos con dedicación, creatividad y atención al detalle para diseñar
                        espacios funcionales y estéticos que reflejan tu identidad y mejoren tu día a día.
                    </p>
                    <a href="proyectos.php" class="btn-accion">Ver Nuestros Proyectos</a>
                </div>
            </div>
        </section>

        <section class="home-identidad">
            <div class="contenedor">
                <h2 class="home-nombre-estudio animar-al-desplazar">
                    ECOS ARQUITECTURA
                </h2>
            </div>
        </section>

        <!-- Muestra una selección de imágenes en formato deslizable -->
        <section class="carrusel-obras">
            <div class="carrusel-contenedor">
                <div class="swiper carrusel-obras-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="imagenes/obra1.jpg" alt="Obra 1">
                        </div>
                        <div class="swiper-slide">
                            <img src="imagenes/obra2.jpg" alt="Obra 2">
                        </div>
                        <div class="swiper-slide">
                            <img src="imagenes/obra3.jpg" alt="Obra 3">
                        </div>
                        <div class="swiper-slide">
                            <img src="imagenes/obra4.jpg" alt="Obra 4">
                        </div>
                        <div class="swiper-slide">
                            <img src="imagenes/obra5.jpg" alt="Obra 5">
                        </div>
                        <div class="swiper-slide">
                            <img src="imagenes/obra6.jpg" alt="Obra 6">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Breve presentación del estudio y su enfoque de trabajo -->
        <section class="seccion-sobre">
            <div class="contenedor">
                <div class="contenido-sobre animar-al-desplazar">
                    <div class="texto-sobre">
                        <h2>Sobre Nosotros</h2>
                        <p>
                            En Ecos Arquitectura cree que cada espacio tiene una historia que contar.
                            Su enfoque integra funcionalidad, estética y sostenibilidad para crear
                            arquitectura que no solo satisface las necesidades presentes, sino que anticipa
                            las futuras.
                        </p>
                        <p>
                            Con más de una década de experiencia, su equipo multidisciplinario
                            combina creatividad y técnica para entregar proyectos excepcionales que
                            superan las expectativas de sus clientes.
                        </p>
                    </div>
                    <div class="imagen-sobre">
                        <img src="imagenes/equipo.jpg" alt="Equipo Ecos Arquitectura" class="img-sobre">
                    </div>
                </div>
            </div>
        </section>

        <!-- Resumen de las principales líneas de servicio del estudio -->
        <section class="seccion-servicios">
            <div class="contenedor">
                <h2 class="seccion-titulo animar-al-desplazar">Nuestros Servicios</h2>
                <div class="servicios-grid">
                    <div class="servicio-card animar-al-desplazar">
                        <div class="servicio-icon">
                            <img src="imagenes/diseno_personalizado.jpg" alt="Diseño Personalizado" loading="lazy">
                        </div>
                        <h3>Diseños Personalizados</h3>
                        <p>Realiza proyectos de acuerdo a las necesidades y preferencias del cliente.</p>
                    </div>
                    <div class="servicio-card animar-al-desplazar">
                        <div class="servicio-icon">
                            <img src="imagenes/direccion_obra.jpg" alt="Dirección de Obra" loading="lazy">
                        </div>
                        <h3>Dirección de Obra</h3>
                        <p>Supervisa de forma integral desde la planificación hasta la entrega final del proyecto.</p>
                    </div>
                    <div class="servicio-card animar-al-desplazar">
                        <div class="servicio-icon">
                            <img src="imagenes/arquitectura_interior.jpg" alt="Diseño Interior" loading="lazy">
                        </div>
                        <h3>Diseño Interior</h3>
                        <p>Crea espacios interiores que combinan funcionalidad y belleza en armonía.</p>
                    </div>
                    <div class="servicio-card animar-al-desplazar">
                        <div class="servicio-icon">
                            <img src="imagenes/paisajismo.jpg" alt="Paisajismo" loading="lazy">
                        </div>
                        <h3>Paisajismo</h3>
                        <p>Integra la arquitectura con la naturaleza para lograr espacios sostenibles.</p>
                    </div>
                </div>
                <div class="cta-servicios">
                    <a href="servicios.php" class="btn-secundario">Ver Todos los Servicios</a>
                </div>
            </div>
        </section>

        <!-- Muestra algunos proyectos representativos -->
        <section class="seccion-proyectos">
            <div class="contenedor">
                <h2 class="seccion-titulo animar-al-desplazar">Proyectos Destacados</h2>
                <div class="proyectos-grid">
                    <article class="proyecto-card animar-al-desplazar">
                        <div class="proyecto-imagen">
                            <img src="imagenes/casa.jpg" alt="Casa Moderna Minimalista" loading="lazy">
                            <div class="superposicion-proyecto">
                                <a href="proyectos_detalle.php?id=1" class="btn-ver">Ver Proyecto</a>
                            </div>
                        </div>
                        <div class="proyecto-info">
                            <h3>Casa Moderna Minimalista</h3>
                            <p>Residencia familiar que combina espacios abiertos y gran conexión con el jardín.</p>
                            <span class="proyecto-categoria">Residencial</span>
                        </div>
                    </article>
                    
                    <article class="proyecto-card animar-al-desplazar">
                        <div class="proyecto-imagen">
                            <img src="imagenes/oficina.jpg" alt="Oficinas Corporativas" loading="lazy">
                            <div class="superposicion-proyecto">
                                <a href="proyectos_detalle.php?id=2" class="btn-ver">Ver Proyecto</a>
                            </div>
                        </div>
                        <div class="proyecto-info">
                            <h3>Oficinas Corporativas</h3>
                            <p>Complejo de oficinas que prioriza el estilo minimalista y el bienestar.</p>
                            <span class="proyecto-categoria">Comercial</span>
                        </div>
                    </article>
                    
                    <article class="proyecto-card animar-al-desplazar">
                        <div class="proyecto-imagen">
                            <img src="imagenes/restaurante.jpg" alt="Restaurante" loading="lazy">
                            <div class="superposicion-proyecto">
                                <a href="proyectos_detalle.php?id=3" class="btn-ver">Ver Proyecto</a>
                            </div>
                        </div>
                        <div class="proyecto-info">
                            <h3>Restaurante</h3>
                            <p>Restaurante con diseño contemporáneo e innovador.</p>
                            <span class="proyecto-categoria">Comercial</span>
                        </div>
                    </article>
                </div>
                <div class="cta-proyectos">
                    <a href="proyectos.php" class="btn-primario">Ver Todos los Proyectos</a>
                </div>
            </div>
        </section>

        <section class="seccion-imagen-final">
            <div class="imagen-final"
                 style="background-image: url('imagenes/obra_footer.jpg');">
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="js/main.js"></script>

    <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/carrusel-obras.js"></script>
</body>
</html>
