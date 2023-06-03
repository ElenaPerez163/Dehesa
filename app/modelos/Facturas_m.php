<?php
class Facturas_m extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function resumen()
    {
        $cadSQL = "SELECT invertirFecha(fechaFac) as Fecha, numFactura as Número, concat(round(Total,2),'€') as Total FROM factura order by fechaFac DESC limit 3 ";

        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function clienteFiltro()
    {

        // LEER TODOS LOS CLIENTES PARA USAR EN EL FILTRO DE LA VISTA, ORDENO POR NOMBRE
        $cadSQL = "SELECT idCliente, NombreCli,ApellidosCli FROM cliente ORDER BY 2";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function insertarCliente($datos){
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
        $cadSQL = "INSERT INTO cliente ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();
    }

    public function provinciaLista()
    {

        // LEER TODAS LAS PROVINCIAS PARA USAR EN EL FORM DE AÑADIR CLIENTE
        $cadSQL = "SELECT provincia_id,nombre FROM provincias ORDER BY 2";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function traerMunicipios(){
        //CON EL ID DE PROVINCIA SELECCIONAR TODOS LOS MUNICIPIOS 
        $cadSQL="SELECT municipio_id,nombre FROM municipios WHERE provincia_id=:provincia ORDER BY 2";
        $this->consultar($cadSQL);
        $this->enlazar(":provincia", $_POST['ProvinciaCli']);
        return $this->resultado();
    }

    public function listado()
    {
        $cadSQL = "select factura.numFactura as número, concat(cliente.NombreCli,' ',cliente.ApellidosCli) as cliente, invertirFecha(factura.fechaFac) as fecha, round(factura.total,2) as total
        from factura inner join cliente on factura.IdClienteFac=cliente.idCliente
        where factura.numFactura like :numFactura and (cliente.idCliente=:idCliente or :idCliente=0) and (factura.fechaFac between :desde and :hasta) order by 1 asc"; //ordeno por fecha

        $this->consultar($cadSQL);

        $this->enlazar(":numFactura", "%$_POST[numFactura]%");
        $this->enlazar(":idCliente", $_POST['idCliente']);
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }

    public function existeCliente($nif)
    {
        $cadSQL = "SELECT count(*) as existe FROM cliente WHERE NIFCli  = '$nif'";
        $this->consultar($cadSQL);
        return $this->fila()['existe'];  //será 0 o 1
    }

    public function existeFactura($numFactura)
    {
        $cadSQL = "SELECT count(*) as existe FROM factura WHERE numFactura  = '$numFactura'";
        $this->consultar($cadSQL);
        return $this->fila()['existe'];  //será 0 o 1
    }

    public function insertarFactura($datos){
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
        $cadSQL = "INSERT INTO factura ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();

    }

    public function insertarLinea($datos){
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
        $cadSQL = "INSERT INTO lineafactura ($columnas) VALUES ($parametros)";
        $this->consultar($cadSQL);   // Preparar sentencia
        for ($ind = 0; $ind < count($campos); $ind++) {    // Enlace de parametros
            $this->enlazar($campos[$ind], $datos[array_keys($datos)[$ind]]);
        }
        return $this->ejecutar();

    }

    //LEER DATOS PARA GENERAR LA FACTURA
    public function leerFactura($numFactura){
        $cadSQL="SELECT numFactura,fechaFac,round(subtotalFac,2) as subtotalFac,round(ivaFac,2) as ivaFac,round(irpfFac,2) as irpfFac, round(Total,2) as Total 
        FROM `factura` 
        WHERE numFactura='$numFactura'";
        $this->consultar($cadSQL);
       
        return $this->fila();

        
    }

    public function leerLineasFactura($numFactura){
        $cadSQL="SELECT numCrotal,(select sexos(sexo) from bovido where crotal=numCrotal) as sexo,
		(select nombreTipo from tipobovido where idTipo=(select tipo from bovido where crotal=numCrotal) ) as tipo,
        round(precioAnimal,2) as precioAnimal
        FROM `lineafactura` WHERE numFactura='$numFactura'";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function leerCliente($idCliente){
        $cadSQL="SELECT NIFCli,nombreCli,ApellidosCli,DireccionCli,cpostalCli, 
        (select nombre from municipios where PoblacionCli=municipio_id) as PoblacionCli,
        (select nombre from provincias where ProvinciaCli=provincia_id) as ProvinciaCli
        FROM `cliente` WHERE idCliente=$idCliente";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerUsuario($usuario){
        $cadSQL="SELECT nif,nombre,apellidos,cPostal,direccion,(select nombre from municipios where municipio_id=poblacion) as poblacion ,(select nombre from provincias where provincia_id=provincia) as provincia FROM `usuario` WHERE usuario='$usuario'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerFacturaDetalles($numFactura){
        $cadSQL="SELECT numFactura as 'Número',invertirFecha(fechaFac) as Fecha, (SELECT concat(NombreCli,' ',ApellidosCli) from Cliente 
        where idCliente=idClienteFac) as Cliente, concat(round(subtotalFac,2),'€') as Subtotal, concat(round(ivaFac,2),'€') as IVA, concat(round(irpfFac,2),'€') as IRPF, concat(round(Total,2),'€') as Total
        from factura where numFactura='$numFactura'";
        $this->consultar($cadSQL);
        return $this->fila();
    }

    public function leerLineasDetalles($numFactura){
        $cadSQL="SELECT numCrotal as Crotal, concat(round(precioAnimal,2),'€') as precio from lineaFactura where numFactura='$numFactura'";
        $this->consultar($cadSQL);
        return $this->resultado();
    }


    public function borrar($numFactura)
    {
        //AL BORRAR LA FACTURA TRIGGER: CAMBIO DE ESTADO DE ANIMALES (ACTIVOS) Y BORRAR LÍNEAS FACTURA
        $cadSQL = "DELETE FROM factura WHERE numFactura='$numFactura'";
        $this->consultar($cadSQL);
        return $this->ejecutar();
    }
}