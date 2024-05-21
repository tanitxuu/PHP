<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE"); 
header('Content-Type: application/json');


require 'funcion.php';
$_POST = json_decode(file_get_contents("php://input"), true);
$id_pedido=$_POST['id_pedido'];

try {
    $consulta = "UPDATE TANIA_pedidos SET estado='terminado' WHERE id_pedido=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido]);
    $respuesta = array("mensaje" => "Pedido terminado con éxito");
} catch (PDOException $e) {
    $respuesta = array("mensaje" => "No se pudo terminar el pedido: " . $e->getMessage());
}

echo json_encode($respuesta);
?>
