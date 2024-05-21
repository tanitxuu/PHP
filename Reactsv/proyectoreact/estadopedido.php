<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header('Content-Type: application/json');

// Conexión a la base de datos
require 'funcion.php';

// Capturar los datos de la solicitud PUT
$input = json_decode(file_get_contents("php://input"), true);
$id_pedido = $input['id_pedido'];

try {
    $consulta = "UPDATE TANIA_pedidos SET estado='terminado' WHERE id_pedido=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido]);
    $respuesta = array("id" => 'terminado');
} catch (PDOException $e) {
    $respuesta = array("mensaje" => "No se pudo terminar el pedido: " . $e->getMessage());
}

echo json_encode($respuesta);
?>

