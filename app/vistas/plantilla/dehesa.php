<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Title</title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Philosopher:wght@400;700&family=Roboto:wght@300;400;500&display=swap"
      rel="stylesheet"
    />
  </head>
  <style>
    body{
      background-color: #c7d989;
      font-family: Roboto;
    }
    h1 {
      font-family: Philosopher;
      font-size: 8em;
      color: #124026;
    }
    #menu {
      background-color: #4d8c4a;
    }

    #centro {
      background-color: #c7d989;
    }
    p {
      font-family: Roboto;
      color: #124026;
      font-size: 3em;
    }

    .btn {
      background-color: #e5f2c9;
      padding-top: 0.7em;
      padding-bottom: 0.7em;
    }

    .btn:hover{
      background-color:#c7d989;
    }
  </style>

  <body>
    <div class="container row mw-100 justify-content-center">
      <div class="row vh-100 justify-content-center">
        <div id="menu" class="col-2">
          <div
            class="d-flex gap-4 col-8 mx-auto vh-100 flex-column justify-content-center"
          >
            <a href="<?= BASE_URL?>Inicio_c/login" class="btn" type="button">Iniciar Sesión</a>
            <button class="btn" type="button">Registrarse</button>
            <button class="btn" type="button">Sobre Dehesa</button>
            <button class="btn" type="button">Contacto</button>
          </div>
        </div>
        <div
          id="centro"
          class="col-10 d-flex align-items-center justify-content-center"
        >
          <div class="text-center">
            <h1>Dehesa</h1>
            <img src="<?= BASE_URL;?>app/assets/img/MedioNoBG.png" alt="" width="400" />
            <p>Gestión sencilla desde cualquier dispositivo</p>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
