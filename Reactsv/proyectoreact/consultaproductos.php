<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods:GET,POST, DELETE"); 
header('Content-Type: application/json');
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
try {
    $consulta = "select * from TANIA_productos";
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