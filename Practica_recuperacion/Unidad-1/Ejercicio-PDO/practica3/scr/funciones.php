<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");

define('MINUTOS',5);
define('FOTO_DEFECTO','no_imagen.jpg');
function LetraNI($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}
function dni_bien_escrito($texto)
{
    $bien_escrito = strlen($texto) == 9  && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
    return $bien_escrito;
}
function dni_valido($texto)
{
    $numero = substr($texto, 0, 8);
    $letra = substr($texto, -1);
    $valido = LetraNI($numero) == $letra;
    return $valido;
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
function repetido($conexion,$tabla,$columna,$usu){
    try {
        $consulta = "select ".$columna." from ".$tabla." where ".$columna."=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu]);
        $respuesta=$sentencia->rowCount()>0;
    } catch (PDOException $e) {
        $respuesta="<p>No he podido conectarse a la consulta: " . $e->getMessage() . "</p>";
    }
    $sentencia = null;
    return $respuesta;
}
?>
