<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,POST,DELETE"); 
header('Content-Type: application/json');

$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';

$datos[] = $_POST['id_pedido']; 
$datos[] = $_POST['id_producto'];  
$datos[]= $_POST['cantidad'];

try {
    $consulta = "insert into pedidos_productos(id_pedido, id_producto,cantidad) VALUES (?, ? , ?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($datos);


    $respuesta["mensaje"] = "Producto insertado con éxito";
   
} catch (PDOException $e) {
    
    $respuesta["mensaje"] = "No se pudo insertar el producto: " . $e->getMessage();
}

echo json_encode($respuesta);
?>
