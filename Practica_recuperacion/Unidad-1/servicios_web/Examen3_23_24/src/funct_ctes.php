<?php
define("MINUTOS",5);

define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_libreria_exam");


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

// Con cuatro argumentos comprueba si hay repetidos cuándo insertamos
// Con seis argumentos comprueba si hay repetidos cuándo editamos
function repetido($conexion,$tabla,$columna,$valor,$columna_clave=null,$valor_clave=null)
{
    try{
        if(isset($columna_clave)){
            $consulta="select * from ".$tabla." where ".$columna."='".$valor."' AND ".$columna_clave."<>'".$valor_clave."'";
        }else{
            $consulta="select * from ".$tabla." where ".$columna."='".$valor."'";
        }

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute();
            $respuesta=$sentencia->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e)
    {
        $sentencia=null;
        $conexion=null;
        session_destroy();
        $respuesta=$e->getMessage();
    }
    return $respuesta;
}

