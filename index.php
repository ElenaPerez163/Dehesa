<?php
if (!session_id()) session_start();
require "system/config.php";
require "system/core/autoload.php";

//instanciamos el router
//echo $_SERVER['DOCUMENT_ROOT'];
$router = new Router();

$controlador = $router->getController();
$metodo = $router->getMethod();
$parametros = $router->getParams();


//incluir el controlador que está en la URI
//COMPROBACION DE QUE EL CONTROLADOR EXTISTA
if (!is_file(PATH_CONTROLLERS . $controlador . ".php")) $controlador = "ErrorPage";
include PATH_CONTROLLERS . $controlador . ".php";

//instanciamos el controlador
$miControlador = new $controlador(); //tengo el nombre controlador en la variable, instancio la clase a partir de ese nombre

//varificar que el método de la uri existe (el controlador y el método del controlador que queremos usar)
if (!method_exists($miControlador, $metodo)) $metodo = "index";

//llamar al método del controlador con los parámetros
if (empty($parametros)) {
    $miControlador->$metodo(); //tengo el nombre del método en la variable, uso ese método
} else {
    $miControlador->$metodo($parametros);
}
