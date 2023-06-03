<?php
class Tareas_m extends Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumen(){
        $cadSQL="SELECT invertirFecha(fecha) as fecha,nombre FROM tarea order by fecha DESC limit 3 ";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function listado()
    {
        $cadSQL = "SELECT tarea.idTarea as codigo, invertirFecha(tarea.fecha) as fecha, tarea.nombre as nombre, left(tarea.Descripcion,65) as descripcion FROM tarea where nombre like :nombre and descripcion like :descripcion and (tarea.fecha between :desde and :hasta) order by 2 desc";

        $this->consultar($cadSQL);

        $this->enlazar(":nombre", "%$_POST[nombre]%");
        $this->enlazar(":descripcion", "%$_POST[descripcion]%");
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }

    public function listadoCalendario()
    {
        $cadSQL = "select idTarea,nombre, fecha from tarea";

        $this->consultar($cadSQL);

        return $this->resultado();
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
        $cadSQL = "INSERT INTO tarea ($columnas) VALUES ($parametros)";
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
        $cadSQL = "UPDATE tarea SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE idTarea='$datos[idTarea]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function borrar($id)
    {
        //como no viene de un formulario, no enlazamos parámetros ni nada (no riesgo inyección sql)
        $cadSQL = "DELETE FROM tarea WHERE idTarea='$id'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }

    public function leerTarea($id)
    {
        $cadSQL = "SELECT idTarea,nombre,fecha,descripcion as descripcion FROM tarea WHERE idTarea='$id'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerTareaDetalles($codigo)
    {
        $cadSQL = "select invertirFecha(fecha) as fecha, nombre,descripcion
        from tarea where idTarea='$codigo'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

}