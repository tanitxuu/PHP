<?php
$datos_env["api_session"]=$_SESSION["api_session"];


if(time()-$_SESSION["ult_accion"]>MINUTOS*60)
{
    $conexion=null;
    session_unset();
    $_SESSION["seguridad"]="Su tiempo de sesión ha expirado. Por favor vuelva a loguearse";
    header('Location:../index.php');
    exit();
}
// Paso el control de tiempo y lo renuevo
$_SESSION["ultm_accion"]=time();

?>