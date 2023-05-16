let paginaAnimales = 1;

//OPCIONES INICIALES DE FILTRADO
let opciones = {
  crotal: "",
  crotalMadre: "",
  raza: 0,
  grupo: 0,
  desde: "1990-01-01",
  hasta: "3000-01-01",
};

//#region GENERAR EL LISTADO DE ANIMALES Y SUS MANEJADORES DE EVENTOS
traerListado(opciones, paginaAnimales);

//*******      FUNCIÓN QUE GENERA EL LISTADO Y SUS MANEJADORES DE EVENTOS      *******/
function traerListado(opciones, paginaAnimales = 1) {
  $.post(base_url + "Bovido_c/listado", opciones, function (datos) {
    animales = JSON.parse(datos);
    let animalesMostrar = partirListado(animales.animales, paginaAnimales); //partimos
    let cadena = visualizarDatos(animalesMostrar); //recogemos html
    $("#listadoAnimales").html(cadena); //insertamos

    //generar botones de paginación
    let paginas = cantidadPaginas(animales.animales);
    let botones = imprimirBotones(paginas);
    $("#paginacionAnimales").html(botones);
    manejadoresByM();

    //NOTA: LOS MANEJADORES DE EVENTOS SE GENERAN AQUÍ PARA ASEGURAR QUE LOS ELEMENTOS A LOS QUE SE APLICAN EXISTEN EN EL DOM

    //********     MANEJADORES PAGINACIÓN    ********/

    $(".anterior").on("click", function (evento) {
      if (paginaAnimales > 1) {
        paginaAnimales--;
        let animalesMostrar = partirListado(animales.animales, paginaAnimales); //partimos
        let cadena = visualizarDatos(animalesMostrar); //recogemos html
        $("#listadoAnimales").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".siguiente").on("click", function (evento) {
      if (paginaAnimales < paginas) {
        paginaAnimales++;
        let animalesMostrar = partirListado(animales.animales, paginaAnimales); //partimos
        let cadena = visualizarDatos(animalesMostrar); //recogemos html
        $("#listadoAnimales").html(cadena); //insertamos
        manejadoresByM();
      }
    });

    $(".numeroPag").on("click", function (evento) {
      paginaAnimales = $(this).data("pagina");
      $("nav").find(".active").removeClass("active").removeAttr("aria-current");
      $(this).parent().addClass("active").attr("aria-current", "page");
      let animalesMostrar = partirListado(animales.animales, paginaAnimales); //partimos
      let cadena = visualizarDatos(animalesMostrar); //recogemos html
      $("#listadoAnimales").html(cadena); //insertamos
      manejadoresByM();
    });
  });
}

//********     MANEJADORES BORRAR Y EDITAR    ********//
function manejadoresByM() {
  //EVENTO BORRAR
  $("#listadoAnimales .btnBorrar").on("click", function (evento) {
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
        let crotal = $(this).parents("tr").children("td").eq(0).html();
        datos = { crotalAnimal: crotal };
        $.post(base_url + "Bovido_c/borrar", datos, function (datos) {
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

  //EVENTO MODIFICAR
  $("#listadoAnimales .btnModificar").on("click", function (evento) {
    //obtener referencia del artículo
    let crotalAnimal = $(this).parents("tr").children("td").eq(0).html();

    //leer mediante ajax el registro del artículo
    $.post(
      base_url + "Bovido_c/leerAnimal",
      { crotal: crotalAnimal },
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);

        let animal = datos["animal"];
        let parto = datos["parto"];

        //primero asigno los datos del animal
        for (let indice in animal) {
          if (indice == "causaAlta") {
            $("#parto").attr(
              "checked",
              animal[indice] == "Nacimiento" ? true : false
            );
          } else {
            document.formAnimales[indice].value = animal[indice];
          }
        }

        //si el animal ha nacido en la explotación, los del parto
        if (parto) {
          if (parto["esAsistido"] == 1) {
            $("#animAsistido").attr("checked", true);
          }
          document.formAnimales["observaciones"].value = parto["observaciones"];
        }

        document.formAnimales.action = base_url + "Bovido_c/modificar";
        $("#modalAltaModAnimal").html("Modificar Animal");
        document.formAnimales.crotal.disabled = true;

        const miModal = new bootstrap.Modal("#animalesModal");
        miModal.show();
      }
    );
  });

  //EVENTO MOSTRAR DETALLES
  $("#listadoAnimales .btnDetalles").on("click", function (evento) {
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
}

//#endregion

//#region VALIDACIONES AÑADIR

//comprobar que el crotal no existe
$(document.formAnimales.crotal).on("blur", function (evento) {
  if (this.value.length > 0) {
    let crotalIntroducido = this.value;
    $.post(
      base_url + "Bovido_c/existe",
      { crotal: crotalIntroducido },
      function (datos) {
        if (datos == "1") {
          //es true, así que existe
          document.formAnimales.crotal.classList.add("is-invalid");
          document.formAnimales.crotal.classList.add("no-valido");
        } else {
          //es false, así que no existe
          document.formAnimales.crotal.classList.remove("is-invalid");
          document.formAnimales.crotal.classList.remove("no-valido");
        }
      }
    );
  }
});

// Producir validacion
$(document.formAnimales).on("submit", function (evento) {
  evento.preventDefault();
  // Ver validación
  if (!this.checkValidity()) {
    this.classList.add("was-validated");
  } else {
    if ($(".no-valido").length == 0) this.submit();
  }
});

$("#btnNuevoAnimal").on("click", function (evento) {
  document.formAnimales.reset();
  document.formAnimales.crotal.disabled = false;
});

$("#animalesModal").on("shown.bs.modal", function (evento) {
  document.formAnimales.crotal.focus();
});

//#endregion

//#region FILTROS
$("#crotal").on("change", function (evento) {
  let datoQuequiero = $("#crotal").val();
  let dato2 = $("#crotalMadre").val();
  let objeto = { dato: datoQuequiero, otroDato: dato2 };
  $.post(base_url + "Bovido_c/leerDatos", objeto, function (datos) {
    if (datos == true) {
      //
    }
  });
  filtrarAnimales();
});

$("#crotalMadre").on("change", function (evento) {
  filtrarAnimales();
});

$("#raza").on("change", function (evento) {
  filtrarAnimales();
});

$("#finca").on("change", function (evento) {
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
    crotalMadre: $("#crotalMadre").val(),
    raza: parseInt($("#raza").val()),
    grupo: parseInt($("#finca").val()),
    desde: $("#desde").val(),
    hasta: $("#hasta").val(),
  };

  if (isNaN(opciones["raza"])) opciones["raza"] = 0;
  if (isNaN(opciones["grupo"])) opciones["grupo"] = 0;

  if (!opciones["desde"]) opciones["desde"] = "1990-01-01";
  if (!opciones["hasta"]) opciones["hasta"] = "3000-01-01";

  paginaAnimales = 1;
  traerListado(opciones, paginaAnimales);
}

//#endregion
