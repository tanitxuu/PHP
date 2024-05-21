<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, DELETE"); 
header('Content-Type: application/json');

require 'funcion.php';

try {
    $consulta = "SELECT 
                    p.id_pedido, 
                    p.nombre, 
                    p.estado, 
                    p.telefono, 
                    p.precio, 
                    pr.nombre AS producto_nombre, 
                    pp.cantidad 
                 FROM TANIA_pedidos_productos pp
                 INNER JOIN TANIA_pedidos p ON p.id_pedido = pp.id_pedido
                 INNER JOIN TANIA_productos pr ON pp.id_producto = pr.id_producto;";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    die(json_encode(["error" => "No he podido conectarse a la base de datos: " . $e->getMessage()]));
}

$rows = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Agrupar resultados por id_pedido
$pedidos = [];
foreach ($rows as $row) {
    $id_pedido = $row['id_pedido'];
    if (!isset($pedidos[$id_pedido])) {
        $pedidos[$id_pedido] = [
            "id_pedido" => $row['id_pedido'],
            "nombre" => $row['nombre'],
            "estado" => $row['estado'],
            "telefono" => $row['telefono'],
            "precio" => $row['precio'],
            "productos" => []
        ];
    }
    $pedidos[$id_pedido]['productos'][] = [
        "producto_nombre" => $row['producto_nombre'],
        "cantidad" => $row['cantidad']
    ];
}

echo json_encode(array_values($pedidos));

?>
