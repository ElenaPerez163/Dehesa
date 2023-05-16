//RECOGER DATOS DE LOCALSTORAGE SI HAY
window.addEventListener("load", function (evento) {
  let usuario = localStorage["usuario"];
  let password = localStorage["password"];
  if (usuario) {
    document.formLogin.usuario.value = usuario;
    document.formLogin.password.value = password;
  }
});

//INTERCEPTAR EL SUBMIT Y  VALIDAR
document.addEventListener("submit", function (evento) {
  //prevenir envío de formulario (evitar que se envíe, vaya)
  evento.preventDefault();

  //validacion
  if (document.formLogin.recuerdame.value == true) {
    //guardar una cookie con el usuario y con el password
    localStorage.usuario = document.formLogin.usuario.value;
    localStorage.password = document.formLogin.password.value;
  } else {
    localStorage.removeItem("usuario");
    localStorage.removeItem("password");
  }

  if (
    document.formLogin.usuario.value.length > 0 &&
    document.formLogin.password.value.length > 0
  ) {
    //ahora sí enviamos el formulario
    document.formLogin.submit();
  } else {
    document.formLogin.classList.add("was-validated");
  }
});
