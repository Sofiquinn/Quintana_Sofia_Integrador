<?php
// $pagina_actual se define en cada página (home, servicios, proyectos, blog, contacto)
if (!isset($pagina_actual)) {
    $pagina_actual = '';
}
?>
<header class="header">
    <nav>
        <div class="nav-contenedor">
            <div class="nav-logo">
                <img src="imagenes/logo_blanco.svg" alt="Ecos Arquitectura Logo" class="logo-img">
                <span class="logo-texto">ECOS ARQUITECTURA</span>
            </div>
            
            <!-- Menú principal -->
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="index.php"
                       class="nav-link <?php echo $pagina_actual === 'home' ? 'activo' : ''; ?>">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a href="servicios.php"
                       class="nav-link <?php echo $pagina_actual === 'servicios' ? 'activo' : ''; ?>">
                        Servicios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="proyectos.php"
                       class="nav-link <?php echo $pagina_actual === 'proyectos' ? 'activo' : ''; ?>">
                        Proyectos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="blog.php"
                       class="nav-link <?php echo $pagina_actual === 'blog' ? 'activo' : ''; ?>">
                        Blog
                    </a>
                </li>
                <li class="nav-item">
                    <a href="contacto.php"
                       class="nav-link <?php echo $pagina_actual === 'contacto' ? 'activo' : ''; ?>">
                        Contacto
                    </a>
                </li>
            </ul>
            
            <div class="boton-hamburguesa">
                <span class="linea-hamburguesa"></span>
                <span class="linea-hamburguesa"></span>
                <span class="linea-hamburguesa"></span>
            </div>
        </div>
    </nav>
</header>
