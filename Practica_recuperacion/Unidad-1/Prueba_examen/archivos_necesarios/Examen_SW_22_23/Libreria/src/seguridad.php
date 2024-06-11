<?php
$datos_env['api_session']=$_SESSION['api_session'];

$respuesta=consumir_servicios_REST(DIR_SERV."/logueado","GET",$datos_env);
$json=json_decode($respuesta,true);

if(!$json){
session_destroy();
die(error_page("Error Examen","<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));
}
if(isset($json['error'])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    die(error_page("Error Examen","<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));
}
if(isset($json['no_auth'])){
session_unset();
$_SESSION['seguridad']="No tienes permisos para usar este servicio";
header("Location:index.php");
exit;
}
if(isset($json['mensaje'])){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    $_SESSION['seguridad']="Usted ya no se encuentra en la BBDD";
    header("Location:index.php");
    exit;
}
$datos_usuario_log=$json['usuario'];

if(time()-$_SESSION['ult_accion']>MINUTOS*60){
    session_unset();
    consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
    $_SESSION['seguridad']="Su tiempo a expirado,vuelva a loguearse por favor";
    header("Location:index.php");
    exit;


}

$_SESSION['ult_accion']=time();
?>