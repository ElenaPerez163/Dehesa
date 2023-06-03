<?php
class Facturas_c extends Controller
{

    private $facturas_m;

    public function __construct()
    {
        $this->facturas_m = $this->loadModel(("Facturas_m"));
    }

    public function index()
    {
        $datos['clientes'] = $this->facturas_m->ClienteFiltro();
        $datos['provincias'] = $this->facturas_m->provinciaLista();
        $bovidos_m = $this->loadModel("Bovido_m");
        $datos['crotales'] = $bovidos_m->leerCrotales();
        $contenido = "facturas_v";
        $this->loadView("plantilla/menuLogueado");
        $this->loadView($contenido,$datos);
        $this->loadView("plantilla/pie");
        
    }

    public function listado()
    {
        //recibo parámetros por ajax, por eso paso $_POST
        $datos['facturas'] = $this->facturas_m->listado($_POST);
        // var_dump($_POST);
        echo json_encode($datos);
    }

    public function traerMunicipios(){
        $datos['municipios']=$this->facturas_m->traerMunicipios($_POST);
        echo json_encode($datos);
    }

    public function insertarCliente(){
        $datos['NombreCli']=$_POST['NombreCli'];
        $datos['ApellidosCli']=$_POST['ApellidosCli'];
        $datos['NIFCli']=$_POST['NIFCli'];
        $datos['ProvinciaCli']=$_POST['ProvinciaCli'];
        $datos['PoblacionCli']=$_POST['PoblacionCli'];
        $datos['CpostalCli']=$_POST['CpostalCli'];
        $datos['DireccionCli']=$_POST['DireccionCli'];
        $insertado=$this->facturas_m->insertarCliente($datos);
        //después de insertar el cliente, traemos todos de nuevo y enviamos
        $datos['clientes'] = $this->facturas_m->ClienteFiltro();
        echo json_encode($datos);

    }

    public function existeCliente(){
        echo $this->facturas_m->existeCliente($_REQUEST['NIFCli']);
    }

    public function existeFactura(){
        echo $this->facturas_m->existeFactura($_REQUEST['numFactura']);
    }

    public function insertarFactura(){
        //primero inserto la factura
        //se insertan los datos básicos, las cantidades se actualizan con triggers
        $datos['numFactura']=$_REQUEST["numFactura"];
        $datos['fechaFac']=$_REQUEST["fechaFac"];
        $datos['idClienteFac']=$_REQUEST["idCliente"];
        $insertada=$this->facturas_m->insertarFactura($datos);
        var_dump($insertada);


        //después cada línea de factura
        $lineas=$_REQUEST["lineas"];
        foreach($lineas as $linea){
            $linea["numFactura"]=$_REQUEST["numFactura"];
            $insertada=$this->facturas_m->insertarLinea($linea);
            var_dump($insertada);
        }

        //luego genero el pdf

        $this->generarPDF($datos["numFactura"],$datos["idClienteFac"]);
        header("location:" . $_SERVER['HTTP_REFERER']);
    }

    public function generarPDF($numFactura,$idCliente){
                
        //LEER LOS DATOS DE LA FACTURA
        $datos['factura'] = $this->facturas_m->leerFactura($numFactura);
        $datos['detalleFactura'] = $this->facturas_m->leerLineasFactura($numFactura);

        //LEER LOS DATOS DEL CLIENTE Y DEL USUARIO
        $datos['cliente'] = $this->facturas_m->leerCliente($idCliente);
        $datos['usuario']=$this->facturas_m->leerUsuario($_SESSION['sesion']['usuario']);

        //CARGAR LA LIBRERÍA
        $path_lib = ROOT . PATH_LIBS . "/html2pdf/html2pdf.class.php";
        if (is_file($path_lib)) {
            require_once $path_lib;
        } else {
            throw new Exception("Libreria no existe");
        }

        // Obtener el HTML para crear PDF en content
        ob_start();
        $this->loadView("factura_pdf", $datos);
        $content = ob_get_clean();

        // inicializar HTML2PDF
        try {
            // init HTML2PDF
            $html2pdf = new HTML2PDF('P', 'A4', 'es', true, 'UTF-8', array(0, 0, 0, 0));
            // visualizar a pagina completa
            $html2pdf->pdf->SetDisplayMode('fullpage');
            // convertir
            $html2pdf->writeHTML($content, false);

            // Comprobar si existe documento. Si existe poner numero al nombre del mismo
            $fichero = $datos['factura']['numFactura'] . '.pdf';
            $html2pdf->Output(ROOT . 'app/assets/documentos/' . $fichero, 'F');

            header("location:" . $_SERVER['HTTP_REFERER']);
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }

    }

  public function leerParaDetalles(){
    //leo los datos completos de este parto
    $datos['factura'] = $this->facturas_m->leerFacturaDetalles($_POST['numFactura']);

    $datos['lineas'] = $this->facturas_m->leerLineasDetalles($_POST['numFactura']);
    //busco y leo los otros partos que ha tenido la madre del ternero
   
    echo json_encode($datos);

  }

  public function borrar()
    {
        $borrado = $this->facturas_m->borrar($_POST['numFactura']);
        echo $borrado;
    }

    public function descargar(){
        //genero la ruta
        $ruta=BASE_URL."/app/assets/documentos/".$_REQUEST['numFactura'].".pdf";

        //realizo la descarga
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$_REQUEST['numFactura'].'.pdf"');
        echo readfile($ruta);
    }
}