<?php
session_name('Examen_colegio');
session_start();

require "../src/funciones_ctes.php";

if (isset($_POST['salir'])) {
    $datos_env['api_session'] = $_SESSION['api_session'];
    consumir_servicios_REST(DIR_SERV . '/salir', 'POST', $datos_env);
    session_unset();
    header('Location:../index.php');
    exit();
}

if (isset($_SESSION['usuario'])) {
    $salto='../index.php';

    require "../src/seguridad.php";
    if($datos_usuario_log['tipo']=='tutor')

     require "../vistas/vista_tutor.php";
    else
    
    header("Location:../index.php");
    exit();

} else {
    header("Location:../index.php");
    exit();
}
?>