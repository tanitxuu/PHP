<?php
session_name("Examen_libreria");
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
    if ($datos_usuario_log['tipo'] == 'admin') {
        require "vistas/admin.php";
    } else {
        require "vistas/normal.php";
    }
} else {
    require "vistas/home.php";
}
?>