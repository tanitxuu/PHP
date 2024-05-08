<?php
header("Access-Control-Allow-Origin: *");

$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';

$id_pedido = $_POST['id_pedido']; 
$id_producto = $_POST['id_producto'];  

try {
    $consulta = "INSERT INTO  TANIA_pedidos_productos  (id_pedido, id_producto) VALUES (?, ?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido, $id_producto]);


    $respuesta["mensaje"] = "Producto insertado con éxito";
   
} catch (PDOException $e) {
    
    $respuesta["mensaje"] = "No se pudo insertar el producto: " . $e->getMessage();
}

echo json_encode($respuesta);
?>
