<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
try {
    $consulta = "select i.nombre, pi.id_producto from TANIA_producto_ingrediente pi inner join  TANIA_ingredientes i on pi.id_ingrediente = i.id_ingrediente inner join TANIA_productos p on pi.id_producto = p.id_producto;";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

$categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);
?>
