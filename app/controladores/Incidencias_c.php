<?php
class Incidencias_c extends Controller
{
    private $incidencia_m;

    public function __construct()
    {
        $this->incidencia_m = $this->loadModel(("Incidencias_m"));
    }

    public function index()
    {
        //cargo modelos razas y fincas para filtros
        $razas_m = $this->loadModel("Razas_m");
        $datos['razas'] = $razas_m->leerTodas();

        $fincas_m = $this->loadModel("Fincas_m");
        $datos['fincas'] = $fincas_m->leerTodas();

        $datos['tipos'] = $this->incidencia_m->tiposInc();

        $bovidos_m = $this->loadModel("Bovido_m");
        $datos['crotales'] = $bovidos_m->leerCrotales();

        $contenido = "incidencias_v";
        $this->loadView("plantilla/menuLogueado");
        $this->loadView($contenido, $datos);
        $this->loadView("plantilla/pie");
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['incidencias'] = $this->incidencia_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function insertar()
    {
        $datos = [];
        $datos['tipo'] = $_REQUEST['tipo'];
        $datos['crotal'] = $_REQUEST['crotal'];
        $datos['Descripcion'] = $_REQUEST['descripcion'];
        $datos['fechaIncidencia'] = $_REQUEST['fechaIncidencia'];

        $insertado = $this->incidencia_m->insertar($datos);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function borrar()
    {
        $borrado = $this->incidencia_m->borrar($_POST['idIncidencia']);
        echo $borrado;
    }

    public function leerIncidencia()
    {
        $datos = $this->incidencia_m->leerIncidencia($_POST['idIncidencia']);
        echo json_encode($datos);
    }

    public function modificar()
    {
        $this->incidencia_m->modificar($_REQUEST);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    //función que se usa para mostrar detalles del parto en ventana modal
    public function leerDatos()
    {
        //leo los datos completos de este parto
        $datos['incidencia'] = $this->incidencia_m->leerIncidenciaDetalles($_POST['codigo']);

        $datos['otrasIncidencias'] = $this->incidencia_m->leerIncidenciasAnimal($_POST['crotal']);
        //busco y leo los otros partos que ha tenido la madre del ternero

        echo json_encode($datos);
    }
}
