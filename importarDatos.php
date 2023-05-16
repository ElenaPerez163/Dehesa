<?

const DBHOST = "localhost";
const DBNAME = "explotacion";
const DBUSER = "root";
const DBPASSWORD = "";

//conectamos con la base de datos
$dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
$opciones = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"
);

try {
    $conexion = new PDO($dsn, DBUSER, DBPASSWORD, $opciones);
} catch (\Throwable $th) {
    echo "Error " . $th->getMessage();
}



$xml = simplexml_load_file("historico.xml") or die("Error: Cannot create object");

//por cada animal del fichero xml
foreach ($xml->children() as $row) {
    //guardo en variables los datos del animal que me interesan
    $crotal = $row->crotal;
    $explotacionPertenencia = $row->explotacionPertenencia;
    $fechaNacimiento = $row->fechaNacimiento;
    $explotacionNacimiento = $row->explotacionNacimiento;
    $sexo = $row->sexo;
    $raza = $row->raza;
    $crotalMadre = $row->crotalMadre;
    $causaAlta = $row->causaAlta;
    $fechaAlta = $row->fechaAlta;
    $causaBaja=$row->causaBaja;
    $fechaBaja=$row->fechaBaja;
    var_dump($fechaBaja);
    var_dump($fechaAlta);

    //cambio el formato de las fechas para que se inserten bien
    $objeto_DateTime = date_create_from_format("d/m/Y", $fechaNacimiento);
    $fechaNacimiento = date_format($objeto_DateTime, "Y-m-d");

    $objeto_DateTime = date_create_from_format("d/m/Y", $fechaAlta);
    $fechaAlta = date_format($objeto_DateTime, "Y-m-d");

    if($fechaBaja[0]){
        $objeto_DateTime = date_create_from_format("d/m/Y", $fechaBaja);
        $fechaBaja = date_format($objeto_DateTime, "Y-m-d");
    }else{
        $fechaBaja=NULL;
    }

    //selecciono el id de la raza a partir del nombre porque en el xml viene así
    $sql="SELECT idRaza from raza where nombre='$raza'";
    $result = $conexion->query($sql);
    $resultado=$result->fetch(PDO::FETCH_ASSOC);
    if (! empty($result)) {
        echo "raza seleccionada";
        var_dump($resultado);
        $raza=$resultado['idRaza'];
        echo $raza;
    } else {
        $raza=5;
    }

    //realizo la inserción de los datos
    $sql = "INSERT INTO bovido(crotal,explotacionPertenencia,fechaNacimiento,explotacionNacimiento,sexo,raza,crotalMadre,causaAlta,fechaAlta,causaBaja,fechaBaja,tipo) VALUES ('$crotal','$explotacionPertenencia','$fechaNacimiento','$explotacionNacimiento','$sexo','$raza','$crotalMadre','$causaAlta','$fechaAlta','$causaBaja','$fechaBaja',null)";
    $sentencia = $conexion->prepare($sql);
    $result = $sentencia->execute();
    
  
}
?>
<h2>DATOS INSERTADOS</h2>
<?php
$sql="call asignarTipos()";
$sentencia = $conexion->prepare($sql);
$result = $sentencia->execute();
if($result){
    echo "Tipos asignados correctamente";
}

?>