<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:GET,POST, DELETE"); 
header('Content-Type: application/json');

$_POST = json_decode(file_get_contents("php://input"), true);
$id_pedido=$_POST['id_pedido'];

require 'funcion.php';
try {
    $consulta = "SELECT 
    pedidos.nombre,
    pedidos.estado,
    pedidos.telefono,
    pedidos.id_pedido,
    pedidos.precio,
    productos.nombre AS producto_nombre,
    pedidos_productos.cantidad ,
    pedidos.direccion,
    pedidos.takeaway
 FROM 
    pedidos_productos 
 INNER JOIN 
    pedidos ON pedidos.id_pedido = pedidos_productos.id_pedido 
 INNER JOIN 
    productos ON pedidos_productos.id_producto = productos.id_producto  
 WHERE 
    pedidos_productos.id_pedido = ?";

    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute([$id_pedido]);
} catch (PDOException $e) {
 ;
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "   Este es el id : $id_pedido</p>"));
}

$categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);

?>
