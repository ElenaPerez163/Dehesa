<?php
class Facturas_m extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function clienteFiltro()
    {

        // LEER TODOS LOS CLIENTES PARA USAR EN EL FILTRO DE LA VISTA, ORDENO POR NOMBRE
        $cadSQL = "SELECT idCliente, NombreCli,ApellidosCli FROM cliente ORDER BY 2";
        $this->consultar($cadSQL);
        return $this->resultado();
    }

    public function listado()
    {
        $cadSQL = "select factura.numFactura as número, concat(cliente.NombreCli,' ',cliente.ApellidosCli) as cliente, invertirFecha(factura.fechaFac) as fecha, factura.total as total
        from factura inner join cliente on factura.IdClienteFac=cliente.idCliente
        where factura.numFactura like :numFactura and (cliente.idCliente=:idCliente or :idCliente=0) and (factura.fechaFac between :desde and :hasta) order by 2 desc"; //ordeno por fecha

        $this->consultar($cadSQL);

        $this->enlazar(":numFactura", "%$_POST[numFactura]%");
        $this->enlazar(":idCliente", $_POST['idCliente']);
        $this->enlazar(":desde", $_POST['desde']);
        $this->enlazar(":hasta", $_POST['hasta']);

        return $this->resultado();
    }
}