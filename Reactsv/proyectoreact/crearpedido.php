<?php
header('Access-Control-Allow-Origin: *'); 

$_POST = json_decode(file_get_contents("php://input"),true);
require 'funcion.php';
$nombre=$_POST['nombrecliente'];
$tele=$_POST['telefonocliente'];
$precio=$_POST['cantidadTotal'];
try {
    $consulta = "insert into TANIA_pedidos (nombre,telefono,precio) VALUES ('$nombre','$telefono','$precio')";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
    $respuesta["mensaje"]="Acceso correcto";
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}
 echo json_encode($respuesta);
?>