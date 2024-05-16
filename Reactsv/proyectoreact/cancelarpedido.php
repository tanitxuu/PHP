<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$_POST = json_decode(file_get_contents("php://input"), true);

require 'funcion.php';


$id_pedido=$_POST['id_pedido'];
try {
    $consulta = "DELETE FROM `TANIA_pedidos` WHERE id_pedido = ?;";
    $consulta2 = "DELETE FROM `TANIA_pedidos_productos` WHERE id_pedido = ?;";

    $sentencia = $conexion->prepare($consulta);
    $sentencia2 = $conexion->prepare($consulta2);

    $sentencia->execute([$id_pedido]);
    $sentencia2->execute([$id_pedido]);
    
    echo json_encode(["message" => "Pedido borrado con éxito"]);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;

    die(json_encode(["error" => "No he podido conectarse a la base de datos: " . $e->getMessage()]));
}

?>
