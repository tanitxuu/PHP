<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

$app->post("/login", function ($v) {
    $usuario = $v->getParam('usuario');
    $clave = $v->getParam('clave');
    echo json_encode(login($usuario, $clave));
});


$app->get('/logueado', function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        echo json_encode(logueado($_SESSION['usuario'], $_SESSION['clave']));
    } else {
        session_destroy();
        $respuesta['no_auth'] = "Usted ya no se encuentra en la bbdd";
        echo json_encode($respuesta);
    }
});

$app->post("/salir", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    session_destroy();
    $respuesta['log_out'] = "Cerrada sesión en la AP";
    echo json_encode($respuesta);

});

$app->get("/profesores", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        echo json_encode(profesores());
    } else {
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get("/horarios/{id_usuario}", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        $id_usuario=$v->getAttribute('id_usuario');
        echo json_encode(horarios($id_usuario));
    } else {
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get("/editar/{id_usuario}", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        $id_usuario=$v->getAttribute('id_usuario');
        $dia=$v->getParam('dia');
        $hora=$v->getParam('hora');
        echo json_encode(editar($id_usuario,$dia,$hora));
    } else {
       
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->delete("/borrar/{id_usuario}", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        $id_usuario=$v->getAttribute('id_usuario');
        $dia=$v->getParam('dia');
        $hora=$v->getParam('hora');
        $grupo=$v->getParam('id_grupo');
        echo json_encode(borrar($id_usuario,$dia,$hora,$grupo));
    } else {
       
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->post("/insertar/{id_usuario}", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        $id_usuario=$v->getAttribute('id_usuario');
        $dia=$v->getParam('dia');
        $hora=$v->getParam('hora');
        $grupo=$v->getParam('id_grupo');
        echo json_encode(insertar($id_usuario,$dia,$hora,$grupo));
    } else {
       
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});

$app->get("/curso/{id_usuario}", function ($v) {
    $api = $v->getParam('api_session');
    session_id($api);
    session_start();
    if (isset($_SESSION['usuario'])) {
        $id_usuario=$v->getAttribute('id_usuario');
        $dia=$v->getParam('dia');
        $hora=$v->getParam('hora');
        echo json_encode(cursos($id_usuario,$dia,$hora));
    } else {
       
        session_destroy();
        $respuesta['no_auth'] = "No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }
});


$app->run();
