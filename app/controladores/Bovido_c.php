<?php
class Bovido_c extends Controller
{
    private $bovido_m;

    public function __construct()
    {
        $this->bovido_m = $this->loadModel(("Bovido_m"));
    }

    public function index($partos=[])
    {
        $datos['animActiva']="";
        $datos['partActiva']="";
        if(!empty($partos)){
            $datos['partActiva']="active";
        }else{
            $datos['animActiva']="active";
        }
        //cargo modelos razas y fincas para filtros
        $razas_m = $this->loadModel("Razas_m");
        $datos['razas'] = $razas_m->leerTodas();

        $fincas_m = $this->loadModel("Fincas_m");
        $datos['fincas'] = $fincas_m->leerTodas();

        $grupos_m = $this->loadModel("Grupos_m");
        $datos['grupos'] = $grupos_m->leerTodos();

        $datos['tipos'] = $this->bovido_m->leerTipos();

        $contenido = "tabsAnim_v";
        $this->loadView("plantilla/menuLogueado");
        $this->loadView($contenido, $datos);
        $this->loadView("plantilla/pie");
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['animales'] = $this->bovido_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function insertar()
    {
        $mensajes = [];
        //RECOJO LOS DATOS QUE ME INTERESAN DE $_REQUEST PARA LA INSERCIÓN 
        $datos = [];
        $datos['crotal'] = $_REQUEST['crotal'];
        $datos['crotalMadre'] = $_REQUEST['crotalMadre'];
        $datos['explotacionPertenencia'] = $_REQUEST['explotacionPertenencia'];
        $datos['explotacionNacimiento'] = $_REQUEST['explotacionNacimiento'];
        $datos['fechaNacimiento'] = $_REQUEST['fechaNacimiento'];
        $datos['raza'] = $_REQUEST['raza'];
        $datos['sexo'] = $_REQUEST['sexo'];
        $datos['idGrupo'] = $_REQUEST['idGrupo'];
        $datos['tipo'] = $_REQUEST['tipo'];

        if ($_REQUEST['parto'] == 1) {
            $datos['causaAlta'] = "Nacimiento";
        } else {
            $datos['causaAlta'] = "Movimiento";
        }
        $datos['causaBaja'] = "";
        $insertado = $this->bovido_m->insertar($datos);

        if (!$insertado) {
            $mensaje[] = "El animal no se pudo insertar en la base de datos";
        }

        //AHORA, SI PROCEDE, REALIZO LA MODIFICACIÓN DEL PARTO (SE GENERARÁ ADEMÁS INCIDENCIA AUTOMÁTICA)
        if (!empty($_REQUEST['observaciones']) || $_REQUEST['asistido'] == 1) {
            $datos = [];
            $datos['crotalTernero'] = $_REQUEST['crotal'];
            $datos['esAsistido'] = $_REQUEST['asistido'];
            $datos['observaciones'] = $_REQUEST['observaciones'];

            //modifico el parto correspondiente con los datos por añadir
            $partos_m = $this->loadModel("Partos_m");
            $partos_m->modificar($datos);
        }

        $_SESSION['mensajes'] = $mensajes;
        
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function borrar()
    {
        $borrado = $this->bovido_m->borrar($_POST['crotalAnimal']);
        echo $borrado;
    }

    public function leerAnimal()
    {
        $datos['animal'] = $this->bovido_m->leerAnimal($_POST['crotal']);

        $parto_m = $this->loadModel("Partos_m");
        $datos['parto'] = $parto_m->esAsistido($_POST['crotal']);

        echo json_encode($datos);
    }

    public function modificar()
    {
        $datos = [];
        $datos['crotal'] = $_REQUEST['crotal'];
        $datos['crotalMadre'] = $_REQUEST['crotalMadre'];
        $datos['explotacionPertenencia'] = $_REQUEST['explotacionPertenencia'];
        $datos['explotacionNacimiento'] = $_REQUEST['explotacionNacimiento'];
        $datos['fechaNacimiento'] = $_REQUEST['fechaNacimiento'];
        $datos['raza'] = $_REQUEST['raza'];
        $datos['sexo'] = $_REQUEST['sexo'];
        $datos['idGrupo'] = $_REQUEST['idGrupo'];
        $datos['tipo'] = $_REQUEST['tipo'];
        if ($_REQUEST['parto'] == 1) {
            $datos['causaAlta'] = "Nacimiento";
        } else {
            $datos['causaAlta'] = "Movimiento";
        }


        $this->bovido_m->modificar($datos);


        $datos = [];
        $datos['crotalTernero'] = $_REQUEST['crotal'];
        $datos['esAsistido'] = $_REQUEST['asistido'];
        $datos['observaciones'] = $_REQUEST['observaciones'];

        $partos_m = $this->loadModel("Partos_m");
        $partos_m->modificar($datos);

        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    //función que se usa para mostrar detalles del animal en ventana modal
    public function leerDatos()
    {
        $datos['animal'] = $this->bovido_m->leerAnimalDetalles($_POST['crotal']);

        $partos_m = $this->loadModel("Partos_m");
        $datos['partos'] = $partos_m->leerPartosDetAnimal($_POST['crotal']);

        $incidencias_m = $this->loadModel("Incidencias_m");
        $datos['incidencias'] = $incidencias_m->leerIncidenciasAnimal($_POST['crotal']);

        echo json_encode($datos);
    }

    public function existe(){
        echo $this->bovido_m->existeAnimal($_REQUEST['crotal']);
    }
}
