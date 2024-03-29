<?php
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_foro2");
//parte A
function obtener_usuarios()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//Parte B
function obtener_producto($codigo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "select * from producto where cod=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta["productos"] = $sentencia->fetch(PDO::FETCH_ASSOC);
    } else
        $respuesta["mensaje"] = "El producto con cod:" . $codigo . " no se encuentra";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//Parte C
function insertar_usuario($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "insert into usuarios(nombre,usuario,clave,email,tipo) VALUE(?,?,?,?,?,)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }

    $respuesta["mensaje"] = "El producto se ha insertado correctamente";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//parte D
function actualizar_producto($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "update producto set nombre=?, nombre_corto=?,descripcion=?,PVP=?,familia=? where cod=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El producto se ha actualizado correctamente";
    } else
        $respuesta["mensaje"] = "El producto no se ha actualizado icorrectamente";



    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//parte E
function borrar_producto($codigo)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "delete from producto where cod=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$codigo]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    if ($sentencia->rowCount() > 0) {
        $respuesta["mensaje"] = "El producto se ha borrado correctamente";
    } else
        $respuesta["mensaje"] = "El producto con cod:" . $codigo . " no se encuentra";

    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//parte F
function obtener_familia()
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "select * from familia";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    $respuesta["productos"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//parte G
function repetido_insertar($tabla,$columna,$valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "select * from ".$tabla." where ".$columna."=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    $respuesta["repetido"] = ($sentencia->rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}
//parte H
function repetido_editar($tabla,$columna,$valor,$columna_id,$valor_id)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {

        return array("mensaje_error" => "No he podido conectarse a la base de batos: " . $e->getMessage());
    }
    try {

        $consulta = "select * from ".$tabla." where ".$columna."=? AND ".$columna_id."<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_id]);
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        return array("mensaje_error" => "No he podido realizar la consulta: " . $e->getMessage());
    }
    $respuesta["repetido"] = ($sentencia->rowCount()) > 0;
    $sentencia = null;
    $conexion = null;
    return $respuesta;
}