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

$app->run();
