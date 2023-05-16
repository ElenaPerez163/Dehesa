//#region RESUMEN PARCELAS
traerParcelas();

//recojo los datos que necesito para mostrarlos
function traerParcelas() {
  $.post(base_url + "Fincas_c/generarFichas", function (datos) {
    visualizarParcelas(JSON.parse(datos));
  });
}

//muestro cada parcela en un card que servirá luego para hacer drop en él
function visualizarParcelas(parcelas) {
  let cadena = "";

  for (let parcela of parcelas) {
    let clase = "";
    if (parcela["grupo"] == 6) {
      clase = "btnPeligro";
    } else {
      clase = "bg-primary";
    }
    cadena += `<div class="card text-center mx-1 mb-2" style="width: 12rem;">
    <div class="cardDrag card-body"  data-grupo="${parcela["grupo"]}" >
      <h5 class="card-title titulo4">${parcela["finca"]}&nbsp;&nbsp;</h5>
      <div class="badge rounded-pill p-2 px-3 fs-4 ${clase}">${parcela["cantidad"]}</div>
     
      <table class="table table-sm text-start">
            <tr>
                <td>Nodrizas</td>
                <td>${parcela["nodrizas"]}</td>
            </tr>
            <tr>
                <td>Novillas</td>
                <td>${parcela["novillas"]}</td>
            </tr>
            <tr>
                <td>Toros</td>
                <td>${parcela["toros"]}</td>
            </tr>
            <tr>
                <td>Terneros</td>
                <td>${parcela["terneros"]}</td>
            </tr>
        </table>
        <form name="formGrupo" action="${base_url}Fincas_c/detallesParcelas" method="post">
        <input type="hidden" name="grupo" value="${parcela["grupo"]}">
      <button type="submit" href="#" class="btn mt-2 btnOscuro px-4" data-grupo="${parcela["grupo"]}">Cargar</button>
      </form>
    </div>
    </div>`;
  }

  $("#parcelas").html(cadena);

  // **** EN ESTOS CARDS SE PODRÁ HACER DROP PARA CAMBIAR GRUPO DE UN ANIMAL **** //

  //GENERO AQUÍ EVENTOS DRAG AND DROP PARA ASEGURARME DE QUE LOS CARDS EXISTEN
  $(".cardDrag").on("dragover", function (evento) {
    evento.preventDefault();
  });

  $(".cardDrag").on("drop", function (evento) {
    let crotalAnimal = evento.originalEvent.dataTransfer.getData("crotal");

    let grupoActual = $(this).data("grupo");
    let datos = {
      crotal: crotalAnimal,
      grupo: grupoActual,
    };

    $.post(base_url + "Fincas_c/cambiarGrupo", datos, function (datos) {
      location.href = base_url + "Fincas_c/detallesParcelas";
    });
  });
}

//#endregion

//#region LISTADO DETALLES PARCELAS
let paginaParcelas = 1;

//filtro de búsqueda inicial
let opciones = {
  crotal: "", //aunque solo sea uno, lo hago como en las demás vistas para que sea ampliable
  grupo: $("#detParcelas").data("grupo"),
};

traerListado(opciones, paginaParcelas);

//*******      FUNCIÓN QUE GENERA EL LISTADO Y SUS MANEJADORES DE EVENTOS     ******* //
function traerListado(opciones, paginaParcelas = 1) {
  $.post(base_url + "Fincas_c/listado", opciones, function (datos) {
    animales = JSON.parse(datos);
    let fincaMostrar = partirListado(animales.finca, paginaParcelas); //partimos
    let cadena = visualizarConMover(fincaMostrar); //recogemos html

    $("#listadoPorParcela").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(animales.finca);
    let botones = imprimirBotones(paginas);

    $("#paginacionPorParcela").html(botones);
    manejadoresListado();

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaParcelas > 1) {
        paginaParcelas--;
        let fincaMostrar = partirListado(animales.finca, paginaParcelas); //partimos
        let cadena = visualizarConMover(fincaMostrar); //recogemos html

        $("#listadoPorParcela").html(cadena); //insertamos
        manejadoresListado();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaParcelas < paginas) {
        paginaParcelas++;
        let fincaMostrar = partirListado(animales.finca, paginaParcelas); //partimos
        let cadena = visualizarConMover(fincaMostrar); //recogemos html

        $("#listadoPorParcela").html(cadena); //insertamos
        manejadoresListado();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaParcelas = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");

      let fincaMostrar = partirListado(animales.finca, paginaParcelas); //partimos
      let cadena = visualizarConMover(fincaMostrar); //recogemos html

      $("#listadoPorParcela").html(cadena); //insertamos
      manejadoresListado();
    });
  });
}

//#endregion

//#region MANEJADORES LISTADO: DETALLES Y DRAGSTART

function manejadoresListado() {
  //EVENTO MOSTRAR DETALLES
  $("#listadoPorParcela .btnDetalles").on("click", function (evento) {
    //obtener referencia del artículo
    let crotalAnimal = $(this).parents("tr").children("td").eq(0).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Bovido_c/leerDatos",
      { crotal: crotalAnimal },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);

        //  LLAMAR A UN MÉTODO QUE REALICE EL LISTADO CON LAS PAREJAS CLAVE-VALOR
        let detAnimal = listarDetalles(datos["animal"]);
        $("#tablaDetalles").html(detAnimal);

        let partosAnimal = listarFilas(datos["partos"]);
        $("#detallesAnPar").html(partosAnimal);

        let incidenciasAnimal = listarFilas(datos["incidencias"]);

        $("#detallesAnInc").html(incidenciasAnimal);

        const miModal = new bootstrap.Modal("#detallesAnimalesModal");
        miModal.show();
      }
    );
  });

  const img = new Image();
  img.src = base_url + "app/assets/img/OscuroNoGB.png";
  // **** MANEJADOR DRAG AND DROP **** //
  $(".btnMover").on("dragstart", function (evento) {
    let crotalAnimal = $(this).parents("tr").children("td").eq(0).html();
    evento.originalEvent.dataTransfer.setData("crotal", crotalAnimal);
  });
}
//#endregion

//#region FILTROS
$("#crotal").on("change", function (evento) {
  filtrarAnimales();
});

function filtrarAnimales() {
  opciones = {
    crotal: $("#crotal").val(),
    grupo: $("#detParcelas").data("grupo"),
  };

  paginaParcelas = 1;
  traerListado(opciones, paginaParcelas);
}

//#endregion
