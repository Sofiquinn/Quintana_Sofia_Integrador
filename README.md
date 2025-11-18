# Ecos Arquitectura

Sitio web dinámico para un estudio de arquitectura, desarrollado con PHP, MySQL, HTML, CSS y JavaScript.  
Permite presentar servicios, mostrar proyectos realizados, publicar artículos de blog y recibir consultas a través de un formulario de contacto.  
Incluye además un panel de administración para gestionar todo el contenido sin modificar el código.

**Alumna:** Sofía Quintana

## Características principales

- **Sección pública**
  - **Inicio (`index.php`)**: hero principal con eslogan e identidad del estudio, carrusel de obras y proyectos destacados.
  - **Servicios (`servicios.php`)**: descripción de los servicios ofrecidos (diseño, dirección de obra, interiorismo, paisajismo).
  - **Proyectos (`proyectos.php`)**: listado dinámico de proyectos desde la tabla `proyectos`, con filtros por categoría.
  - **Detalle de proyecto (`proyectos_detalle.php`)**: muestra información ampliada de cada proyecto (imágenes, descripción, ubicación, superficie, año).
  - **Blog (`blog.php` / `articulo.php`)**: listado de artículos y vista individual con contenido HTML, “me gusta” y comentarios.
  - **Contacto (`contacto.php`)**: formulario de contacto, que guarda los mensajes en la tabla `contactos`.

- **Panel de administración**
  - Acceso protegido por login (`admin_login.php` + `includes/admin_auth.php`).
  - Gestión de proyectos (`admin_proyectos.php`): alta, edición, eliminación y subida de imágenes.
  - Gestión de artículos del blog (`admin_blog.php`).
  - Moderación de comentarios (`admin_blog_comentarios.php`): aprobar, desaprobar, eliminar.
  - Gestión de mensajes de contacto (`admin_contactos.php`).

## Tecnologías utilizadas

- **Backend:** PHP (extensión mysqli)
- **Base de datos:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Librerías:**  
  - [Swiper](https://swiperjs.com/) para el carrusel de obras
- **Servidor local de desarrollo:** XAMPP (Apache + MySQL)

---

## Estructura principal del proyecto

```text
Integrador/
├─ index.php
├─ servicios.php
├─ proyectos.php
├─ proyectos_detalle.php
├─ blog.php
├─ articulo.php
├─ contacto.php
├─ admin_*.php         
├─ includes/
│  ├─ config.php        # conexión a la base de datos
│  ├─ header.php      
│  ├─ footer.php        
│  └─ admin_auth.php   
├─ css/
├─ js/
├─ imagenes/
└─ sql/                 # scripts SQL para crear BD y tablas
