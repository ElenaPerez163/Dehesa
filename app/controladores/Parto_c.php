<?php
class Parto_c extends Controller
{
    private $parto_m;

    public function __construct()
    {
        $this->parto_m = $this->loadModel(("Partos_m"));
    }

    public function index()
    {
        //ya cargo vistas y modelos razas/fincas para filtros en bovido
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['partos'] = $this->parto_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    //función para el futuro, ahora los partos solo se insertan al insertar un animal de manera automática
    public function insertar()
    {
        var_dump($_REQUEST);
        $mensajes = [];

        //primero comprobamos que la madre existe:
        if (!empty($_REQUEST['crotalTernero'])) {
            $bovidos_m = $this->loadModel("Bovidos_m");
            $bovido = $bovidos_m->buscar($_REQUEST['crotalTernero']);
        }
        $insertado = $this->parto_m->insertar($_REQUEST);

        if (!$insertado) {
            $mensajes[] = "El parto no se pudo insertar en la base de datos";
        }

        $_SESSION['mensajes'] = $mensajes;
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function borrar()
    {
        $borrado = $this->parto_m->borrar($_POST['crotalAnimal']);
        echo $borrado;
    }

    public function leerParto(){
        $datos['parto']=$this->parto_m->leerParto($_POST['crotal']);
        echo json_encode($datos);
    }

    //función que se usa para mostrar detalles del parto en ventana modal
    public function leerDatos()
    {
        //leo los datos completos de este parto
        $datos['parto'] = $this->parto_m->leerPartoDetalles($_POST['crotal']);

        $datos['otrosPartos']=$this->parto_m->leerCrotalMadre($_POST['crotal']);
        //busco y leo los otros partos que ha tenido la madre del ternero

        echo json_encode($datos);
    }
}
