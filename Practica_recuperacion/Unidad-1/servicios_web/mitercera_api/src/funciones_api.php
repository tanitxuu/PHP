<?php
require "src/conf_bd.php";

//INSERTAR USUARIO
function insertar_usu($datos)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "insert into usuarios(nombre,usuario,clave,dni,sexo,subscripcion) values(?,?,?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ult_id"] = $conexion->lastInsertId();
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//ACTUALIZAR FOTO   
function actualizar_foto($datos)
{

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "Update usuarios set foto=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["mensaje"] = "Actualizacion realizada con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//REPETIDO INSERTANDO
function repetido_insertando($tabla, $columna, $valor)
{
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor]);

        //esto me devuelve true o false
        $respuesta["repetido"] = $sentencia->rowCount() > 0;
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//PAGINACION (TODOS)
function obtener_todos_usu(){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where tipo<>'admin'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//PAGINACION (NUMEROS)
function obtener_num_usu($pag,$n_reg){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where tipo<>'admin' LIMIT ".$pag." , ".$n_reg."";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//FILTRO TODOS LOS USUARIOS
function obtener_todos_usu_filtro($buscar){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where tipo<>'admin' AND nombre LIKE '%".$buscar."%'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}
//FILTRO  USUARIOS NUMEROS
function obtener_todos_usu_filtro_pag($pag,$n_reg,$buscar){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where tipo<>'admin' AND nombre LIKE '%".$buscar."%' LIMIT ".$pag." , ".$n_reg."";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
        $respuesta["usuarios"] = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//DETALLES DE UN USUARIO
function obtener_detalles_usu($id_usu){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usu]);
        $respuesta["usuario"] = $sentencia->fetch(PDO::FETCH_ASSOC);
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//BORRAR USUARIO
function borrar_usu($id_usu){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {
        $consulta = "delete from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usu]);
        $respuesta["mensaje"] = "Usuario borrado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}

//ACTUALIZAR EDITAR CON CLAVE
function actualizar_usu_cc($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "update usuarios set nombre=?,usuario=?,clave=?,dni=?,sexo=?,subscripcion=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"] = "Usuario editado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}

//ACTUALIZAR EDITAR SIN CLAVE
function actualizar_usu_sc($datos){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }


    try {
        $consulta = "update usuarios set nombre=?,usuario=?,dni=?,sexo=?,subscripcion=? where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute($datos);
        $respuesta["ultm_id"] = "Usuario editado con exito";
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error"] = "Error en la consulta. Error:" . $e->getMessage();
        return $respuesta;
    }
}

//REPETIDO EDITANDO
function repetido_editando($tabla,$columna,$valor,$columna_clave,$valor_clave){
    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        $respuesta["error_bd"] = "Imposible conectar a la BD. Error:" . $e->getMessage();
        return $respuesta;
    }
    try {

        $consulta = "select " . $columna . " from " . $tabla . " where " . $columna . "=? and ".$columna_clave."<>?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$valor,$valor_clave]);

        //esto me devuelve true o false
        $respuesta["repetido"] = $sentencia->rowCount() > 0;
        $sentencia = null;
        $conexion = null;
        return $respuesta;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        $respuesta["error_bd"] = "Error en la consulta:" . $e->getMessage();
        return $respuesta;
    }
}