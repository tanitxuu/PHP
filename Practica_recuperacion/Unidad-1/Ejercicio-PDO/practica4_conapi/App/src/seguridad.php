<?php
$datos_env['api_key'] = $_SESSION['api_key'];
$respuesta = consumir_servicios_REST(SERVICIOS . "/logeado", "POST", $datos_env);
$json = json_decode($respuesta, true);

if (!$json) {
    session_destroy();
    die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la api</p>"));
}
if (isset($json['error_bd'])) {
    session_destroy();
    $respuesta = consumir_servicios_REST(SERVICIOS . "/salir", "POST", $api_key);
    die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>" . $json['error_bd'] . "</p>"));
}
if (isset($json['no_auth'])) {
    session_unset();
    $_SESSION["seguridad"] = "Usted a dejado de tener acceso a la API.Por favor vuelva a logearse";
    header("Location:index.php");
    exit();
}
if (isset($json['mensaje'])) {
    session_unset();
    $respuesta = consumir_servicios_REST(SERVICIOS . "/salir", "POST", $api_key);
    $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
    header("Location:index.php");
    exit();
}
// Acabo de pasar el control de baneo
$datos_usuario_log = $json['usuario'];

//Ahora paso el control de tiempo

if (time() - $_SESSION["ultm_accion"] > MINUTOS * 60) {
    session_unset();
    $_SESSION["seguridad"] = "Su tiempo de sesión ha expirado. Por favor vuelva a loguearse";
    header("Location:index.php");
    exit();
}
// Paso el control de tiempo y lo renuevo
$_SESSION["ultm_accion"] = time();
