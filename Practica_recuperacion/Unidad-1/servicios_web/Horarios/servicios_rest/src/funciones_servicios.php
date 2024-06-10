<?php
require "config_bd.php";

function login($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        $conexion = null;
        $sentencia = null;
        return $respuesta;
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);

        session_name("Horarios1");
        session_start();

        $_SESSION['usuario'] = $respuesta['usuario']['usuario'];
        $_SESSION['clave'] = $respuesta['usuario']['clave'];

        $respuesta['api_session'] = session_id();

    } else {
        $conexion = null;
        $sentencia = null;
        $respuesta["mensaje"] = "El usuario no se encuentra en la bbdd";
        return $respuesta;
    }
    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function logueado($usuario, $clave)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usuario, $clave]);
        if ($sentencia->rowCount() > 0) {


            $respuesta['usuario'] = $sentencia->fetch(PDO::FETCH_ASSOC);

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
function profesores()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }

    $respuesta['profesores'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function horarios($id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * FROM `horario_lectivo` INNER JOIN grupos ON horario_lectivo.grupo=grupos.id_grupo where usuario=? ;";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }

    $respuesta['horario'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function editar($id_usuario,$dia,$hora)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * FROM `horario_lectivo` INNER JOIN grupos ON horario_lectivo.grupo=grupos.id_grupo where usuario=? and dia=? and hora=? ";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario,$dia,$hora]);
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }

    $respuesta['editar'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

function borrar($id_usuario,$dia,$hora,$grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "DELETE FROM `horario_lectivo` where usuario=? and dia=? and hora=? and grupo=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario,$dia,$hora,$grupo]);
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }

    $respuesta['mensaje'] ="Grupo borrado con exito del horario";

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function insertar($id_usuario,$dia,$hora,$grupo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "INSERT INTO `horario_lectivo`(`usuario`, `dia`, `hora`, `grupo`) VALUES (?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario,$dia,$hora,$grupo]);
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }

    $respuesta['mensaje'] ="Grupo insertado con exito del horario";

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}
function cursos($dia,$hora,$id_usuario)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "SELECT g.id_grupo, g.nombre FROM grupos g LEFT JOIN horario_lectivo h ON g.id_grupo = h.grupo AND h.dia = ? AND h.hora = ? AND h.usuario = ? WHERE h.grupo IS NULL;)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$dia,$hora,$id_usuario]);
    } catch (PDOException $e) {
        $conexion = null;
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    $respuesta['cursos'] = $sentencia->fetchAll(PDO::FETCH_ASSOC);

    $conexion = null;
    $sentencia = null;
    return $respuesta;
}

?>