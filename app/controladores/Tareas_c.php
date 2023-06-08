<?php

class Tareas_c extends Controller
{
    private $tareas_m;

    public function __construct()
    {
        $this->tareas_m = $this->loadModel(("Tareas_m"));
    }

    public function index(){
         //cargo modelos razas y fincas para filtros
         $razas_m = $this->loadModel("Razas_m");
         $datos['razas'] = $razas_m->leerTodas();
 
         $fincas_m = $this->loadModel("Fincas_m");
         $datos['fincas'] = $fincas_m->leerTodas();
 
         $incidencias_m = $this->loadModel("Incidencias_m");
         $datos['tipos'] = $incidencias_m->tiposInc();
 
         $bovidos_m = $this->loadModel("Bovido_m");
         $datos['crotales'] = $bovidos_m->leerCrotales();
 
         $contenido = "tabsTareas_v";
         $this->loadView("plantilla/menuLogueado");
         $this->loadView($contenido, $datos);
         $this->loadView("plantilla/pie");

    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['tareas'] = $this->tareas_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function calendario()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['tareas'] = $this->tareas_m->listadoCalendario();
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function insertar()
    {
        $datos = [];
        $datos['nombre'] = $_REQUEST['nombre'];
        $datos['descripcion'] = $_REQUEST['descripcion'];
        $datos['fecha'] = $_REQUEST['fecha'];

        $insertado = $this->tareas_m->insertar($datos);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function borrar()
    {
        $borrado = $this->tareas_m->borrar($_POST['idTarea']);
        echo $borrado;
    }

    public function leerTarea()
    {
        $datos = $this->tareas_m->leerTarea($_POST['idTarea']);
        echo json_encode($datos);
    }

    public function modificar()
    {
		$datos['idTarea']=$_REQUEST['idTarea'];
		$datos['nombre']=$_REQUEST['nombre'];
		$datos['Descripcion']=$_REQUEST['descripcion'];
		$datos['fecha']=$_REQUEST['fecha'];
        $this->tareas_m->modificar($datos);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    //función que se usa para mostrar detalles de la tarea en ventana modal
    public function leerDatos()
    {
        //leo los datos completos de este parto
        $datos['tarea'] = $this->tareas_m->leerTareaDetalles($_POST['codigo']);

        echo json_encode($datos);
    }

    public function ModificarDrop(){
		$datos['idTarea']=$_REQUEST['idTarea'];
		$datos['fecha']=$_REQUEST['fecha'];
        echo $this->tareas_m->modificar($datos);
    }

}