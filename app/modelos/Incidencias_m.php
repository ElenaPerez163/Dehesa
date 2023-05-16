<?php
class Incidencias_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $cadSQL = "SELECT invertirFecha(fechaIncidencia) as fecha,(select nombreInc from tipoincidencia where idTipoInc=tipo) as tipo, crotal FROM incidencia order by fechaIncidencia DESC limit 3 ";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function tiposInc()
    {

        // Este metodo lee todas las familias y las devuelve
        $cadSQL = "SELECT * FROM tipoincidencia ORDER BY 1";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function leerIncidencia($id)
    {
        $cadSQL = "SELECT idIncidencia,crotal, fechaIncidencia,tipo,Descripcion as descripcion FROM incidencia WHERE idIncidencia='$id'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerIncidenciasAnimal($crotal)
    {
        $cadSQL = "SELECT (select tipoincidencia.nombreInc from tipoincidencia where tipoincidencia.idTipoInc=incidencia.tipo) as tipo, invertirFecha(incidencia.fechaIncidencia) as fecha from incidencia where incidencia.crotal like '%$crotal%'";
        $this->consultar($cadSQL);
        return $this->resultado(); //un animal puede tener más de una incidencia

    }

    public function listado()
    {
        $cadSQL = "select idIncidencia as codigo, tipoincidencia.nombreInc as tipo, incidencia.crotal as crotal, left(Descripcion,55) as descripcion, invertirFecha(incidencia.fechaIncidencia) as fecha
        from incidencia inner join tipoincidencia on incidencia.tipo=tipoincidencia.idTipoInc
        where crotal like :crotal and (incidencia.tipo=:tipo or :tipo=0) and (incidencia.fechaIncidencia between :desde and :hasta) order by 5 desc";

        $this->consultar($cadSQL);

        $this->enlazar(":crotal", "%$_POST[crotal]%");
        $this->enlazar(":tipo", $_POST['idTipoInc']);
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }

    //leer un parto para mostrarlo en modal de detalles
    public function leerIncidenciaDetalles($codigo)
    {
        $cadSQL = "select (select tipoincidencia.nombreInc
        from tipoincidencia
        where incidencia.tipo=tipoincidencia.idTipoInc) as Tipo, incidencia.crotal as Crotal,invertirFecha(incidencia.fechaIncidencia) as Fecha,  incidencia.Descripcion as Descripcion
        from incidencia where idIncidencia='$codigo'";
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
        $cadSQL = "INSERT INTO incidencia ($columnas) VALUES ($parametros)";
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
        $cadSQL = "UPDATE incidencia SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE idIncidencia='$datos[idIncidencia]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }


    public function borrar($id)
    {
        //como no viene de un formulario, no enlazamos parámetros ni nada (no riesgo inyección sql)
        $cadSQL = "DELETE FROM incidencia WHERE idIncidencia='$id'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
}
