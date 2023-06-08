<?php
$menu = "2"; //por defecto 1
if (isset($_SESSION['menuActivo'])) { //si hay algún menú activo guardado, lo cambiamos
    $menu = $_SESSION['menuActivo'];
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Dehesa</title>
	<link rel="icon" type="image/jpg" href="<?= BASE_URL ?>app/assets/img/icono2.png"/>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <!-- Bootstrap CSS v5.2.1 -->
    <link rel="stylesheet" href="<?= BASE_URL; ?>/app/assets/libs/bootstrap/css/bootstrap.min.css" />
    <script src="<?= BASE_URL; ?>/app/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>/app/assets/libs/jquery-3.6.3.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= BASE_URL;?>/app/vistas/css/clasesGenerales.css">

  </head>
  <style>
    body{
      background-color: #c7d989;
      font-family: Roboto;
    }
    h1,h2 {
      font-family: Marcellus;
      font-size: 8em;
      color: #124026;
    }

    h2{
        font-size: 4em;
    }
    
    p {
      font-family: Roboto;
      color: #124026;
      font-size: 2em;
    }

    #cajonLogin{
        background-color:#e5f2c9;
        border-radius: 5px;
        -webkit-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57);
        -moz-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57);
        box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57);
    }

    input:focus{
        border: none!important;
        -webkit-box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57)!important;
        -moz-box-shadow: 10px 10px 13px -5px rgba(18,64,38,0.57)!important;
        box-shadow: 5px 5px 8px -5px rgba(18,64,38,0.57)!important;
    } 
  
  </style>

  <body>
    <div class="container-fluid row vh-100 m-auto align-items-center align-items-md-end align-items-lg-center justify-content-center">
    <div class="col-lg-6 col-md-8  d-none d-sm-none d-lg-block d-md-block d-xl-block col-md-5 d-flex align-items-center justify-content-center  ">

        <div id="centro" class="row text-center">
            <h1 class="fs-md-5">Dehesa</h1>
        </div>
        <div class="row justify-content-center text-center"> 
          <div class="col-10 d-lg-block d-sm-none d-block">
          <img src="<?= BASE_URL;?>app/assets/img/NuevoOPM.png" class="img-fluid " alt="logo" width="400" />
          </div>
          
        </div>
        <div class="row text-center d-block d-lg-block d-sm-none">
            <p>Contigo para que las cosas sean fáciles</p>
        </div>

    </div>
    <div class="col-lg-6 col-md-8 col-sm-12 m-auto">

        <div class="row ">
  
      <div class="col-lg-6 col-md-7 col-sm-10 m-auto" id="cajonLogin">
            <div class="w-100 d-flex mb-1 pt-2 justify-content-center">
                <h2>Login</h2>
            </div>

            <form class="d-flex flex-column needs-validation" id="formLogin" name="formLogin" action="<? echo BASE_URL ?>Usuario_c/autenticar" method="post" novalidate>

            <div class="w-100 mb-3 d-flex justify-content-center">
                <input class=" form-control w-75" type="text" placeholder="Usuario" name="usuario" id="usuario" required>
            </div>
            
            <div class="w-100 mb-3 d-flex justify-content-center">
                <input class="form-control w-75" type="password" placeholder="Contraseña" name="password" id="password" required>
            </div>

            <div class="form-check mb-3 offset-2">
                <input class="form-check-input" type="checkbox" value="" id="recuerdame">
                <label class="form-check-label" for="recuerdame">
                Recuérdame
                </label>
            </div>
            <div class=" w-100 mb-4 d-flex justify-content-center">
            <button id="btnLogin" type="submit" class="btn btnOscuro w-75 ">Iniciar Sesión</button>
            </div>
        </form>
        </div>
      </div>

      <div class="row mt-2">
      <? if(isset($_SESSION['mensajeError'])): ?>
      <div class="col-6 mx-auto alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> <?= $_SESSION['mensajeError']?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['mensajeError']);
      endif;
      ?>

    </div>
    
    </div>

    </div>
  </body>
    <script src="<? echo BASE_URL ?>app/assets/libs/cookies.js"></script>
    <script src="<?echo BASE_URL?>app/vistas/js/login.js"></script>
</html>