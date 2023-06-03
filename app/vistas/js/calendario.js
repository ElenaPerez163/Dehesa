//*******      GENERO EL CALENDARIO     *******/
let botonesModificar = false;
// DECLARAR Y RENDERIZAR EL CALENDARIO
document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
  });
  calendar.render();
});

//*******     PARÁMETROS DEL CALENDARIO     *******/
$(function () {
  var initialLocaleCode = "es";
  $.post(base_url + "Tareas_c/calendario", function (datos) {
    let tareas = JSON.parse(datos);
    arrayTareas = prepararDatos(tareas.tareas);
    $("#calendar").fullCalendar({
      header: {
        left: "prev,next today",
        center: "title",
        right: "month,agendaWeek,agendaDay",
      },
      locale: initialLocaleCode,
      buttonIcons: false, // show the prev/next text
      weekNumbers: true,
      navLinks: true, // can click day/week names to navigate views
      eventLimit: true,
      events: arrayTareas,
      editable: true,
      eventDrop: function(info) {
        let nuevaFecha=info.start.toISOString();
        let idTareaR=info.id;
        datos={
          fecha:nuevaFecha,
          idTarea:idTareaR
        }
        $.post(base_url+"Tareas_c/modificarDrop",datos,function(datos){
          console.log(datos);
        });
      },
      eventDragStart: function (datos) {},
      eventClick: function (datos) {
        //hacer aquí llamada ajax para recuperar los datos según el id
        $.post(
          base_url + "Tareas_c/leerTarea",
          { idTarea: datos.id },
          function (datos) {
            //cargar todos los valores de los campos del formulario con los datos recibidos
            let tarea = JSON.parse(datos);

            nuevaTarea.nombreCal.value = tarea.nombre;
            nuevaTarea.descripcionCal.value = tarea.descripcion;
            nuevaTarea.fechaCal.value = tarea.fecha;
            nuevaTarea.idTarea.value = tarea.idTarea;
            let botones = cambiarBotones();
            $("#botonesCal").html(botones);

            ////  MANEJADOR  BOTON BORRAR ////
            $("#eliminarCal").on("click", function (evento) {
              evento.preventDefault();
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
                  //BORRAR TAREA
                  let id = nuevaTarea.idTarea.value;
                  console.log(id);
                  datos = { idTarea: id };
                  $.post(base_url + "Tareas_c/borrar", datos, function (datos) {
                    Swal.fire({
                      title: "¡Eliminado!",
                      confirmButtonColor: "#1f5034",
                    }).then((result) => {
                      if (result.isConfirmed) {
                        location.href = base_url + "Tareas_c/index";
                        botonesModificar = true;
                        cambiarBotones();
                      }
                    });
                  });
                }
              });
            });

            $(".btnLimpiar").on("click", function (evento) {
              evento.preventDefault();
              nuevaTarea.nombreCal.value = "";
              nuevaTarea.descripcionCal.value = "";
              nuevaTarea.fechaCal.value = "";
              nuevaTarea.idTarea.value = "";
              botonesModificar = true;
              let botones = cambiarBotones();
              $("#botonesCal").html(botones);
              botonesModificar = false;
            });
          }
        );
      },
    });
  });
});

// preparo un array con el formato de datos que voy a pasar a fullcalendar
function prepararDatos(tareas) {
  let arrayTareas = [];
  for (let tarea of tareas) {
    let start = moment(tarea.fecha).format('YYYY-MM-DD');
    arrayTareas.push({
      id: tarea.idTarea,
      title: tarea.nombre,
      start: start,
      end:start
    });
  }
  return arrayTareas;
}

//si pulso en una tarea, se cambiarán los botones y el action del formulario
function cambiarBotones() {
  let botonesNuevos;
  if (botonesModificar == false) {
    document.nuevaTarea.action = base_url + "Tareas_c/modificar";
    botonesNuevos = `<button type="submit" class="btn mt-3 btnOscuro w-75">Modificar</button>
        <button  class="btn mt-3 btnMedio w-75 btnLimpiar">Limpiar</button>
        <button id="eliminarCal" class="btn mt-3 btnPeligro w-75">Eliminar</button>`;
  } else {
    botonesNuevos = `<button type="submit" class="btn mt-3 btnOscuro w-75">Nueva</button>
        <button  class="btn mt-3 btnMedio w-75 btnLimpiar">Limpiar</button>`;
  }
  return botonesNuevos;
}
