<?php
class Partos_m extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $cadSQL = "SELECT invertirFecha(fechaParto) as fecha,crotalMadre as madre, asistido(esAsistido) as asistido FROM parto order by fechaParto DESC limit 3";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function esAsistido($crotal)
    {
        $cadSQL = "SELECT esAsistido, observaciones from parto where crotalTernero='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerParto($crotal)
    {
        $cadSQL = "SELECT parto.crotalTernero as crotalTernero, parto.crotalMadre as crotalMadre, parto.crotalPadre as crotalPadre,fechaParto, esAsistido,observaciones FROM parto WHERE crotalTernero='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerPartosAnimal($crotal)
    {
        $cadSQL = "SELECT * FROM parto WHERE crotalMadre='$crotal'";
        $this->consultar($cadSQL);
        return $this->resultado(); //una madre puede tener más de un parto
    }

    public function leerPartosDetAnimal($crotal)
    {
        $cadSQL = "SELECT invertirFecha(parto.fechaParto) as fecha, parto.crotalTernero as ternero, asistido(parto.esAsistido) as asistido from parto where parto.crotalMadre like '%$crotal%'";
        $this->consultar($cadSQL);
        return $this->resultado(); //una madre puede tener más de un parto
    }

    public function listado()
    {
        $cadSQL = "select invertirFecha(parto.fechaParto) as fecha, parto.crotalMadre as madre, parto.crotalTernero as ternero, asistido(parto.esAsistido) as asistido, parto.observaciones as observaciones
        from parto
        where parto.crotalTernero like :crotal and parto.crotalMadre like :crotalMadre and (parto.fechaParto between :desde and :hasta)";

        if (!empty($_POST['asistido'])) $cadSQL .= " and (parto.esAsistido=1)";

        $cadSQL.=" order by 2 desc";

        $this->consultar($cadSQL);

        $this->enlazar(":crotal", "%$_POST[crotal]%");
        $this->enlazar(":crotalMadre", "%$_POST[crotalMadre]%");
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }

    //leer un parto para mostrarlo en modal de detalles
    public function leerPartoDetalles($crotal)
    {
        $cadSQL = "select invertirFecha(parto.fechaParto) as Fecha, asistido(parto.esAsistido) as Asistido, parto.crotalTernero as Ternero, parto.crotalMadre as Madre, parto.crotalPadre as Padre, parto.observaciones as Observaciones
        from  parto where parto.crotalTernero='$crotal'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    //buscar el crotal de una madre a partir del de su ternero
    public function leerCrotalMadre($crotal)
    {
        $cadSQL = "select parto.crotalMadre as madre from parto where parto.crotalTernero='$crotal'";
        $this->consultar($cadSQL);
        $madre = $this->fila()['madre'];

        return $this->leerPartosDetAnimal($madre);
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
        $cadSQL = "INSERT INTO parto ($columnas) VALUES ($parametros)";
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
        $cadSQL = "UPDATE parto SET ";
        // Poner todos los campos y parametros
        for ($ind = 0; $ind < count($campos); $ind++) {
            $cadSQL .= array_keys($datos)[$ind] . "=" . $campos[$ind] . ",";
        }
        $cadSQL = substr($cadSQL, 0, strlen($cadSQL) - 1); // quitar la ultima coma
        $cadSQL .= " WHERE crotalTernero='$datos[crotalTernero]'"; // Añadir el WHERE
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function borrar($crotal)
    {
        //como no viene de un formulario, no enlazamos parámetros ni nada (no riesgo inyección sql)
        $cadSQL = "DELETE FROM parto WHERE crotalTernero='$crotal'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
}
