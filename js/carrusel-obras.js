document.addEventListener('DOMContentLoaded', function () {
  // Selecciona el elemento principal del carrusel
  const carruselEl = document.querySelector('.carrusel-obras-swiper');
  if (!carruselEl) return;

  // Inicializa la instancia de Swiper sobre el carrusel de obras
  new Swiper('.carrusel-obras-swiper', {
    loop: true,
    speed: 15000,
    allowTouchMove: false,
    slidesPerView: 3.5,
    spaceBetween: 0,
    autoplay: {
      delay: 0,
      disableOnInteraction: false
    },
    // Ajustes responsivos según el ancho de la pantalla
    breakpoints: {
      0: {
        slidesPerView: 1.5
      },
      640: {
        slidesPerView: 2.5
      },
      1024: {
        slidesPerView: 3.5
      }
    }
  });
});
