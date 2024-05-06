<?php

require __DIR__ . '/Slim/autoload.php';

$app= new \Slim\App;

//LOGIN




//LOGEADO


//1 tabla libros y libro paginado
$app->get("/obtener_libros",function(){

    $respuesta['libros']="json con libros";
    echo json_encode($respuesta);
});

//2 detalles libros
$app->get("/detalles_libros/{id}",function($v){
    $id_libro=$v->getAttribute("id");
    $respuesta['libros']="json con los detalles del libro";
    echo json_encode($respuesta);
});

//3 borrar libros
$app->delete("/borrar_libros/{id}",function($v){
    $id_libro=$v->getAttribute("id");
    $respuesta['mensaje']="Libro borrado con exito";
    echo json_encode($respuesta);
});

//4 editar libros
$app->put("/editar_libro/{id}",function($v){
    $id_libro=$v->getAttribute("id");
    $nombre=$v->getParam("nombre");
    $autor=$v->getParam("autor");
    //todos los datos faltantes
    $respuesta['mensaje']="Libro editado con exito";
    echo json_encode($respuesta);
});

//5 insertar libros
$app->post("/insertar_libro",function($v){
    $id_libro=$v->getParam("id");
    $nombre=$v->getParam("nombre");
    $autor=$v->getParam("autor");
    //todos los datos faltantes
    $respuesta['mensaje']="libro insertado con exito";
    echo json_encode($respuesta);
});


//6 repetido insertar
$app->get("/repetido_insertar/{tabla}/{columna}/{valor}",function($v){
    $tabla=$v->getAttribute("tabla");
    $columna=$v->getAttribute("columna");
    $valor=$v->getAttribute("valor");
    $respuesta['repetido']="valor repetido o no";
    echo json_encode($respuesta);
});

//7 repetido editar
$app->get("/repetido_editar/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}",function($v){
    $tabla=$v->getAttribute("tabla");
    $columna=$v->getAttribute("columna");
    $valor=$v->getAttribute("valor");
    $columna_clave=$v->getAttribute("columna_clave");
    $valor_clave=$v->getAttribute("valor_clave");
    $respuesta['repetido']="valor repetido o no";
    echo json_encode($respuesta);
});
 

//9 actualizar foto
$app->put("/actualizar_foto/{id}",function($v){
    $id_libro=$v->getAttribute("id");
    $nombre_foto=$v->getParam("nombre_foto");

    $respuesta['mensaje']="Foto actualizada";
    echo json_encode($respuesta);
});

$app->run();

?>