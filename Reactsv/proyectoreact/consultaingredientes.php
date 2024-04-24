<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
try {
    $consulta = "SELECT i.nombre FROM TANIA_producto_ingrediente pi INNER JOIN TANIA_ingredientes i ON pi.id_ingrediente = i.id_ingrediente INNER JOIN TANIA_productos p ON pi.id_producto = p.id_producto WHERE pi.id_producto = ?;";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($_POST['producto']);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

$categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);
?>
