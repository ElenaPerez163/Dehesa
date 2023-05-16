<?php
///  ESTE CÓDIGO AUTOCARGA TODAS LAS CLASES QUE ESTÉN EN EL CORE  ///
spl_autoload_register(function ($nombreClase) {
    if (is_file(CORE . $nombreClase . ".php")) {
        include CORE . $nombreClase . ".php";
    }
});
