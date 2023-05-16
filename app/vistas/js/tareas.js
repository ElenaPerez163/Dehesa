let paginaTareas = 1;

//OPCIONES INICIALES DE FILTRADO
let opciones = {
  nombre: "",
  descripcion: "",
  desde: "1990-01-01",
  hasta: "3000-01-01",
};

traerListado(opciones, paginaTareas);

//#region GENERAR EL LISTADO

//*******      FUNCIÓN QUE GENERA EL LISTADO Y SUS MANEJADORES DE EVENTOS      *******/
function traerListado(opciones, paginaTareas = 1) {
  $.post(base_url + "Tareas_c/listado", opciones, function (datos) {
    tareas = JSON.parse(datos);
    let tareasMostrar = partirListado(tareas.tareas, paginaTareas); //partimos
    let cadena = visualizarDatos(tareasMostrar); //recogemos html
    $("#listadoTareas").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(tareas.tareas);
    let botones = imprimirBotones(paginas);
    $("#paginacionTareas").html(botones);
    manejadoresByM();

    //NOTA: LOS MANEJADORES DE EVENTOS SE GENERAN AQUÍ PARA ASEGURAR QUE LOS ELEMENTOS A LOS QUE SE APLICAN EXISTEN EN EL DOM

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaTareas > 1) {
        paginaTareas--;
        let tareasMostrar = partirListado(tareas.tareas, paginaTareas); //partimos
        let cadena = visualizarDatos(tareasMostrar); //recogemos html
        $("#listadoTareas").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaTareas < paginas) {
        paginaTareas++;
        let tareasMostrar = partirListado(tareas.tareas, paginaTareas); //partimos
        let cadena = visualizarDatos(tareasMostrar); //recogemos html
        $("#listadoTareas").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaTareas = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");
      let tareasMostrar = partirListado(tareas.tareas, paginaTareas); //partimos
      let cadena = visualizarDatos(tareasMostrar); //recogemos html
      $("#listadoTareas").html(cadena); //insertamos
      manejadoresByM();
    });
  });
}

//#endregion

//#region FILTROS
$("#nombre").on("change", function (evento) {
  filtrarTareas();
});

$("#descripcion").on("change", function (evento) {
  filtrarTareas();
});

$("#desde").on("change", function (evento) {
  filtrarTareas();
});

$("#hasta").on("change", function (evento) {
  filtrarTareas();
});

//función para filtrar
function filtrarTareas() {
  opciones = {
    nombre: $("#nombre").val(),
    descripcion: $("#descripcion").val(),
    desde: $("#desde").val(),
    hasta: $("#hasta").val(),
  };

  if (!opciones["desde"]) opciones["desde"] = "1990-01-01";
  if (!opciones["hasta"]) opciones["hasta"] = "3000-01-01";

  paginaTareas = 1;
  traerListado(opciones, paginaTareas);
}

//#endregion

//#region MENEJADORES BORRAR, MODIFICAR Y DETALLES

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
        let id = $(this).parents("tr").children("td").eq(0).html();
        datos = { idTarea: id };
        $.post(base_url + "Tareas_c/borrar", datos, function (datos) {
          Swal.fire({
            title: "¡Eliminado!",
            confirmButtonColor: "#1f5034",
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = base_url + "Tareas_c/index";
            }
          });
        });
      }
    });
  });


  //EVENTO MODIFICAR
  $(".btnModificar").on("click", function (evento) {
    //obtener referencia del artículo
    let id = $(this).parents("tr").children("td").eq(0).html();

    //leer mediante ajax el registro del artículo
    $.post(base_url + "Tareas_c/leerTarea", { idTarea: id }, function (datos) {
      //cargar todos los valores de los campos del formulario con los datos recibidos
      let tarea = JSON.parse(datos);

      for (let indice in tarea) {
        document.formTareas[indice].value = tarea[indice];
      }

      document.formTareas.action = base_url + "Tareas_c/modificar";
      $("#labelModalTareas").html("Modificar Tarea");

      const miModal = new bootstrap.Modal("#tareasModal");
      miModal.show();
    });
  });

  //EVENTO MOSTRAR DETALLES
  $(".btnDetalles").on("click", function (evento) {
    //obtener referencia del artículo
    let codigoTar = $(this).parents("tr").children("td").eq(0).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Tareas_c/leerDatos",
      { codigo: codigoTar },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);

        //  LLAMAR A UN MÉTODO QUE REALICE EL LISTADO CON LAS PAREJAS CLAVE-VALOR
        let detTarea = listarDetalles(datos["tarea"]);
        $("#tablaDetallesTarea").html(detTarea);

        const miModal = new bootstrap.Modal("#detallesTarModal");
        miModal.show();
      }
    );
  });
}

//#endregion
