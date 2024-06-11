<?php
require "config_bd.php";



function login($usuario,$clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
        session_name("API_ExamRec_23_24");
        session_start();
        $_SESSION["usuario"]=$respuesta["usuario"]["usuario"];
        $_SESSION["clave"]=$respuesta["usuario"]["clave"];
        
        $respuesta["api_session"]=session_id();
    }
    else
    {
        $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function logueado($usuario,$clave)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where usuario=? and clave=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$usuario,$clave]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
        $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function usuario($id_usuario)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select * from usuarios where id_usuario=?";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

    if($sentencia->rowCount()>0)
    {
        $respuesta["usuario"]=$sentencia->fetch(PDO::FETCH_ASSOC);
    }
    else
    {
        $respuesta["mensaje"]="El usuario con ".$id_usuario." no se encuentra registrado en la BD";
    }

    $sentencia=null;
    $conexion=null;
    return $respuesta;
}

function usuariosGuardia($dia,$hora)
{
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="select u.id_usuario,u.nombre FROM `horario_lectivo` h INNER JOIN usuarios u ON h.usuario=u.id_usuario INNER JOIN grupos g ON h.grupo=g.id_grupo where dia=? and hora = ? and grupo=51;";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora]);
        $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia=null;
        $conexion=null;
        return $respuesta;

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }

  
}



?>
