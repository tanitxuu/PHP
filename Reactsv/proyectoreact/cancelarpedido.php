<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
$id_pedido=$_POST['id_pedido'];
try {
    $consulta = "delete FROM `TANIA_pedidos` WHERE id_pedido=?;";
    $consulta2 = "delete FROM `TANIA_pedidos_productos` WHERE id_pedido=?;";
    $sentencia = $conexion->prepare($consulta);
    $sentencia2 = $conexion->prepare($consulta2);
    $sentencia->execute($id_pedido);
    $sentencia2->execute($id_pedido);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

$categorias = 'Pedido borrado con exito';

echo json_encode($categorias);
?>
