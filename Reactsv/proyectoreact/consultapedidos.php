<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:GET,POST, DELETE"); 
header('Content-Type: application/json');


$id_pedido=$_GET['id_pedido'];
require 'funcion.php';
try {
    $consulta = "select TANIA_pedidos.nombre, TANIA_pedidos.telefono, TANIA_pedidos.id_pedido, TANIA_pedidos.precio, TANIA_productos.nombre AS producto_nombre,TANIA_pedidos_productos.cantidad FROM TANIA_pedidos_productos INNER JOIN TANIA_pedidos ON TANIA_pedidos.id_pedido = TANIA_pedidos_productos.id_pedido INNER JOIN TANIA_productos ON TANIA_pedidos_productos.id_producto = TANIA_productos.id_producto where WHERE TANIA_pedidos.id_pedido = 21";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido]);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

$categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);
?>
