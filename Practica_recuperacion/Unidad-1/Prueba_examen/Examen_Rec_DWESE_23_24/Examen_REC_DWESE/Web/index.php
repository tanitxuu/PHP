<?php
session_name("ExamenRec_SW_23_24");
session_start();

require "src/funciones.php";
if (isset($_POST['salir'])) {
    $datos_env['api_session'] = $_SESSION['api_session'];
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    session_destroy();
    header("Location:index.php");
    exit;
}

if (isset($_SESSION['usuario'])) {
    require "src/seguridad.php";

    require "vistas/vista_profesor.php";
} else {
    require "vistas/vista_home.php";
}
?>