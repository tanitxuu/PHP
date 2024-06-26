<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;




$app->post('/login',function($request){

    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");


    echo json_encode(login($usuario,$clave));
});


$app->post('/logueado',function($request){
    $api=$request->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario'])){
        echo json_encode(logueado($_SESSION['usuario'],$_SESSION['clave']));
    }else{
        session_destroy();
        $respuesta['no_auth']='Usuario no identificado';
        echo json_encode($respuesta);
    }
});

$app->post('/salir',function($request){

    $api_session=$request->getParam("api_session");
    session_id($api_session);
    session_start();
    session_destroy();
    echo json_encode(array("log_out"=>"Cerrada sesión en la API"));
});

$app->get('/usuario/{id_usuario}',function($v){
    $api=$v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario'])){
        $id_usuario=$v->getAttribute('id_usuario');
        echo json_encode(usuario($id_usuario));
    }else{
        session_destroy();
        $respuesta['no_auth']='Usuario no identificado';
        echo json_encode($respuesta);
    }
});

$app->get('/usuariosGuardia/{dia}/{hora}',function($v){
    $api=$v->getParam('api_session');
    session_id($api);
    session_start();
    if(isset($_SESSION['usuario'])){
        $dia=$v->getAttribute('dia');
        $hora=$v->getAttribute('hora');
        echo json_encode(usuariosGuardia($dia,$hora));
    }else{
        session_destroy();
        $respuesta['no_auth']='Usuario no identificado';
        echo json_encode($respuesta);
    }
});


// Una vez creado servicios los pongo a disposición
$app->run();
?>
