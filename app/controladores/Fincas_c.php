<?php
class Fincas_c extends Controller
{
    private $finca_m;

    public function __construct()
    {
        $this->finca_m = $this->loadModel(("Fincas_m"));
    }

    public function index(){
        $this->loadView("plantilla/menuLogueado");
        $this->loadView("parcelas_v");
        $this->loadView("plantilla/pie");
    }

    public function detallesParcelas(){
        if(isset($_POST['grupo'])){
            $_SESSION['grupo']=$_POST['grupo'];
        }
        $datos['nombreFinca']=$this->finca_m->nombreFinca($_SESSION['grupo']);
        $this->loadView("plantilla/menuLogueado");
        $this->loadView("detallesP_v",$datos);
        $this->loadView("plantilla/pie");
    }

    public function generarFichas(){
        $datos=$this->finca_m->leerDatosMostrar();
        echo json_encode($datos);
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['finca'] = $this->finca_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function cambiarGrupo(){
       echo $this->finca_m->cambiarGrupo($_POST['grupo'],$_POST['crotal']); 
    }
}