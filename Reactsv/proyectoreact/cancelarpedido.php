<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:GET,POST, DELETE"); 
header('Content-Type: application/json');

require 'funcion.php';

$id_pedido = $_GET['id_pedido'];

try {
    $consulta = "DELETE FROM `TANIA_pedidos` WHERE id_pedido = ?;";
    $consulta2 = "DELETE FROM `TANIA_pedidos_productos` WHERE id_pedido = ?;";

    $sentencia = $conexion->prepare($consulta);
    $sentencia2 = $conexion->prepare($consulta2);

    $sentencia->execute([$id_pedido]);
    $sentencia2->execute([$id_pedido]);

    echo json_encode(["message" => "Pedido borrado con éxito"]);
} catch (PDOException $e) {
    echo json_encode(["error" => "No he podido conectarse a la base de datos: " . $e->getMessage()]);
    exit;
}
?>
