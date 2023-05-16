<?php
class Facturas_c extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $contenido = "facturas_v";
        $this->loadView("plantilla/menuLogueado");
        $this->loadView($contenido);
        $this->loadView("plantilla/pie");
        
    }

}