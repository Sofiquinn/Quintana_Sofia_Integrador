document.addEventListener('DOMContentLoaded', function () {
  // Se busca el formulario solo en la página de contacto
  const formulario = document.getElementById('formulario-contacto');
  if (!formulario) return; 

  const btnEnviar = document.getElementById('btn-enviar');
  const estado = document.getElementById('estado-formulario');

  // Helper rápido para obtener elementos por id
  const $ = (id) => document.getElementById(id);

  // Campos del formulario
  const campos = {
    nombre: $('nombre'),
    email: $('email'),
    telefono: $('telefono'),
    mensaje: $('mensaje'),
  };

  // Elementos <small> donde se muestra errores
  const errores = {
    nombre: $('err-nombre'),
    email: $('err-email'),
    telefono: $('err-telefono'),
    mensaje: $('err-mensaje'),
  };

  // Validación básica de email
  const esEmailValido = (email) =>
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(String(email).toLowerCase());

  // Validación básica de teléfono (mínimo 8 dígitos)
  const esTelefonoValido = (telefono) => {
    const digitos = telefono.replace(/\D/g, '');
    return digitos.length >= 8;
  };

  // Marca campo con error y muestra mensaje
  function marcarError(input, msgEl, mensaje) {
    input.classList.add('error');
    if (msgEl) msgEl.textContent = mensaje || '';
  }

  // Limpia el error visual y el texto
  function limpiarError(input, msgEl) {
    input.classList.remove('error');
    if (msgEl) msgEl.textContent = '';
  }

  // Se valida todos los campos y devuelve true/false
  function validar() {
    let ok = true;

    // Nombre
    if (!campos.nombre.value.trim()) {
      marcarError(campos.nombre, errores.nombre, 'El nombre es obligatorio.');
      ok = false;
    } else {
      limpiarError(campos.nombre, errores.nombre);
    }

    // Email
    if (!campos.email.value.trim()) {
      marcarError(campos.email, errores.email, 'El email es obligatorio.');
      ok = false;
    } else if (!esEmailValido(campos.email.value)) {
      marcarError(campos.email, errores.email, 'Ingresá un email válido.');
      ok = false;
    } else {
      limpiarError(campos.email, errores.email);
    }

    // Teléfono
    if (!campos.telefono.value.trim()) {
      marcarError(campos.telefono, errores.telefono, 'El teléfono es obligatorio.');
      ok = false;
    } else if (!esTelefonoValido(campos.telefono.value)) {
      marcarError(campos.telefono, errores.telefono, 'Ingresá un teléfono válido.');
      ok = false;
    } else {
      limpiarError(campos.telefono, errores.telefono);
    }

    // Mensaje
    if (!campos.mensaje.value.trim()) {
      marcarError(campos.mensaje, errores.mensaje, 'El mensaje es obligatorio.');
      ok = false;
    } else {
      limpiarError(campos.mensaje, errores.mensaje);
    }

    return ok;
  }

  Object.values(campos).forEach((input) => {
    // Al salir del campo, se valida todo 
    input.addEventListener('blur', validar);

    // Al escribir, se limpia el error de ese campo y el estado general
    input.addEventListener('input', () => {
      const clave = input.id;
      limpiarError(input, errores[clave]);
      if (estado) estado.textContent = '';
    });
  });

  // Envío del formulario
  formulario.addEventListener('submit', function (e) {
    if (estado) estado.textContent = '';

    // Se valida primero del lado del cliente
    if (!validar()) {
      // Solo se frena el envío si hay errores
      e.preventDefault();
      if (estado) estado.textContent = 'Revisá los campos marcados en rojo.';
      return;
    }

    // Si todo está bien, se deja que se envíe al servidor
    if (btnEnviar) {
      btnEnviar.disabled = true;
      btnEnviar.textContent = 'Enviando...';
    }
    // El navegador hace el POST a contacto.php y la página se recarga
  });
});
