<?php
session_name('Practica3');
session_start();

require 'scr/funciones.php';

if (isset($_POST['btnsalir'])) {
    session_destroy();
    header('Location:index.php');
    exit();
}

if (isset($_SESSION['usuario']) || isset($_POST['btnborrar']) || isset($_POST['enviar']) || isset($_POST['borrar']) || isset($_POST['usu']) || isset($_POST['btnnuevousu']) || isset($_POST['btneditar']) || isset($_POST['btnverusu']) || isset($_POST['si'])) {
    require "scr/seguridad.php";
   
    if ($datos_usu_log['tipo'] == 'admin') {
        require "vistas/vista_usuarioAdmin.php";
   
    } else {
        require "vistas/vista_usuarioNormal.php";
       
    }

    $conexion = null;
} elseif (isset($_POST['btnregis']) || isset($_POST['btnEnviar']) || isset($_POST['btnBorrar'])){
    require "vistas/vista_registrar.php";
} else {
    require "vistas/vista_login.php";
}
