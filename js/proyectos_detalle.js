document.addEventListener('DOMContentLoaded', function () {
  // Se busca el contenedor del detalle del proyecto
  const tarjeta = document.querySelector('.proyecto-detalle');
  if (!tarjeta) return;

  const imagenPrincipal = tarjeta.querySelector('.detalle-media > img');
  const miniaturas = tarjeta.querySelectorAll('.miniaturas img');

  if (!imagenPrincipal || !miniaturas.length) return;

  miniaturas.forEach((miniatura) => {
    miniatura.addEventListener('click', () => {
      // Cambiar src (y alt) de la imagen principal
      imagenPrincipal.src = miniatura.src;
      const alt = miniatura.getAttribute('alt') || '';
      if (alt) imagenPrincipal.alt = alt;

      miniaturas.forEach(m => m.classList.remove('activo'));
      miniatura.classList.add('activo');
    });
  });
});
