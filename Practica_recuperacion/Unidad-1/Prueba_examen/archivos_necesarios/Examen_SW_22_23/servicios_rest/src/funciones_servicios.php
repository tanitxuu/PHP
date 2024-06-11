<?php
require "config_bd.php";


function login($usu, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu, $clave]);
    } catch (Exception $e) {
        $conexion = null;
        $sentencia = null;
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);

        session_name('Libreria');
        session_start();

        $respuesta['api_session'] = session_id();
        $_SESSION['usuario'] = $respuesta['usuario']['lector'];
        $_SESSION['clave'] = $respuesta['usuario']['clave'];
        $_SESSION['tipo'] = $respuesta['usuario']['tipo'];
    } else {
        $conexion = null;
        $sentencia = null;
        $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function logueado($usu, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "select * from usuarios where lector=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu, $clave]);
    } catch (Exception $e) {
        $conexion = null;
        $sentencia = null;
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else {
        $conexion = null;
        $sentencia = null;
        $respuesta["mensaje"] = "Usuario no se encuentra regis. en la BD";
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function libros()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }
    try {
        $consulta = "select * from libros";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (Exception $e) {
        $conexion = null;
        $sentencia = null;
        $respuesta["error"] = "Imposible conectar:" . $e->getMessage();
    }

    $respuesta['libros'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

?>