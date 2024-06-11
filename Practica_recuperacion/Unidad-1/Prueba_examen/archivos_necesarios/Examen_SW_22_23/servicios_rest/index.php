<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;



$app->post('/login',function($v){
    $usu=$v->getParam('usuario');
    $clave=$v->getParam('clave');
    echo json_encode(login($usu,$clave));
});


$app->get('/logueado',function($v){
    $api=$v->getParam('api_session');
   session_id($api);
   session_start();
   if(isset($_SESSION['usuario'])){
    echo json_encode(logueado($_SESSION['usuario'],$_SESSION['clave']));
   }else{
    session_destroy();
    $respuesta['no_auth']="No tienes permisos para usar este servicio";
    echo json_encode($respuesta);
   }
});

$app->post('/salir',function($v){
    $api=$v->getParam('api_session');
   session_id($api);
   session_start();
    session_destroy();
    $respuesta['log_out']="No tienes permisos para usar este servicio";
    echo json_encode($respuesta);
});

$app->get('/obtenerLibros',function($v){
  
echo json_encode(libros());
  
});



// Una vez creado servicios los pongo a disposición
$app->run();
?>
