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
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});
$app->post('/salir', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    $respuesta['no_auth'] = "Cerrada sesión en la API";
    echo json_encode($respuesta);
});

$app->get('/alumnos', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
    {
    echo json_encode(obtener_alumnos());
} else{
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});
$app->get('/notasAlumno/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
    {
    $cod_alu = $v->getAttribute('cod_alu');
    echo json_encode(obtener_notas($cod_alu));
} else{
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});
$app->get('/NotasNoEvalAlumno/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
    {
    $cod_alu = $v->getAttribute('cod_alu');
    echo json_encode(obtener_notasNO($cod_alu));
} else{
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});

$app->delete('/quitarNota/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
    {
    $cod_alu = $v->getAttribute('cod_alu');
    $cod_asig = $v->getParam('cod_asig');
    echo json_encode(borrar($cod_alu,$cod_asig));
} else{
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});
$app->post('/ponerNota/{cod_alu}', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario']))
    {
    $cod_alu = $v->getAttribute('cod_alu');
    $cod_asig = $v->getParam('cod_asig');
    echo json_encode(poner_nota($cod_alu,$cod_asig));
} else{
    session_destroy();
    $respuesta['no_auth']="Usted ya no se encuentra en la bbdd";
    echo json_encode($respuesta);
}

});

// Una vez creado servicios los pongo a disposición
$app->run();
?>