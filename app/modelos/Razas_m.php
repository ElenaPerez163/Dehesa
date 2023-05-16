<?php

class Razas_m extends Model{

    public function __construct()
    {
        // Llamada al constructor del padre para conectar a la BBDD
        parent::__construct();
    }

    //llamada a todas las razas (filtros)
    public function leerTodas()
    {
        // Este metodo lee todas las familias y las devuelve
        $cadSQL = "SELECT * FROM raza ORDER BY 1";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

}