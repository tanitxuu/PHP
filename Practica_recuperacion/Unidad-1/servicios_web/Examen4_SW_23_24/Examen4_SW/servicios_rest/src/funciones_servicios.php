<?php
require "config_bd.php";
function login($usu, $clave) {
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }

    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error al ejecutar la consulta: " . $e->getMessage();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    }

    if ($sentencia->rowCount() > 0) {
        $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);

        session_name('Examen_colegio');
        session_start();

        $_SESSION['usuario'] = $respuesta['usuario']['usuario'];
        $_SESSION['clave'] = $respuesta['usuario']['clave'];
        $_SESSION['tipo'] = $respuesta['usuario']['tipo'];

        $respuesta['api_session'] = session_id();
    } else {
        $respuesta['mensaje'] = "Usuario no se encuentra registrado en la BD";
    }

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($usu,$clave){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu,$clave]);
        if($sentencia->rowCount()>0){

       
            $respuesta['usuario']=$sentencia->fetch(PDO::FETCH_ASSOC);
    
        }
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }  
}
function obtener_alumnos(){
    try{
        $conexion= new PDO("mysql:host=".SERVIDOR_BD.";dbname=".NOMBRE_BD,USUARIO_BD,CLAVE_BD,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES 'utf8'"));
    }
    catch(PDOException $e){
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
    try{
        $consulta="select * from usuarios where tipo='alumno' ";
        $sentencia=$conexion->prepare($consulta);
        $sentencia->execute([]);
    }
    catch(PDOException $e){
        $sentencia=null;
        $conexion=null;
        $respuesta["error"]="Imposible conectar:".$e->getMessage();
        return $respuesta;
    }
 
     $respuesta['alumnos']=$sentencia->fetchAll(PDO::FETCH_ASSOC);

   
    $conexion=null;
    $sentencia=null;
    return $respuesta;
}
function obtener_notas($cod_alu){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "select asignaturas.denominacion,asignaturas.cod_asig, notas.nota 
                     FROM notas 
                     INNER JOIN asignaturas ON notas.cod_asig = asignaturas.cod_asig 
                     INNER JOIN usuarios ON notas.cod_usu = usuarios.cod_usu
                     WHERE notas.cod_usu = ?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
        $respuesta['notas'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }
    
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}


function obtener_notasNO($cod_alu){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "select asignaturas.denominacion, notas.nota 
                     FROM notas 
                     INNER JOIN asignaturas ON notas.cod_asig = asignaturas.cod_asig 
                     WHERE notas.cod_usu = ? AND notas.nota = 0";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu]);
        $respuesta['notas'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }
    
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function borrar($cod_alu,$cod_asig){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "delete FROM notas WHERE cod_usu=? and cod_asig=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu,$cod_asig]);
        $respuesta['mensaje'] = "Asignatura descalificada con éxito";
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }
    
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function poner_nota($cod_alu,$cod_asig){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar: " . $e->getMessage();
        return $respuesta;
    }
    
    try {
        $consulta = "insert INTO `notas`(cod_asig, cod_usu, nota) VALUES (?,?,0)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$cod_alu,$cod_alu]);
        $respuesta['mensaje'] = "Asignatura calificada con éxito";
    } catch (PDOException $e) {
        $respuesta["error"] = "Error en la consulta: " . $e->getMessage();
    }
    
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
//SELECT u.cod_usu, u.nombre AS nombre_usuario, a.cod_asig, a.denominacion AS nombre_asignatura FROM notas n INNER JOIN asignaturas a ON n.cod_asig=a.cod_asig INNER JOIN usuarios u ON n.cod_usu = u.cod_usu WHERE n.nota IS NULL;
?>