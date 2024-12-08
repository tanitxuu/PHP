<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
header('Content-Type: application/json');

// Conexión a la base de datos
require 'funcion.php';

// Capturar los datos de la solicitud PUT
$input = json_decode(file_get_contents("php://input"), true);
$estado_pedido=$input['estado_pedido'];
$id_pedido = $input['id_pedido'];


try {
    $consulta = "UPDATE pedidos SET estado=? WHERE id_pedido=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$estado_pedido,$id_pedido]);
    $respuesta = array("estado" => 'estado cambiado con exito');
} catch (PDOException $e) {
    $respuesta = array("mensaje" => "No se pudo terminar el pedido: " . $e->getMessage());
}

echo json_encode($respuesta);
?>

