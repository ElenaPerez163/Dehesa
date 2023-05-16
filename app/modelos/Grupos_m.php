<?php
class Grupos_m extends Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumen(){
        $cadSQL="SELECT finca.nombre as finca,grupo.nombre as grupo,(select count(*)
                                                                    from bovido as b
                                                                    where grupo.idGrupo=b.idGrupo) as cantidad
            FROM grupo inner join finca on grupo.idGrupo=finca.idGrupo
            order by grupo.idGrupo asc limit 3 ";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function leerTodos()
    {
        // Este metodo lee todas las familias y las devuelve
        $cadSQL = "SELECT * FROM grupo ORDER BY 2";
        $this->consultar($cadSQL);
        return $this->resultado();
    }
}