<?php
class Inicio_c extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $this->loadView("landing_v");
        
    }

    public function resumen(){
        $this->loadView("plantilla/menuLogueado");
        $this->loadView("resumen_v");
        $this->loadView("plantilla/pie");
    }

    public function recogerResumen(){
        //instancio los modelos y uso su método resumen para obtener los cinco últimos insertados de cada una de las tablas para así generar el resumen en la parte de cliente
        $bovidos_m=$this->loadModel("Bovido_m");
        $datos['Animales']=$bovidos_m->resumen();

        $partos_m=$this->loadModel("Partos_m");
        $datos['Partos']=$partos_m->resumen();

        $incidencias_m=$this->loadModel("Incidencias_m");
        $datos['Incidencias']=$incidencias_m->resumen();

        $tareas_m=$this->loadModel("Tareas_m");
        $datos['Tareas']=$tareas_m->resumen();
        

        $grupos_m=$this->loadModel("Grupos_m");
        $datos['Parcelas']=$grupos_m->resumen();

        echo json_encode($datos);
        
    }

    public function menuActivo_Ajax()
    {
        $_SESSION['menuActivo'] = $_REQUEST['menuActivo'];
    }

}
