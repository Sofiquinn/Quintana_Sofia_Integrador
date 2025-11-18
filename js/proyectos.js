document.addEventListener('DOMContentLoaded', () => {
  // Botones de filtro (Todos, Residencial, Comercial, etc.)
  const botonesFiltro = document.querySelectorAll('.btn-filtro');
  // Tarjetas de proyectos
  const itemsProyecto = document.querySelectorAll('.proyecto-item');

  // Función que muestra/oculta proyectos según la categoría
  function filtrarProyectos(categoria) {
    itemsProyecto.forEach(item => {
      // data-category viene de proyectos.php (tipo_slug)
      const categoriaItem = item.dataset.category;
      // Mostrar si es "all" o si coincide la categoría
      const mostrar = categoria === 'all' || categoriaItem === categoria;

      if (mostrar) {
        // Se vuelve a mostrar el proyecto
        item.style.display = 'block'; 
        item.classList.add('filtrar-entrar'); 
        setTimeout(() => item.classList.remove('filtrar-entrar'), 500);
      } else {
        // Animación de salida antes de ocultar
        item.classList.add('filtrar-salir');
        setTimeout(() => {
          item.style.display = 'none';
          item.classList.remove('filtrar-salir');
        }, 300);
      }
    });
  }

  // Asignar click a cada botón de filtro
  botonesFiltro.forEach(btn => {
    btn.addEventListener('click', () => {
      // Sacar la clase "activo" de todos y ponérsela al botón clickeado
      botonesFiltro.forEach(b => b.classList.remove('activo'));
      btn.classList.add('activo');

      // Leer la categoría desde data-filter y aplicar el filtro
      const categoria = btn.getAttribute('data-filter');
      filtrarProyectos(categoria);
    });
  });
});
