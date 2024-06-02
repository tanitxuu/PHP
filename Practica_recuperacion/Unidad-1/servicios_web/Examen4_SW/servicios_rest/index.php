<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;


$app->post('/login', function ($v) {
    $usuario = $v->getParam('usuario');
    $clave = $v->getParam('clave');
    echo json_encode(login($usuario, $clave));

});
$app->get('/logueado', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
{
    echo json_encode(logueado($_SESSION['usuario'], $_SESSION['clave']));
} else{
    $respuesta['log_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});
$app->post('/salir', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    $respuesta['log_out'] = "Cerrada sesión en la API";
    echo json_encode($respuesta);
});

$app->get('/alumnos', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    echo json_encode(obtener_alumnos());

});
$app->get('/notasAlumno/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    $cod_alu = $v->getAttribute('cod_alu');
    echo json_encode(obtener_notas($cod_alu));

});
$app->get('/NotasNoEvalAlumno/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    $cod_alu = $v->getAttribute('cod_alu');
    echo json_encode(obtener_notasNO($cod_alu));

});

$app->delete('/quitarNota/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    $cod_asig = $v->getParam('cod_asig');
    session_id($api);
    session_start();
    session_destroy();
    $cod_alu = $v->getAttribute('cod_alu');
    echo json_encode(borrar($cod_alu,$cod_asig));

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>