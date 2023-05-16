<?php

class Usuario_c extends Controller{
    private $usuario_m;

    public function __construct()
    {
        $this->usuario_m=$this->loadModel(("Usuario_m"));
    }

    public function index(){

    }

    public function autenticar(){
        $usuario = $_REQUEST['usuario'];
        $password = $_REQUEST['password'];
        $fila = $this->usuario_m->autenticar($usuario, $password);

        if ($fila) {
            $_SESSION['sesion'] = [
                "usuario" => $fila['usuario'],
                "codigoExplotacion" => $fila['codigoExplotacion'],
                "tipo" => $fila['tipo']  //este campo es para el futuro, por si se creasen trabajadores
            ];

            header("location:" . BASE_URL . "Inicio_c/resumen");
        } else {
            //si el usuario no existe, retornar al  login y dar mensaje de error
            //flash data, variables de sesión que valen para una sola vez
            $_SESSION['mensajeError'] = "Credenciales incorrectas";
            header("location:" . BASE_URL . "Inicio_c/Index");
        }
    }
}