<?php
// Conexión a la BD y configuración general 
require_once 'includes/config.php';

$pagina_actual = 'blog';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Ecos Arquitectura</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/blog.css">
</head>
<body>
    <?php
    include 'includes/header.php';
    ?>

    <main>
        <section class="hero-pagina hero-pagina--imagen" style="--hero-img: url('../imagenes/blog.jpg')">
            <div class="contenedor">
                <div class="hero-pagina-contenido animar-al-desplazar">
                    <h1>Blog</h1>
                    <p>
                        Compartimos ideas, tendencias y reflexiones sobre arquitectura,
                        ciudad, materiales y procesos de diseño que inspiran nuestro trabajo
                        cotidiano en Ecos Arquitectura.
                    </p>
                </div>
            </div>
        </section>

        <!-- Bloque del artículo destacado -->
        <section class="articulo-destacado">
            <h2 class="visually-hidden">Artículo destacado</h2>
            <div class="contenedor">
                <?php
                // Buscar el último artículo marcado como destacado
                $sqlDest = "SELECT * FROM blog_articulos WHERE es_destacado = 1 ORDER BY id DESC LIMIT 1";
                $resDest = $mysqli->query($sqlDest);
                $artDest = ($resDest && $resDest->num_rows > 0) ? $resDest->fetch_assoc() : null;
                ?>
                <div class="contenedor">
                <?php if ($artDest): ?>
                    <article class="post-destacado animar-al-desplazar">
                        <div class="imagen-destacada">
                            <img src="<?php echo htmlspecialchars($artDest['imagen_portada']); ?>"
                                 alt="<?php echo htmlspecialchars($artDest['titulo']); ?>" loading="lazy">
                            <div class="overlay-destacado">
                                <span class="badge-destacado">Artículo Destacado</span>
                            </div>
                        </div>
                        <div class="contenido-destacado">
                            <div class="articulo-meta">
                                <span class="articulo-categoria">
                                    <?php echo htmlspecialchars($artDest['categoria']); ?>
                                </span>
                                <span class="articulo-fecha">
                                    <?php echo htmlspecialchars($artDest['fecha_visible']); ?>
                                </span>
                            </div>
                            <h2>
                                <a href="articulo.php?id=<?php echo (int)$artDest['id']; ?>">
                                    <?php echo htmlspecialchars($artDest['titulo']); ?>
                                </a>
                            </h2>
                            <p><?php echo htmlspecialchars($artDest['resumen']); ?></p>
                            <a href="articulo.php?id=<?php echo (int)$artDest['id']; ?>" class="btn-leer-mas">
                                Leer Artículo Completo
                            </a>
                        </div>
                    </article>
                <?php else: ?>
                    <!-- Mensaje si no hay artículo destacado -->
                    <p>No hay artículo destacado cargado.</p>
                <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Listado del resto de artículos del blog -->
        <section class="blog-articulos">
            <h2 class="visually-hidden">Artículos del blog</h2>
            <div class="contenedor">
                <div class="articulos-grid" id="articulosGrid">
                <?php
                // Artículos que no son destacados
                $sqlLista = "SELECT * FROM blog_articulos WHERE es_destacado = 0 ORDER BY id DESC";
                $resLista = $mysqli->query($sqlLista);

                if ($resLista && $resLista->num_rows > 0):
                    while ($row = $resLista->fetch_assoc()):
                ?>
                    <article
                        class="articulo-card animar-al-desplazar"
                        data-category="<?php echo strtolower(htmlspecialchars($row['categoria'])); ?>"
                    >
                        <div class="articulo-imagen">
                            <img src="<?php echo htmlspecialchars($row['imagen_portada']); ?>"
                                 alt="<?php echo htmlspecialchars($row['titulo']); ?>" loading="lazy">
                            <div class="articulo-overlay">
                                <a href="articulo.php?id=<?php echo (int)$row['id']; ?>" class="btn-leer">
                                    Leer Más
                                </a>
                            </div>
                        </div>
                        <div class="articulo-contenido">
                            <div class="articulo-meta">
                                <span class="articulo-categoria">
                                    <?php echo htmlspecialchars($row['categoria']); ?>
                                </span>
                                <span class="articulo-fecha">
                                    <?php echo htmlspecialchars($row['fecha_visible']); ?>
                                </span>
                            </div>
                            <h3>
                                <a href="articulo.php?id=<?php echo (int)$row['id']; ?>">
                                    <?php echo htmlspecialchars($row['titulo']); ?>
                                </a>
                            </h3>
                            <p><?php echo htmlspecialchars($row['resumen']); ?></p>
                        </div>
                    </article>
                <?php
                    endwhile;
                else:
                ?>
                    <!-- Mensaje si no hay artículos en la tabla -->
                    <p>No hay artículos cargados todavía.</p>
                <?php endif; ?>
                </div>
            </div>
        </section>

    </main>

    <?php
    include 'includes/footer.php';
    ?>
    <script src="js/main.js"></script>
</body>
</html>
