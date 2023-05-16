<?php
////  CONFIGURACIONES  ////
define("URI", $_SERVER['REQUEST_URI']);
const DEFAULT_CONTROLLER = "Inicio_c";
const DEFAULT_METHOD = "index";
const CORE = "system/core/";
const PATH_CONTROLLERS = "app/controladores/";
const PATH_VIEWS = "app/vistas/";
const PATH_MODELS = "app/modelos/";

/// cambiar las siguientes rutas para cada proyecto ///
define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/dehesa/");
define("BASE_URL", "http://localhost/dehesa/");


////  BASE DE DATOS  ////
const DB_HOST = "localhost";
const DB_USER = "root";
const DB_PASS = "";
const DB_NAME = "explotacion";
