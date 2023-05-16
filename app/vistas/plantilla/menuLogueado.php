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
  </script>
  <!-- script donde genero mi calendario (debe estar en el head) -->
  <script src="<?= BASE_URL?>app/vistas/js/calendario.js"></script>
</head>


<body>
  <div class="container-fluid vw-100 vh-100 row sinMargen">

    <div id="menu" class="container-fluid col-lg-2 col-md-12 d-flex gap-lg-4 flex-md-row  flex-lg-column justify-content-center align-items-center justify-content-lg-start justify-content-md-evenly align-items-md-center align-items-lg-stretch  text-center px-lg-3 px-md-3 px-1">
    
      <a id="enlaceLogo"href="<?= BASE_URL ?>Inicio_c/resumen"><img title="Resumen" id="logoMenu" class="mt-lg-5 mb-lg-3 mb-md-2" src="<?= BASE_URL ?>app/assets/img/NuevoClaro.png" alt="resumen" width="125"></a>

        <a data-menu="1" href="<?= BASE_URL ?>Bovido_c/index" class="btn" type="button">Animales</a>
        <a data-menu="2" href="<?= BASE_URL ?>Incidencias_c/index" class="btn" type="button">Incidencias</a>
        <a data-menu="3" href="<?= BASE_URL ?>Fincas_c/index" class="btn" type="button">Grupos</a>
        <a data-menu="4" href="<?= BASE_URL ?>Tareas_c/index" class="btn" type="button">Tareas</a>
        <a data-menu="5" href="<?= BASE_URL ?>Facturas_c/index" class="btn" type="button">Facturas</a>
        <a href="<?= BASE_URL ?>Inicio_c/index" class="btn ml-md-5 mt-lg-5 btnPeligro" type="button">Cerrar Sesión</a>
    
    </div>

    <script>
      //obtener la variable del menú activo
      let menuActivo = <?= $menu; ?>; //sin comillas para que sea un número

      //poner el menú activo
      $("#menu a").eq(menuActivo).addClass("activo");

      //EVENTO PARA CAMBIAR AL HACER CLICK
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
    </script>