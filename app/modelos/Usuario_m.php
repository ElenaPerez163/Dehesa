<?php
class Usuario_m extends Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function autenticar($usuario,$password){
        $cadSQL = "SELECT * FROM usuario WHERE (usuario.usuario=:usuario)";
        $this->consultar($cadSQL);
        $this->enlazar(":usuario", $usuario);
        $fila = $this->fila();
        if ($fila) {
            // Comprobar el password
            if (!password_verify($password, $fila['contraseña'])) {
                return null;
            }
        }
        return $fila;
    }
}