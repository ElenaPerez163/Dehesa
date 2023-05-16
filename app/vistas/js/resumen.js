//*  RECOGER DATOS MEDIANTE AJAX, 5 ÚLTIMOS REGISTROS DE CADA TABLA DEL RESUMEN  *//
$.post(base_url + "Inicio_c/recogerResumen", function (datos) {
  visualizar(JSON.parse(datos));
});

//VISUALIZAR EL RESUMEN DE CADA TABLA
function visualizar(datos) {
  console.log(datos);
  let cadena = imprimirCards(datos);
  $("#resumen").html(cadena);
}

//GENERAR LOS CARDS
function imprimirCards(datos) {
  let enlace = "";
  cadena = "";
  for (tabla in datos) {
    enlace = asignarEnlace(tabla);
    cadena += `<div class="card mb-2 mx-2" style="width: 25rem;">
    <div class="card-body">
      <h4 class="card-title titulo3">${tabla}</h4>`;

    cadena += imprimir(datos[tabla]);

    cadena += `<a type="button" href="${enlace}" class="btn mt-2 btnMedio px-4">Ver</a>`;
    cadena += `</div></div>`;
  }
  return cadena;
}

//ASIGNAR ENLACES EN FUNCIÓN DEL CARD
function asignarEnlace(tabla) {
  let enlace = "";
  switch (tabla) {
    case "Animales":
      enlace = base_url + "Bovido_c/index";
      break;
    case "Partos":
      enlace = base_url + "Bovido_c/index/partos";
      break;
    case "Incidencias":
      enlace = base_url + "Incidencias_c/index";
      break;
    case "Tareas":
      enlace = base_url + "Tareas_c/index";
      break;
    case "Parcelas":
      enlace = base_url + "Fincas_c/index";
      break;

    default:
      break;
  }

  return enlace;
}

//FUNCIÓN QUE RECOGE LOS DATOS DE CADA TABLA Y CREA EL CONTENIDO
function imprimir(tabla) {
  console.log(tabla);
  cadena = "";
  cadena += "<table class='table table-striped table-hover table-responsive'>";

  //imprimo los títulos de tabla
  cadena += "<tr>";
  for (clave in tabla[0]) {
    cadena += `<th>${clave}</th>`;
  }
  cadena += "<tr>";

  //imprimo las filas de la tabla
  for (fila of tabla) {
    cadena += "<tr>";
    for (elemento in fila) {
      cadena += "<td>";
      if (fila[elemento] != null) {
        cadena += fila[elemento];
      }
      cadena += "</td>";
    }
    cadena += "</tr>";
  }
  cadena += "</table>";
  return cadena;
}

//#region FUNCIÓN MANEJADORES DE EVENTOS

//#endregion
