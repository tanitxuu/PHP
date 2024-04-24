<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");

define('MINUTOS',5);
define('FOTO_DEFECTO','no_imagen.jpg');
define("RECAPTCHA_V3_SECRET_KEY", '6Lc5GsQpAAAAAFPpRdTtm25cHzNbfr-h0xkcaT57');
function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}

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
function repetido_editando($conexion, $tabla, $columna, $valor,$columna_clave,$valor_clave)
{
    try{
     
        $consulta = "SELECT ".$columna." from ".$tabla." where ".$columna."=? AND ".$columna_clave."<>?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_clave]);
        $respuesta=$sentencia->rowCount()>0;
    }
    catch(PDOException $e){
        
        $respuesta="Imposible realizar la consulta. Error:".$e->getMessage();
    }

    $sentencia=null;
    return $respuesta;
}
?>
