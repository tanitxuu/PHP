<?php

require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

require "src/funciones.php";

//Parte A (funcion en la carpeta src)
$app->get("/productos", function () {
    echo json_encode(obtener_productos());
});

//Parte B 
$app->get("/productos/{cod}", function ($request) {
    echo json_encode(obtener_producto($request->getAttribute("cod")));
});

//Parte C
$app->post("/producto/insertar", function ($request) {
    $datos[] = $request->getParam('cod');
    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('nombre_corto');
    $datos[] = $request->getParam('descripcion');
    $datos[] = $request->getParam('PVP');
    $datos[] = $request->getParam('familia');
    echo json_encode(insertar_producto($datos));
});
//parte D
$app->put("/producto/actualizar/{cod}", function ($request) {
    
    $datos[] = $request->getParam('nombre');
    $datos[] = $request->getParam('nombre_corto');
    $datos[] = $request->getParam('descripcion');
    $datos[] = $request->getParam('PVP');
    $datos[] = $request->getParam('familia');
    $datos[] = $request->getAttribute('cod');
    echo json_encode(actualizar_producto($datos));
});
//parte E
$app->delete("/producto/borrar/{cod}", function ($request) {
    
    echo json_encode(borrar_producto($request->getAttribute("cod")));
});
//parte F
$app->get("/familias", function () {
    echo json_encode(obtener_familia());
});
//parte G
$app->get("/repetido/{tabla}/{columna}/{valor}", function ($request) {
    echo json_encode(repetido_insertar($request->getAttribute("tabla"),$request->getAttribute("columna"),$request->getAttribute("valor")));
});
// parte h
$app->get("/repetido/{tabla}/{columna}/{valor}/{columna_id}/{valor_id}", function ($request) {
    echo json_encode(repetido_editar($request->getAttribute("tabla"),$request->getAttribute("columna"),$request->getAttribute("valor"),$request->getAttribute("columna_id"),$request->getAttribute("valor_id")));
});
$app->run();
