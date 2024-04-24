<?php
header("Access-Control-Allow-Origin: *");
$_POST = json_decode(file_get_contents("php://input"), true);
require 'funcion.php';
try {
    $consulta = "SELECT * FROM TANIA_productos p INNER JOIN TANIA_categoria c ON p.id_categoria = c.id_categoria WHERE p.id_producto = ?;";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($_POST['categoria']);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de datos: " . $e->getMessage() . "</p>"));
}

$categorias = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($categorias);
?>
