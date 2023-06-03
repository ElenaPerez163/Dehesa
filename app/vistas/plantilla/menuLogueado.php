<?php
$menu = "-1"; //por defecto 1
if (isset($_SESSION['menuActivo'])) { //si hay algún menú activo guardado, lo cambiamos
  $menu = $_SESSION['menuActivo'];
}
?>
<!DOCTYPE html >

<head>
  <title>Dehesa</title>
  <link rel="icon" type="image/jpg" href="<?= BASE_URL ?>app/assets/img/icono2.png"/>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS v5.2.1 -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>/app/assets/libs/bootstrap/css/bootstrap.css" />
  <script src="<?= BASE_URL; ?>/app/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <!-- jquery -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>

  <!-- fuentes -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Philosopher:wght@400;700&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet" />

  <!-- sweetalert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.1/dist/sweetalert2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= BASE_URL; ?>/app/vistas/css/clasesGenerales.css">
  

  <!-- fullcalendar -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.print.css" rel="stylesheet" media="print">
  <script src="https://cdn.jsdelivr.net/npm/moment@2/min/moment.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/fullcalendar.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.10.5/dist/locale-all.min.js"></script>

  <!-- ---------------------------------------------------------------- -->
  <link rel="stylesheet" href="<?= BASE_URL; ?>/app/vistas/css/overrideFC.css">
  <link rel="stylesheet" href="<?= BASE_URL; ?>/app/vistas/css/menuLogueado.css">
  <!-- paso mi constante PHP a Javascript para tenerla disponible -->
  <script>
  const base_url = '<?= BASE_URL; ?>';
  const root='<?= ROOT;?>';
  </script>
  <!-- script donde genero mi calendario (debe estar en el head) -->
  <script src="<?= BASE_URL?>app/vistas/js/calendario.js"></script>
</head>


<body>
  <div class="container-fluid vw-100 vh-100 row sinMargen">

    <div id="menu" class="container-fluid col-lg-2 col-md-12 d-flex gap-lg-4 flex-md-row  flex-lg-column justify-content-center align-items-center justify-content-lg-start justify-content-md-evenly align-items-md-center align-items-lg-stretch  text-center px-lg-3 px-md-3 px-1">
    
      <a id="enlaceLogo"href="<?= BASE_URL ?>Inicio_c/resumen"><img title="Resumen" id="logoMenu" class="mt-lg-3 mb-lg-2 mb-md-2" src="<?= BASE_URL ?>app/assets/img/NuevoClaro.png" alt="resumen" width="125"></a>

        <a data-menu="1" href="<?= BASE_URL ?>Bovido_c/index" class="btn" type="button">Animales</a>
        <a data-menu="2" href="<?= BASE_URL ?>Incidencias_c/index" class="btn" type="button">Incidencias</a>
        <a data-menu="3" href="<?= BASE_URL ?>Fincas_c/index" class="btn" type="button">Grupos</a>
        <a data-menu="4" href="<?= BASE_URL ?>Tareas_c/index" class="btn" type="button">Tareas</a>
        <a data-menu="5" href="<?= BASE_URL ?>Facturas_c/index" class="btn" type="button">Facturas</a>
        <button data-bs-toggle="modal" data-bs-target="#cargaInicialModal" type="button" id="btnCargaInicial" class="btn ml-md-5 mt-lg-5 btnOscuro ">Carga Inicial</button>
        <a href="<?= BASE_URL ?>Inicio_c/index" class="btn btnPeligro" type="button">Cerrar Sesión</a>
    
    </div>

      <!-- Modal -->
        <div class="modal fade" id="cargaInicialModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Carga inicial de datos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
              <form action="<?=BASE_URL?>Bovido_c/cargaInicial" method="POST" name="formCargaInicial" id="formCargaInicial" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="formFile" class="form-label">**El archivo seleccionado debe ser un XML descargado de CAÑADA</label>
                <input class="form-control" type="file" id="inputCargaInicial" name="inputCargaInicial" required>
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                  El fichero debe tener la extensión .xml
                </div>
              </div>  
                                      
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btnPeligro" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btnOscuro">Cargar</button>
                </form>
              </div>
            </div>
           
          </div>
        </div>

    <script>
      //obtener la variable del menú activo
      let menuActivo = <?= $menu; ?>; //sin comillas para que sea un número

      //poner el menú activo
      $("#menu a").eq(menuActivo).addClass("activo");

      //EVENTO PARA CAMBIAR COLOR AL BOTÓN AL HACER CLICK
      //Activar la opción corriente y desactivar las demás
      $("#menu").on("click", "a", function(evento) {
        //desactivar el activo (removeClass también lo haría si seleccionamos todos los a)
        $("#menu a.activo").removeClass("activo");
        $(this).addClass("activo");

        //enviar el número del menú activo a una variable de sessión por ajax
        $.post(base_url + "Inicio_c/menuActivo_Ajax", {
          menuActivo: this.dataset.menu
        });

      });

      //VALIDACIÓN TIPO DE ARCHIVO
      $("#inputCargaInicial").on("change",function(evento){
        if(document.getElementById('inputCargaInicial').files[0].name){
        let nombre=document.getElementById('inputCargaInicial').files[0].name;
        console.log(nombre);
        if(nombre.slice(-4)!='.xml'){
          document.formCargaInicial.inputCargaInicial.classList.add("is-invalid");
          document.formCargaInicial.inputCargaInicial.classList.add("no-valido");
        }else{
          document.formCargaInicial.inputCargaInicial.classList.remove("is-invalid");
          document.formCargaInicial.inputCargaInicial.classList.remove("no-valido");

        }
      }
        
      });

      // VALIDACIÓN DEL FORMULARIO ANTES DE ENVIAR
      $(document.formCargaInicial).on("submit", function (evento) {
        evento.preventDefault();
        // Ver validación
        if (!this.checkValidity()) {
          this.classList.add("was-validated");
        } else {
          if ($(".no-valido").length == 0) this.submit();
        }
      });

     
    </script>