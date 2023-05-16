let paginaIncidencias = 1;

//OPCIONES INICIALES DE FILTRADO
let opciones = {
  crotal: "",
  idTipoInc: 0,
  desde: "1990-01-01",
  hasta: "3000-01-01",
};

//#region GENERAR LISTADO Y MANEJADORES
traerListado(opciones, paginaIncidencias);

//*******      FUNCIÓN QUE GENERA EL LISTADO Y SUS MANEJADORES DE EVENTOS      *******/
function traerListado(opciones, paginaIncidencias = 1) {
  $.post(base_url + "Incidencias_c/listado", opciones, function (datos) {
    incidencias = JSON.parse(datos);
    let incidenciasMostrar = partirListado(
      incidencias.incidencias,
      paginaIncidencias
    ); //partimos
    let cadena = visualizarDatos(incidenciasMostrar); //recogemos html
    $("#listadoIncidencias").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(incidencias.incidencias);
    let botones = imprimirBotones(paginas);
    $("#paginacionIncidencias").html(botones);
    manejadoresByM();

    //NOTA: LOS MANEJADORES DE EVENTOS SE GENERAN AQUÍ PARA ASEGURAR QUE LOS ELEMENTOS A LOS QUE SE APLICAN EXISTEN EN EL DOM

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaIncidencias > 1) {
        paginaIncidencias--;

        let incidenciasMostrar = partirListado(
          incidencias.incidencias,
          paginaIncidencias
        ); //partimos

        let cadena = visualizarDatos(incidenciasMostrar); //recogemos html

        $("#listadoincidencias").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaIncidencias < paginas) {
        paginaIncidencias++;

        let incidenciasMostrar = partirListado(
          incidencias.incidencias,
          paginaIncidencias
        ); //partimos

        let cadena = visualizarDatos(incidenciasMostrar); //recogemos html

        $("#listadoincidencias").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaIncidencias = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");
      let incidenciasMostrar = partirListado(
        incidencias.incidencias,
        paginaIncidencias
      ); //partimos
      let cadena = visualizarDatos(incidenciasMostrar); //recogemos html

      $("#listadoincidencias").html(cadena); //insertamos
      manejadoresByM();
    });
  });
}

//#endregion

//#region FILTROS
$("#crotal").on("change", function (evento) {
  filtrarAnimales();
});

$("#idTipoInc").on("change", function (evento) {
  filtrarAnimales();
});

$("#desde").on("change", function (evento) {
  filtrarAnimales();
});

$("#hasta").on("change", function (evento) {
  filtrarAnimales();
});

//función para filtrar
function filtrarAnimales() {
  opciones = {
    crotal: $("#crotal").val(),
    idTipoInc: parseInt($("#idTipoInc").val()),
    desde: $("#desde").val(),
    hasta: $("#hasta").val(),
  };

  if (isNaN(opciones["idTipoInc"])) opciones["idTipoInc"] = 0;

  if (!opciones["desde"]) opciones["desde"] = "1990-01-01";
  if (!opciones["hasta"]) opciones["hasta"] = "3000-01-01";

  paginaIncidencias = 1;
  traerListado(opciones, paginaIncidencias);
}

//#endregion

//#region MANEJADORES BORRAR, MODIFICAR Y DETALLES

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

//#region VALIDACIONES PARA AÑADIR
//EL ANIMAL DEBE EXISTIR EN BBDD
$(document.formIncidencias.crotal).on("blur", function (evento) {
  if (this.value.length > 0) {
    let crotalIntroducido = this.value;
    $.post(
      base_url + "Bovido_c/existe",
      { crotal: crotalIntroducido },
      function (datos) {
        if (datos == "1") {
          //es true, así que existe (debe existir)
          document.formIncidencias.crotal.classList.remove("is-invalid");
          document.formIncidencias.crotal.classList.remove("no-valido");
        } else {
          //es false, así que no existe (debe existir)
          document.formIncidencias.crotal.classList.add("is-invalid");
          document.formIncidencias.crotal.classList.add("no-valido");
        }
      }
    );
  }
});

// Producir validacion
$(document.formIncidencias).on("submit", function (evento) {
  evento.preventDefault();
  // Ver validación
  if (!this.checkValidity()) {
    this.classList.add("was-validated");
  } else {
    if ($(".no-valido").length == 0) this.submit();
  }
});

//#endregion
