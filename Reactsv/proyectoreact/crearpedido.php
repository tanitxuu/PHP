<?php
header("Access-Control-Allow-Origin: *");

$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';

$nombre = $_POST['nombrecliente'];
$telefono = $_POST['telefonocliente']; 
$precio = $_POST['cantidadTotal'];

try {
    $consulta = "INSERT INTO TANIA_pedidos (nombre, telefono, precio) VALUES ('$nombre','$telefono','$precio')";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
    
    // Obtener la última ID insertada
    $ultima_id = $conexion->lastInsertId();
    
    // Crear el array de respuesta
    $respuesta = array("ult_id" => $ultima_id);
} catch (PDOException $e) {
    $respuesta = array("mensaje" => "No se pudo insertar");
}

// Devolver la respuesta como JSON
echo json_encode($respuesta);
?>
