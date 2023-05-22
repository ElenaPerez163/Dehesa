//#region FUNCIONES PARA LISTAR Y PAGINAR

//Creo una variable global porque así es más fácil de cambiar
const datosPagina = 10;

function partirListado(datos, pagina) {
  //total del conjunto de datos pasado por parámetro
  let totalDatos = datos.length;

  let paginas = totalDatos / datosPagina; //nº total de páginas
  let datosAnteriores = (pagina - 1) * datosPagina; //último mostrado
  let datosImprimir = datos.slice(
    datosAnteriores,
    datosPagina + datosAnteriores
  ); //registros que se van a imprimir esta vez

  //retornamos el conjunto de datos para luego visualizarlo con visualizarDatos
  return datosImprimir;
}

function cantidadPaginas(datos) {
  let totalDatos = datos.length;
  let paginas = totalDatos / datosPagina;
  return paginas;
}

//aquí deberemos pasar los datos recogidos con la función anterior (partirListado)
function visualizarDatos(datos) {
  if (datos.length == 0) {
    let cadena = `<div class="alert alert-secondary" role="alert">
  <i class="bi bi-info-circle-fill"></i> No existen datos
  </div>`;
    return cadena;
  }

  let cadena = "<div class='table-responsive'>";
  cadena +=
    "<table class='text-start table mt-2 mb-3 px-lg-4 table-striped table-hover table-responsive'>";

  //imprimo los títulos de tabla
  cadena += "<tr class='text-center'>";
  for (clave in datos[0]) {
    cadena += `<th>${clave}</th>`;
  }
  cadena += `<th></th>`;
  cadena += `<th></th>`;
  cadena += `<th></th>`;
  cadena += "<tr>";

  for (let dato of datos) {
    cadena += "<tr>";
    for (let elemento in dato) {
      cadena += "<td>";
      if (dato[elemento] != null) {
        cadena += dato[elemento];
      }
      cadena += "</td>";
    }
    cadena +=
      "<td><i class='bi bi-pencil-square btnModificar fs-5' title='modificar animal' style='color: #1f5034; cursor:pointer;'></i></td>";
    cadena +=
      "<td><i class='bi bi-card-text btnDetalles fs-5' title='detalles animal' style='color: #1f5034; cursor:pointer;'></i></td>";
    cadena +=
      "<td><i class='bi bi-x-circle-fill btnBorrar fs-5' title='borrar animal' style='color: #c54444; cursor:pointer;'></i></td>";

    cadena += "</tr>";
  }

  cadena += "</table>";
  cadena += "</div>";

  //devolvemos la cadena que queremos visualizar para insertarla donde toque
  return cadena;
}

//aquí deberemos pasar los datos recogidos con la función anterior (partirListado)
function visualizarConMover(datos) {
  if (datos.length == 0) {
    let cadena = `<div class="alert alert-secondary" role="alert">
   <i class="bi bi-info-circle-fill"></i> No existen datos
   </div>`;
    return cadena;
  }

  let cadena = "<div class='table-responsive'>";
  cadena +=
    "<table class='table mt-2 mb-3 table-striped table-hover table-responsive'>";

  //imprimo los títulos de tabla
  cadena += "<tr>";
  for (clave in datos[0]) {
    cadena += `<th>${clave}</th>`;
  }
  cadena += `<th></th>`;
  cadena += `<th></th>`;
  cadena += "<tr>";

  for (let dato of datos) {
    cadena += "<tr>";
    for (let elemento in dato) {
      cadena += "<td>";
      if (dato[elemento] != null) {
        cadena += dato[elemento];
      }
      cadena += "</td>";
    }

    cadena +=
      "<td><i class='bi bi-card-text btnDetalles fs-5' title='detalles animal' style='color: #1f5034; cursor:pointer;'></i></td>";
    cadena +=
      "<td><i class='bi bi-arrows-move btnMover fs-5' title='mover animal' draggable='true' style='color: #1f5034; cursor:pointer; font-size:1.2em;'></i></td>";
    cadena += "</tr>";
  }

  cadena += "</table>";
  cadena += "</div>";

  //devolvemos la cadena que queremos visualizar para insertarla donde toque
  return cadena;
}

//aquí deberemos pasar los datos recogidos con la función anterior (partirListado) -> opción para listado de facturas
function visualizarFacturas(datos) {
  if (datos.length == 0) {
    let cadena = `<div class="alert alert-secondary" role="alert">
  <i class="bi bi-info-circle-fill"></i> No existen datos
  </div>`;
    return cadena;
  }

  let cadena = "<div class='table-responsive'>";
  cadena +=
    "<table class='text-start table mt-2 mb-3 px-lg-4 table-striped table-hover table-responsive'>";

  //imprimo los títulos de tabla
  cadena += "<tr class='text-center'>";
  for (clave in datos[0]) {
    cadena += `<th>${clave}</th>`;
  }
  cadena += `<th></th>`;
  cadena += `<th></th>`;
  cadena += `<th></th>`;
  cadena += "<tr>";

  for (let dato of datos) {
    cadena += "<tr>";
    for (let elemento in dato) {
      cadena += "<td>";
      if (dato[elemento] != null) {
        cadena += dato[elemento];
      }
      cadena += "</td>";
    }
    cadena +=
      "<td><i class='bi bi-filetype-pdf btnPDF fs-5' title='factura pdf' style='color: #1f5034; cursor:pointer;'></i></td>";
    cadena +=
      "<td><i class='bi bi-card-text btnDetalles fs-5' title='detalles factura' style='color: #1f5034; cursor:pointer;'></i></td>";
    cadena +=
      "<td><i class='bi bi-x-circle-fill btnBorrar fs-5' title='borrar factura' style='color: #c54444; cursor:pointer;'></i></td>";

    cadena += "</tr>";
  }

  cadena += "</table>";
  cadena += "</div>";

  //devolvemos la cadena que queremos visualizar para insertarla donde toque
  return cadena;
}

//**** IMPRIMIR BOTONES DE PAGINACIÓN ****//
function imprimirBotones(paginas) {
  if (paginas == 0) {
    return "";
  }

  //CREO LOS BOTONES
  let cadena = `<nav aria-label="paginacion">
      <ul class="pagination justify-content-center flex-wrap">
        <li class="page-item">
          <a class="page-link anterior" aria-label="Anterior">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>`;

  let activo = "";
  for (let indice = 0; indice < paginas; indice++) {
    if (indice == 0) {
      activo = "active";
    } else {
      activo = "";
    }
    cadena += ` <li class="page-item ${activo}" aria-current="page"><a data-pagina=${
      indice + 1
    } class="page-link numeroPag" >${indice + 1}</a></li>`;
  }

  cadena += `
        <li class="page-item">
          <a class="page-link siguiente"  aria-label="Siguiente">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
      </nav>`;

  return cadena; //devuelvo la cadena para insertarla donde corresponda
}

//#endregion

//#region   FUNCIONES PARA MOSTRAR DETALLES

//funcion para listar detalles de algo por parejas clave-valor
function listarDetalles(datos) {
  cadena = "<table class='table'>";
  for (clave in datos) {
    cadena += "<tr>";
    cadena += `<td class="tablaTitulo table-light">${clave}</td>`;
    if (datos[clave] != null) {
      cadena += `<td>${datos[clave]}</td>`;
    } else {
      cadena += `<td>Sin datos</td>`;
    }
    cadena += "</tr>";
  }
  cadena += "</table>";

  return cadena;
}

//función para cuando en los detalles de algo puede haber más de una fila
function listarFilas(datos) {
  cadena = "";
  if (datos.length > 0) {
    //imprimo los títulos de tabla
    cadena += "<table class='table'>";
    cadena += "<tr>";
    for (clave in datos[0]) {
      cadena += `<th>${clave}</th>`;
    }
    cadena += "<tr>";

    for (dato of datos) {
      cadena += "<tr>";
      for (clave in dato) {
        cadena += `<td>${dato[clave]}</td>`;
      }
      cadena += "</tr>";
    }
    cadena += "</table>";
  } else {
    cadena += `<div class="alert alert-secondary" role="alert">
    <i class="bi bi-info-circle-fill"></i> No existen datos
    </div>`;
  }

  return cadena;
}

//#endregion
