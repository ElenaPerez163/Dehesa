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

  //EVENTO BORRAR
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
        let numRecibido = $(this).parents("tr").children("td").eq(0).html();
        datos = { numFactura: numRecibido };
        $.post(base_url + "Facturas_c/borrar", datos, function (datos) {
          Swal.fire({
            title: "¡Eliminado!",
            confirmButtonColor: "#1f5034",
          }).then((result) => {
            if (result.isConfirmed) {
              location.href = base_url + "Facturas_c/index";
            }
          });
        });
      }
    });
  });

  //evento ver PDF
  $(".btnPDF").on("click", function (evento) {
    let numFacturaR = $(this).parents("tr").children("td").eq(0).html();
    console.log(numFacturaR);
    localStorage.numFactura=numFacturaR;
    window.location.href = base_url + "app/vistas/visorPDF_v.php";
  });

  //evento descargar PDF
  $(".btnPDFdesc").on("click", function (evento) {
    console.log("entra");
    let numFacturaR = $(this).parents("tr").children("td").eq(0).html();
    console.log(numFacturaR);
   
    $.post(base_url+"Facturas_c/descargar",{numFactura:numFacturaR},function(datos){
      
      const url =base_url+"app/assets/documentos/"+numFacturaR+".pdf";
      const a = document.createElement('a');
      a.href = url;
      a.download =numFacturaR+".pdf";
      a.click();

    // Limpia el enlace y libera recursos
    URL.revokeObjectURL(url);
    console.log("descargado"); 
    });
  });

  

  //EVENTO MOSTRAR DETALLES
  $("#listadofacturas .btnDetalles").on("click", function (evento) {
    //obtener número de factura
    let numRecogido = $(this).parents("tr").children("td").eq(0).html();
    console.log(numRecogido);

    //leer mediante ajax la factura y sus líneas
    $.post(
      base_url + "Facturas_c/leerParaDetalles",
      { numFactura: numRecogido},
      function (datos) {
        //cargar todos los valores de los campos del formulario con los datos recibidos
        datos = JSON.parse(datos);
        console.log(datos);

        //  LLAMAR A UN MÉTODO QUE REALICE EL LISTADO CON LAS PAREJAS CLAVE-VALOR
        let detFactura = listarDetalles(datos["factura"]);
        $("#tablaDetallesFactura").html(detFactura);

        let lineasFactura = listarFilas(datos["lineas"]);
        $("#lineasFacturaDetalles").html(lineasFactura);

        const miModal = new bootstrap.Modal("#detallesFacModal");
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

//#region MANEJADORES PROVINCIAS-MUNICIPIOS

//cogiendo el código de la provincia seleccionada, se obtienen sus municipios
$("#ProvinciaCli").on("change", function (evento) {
  let provincia = formFacturas.ProvinciaCli.value;
  let codProv = provincia.slice(-2);
  provincia = { ProvinciaCli: codProv };

  //llamada ajax para obtener los municipios de esa provincia
  $.post(base_url + "Facturas_c/traerMunicipios", provincia, function (datos) {
    console.log(JSON.parse(datos));
    municipios = JSON.parse(datos);
    options = generarOptions(municipios.municipios);
    $("#opcionesMunicipios").html(options);
  });
});

// con los datos recibidos, se genera una cadena para insertar en opcionesMunicipios
function generarOptions(municipios) {
  cadena = "";
  for (let municipio of municipios) {
    cadena += `<option value="${
      municipio.nombre + " " + municipio.municipio_id
    }"></option>`;
  }
  return cadena;
}
//#endregion

//#region INSERCIÓN DEL NUEVO CLIENTE Y REFRESCAR DATALIST OPCIONESCLIENTES

$("#cliNuevoBTN").on("click", function (evento) {
  evento.preventDefault();
  if (formFacturas.NIFCli.classList.contains("no-valido")) {
    console.log("ha entrado en invalido");
    this.classList.add("was-validated");
  } else {
    let cliente = {};
    cliente.NombreCli = formFacturas.NombreCli.value;
    cliente.ApellidosCli = formFacturas.ApellidosCli.value;
    cliente.NIFCli = formFacturas.NIFCli.value;
    cliente.ProvinciaCli = formFacturas.ProvinciaCli.value.slice(-2);
    cliente.PoblacionCli = formFacturas.PoblacionCli.value.slice(-5);
    cliente.CpostalCli = formFacturas.CpostalCli.value;
    cliente.DireccionCli = formFacturas.DireccionCli.value;
    console.log(cliente);
    //insertamos el cliente nuevo
    $.post(base_url + "Facturas_c/insertarCliente", cliente, function (datos) {
      //los datos recibidos son todos los clientes incluido el insertado
      datos = JSON.parse(datos);

      //ahora volvemos a rellenar la lista de clientes del formulario
      options = rellenarClientes(datos.clientes);
      $("#opcionesClientes").html(options);
    });
  }
});

function rellenarClientes(clientes) {
  cadena = "";
  for (let cliente of clientes) {
    cadena += `<option value="${cliente.idCliente}">${
      cliente.NombreCli} ${cliente.ApellidosCli}</option>`;
  }
  return cadena;
}
//#endregion

//#region AÑADIR LÍNEA DE FACTURA

$("#btnAñadirLinea").on("click", function (evento) {
  evento.preventDefault();
  if (formFacturas.numCrotal.value) {
    let crotalAnim = formFacturas.numCrotal.value;

    if (comprobarDuplicados(crotalAnim)) {
    } else {
      $.post(
        base_url + "Bovido_c/leerParaFactura",
        { crotal: crotalAnim },
        function (datos) {
          console.log(JSON.parse(datos));
          let animal = JSON.parse(datos);
          let linea = generarLinea(animal.animal);
          $("#lineasFactura").append(linea);
          eventoBorrarLinea();
          formFacturas.numCrotal.value = "";
        }
      );
    }
  }
});

function comprobarDuplicados(crotalAnim) {
  let existe = false;
  console.log("entra");
  $("#lineasFactura li").each(function (indice, linea) {
    console.log(linea);
    if (linea.dataset.crotal == crotalAnim) {
      existe = true;
    }
  });
  return existe;
}

//generar la línea de factura
function generarLinea(animal) {
  cadena = `
  <li class="list-group-item" data-crotal="${animal.crotal}">
    <table class="table table-hover table-borderless table-sm mb-0 col-sm-12">
      <tr >
        <td>${animal.crotal}</td>
        <td>${animal.raza}</td>
        <td>${animal.sexo}</td>
        <td>
        <input name="precio" id="${animal.crotal}" class="form-control form-control-sm precio" type="number" placeholder="0.00€" required>
        </td>
        <td><i class='bi bi-x-circle-fill borrarLinea fs-5' title='borrar línea' style='color: #c54444; cursor:pointer;'></i></td>
      </tr>
    </table>
    </li>
  `;

  return cadena;
}

function eventoBorrarLinea() {
  $(".borrarLinea").on("click", function (evento) {
    console.log("hola");
    $(this).parents("li").remove();
  });
}

$(document.formFacturas.numCrotal).on("blur", function (evento) {
  if (this.value.length > 0) {
    let crotalIntroducido = this.value;
    $.post(
      base_url + "Bovido_c/existe",
      { crotal: crotalIntroducido },
      function (datos) {
        if (datos == "1") {
          let btnAñadir = document.getElementById("btnAñadirLinea");
          if (comprobarDuplicados(crotalIntroducido)) {
            //si es true, está duplicado y no debe estarlo
            document.formFacturas.numCrotal.classList.add("is-invalid");
            document.formFacturas.numCrotal.classList.add("no-valido");
            $("#btnAñadirLinea").prop("disabled", true);
          } else {
            //es false, así que existe (debe existir) y no está duplicado
            document.formFacturas.numCrotal.classList.remove("is-invalid");
            document.formFacturas.numCrotal.classList.remove("no-valido");
            $("#btnAñadirLinea").prop("disabled", false);
          }
        } else {
          //es false, así que no existe (debe existir)
          document.formFacturas.numCrotal.classList.add("is-invalid");
          document.formFacturas.numCrotal.classList.add("no-valido");
          $("#btnAñadirLinea").prop("disabled", true);
        }
      }
    );
  }
});

//#endregion

//#region ENVÍO DEL FORMULARIO

$(document.formFacturas).on("submit", function (evento) {
  evento.preventDefault();
  console.log("Hola");

  if (formFacturas.numFactura.classList.contains("no-valido")) {
    console.log("ha entrado en invalido");
    this.classList.add("was-validated");
  } else {
    let datosFac = {};
    datosFac.idCliente = formFacturas.opcionesClientes.value;
    datosFac.numFactura = formFacturas.numFactura.value;
    datosFac.fechaFac = formFacturas.fechaFac.value;
    datosFac.lineas = seleccionarLineas();

    $.post(base_url + "Facturas_c/insertarFactura", datosFac, function (datos) {
      location.href = base_url + "Facturas_c/index";
    });
  }
});

function seleccionarLineas() {
  let lineas = [];
  $("#lineasFactura li").each(function (indice, linea) {
    linea = {
      numCrotal: linea.dataset.crotal,
      precioAnimal: document.getElementById(linea.dataset.crotal).value,
    };
    lineas.push(linea);
  });
  return lineas;
}

//#endregion

//#region VALIDACIONES

//VALIDACIÓN DNI NUEVO CLIENTE
$(document.formFacturas.NIFCli).on("blur", function (evento) {
  if (this.value.length > 0) {
    let NIFCliIntroducido = this.value;
    $.post(
      base_url + "Facturas_c/existeCliente",
      { NIFCli: NIFCliIntroducido },
      function (datos) {
        if (datos == "1") {
          //es true, así que existe
          console.log("existe");
          document.formFacturas.NIFCli.classList.add("is-invalid");
          document.formFacturas.NIFCli.classList.add("no-valido");
        } else {
          //es false, así que no existe
          console.log("no existe");
          document.formFacturas.NIFCli.classList.remove("is-invalid");
          document.formFacturas.NIFCli.classList.remove("no-valido");
        }
      }
    );
  }
});

//VALIDACIÓN NÚMERO DE FACTURA EXISTE
$(document.formFacturas.numFactura).on("blur", function (evento) {
  if (this.value.length > 0) {
    let numFacturaIntroducido = this.value;
    $.post(
      base_url + "Facturas_c/existeFactura",
      { numFactura: numFacturaIntroducido },
      function (datos) {
        if (datos == "1") {
          //es true, así que existe
          console.log("existe");
          document.formFacturas.numFactura.classList.add("is-invalid");
          document.formFacturas.numFactura.classList.add("no-valido");
        } else {
          //es false, así que no existe
          console.log("no existe");
          document.formFacturas.numFactura.classList.remove("is-invalid");
          document.formFacturas.numFactura.classList.remove("no-valido");
        }
      }
    );
  }
});

//VALIDACIÓN NÚMERO DE FACTURA

//VALIDACIÓN CLIENTE EXISTE

//VALIDACIÓN NO AÑADIR CROTAL 2 VECES

//EVENTO AL RELLENAR BUSCADOR CROTALES
//#endregion
