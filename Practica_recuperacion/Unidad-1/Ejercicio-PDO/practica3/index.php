<?php
session_name('Practica3');
session_start();

require 'scr/funciones.php';

if (isset($_POST['btnsalir'])) {
    session_destroy();
    header('Location:index.php');
    exit();
}

if (isset($_SESSION['usuario'])) {
    require "scr/seguridad.php";
    if ($datos_usu_log['tipo'] == 'admin') {
        require "vistas/vista_usuarioAdmin.php";
        session_destroy();
    } else {
        require "vistas/vista_usuarioNormal.php";
        session_destroy();
    }
    $conexion = null;
} else if (isset($_POST['btnregis']) || isset($_POST['btnborrar']) || isset($_POST['enviar'])  ){
    require "vistas/vista_registrar.php";
} else {
    require "vistas/vista_login.php";
}
