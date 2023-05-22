let paginaFacturas = 1;

//OPCIONES INICIALES DE FILTRADO
let opciones = {
  numFactura: "",
  idCliente: 0,
  desde: "1990-01-01",
  hasta: "3000-01-01",
};

//#region CREAR LISTADO Y MANEJADORES DE EVENTOS
traerListado(opciones, paginaFacturas);

//*******      FUNCIÓN QUE GENERA EL LISTADO Y SUS MANEJADORES DE EVENTOS      *******/
function traerListado(opciones, paginaFacturas = 1) {
  $.post(base_url + "Facturas_c/listado", opciones, function (datos) {
    facturas = JSON.parse(datos);
    let facturasMostrar = partirListado(facturas.facturas, paginaFacturas); //partimos
    let cadena = visualizarFacturas(facturasMostrar); //recogemos html
    $("#listadofacturas").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(facturas.facturas);
    let botones = imprimirBotones(paginas);
    $("#paginacionfacturas").html(botones);
    manejadoresByM();

    //NOTA: LOS MANEJADORES DE EVENTOS SE GENERAN AQUÍ PARA ASEGURAR QUE LOS ELEMENTOS A LOS QUE SE APLICAN EXISTEN EN EL DOM

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaFacturas > 1) {
        paginaFacturas--;

        let facturasMostrar = partirListado(facturas.facturas, paginaFacturas); //partimos

        let cadena = visualizarFacturas(facturasMostrar); //recogemos html

        $("#listadofacturas").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaFacturas < paginas) {
        paginaFacturas++;

        let facturasMostrar = partirListado(facturas.facturas, paginaFacturas); //partimos

        let cadena = visualizarFacturas(facturasMostrar); //recogemos html

        $("#listadofacturas").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaFacturas = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");
      let facturasMostrar = partirListado(facturas.facturas, paginaFacturas); //partimos
      let cadena = visualizarFacturas(facturasMostrar); //recogemos html

      $("#listadofacturas").html(cadena); //insertamos
      manejadoresByM();
    });
  });
}

//#endregion

//#region MANEJADORES DE EVENTOS BOTONES DEL LISTADO
function manejadoresByM() {
  //evento borrar
  $(".btnBorrar").on("click", function (evento) {
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
        //BORRAR ANIMAL
        let idInc = $(this).parents("tr").children("td").eq(0).html();
        datos = { idIncidencia: idInc };
        $.post(base_url + "Incidencias_c/borrar", datos, function (datos) {
          Swal.fire({
            title: "¡Eliminado!",
            confirmButtonColor: "#1f5034",
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = base_url + "Incidencias_c/index";
            }
          });
        });
      }
    });
  });

  //evento modificar
  //EVENTO MODIFICAR
  $("#listadoIncidencias .btnModificar").on("click", function (evento) {
    //obtener referencia del artículo
    let id = $(this).parents("tr").children("td").eq(0).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Incidencias_c/leerIncidencia",
      { idIncidencia: id },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        let incidencia = JSON.parse(datos);

        /* let inputHidden = document.createElement("input");
          inputHidden.type = "hidden";
          inputHidden.name = "idIncidencia";
          inputHidden.id = "idIncidencia";
          document.formIncidencias.appendChild(inputHidden); */

        for (let indice in incidencia) {
          document.formIncidencias[indice].value = incidencia[indice];
        }

        document.formIncidencias.action = base_url + "Incidencias_c/modificar";
        $("#labelModalIncidencias").html("Modificar Incidencia");

        const miModal = new bootstrap.Modal("#incidenciasModal");
        miModal.show();
      }
    );
  });

  //EVENTO MOSTRAR DETALLES
  $("#listadoIncidencias .btnDetalles").on("click", function (evento) {
    //obtener referencia del artículo
    let codigoInc = $(this).parents("tr").children("td").eq(0).html();
    let crotalInc = $(this).parents("tr").children("td").eq(2).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Incidencias_c/leerDatos",
      { codigo: codigoInc, crotal: crotalInc },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);

        //  LLAMAR A UN MÉTODO QUE REALICE EL LISTADO CON LAS PAREJAS CLAVE-VALOR
        let detAnimal = listarDetalles(datos["incidencia"]);
        $("#tablaDetallesIncidencia").html(detAnimal);

        let partosAnimal = listarFilas(datos["otrasIncidencias"]);
        $("#detallesOtrasIncidencias").html(partosAnimal);

        const miModal = new bootstrap.Modal("#detallesIncModal");
        miModal.show();
      }
    );
  });
}

//#endregion

//#region FILTROS
$("#numFactura").on("change", function (evento) {
  filtrarFacturas();
});

$("#idCliente").on("change", function (evento) {
  filtrarFacturas();
});

$("#desde").on("change", function (evento) {
  filtrarFacturas();
});

$("#hasta").on("change", function (evento) {
  filtrarFacturas();
});

//función para filtrar
function filtrarFacturas() {
  opciones = {
    numFactura: $("#numFactura").val(),
    idCliente: parseInt($("#idCliente").val()),
    desde: $("#desde").val(),
    hasta: $("#hasta").val(),
  };

  if (isNaN(opciones["idCliente"])) opciones["idCliente"] = 0;

  if (!opciones["desde"]) opciones["desde"] = "1990-01-01";
  if (!opciones["hasta"]) opciones["hasta"] = "3000-01-01";

  paginaIncidencias = 1;
  traerListado(opciones, paginaIncidencias);
}

//#endregion
