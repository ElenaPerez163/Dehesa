<?php
class Facturas_c extends Controller
{

    private $facturas_m;

    public function __construct()
    {
        $this->facturas_m = $this->loadModel(("Facturas_m"));
    }

    public function index()
    {
        $datos['clientes'] = $this->facturas_m->ClienteFiltro();
        $contenido = "facturas_v";
        $this->loadView("plantilla/menuLogueado");
        $this->loadView($contenido,$datos);
        $this->loadView("plantilla/pie");
        
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['facturas'] = $this->facturas_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

}