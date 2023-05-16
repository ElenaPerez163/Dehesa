<?php
abstract class Controller
{
    /// PROPIEDADES ///
    // private $view; //vista


    public function __construct()
    {
    }

    abstract public function index();

    //cargar una vista
    protected function loadView($vista, $params = array())
    {
        return new View($vista, $params);
    }

    protected function loadModel($modelo)
    {
        if (is_file(ROOT . PATH_MODELS . $modelo . ".php")) {
            include ROOT . PATH_MODELS . $modelo . ".php";
            return new $modelo();
        } else {
            throw new Exception("Error, modelo no existe");
        }
    }
}
