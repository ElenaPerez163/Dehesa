 //SETEAR UNA COOKIE
 function setCookie(clave, valor, dias) {
    let expira = "";

    if (dias) {
      //si dias está seteado, si se lo hemos pasado
      let fecha = new Date();
      fecha.setTime(fecha.getTime() + dias * 24 * 60 * 60 * 1000);
      expira = "; expires=" + fecha.toUTCString();
    }
    document.cookie = clave + "=" + (valor || "") + expira + "; path=/";
  }

  //SACAR UNA COOKIE A PARTIR DE SU CLAVE
  function getCookie(clave) {
    let nombre = clave + "=";
    let cadena = document.cookie.split(";");

    for (let cont = 0; cont < cadena.length; cont++) {
      let car = cadena[cont];

      //si encuentra un espacio al principio, lo quitamos
      while (car.charAt(0) == " ") car = car.substring(1, car.length);

      if (car.indexOf(nombre) == 0) {
        return car.substring(nombre.length, car.length);
      }
    }
    return null;
  }

  //BORRAR UNA COOKIE
  function eraseCookie(clave) {
    document.cookie =
      clave + "=; path=/; expires=Thu, 01 Jan 1970 00:00:01GMT;";
  }