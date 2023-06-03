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

    public function leerParaFactura(){
        $datos['animal']=$this->bovido_m->leerParaFactura($_POST['crotal']);
        echo json_encode($datos);
    }

    public function cargaInicial(){
         //**** VAMOS A ORDENARLOS PARA QUE CADA ÍNDICE SEA UN ELEMENTO ****//
         if (!empty($_FILES['inputCargaInicial'])) {
           
            $file = $_FILES['inputCargaInicial'];
          
            $file['name']="cargaInicial.xml";
            // print_r($files); vemos el array ordenado
           

            $mensajes = [];
           
                $subida = new Uploader();
                $camino = ROOT . "app/assets/documentos/"; //camino absoluto al que subir el archivo
                $subida->setDir($camino);  //poner directorio de subida
                $subida->setExtensions(array('xml')); //elegir extensiones permitidas
                $subida->setMaxSize(5); //tamaño máximo en mb

                if ($subida->uploadFile($file)) {
                    //guardar registro en imagenes_articulos
                    $this->cargarDatos();
                    header("location:" . $_SERVER['HTTP_REFERER']);   
                } else {
                    $mensajes[] = "El archivo " . $file['name'] . " no se puede subir, " . $subida->getMessage();
                    header("location:" . $_SERVER['HTTP_REFERER']);
                }
            
        }
    }

    public function cargarDatos(){
        //cargar el documento xml
        $xml = simplexml_load_file(BASE_URL."app/assets/documentos/cargaInicial.xml") or die("Error: Cannot create object");
       
        //PRIMERO LIMPIO LAS TABLAS
        
        $this->bovido_m->vaciarPartos();
        $this->bovido_m->vaciarAnimales();

         //por cada animal del fichero xml
        foreach ($xml->children() as $row) {
            //guardo en variables los datos del animal que me interesan
            $datos['crotal'] = $row->crotal;
            $datos['explotacionPertenencia'] = $row->explotacionPertenencia;
            $fechaNacimiento = $row->fechaNacimiento;
            $datos['explotacionNacimiento'] = $row->explotacionNacimiento;
            $datos['sexo'] = $row->sexo;
            //raza se trata luego
            $raza= $row->raza;
            $datos['crotalMadre'] = $row->crotalMadre;
            $datos['causaAlta'] = $row->causaAlta;
            $fechaAlta = $row->fechaAlta;
            $datos['causaBaja']=$row->causaBaja;
            $fechaBaja=$row->fechaBaja;
            $datos['idGrupo']=6;

            //cambio el formato de las fechas para que se inserten bien
            $objeto_DateTime = date_create_from_format("d/m/Y", $fechaNacimiento);
            $datos['fechaNacimiento'] = date_format($objeto_DateTime, "Y-m-d");

            $objeto_DateTime = date_create_from_format("d/m/Y", $fechaAlta);
            $datos['fechaAlta'] = date_format($objeto_DateTime, "Y-m-d");

            if($fechaBaja[0]){
                $objeto_DateTime = date_create_from_format("d/m/Y", $fechaBaja);
                $datos['fechaBaja'] = date_format($objeto_DateTime, "Y-m-d");
            }else{
                $datos['fechaBaja']=NULL;
            }

            //selecciono el id de la raza a partir del nombre porque en el xml viene así
            $resultado=$this->bovido_m->consultarRaza($raza);
            if (!empty($resultado)) {
                $datos['raza']=$resultado['idRaza'];
            } else {
                $datos['raza']=5;
            }
            
            //realizo la inserción de los datos
            $insertado = $this->bovido_m->insertar($datos);

            if (!$insertado) {
                $mensaje[] = "El animal no se pudo insertar en la base de datos";
            }
           
        }

            $result = $this->bovido_m->asignarTipos();
           

    }
}
