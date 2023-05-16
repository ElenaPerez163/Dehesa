<?php

class Bovido_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $cadSQL = "SELECT invertirFecha(fechaNacimiento) as fecha,crotal,sexos(sexo) as sexo FROM bovido order by fechaNacimiento DESC limit 3";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function listado()
    {
        $cadSQL = "select bovido.crotal as crotal, bovido.nombre as nombre, grupo.nombre as grupo, finca.nombre as finca, invertirFecha(bovido.fechaNacimiento) as nacimiento, bovido.crotalMadre as madre 
        from bovido inner join grupo on bovido.idGrupo=grupo.idGrupo inner join finca on grupo.idGrupo=finca.idGrupo where grupo.idGrupo=finca.idGrupo and causaBaja='' and crotal like :crotal and bovido.crotalMadre like :crotalMadre and (bovido.raza=:raza or :raza=0) and (bovido.idGrupo=:grupo or :grupo=0) and (bovido.fechaNacimiento between :desde and :hasta)";

        $this->consultar($cadSQL);

        $this->enlazar(":crotal", "%$_POST[crotal]%");
        $this->enlazar(":crotalMadre", "%$_POST[crotalMadre]%");
        $this->enlazar(":raza", $_POST['raza']);
        $this->enlazar(":grupo", $_POST['grupo']);
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }

    //aunque tipos sea una tabla separada, como solo la voy a usar para esto por ahora meto el leer tipos en bóvido_m
    public function leerTipos()
    {
        // Este metodo lee todas las familias y las devuelve
        $cadSQL = "SELECT * FROM tipobovido ORDER BY 1";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function buscar($crotal)
    {
        $cadSQL = "SELECT * FROM bovido WHERE crotal='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerAnimal($crotal)
    {
        $cadSQL = "SELECT bovido.crotal as crotal, bovido.crotalMadre as crotalMadre, explotacionPertenencia, explotacionNacimiento, fechaNacimiento, raza, sexo, causaAlta, idGrupo, tipo FROM bovido WHERE crotal='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerAnimalCompleto($crotal)
    {
        $cadSQL = "SELECT * FROM bovido WHERE crotal='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerAnimalDetalles($crotal)
    {
        $cadSQL = "select bovido.crotal as Crotal, invertirFecha(bovido.fechaNacimiento) as 'F. Nacimiento', sexos(bovido.sexo) as Sexo,(select raza.nombre from raza where raza.idRaza=bovido.raza) as Raza, bovido.causaAlta as 'Causa Alta', invertirFecha(bovido.fechaAlta) as 'Fecha Alta', (select tipobovido.nombreTipo from tipobovido where tipobovido.idTipo=bovido.tipo) as Tipo, (select grupo.nombre from grupo where grupo.idGrupo=bovido.idGrupo) as Grupo, bovido.crotalMadre as 'Crotal Madre', bovido.explotacionPertenencia as 'Exp. Pertenencia', bovido.explotacionNacimiento as 'Exp. Nacimiento' from bovido where causaBaja='' and crotal like '%$crotal%'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function insertar($datos)
    {
        // Recibimos los datos del formulario en un array
        // Obtenemos cadena con las columnas desde las claves del array asociativo
        $columnas = implode(",", array_keys($datos));
        // Campos de columnas
        $campos = array_map(
            function ($col) {
                return ":" . $col;
            },
            array_keys($datos)
        );
        $parametros = implode(",", $campos); // Parametros para enlazar
        $cadSQL = "INSERT INTO bovido ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function modificar($datos)
    {
        // Recibimos los datos del formulario en un array
        // Obtenemos cadena con las columnas desde las claves del array asociativo
        $columnas = implode(",", array_keys($datos));
        // Campos de columnas
        $campos = array_map(
            function ($col) {
                return ":" . $col;
            },
            array_keys($datos)
        );
        $cadSQL = "UPDATE bovido SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE crotal='$datos[crotal]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function borrar($crotal)
    {
        //como no viene de un formulario, no enlazamos parámetros ni nada (no riesgo inyección sql)
        $cadSQL = "DELETE FROM bovido WHERE crotal='$crotal'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }

    public function existeAnimal($crotal)
    {
        $cadSQL = "SELECT count(*) as existe FROM bovido WHERE crotal  = '$crotal'";
        $this->consultar($cadSQL);
        return $this->fila()['existe'];  //será 0 o 1
    }

    public function leerCrotales()
    {
        $cadSQL = "SELECT crotal from bovido where causaBaja=''";
        $this->consultar($cadSQL);
        return $this->resultado();
    }
}
