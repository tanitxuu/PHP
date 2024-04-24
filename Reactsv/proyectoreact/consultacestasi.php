<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
try {
    $consulta = "INSERT INTO `TANIA_pedidos_productos`(`id_pedido`, `id_producto`) VALUES (?,?)";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$_POST['pedido'],$_POST['producto']]);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

?>
