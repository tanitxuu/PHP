<?php
header("Access-Control-Allow-Origin: *");

$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';

$id_pedido = $_POST['id_pedido'];  // Supongamos que este es un array
$id_producto = $_POST['id_producto'];  // Supongamos que este es un array

// Accede a los elementos individuales del array
$id_pedido_primero = $id_pedido[0];  // Suponiendo que quieres el primer elemento del array
$id_producto_primero = $id_producto[0];  // Suponiendo que quieres el primer elemento del array

try {
    $consulta = "INSERT INTO TANIA_pedidos_producto VALUES (?, ?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido_primero, $id_producto_primero]);
    $respuesta["mensaje"] = "producto insertado con exito";
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    $respuesta["mensaje"] = "No se pudo insertar";
}

echo json_encode($respuesta);
?>
