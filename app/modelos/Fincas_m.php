<?php
class Fincas_m extends Model{

    public function __construct()
    {
        parent::__construct();
    }

     //llamada a todas las razas (filtros)
     public function leerTodas()
     {
         // Este metodo lee todas las familias y las devuelve
         $cadSQL = "SELECT * FROM finca ORDER BY 1";
         $this->consultar($cadSQL);
         return $this->resultado();
     }

     public function leerDatosMostrar(){
        //consulta que agrupa por finca (por grupos) y además por tipo de animal
        $cadSQL="select(select finca.nombre from finca where bovido.idGrupo=finca.idGrupo) as finca,bovido.idGrupo as grupo, count(bovido.idGrupo) as cantidad,(select count(tipo) from bovido as b where tipo=1 and b.idGrupo=bovido.idGrupo) as nodrizas,(select count(tipo) from bovido as b where tipo=2 and b.idGrupo=bovido.idGrupo) as novillas,(select count(tipo) from bovido as b where tipo=3 and b.idGrupo=bovido.idGrupo) as toros,(select count(tipo) from bovido as b where tipo=4 and b.idGrupo=bovido.idGrupo) as terneros from bovido group by bovido.idGrupo having finca is not null;";

        $this->consultar($cadSQL);
        return $this->resultado();
     }

     public function listado()
     {
         $cadSQL = "select bovido.crotal as crotal, (select raza.nombre from raza where bovido.raza=raza.idRaza) as raza,sexos(bovido.sexo) as sexo, invertirFecha(bovido.fechaNacimiento) as nacimiento from bovido where bovido.idGrupo=:grupo and causaBaja='' and crotal like :crotal;";
 
         $this->consultar($cadSQL);
 
         $this->enlazar(":crotal", "%$_POST[crotal]%");
         $this->enlazar(":grupo", $_SESSION['grupo']);
 
         return $this->resultado();
     }

     public function nombreFinca($grupo){
        $cadSQL="select nombre
                from finca
                where idGrupo='$grupo'";

        $this->consultar($cadSQL);
        return $this->fila()['nombre'];
     }
    
     public function cambiarGrupo($grupo,$crotal){

        $cadSQL="update bovido set idGrupo='$grupo' where crotal='$crotal'";
        $this->consultar($cadSQL);
        return $this->ejecutar();

     }

}