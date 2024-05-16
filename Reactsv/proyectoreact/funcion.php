<?php
define("SERVIDOR_BD", "qahz656.thematic-learning.com");
define("USUARIO_BD", "qaiw208");
define("CLAVE_BD", "1PesetaSpain");
define("NOMBRE_BD", "qahz656");
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}
function error_page($title,$body)
{
    $page='<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'</body>
    </html>';
    return $page;
}
?>