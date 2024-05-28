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
function logueado($usuario,$clave){
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
    }else{
    $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function usuario($id){
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
        $sentencia->execute([$id]);

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
    }else{
    $respuesta["mensaje"]="Usuario no se encuentra regis. en la BD";
    }
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}
function usuarioGuardia($dia,$hora){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
        
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }

    try{
        $consulta="SELECT hl.dia,hl.hora,u.nombre,u.usuario,u.email,u.id_usuario FROM horario_lectivo hl 
        INNER JOIN usuarios u ON hl.usuario=u.id_usuario 
        INNER JOIN grupos g ON hl.grupo=g.id_grupo 
        where dia=? and hora=? and g.nombre='GUARD'; ";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora]);

    }
    catch(PDOException $e){

        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        $sentencia=null;
        $conexion=null;
        return $respuesta;
    }
 
    //no olvidar el all para cuando es mas de una informacion
    $respuesta["usuarios"]=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    $sentencia=null;
    $conexion=null;
    return $respuesta;
}


?>
