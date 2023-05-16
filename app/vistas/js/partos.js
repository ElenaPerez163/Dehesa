let paginaPartos = 1;

//OPCIONES INICIALES DE FILTRADO
let opcionesPartos = {
  crotal: "",
  crotalMadre: "",
  asistido: 0,
  desde: "1990-01-01",
  hasta: "3000-01-01",
};

//#region  GENERAR LISTADO Y MANEJADORES

traerPartos(opcionesPartos, paginaPartos);

function traerPartos(opcionesPartos, paginaPartos = 1) {
  $.post(base_url + "Parto_c/listado", opcionesPartos, function (datos) {
    partos = JSON.parse(datos);
    let partosMostrar = partirListado(partos.partos, paginaPartos); //partimos
    let cadena = visualizarDatos(partosMostrar); //recogemos html
    $("#listadoPartos").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(partos.partos);
    let botones = imprimirBotones(paginas);
    $("#paginacionPartos").html(botones);
    manejadoresByMpartos();
    if ($("#listadoPartos .btnModificar"))
      $("#listadoPartos .btnModificar").remove();

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaPartos > 1) {
        paginaPartos--;
        let partosMostrar = partirListado(partos.partos, paginaPartos); //partimos
        let cadena = visualizarDatos(partosMostrar); //recogemos html
        $("#listadoPartos").html(cadena); //insertamos
        if ($("#listadoPartos .btnModificar"))
          $("#listadoPartos .btnModificar").remove();
        manejadoresByMpartos();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaPartos < paginas) {
        paginaPartos++;
        let partosMostrar = partirListado(partos.partos, paginaPartos); //partimos
        let cadena = visualizarDatos(partosMostrar); //recogemos html
        $("#listadoPartos").html(cadena); //insertamos
        if ($("#listadoPartos .btnModificar"))
          $("#listadoPartos .btnModificar").remove();
        manejadoresByMpartos();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaPartos = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");
      let partosMostrar = partirListado(partos.partos, paginaPartos); //partimos
      let cadena = visualizarDatos(partosMostrar); //recogemos html
      $("#listadoPartos").html(cadena); //insertamos
      if ($("#listadoPartos .btnModificar"))
        $("#listadoPartos .btnModificar").remove();
      manejadoresByMpartos();
    });
  });
}

//#endregion

//#region MANEJADORES BOTONES FILAS

//********     MANEJADORES BORRAR Y EDITAR    ********//
function manejadoresByMpartos() {
  //EVENTO BORRAR
  $("#listadoPartos .btnBorrar").on("click", function (evento) {
    Swal.fire({
      title: "¿Estás seguro?",
      text: "Esta acción es irreversible",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#1f5034",
      cancelButtonColor: " #c54444",
      confirmButtonText: "Sí, borrar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        //BORRAR PARTO
        let crotal = $(this).parents("tr").children("td").eq(2).html();
        datos = { crotalAnimal: crotal };
        $.post(base_url + "Parto_c/borrar", datos, function (datos) {
          Swal.fire({
            title: "¡Eliminado!",
            confirmButtonColor: "#1f5034",
          }).then((result2) => {
            if (result.isConfirmed) {
              location.href = base_url + "Bovido_c/index";
            }
          });
        });
      }
    });
  });

  //EVENTO MOSTRAR DETALLES
  $("#listadoPartos .btnDetalles").on("click", function (evento) {
    //obtener referencia del artículo
    let crotalTernero = $(this).parents("tr").children("td").eq(2).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Parto_c/leerDatos",
      { crotal: crotalTernero },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);

        //  LLAMAR A UN MÉTODO QUE REALICE EL LISTADO CON LAS PAREJAS CLAVE-VALOR
        let detAnimal = listarDetalles(datos["parto"]);
        $("#tablaDetallesParto").html(detAnimal);

        let partosAnimal = listarFilas(datos["otrosPartos"]);
        $("#detallesOtrosPartos").html(partosAnimal);

        const miModal = new bootstrap.Modal("#detallesPartosModal");
        miModal.show();
      }
    );
  });
}

//#endregion

//#region FILTROS
$("#partoCrotal").on("change", function (evento) {
  filtrarListado();
});

$("#partoCrotalMadre").on("change", function (evento) {
  filtrarListado();
});

$("#asistido").on("click", function (evento) {
  filtrarListado();
});

$("#partoDesde").on("change", function (evento) {
  filtrarListado();
});

$("#partoHasta").on("change", function (evento) {
  filtrarListado();
});

function filtrarListado() {
  opcionesPartos = {
    crotal: $("#partoCrotal").val(),
    crotalMadre: $("#partoCrotalMadre").val(),
    asistido: $("#asistido").prop("checked") ? 1 : 0,
    desde: $("#partoDesde").val(),
    hasta: $("#partoHasta").val(),
  };

  if (!opcionesPartos["desde"]) opcionesPartos["desde"] = "1990-01-01";
  if (!opcionesPartos["hasta"]) opcionesPartos["hasta"] = "3000-01-01";

  paginaPartos = 1;
  traerPartos(opcionesPartos, paginaPartos);
}

//#endregion
