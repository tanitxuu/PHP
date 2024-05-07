<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

require "src/funciones_api.php";


//LOGIN




//LOGEADO

                                  /*REGISTRO USUARIO*/ 

//1 insertar usuario la clave viene ya con el md5 y el strtoupp
$app->post("/insertar_usuario",function($v){
    $datos[]=$v->getParam("nombre");
    $datos[]=$v->getParam("usuario");
    $datos[]=$v->getParam("clave");
    $datos[]=$v->getParam("dni");
    $datos[]=$v->getParam("sexo");
    $datos[]=$v->getParam("subs");
   
    $respuesta['mensaje']="Usuario insertado con exito";
    echo json_encode(insertar_usu($datos[]));
});

//2 actualizar foto
$app->put("/actualizar_foto/{id_usu}",function($v){
    $datos[]=$v->getParam("foto");
    $datos[]=$v->getAttribute("id_usu");

    echo json_encode(actualizar_foto($datos[]));
});

//3 repetido insertando usuario true o false
$app->get("/repetido_insertar/{tabla}/{columna}/{valor}",function($v){
    $tabla=$v->getAttribute("tabla");
    $columna=$v->getAttribute("columna");
    $valor=$v->getAttribute("valor");
    
    echo json_encode(repetido_insertando($tabla,$columna,$valor));
});

                                    /*PAGINACION*/ 

//1 tabla usuarios todos paginado
$app->get("/obtener_usuarios",function(){
    echo json_encode(obtener_todos_usu());
});

//2 tabla usuarios numeros paginado
$app->get("/obtener_usuarios/{pag}/{n_reg}",function($v){
    $pag=$v->getAttribute('pag');
    $n_reg=$v->getAttribute('n_reg');
    echo json_encode(obtener_num_usu($pag,$n_reg));
});

//3 filtro
$app->get("/obtener_usuarios_filtro",function($v){
    
    echo json_encode(obtener_todos_usu_filtro($v->getParam('buscar')));
});

//4 filtro numero
$app->get("/obtener_usuarios_filtro_pag/{pag}/{n_reg}",function($v){
    $pag=$v->getAttribute('pag');
    $n_reg=$v->getAttribute('n_reg');
    echo json_encode(obtener_todos_usu_filtro_pag($pag,$n_reg,$v->getParam('buscar')));
});


                                    /*DETALLES USUARIOS*/ 


//1 detalles usuarios
$app->get("/detalles_usuarios/{id}",function($v){
    $id_usu=$v->getAttribute("id");
    
    echo json_encode(obtener_detalles_usu($id_usu));
});

//2 borrar usuario
$app->delete("/borrar_usuario/{id}",function($v){
    $id_usu=$v->getAttribute("id");
    
    echo json_encode(borrar_usu($id_usu));
});

//4 editar usuarios con clave
$app->put("/editar_usuario_cc/{id}",function($v){
    $datos[]=$v->getParam("nombre");
    $datos[]=$v->getParam("usuario");
    $datos[]=$v->getParam("clave");
    $datos[]=$v->getParam("dni");
    $datos[]=$v->getParam("sexo");
    $datos[]=$v->getParam("subs");
    $datos[]=$v->getAttribute("id");
    
    echo json_encode(actualizar_usu_cc($datos[]));
});

//5 editar usuarios sin clave
$app->put("/editar_usuario_sc/{id}",function($v){
    $datos[]=$v->getParam("nombre");
    $datos[]=$v->getParam("usuario");
    $datos[]=$v->getParam("clave");
    $datos[]=$v->getParam("dni");
    $datos[]=$v->getParam("sexo");
    $datos[]=$v->getParam("subs");
    $datos[]=$v->getAttribute("id");
    echo json_encode(actualizar_usu_sc($datos[]));
});

//6 repetido editando
$app->get("/repetido_editar/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}",function($v){
    $tabla=$v->getAttribute("tabla");
    $columna=$v->getAttribute("columna");
    $valor=$v->getAttribute("valor");
    $columna_clave=$v->getAttribute("columna_clave");
    $valor_clave=$v->getAttribute("valor_clave");
    
    echo json_encode(repetido_editando($tabla,$columna,$valor,$columna_clave,$valor_clave));
});
 

$app->run();

?>