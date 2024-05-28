<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;




$app->post('/login', function ($request) {

    $usuario = $request->getParam("usuario");
    $clave = $request->getParam("clave");


    echo json_encode(login($usuario, $clave));
});


$app->post('/salir', function ($request) {

    $api_session = $request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("no_auth" => "Cerrada sesión en la API"));
});

$app->get("/logueado", function ($v) {
    $api_session = $v->getParam("api_session");
    session_id($api_session);
    session_start();
    if (isset($_SESSION["usuario"])) {
        echo json_encode(logueado($_SESSION["usuario"], $_SESSION["clave"]));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Cerrada sesión en la API"));
    }
});
$app->get("/usuario/{id_usuario}", function ($v) {
    $api_session = $v->getParam("api_session");
    session_id($api_session);
    session_start();
    $id_usuario = $v->getAttribute("id_usuario");
    if (isset($_SESSION["usuario"])) {

        echo json_encode(usuario($id_usuario));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Cerrada sesión en la API"));
    }
});
$app->get("/usuariosGuardia/{dia}/{hora}", function ($v) {
    $api_session = $v->getParam("api_session");
    session_id($api_session);
    session_start();
    $dia = $v->getAttribute("dia");
    $hora = $v->getAttribute("hora");
    if (isset($_SESSION["usuario"])) {

        echo json_encode(usuarioGuardia($dia, $hora));
    } else {
        session_destroy();
        echo json_encode(array("no_auth" => "Cerrada sesión en la API"));
    }
});


// Una vez creado servicios los pongo a disposición
$app->run();
