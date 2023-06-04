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
        $cadSQL="SELECT c.nombre AS finca,
        b.idGrupo AS grupo,
        COUNT(d.crotal) AS cantidad,
        COUNT(CASE WHEN d.tipo = 1 THEN d.crotal END) AS nodrizas,
        COUNT(CASE WHEN d.tipo = 2 THEN d.crotal END) AS novillas,
        COUNT(CASE WHEN d.tipo = 3 THEN d.crotal END) AS toros,
        COUNT(CASE WHEN d.tipo = 4 THEN d.crotal END) AS terneros
        FROM finca AS c
        LEFT JOIN grupo AS b ON c.idGrupo = b.idGrupo
        LEFT JOIN bovido AS d ON b.idGrupo = d.idGrupo AND d.causaBaja = ''
        GROUP BY c.nombre, b.idGrupo;";

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