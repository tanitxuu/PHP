<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"),true);
require 'funcion.php';
try {
    $consulta = "select * from TANIA_categoria";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}

$categorias = $sentencia->fetch(PDO::FETCH_ASSOC);

echo $categorias;
echo json_encode($categorias);
?>