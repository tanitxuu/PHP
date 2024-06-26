<?php

require "src/funciones_servicios.php";
require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;


$app->post('/salir',function($request){
    session_id($request->getParam("api_session"));
    session_start();
    session_destroy();
    $respuesta["log_out"]="Cerrada sesión en la API";
    echo json_encode($respuesta);
});


$app->post('/login',function($request){
    $usuario=$request->getParam("usuario");
    $clave=$request->getParam("clave");

    echo json_encode(login($usuario,$clave));

});

$app->get('/logueado',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
        $usuario=$_SESSION["usuario"];
        $clave=$_SESSION["clave"];
        echo json_encode(logueado($usuario,$clave));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/notasAlumno/{cod_usu}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]))
    {
     
        echo json_encode(obtener_notas_alumno($request->getAttribute("cod_usu")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});


$app->get('/alumnos',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor")
    {
     
        echo json_encode(obtener_alumnos());
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->delete('/quitarNota/{cod_usu}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor")
    {
     
        echo json_encode(quitar_nota_alumno_asig($request->getAttribute("cod_usu"),$request->getParam("cod_asig")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});


$app->put('/cambiarNota/{cod_usu}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor")
    {
     
        echo json_encode(cambiar_nota_alumno_asig($request->getAttribute("cod_usu"),$request->getParam("cod_asig"),$request->getParam("nota")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->get('/notasNoEvalAlumno/{cod_usu}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor")
    {
     
        echo json_encode(obtener_notas_no_eval_alumno($request->getAttribute("cod_usu")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});

$app->post('/ponerNota/{cod_usu}',function($request){

    session_id($request->getParam("api_session"));
    session_start();
    if(isset($_SESSION["usuario"]) && $_SESSION["tipo"]=="tutor")
    {
     
        echo json_encode(poner_nota_asig($request->getAttribute("cod_usu"),$request->getParam("cod_asig")));
    }
    else
    {
        session_destroy();
        $respuesta["no_auth"]="No tienes permisos para usar este servicio";
        echo json_encode($respuesta);
    }

});
// Una vez creado servicios los pongo a disposición
$app->run();
?>
