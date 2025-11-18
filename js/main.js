document.addEventListener('DOMContentLoaded', function () {
  const botonHamburguesa = document.querySelector('.boton-hamburguesa');
  const menuNavegacion = document.querySelector('.nav-menu');
  const enlacesNavegacion = document.querySelectorAll('.nav-link');

  if (botonHamburguesa && menuNavegacion) {
    botonHamburguesa.addEventListener('click', function () {
      botonHamburguesa.classList.toggle('activo');
      menuNavegacion.classList.toggle('activo');

      document.body.classList.toggle('menu-abierto');
    });

    enlacesNavegacion.forEach((enlace) => {
      enlace.addEventListener('click', () => {
        botonHamburguesa.classList.remove('activo');
        menuNavegacion.classList.remove('activo');
        document.body.classList.remove('menu-abierto');
      });
    });
  }

  // Header scroll
  const encabezado = document.querySelector('.header');
  let ultimoScrollTop = 0;

  window.addEventListener('scroll', function () {
    const posicionScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (posicionScroll > 100) {
      encabezado.classList.add('scrolled');
    } else {
      encabezado.classList.remove('scrolled');
    }

    if (posicionScroll > ultimoScrollTop && posicionScroll > 200) {
      encabezado.style.transform = 'translateY(-100%)';
    } else {
      encabezado.style.transform = 'translateY(0)';
    }

    ultimoScrollTop = posicionScroll;
  });

  // Animaciones al desplazar
  const opcionesObservador = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px',
  };

  const observador = new IntersectionObserver(function (entradas) {
    entradas.forEach((entrada) => {
      if (entrada.isIntersecting) {
        entrada.target.classList.add('animated');
      }
    });
  }, opcionesObservador);

  const elementosAnimados = document.querySelectorAll('.animar-al-desplazar');
  elementosAnimados.forEach((el) => observador.observe(el));
});


// Efecto de aclarar/oscurecer la imagen final con el scroll 
document.addEventListener('DOMContentLoaded', function () {
  const seccionFinal = document.querySelector('.seccion-imagen-final');
  if (!seccionFinal) return;

  function actualizarOverlay() {
    const rect = seccionFinal.getBoundingClientRect();
    const vh = window.innerHeight || document.documentElement.clientHeight;

    let progreso = 1 - rect.top / vh;
    progreso = Math.max(0, Math.min(1, progreso));

    const darkness = 0.25 + progreso * 0.5;

    seccionFinal.style.setProperty('--darkness', darkness.toString());
  }

  actualizarOverlay();
  window.addEventListener('scroll', actualizarOverlay);
  window.addEventListener('resize', actualizarOverlay);
});
