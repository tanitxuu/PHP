<?php
require __DIR__ . '/Slim/autoload.php';

$app = new \Slim\App;

require "src/funciones_api.php";


/*LOGIN*/

//1 salir
$app->post("/salir", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    session_destroy();
    $respuesta['logout'] = 'Sesion cerrada';
    echo json_encode($respuesta);
});

//2 logearse
$app->post("/login", function ($v) {
    $datos[] = $v->getParam("usuario");
    $datos[] = $v->getParam("clave");

    echo json_encode(login($datos[]));
});

/*REGISTRO USUARIO*/

//1 insertar usuario la clave viene ya con el md5 y el strtoupp
$app->post("/insertar_usuario", function ($v) {
    $datos[] = $v->getParam("nombre");
    $datos[] = $v->getParam("usuario");
    $datos[] = $v->getParam("clave");
    $datos[] = $v->getParam("dni");
    $datos[] = $v->getParam("sexo");
    $datos[] = $v->getParam("subs");

    echo json_encode(insertar_usu($datos[]));
});

//2 actualizar foto
$app->put("/actualizar_foto/{id_usu}", function ($v) {
    $datos[] = $v->getParam("nombre_foto");
    $datos[] = $v->getAttribute("id_usu");

    echo json_encode(actualizar_foto($datos[]));
});

//3 repetido insertando usuario true o false
$app->get("/repetido_insertar/{tabla}/{columna}/{valor}", function ($v) {
    $tabla = $v->getAttribute("tabla");
    $columna = $v->getAttribute("columna");
    $valor = $v->getAttribute("valor");

    echo json_encode(repetido_insertando($tabla, $columna, $valor));
});

/*LOGEADO*/

$app->post("/logeado", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario'])) {

        $datos[] = $_SESSION['usuario'];
        $datos[] = $$_SESSION['clave'];

        echo json_encode(logeado($datos[]));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

/*PAGINACION*/

//1 tabla usuarios todos paginado
$app->get("/obtener_usuarios", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        echo json_encode(obtener_todos_usu());
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//2 tabla usuarios numeros paginado
$app->get("/obtener_usuarios/{pag}/{n_reg}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $pag = $v->getAttribute('pag');
        $n_reg = $v->getAttribute('n_reg');
        echo json_encode(obtener_num_usu($pag, $n_reg));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//3 filtro
$app->get("/obtener_usuarios_filtro", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        echo json_encode(obtener_todos_usu_filtro($v->getParam('buscar')));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//4 filtro numero
$app->get("/obtener_usuarios_filtro_pag/{pag}/{n_reg}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $pag = $v->getAttribute('pag');
        $n_reg = $v->getAttribute('n_reg');
        echo json_encode(obtener_todos_usu_filtro_pag($pag, $n_reg, $v->getParam('buscar')));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});


/*DETALLES USUARIOS*/

//1 detalles usuarios
$app->get("/detalles_usuarios/{id}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $id_usu = $v->getAttribute("id");

        echo json_encode(obtener_detalles_usu($id_usu));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//2 borrar usuario
$app->delete("/borrar_usuario/{id}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $id_usu = $v->getAttribute("id");

    echo json_encode(borrar_usu($id_usu));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//4 editar usuarios con clave
$app->put("/editar_usuario_cc/{id}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $datos[] = $v->getParam("nombre");
        $datos[] = $v->getParam("usuario");
        $datos[] = $v->getParam("clave");
        $datos[] = $v->getParam("dni");
        $datos[] = $v->getParam("sexo");
        $datos[] = $v->getParam("subs");
        $datos[] = $v->getAttribute("id");
    
        echo json_encode(actualizar_usu_cc($datos[]));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
   
});

//5 editar usuarios sin clave
$app->put("/editar_usuario_sc/{id}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $datos[] = $v->getParam("nombre");
        $datos[] = $v->getParam("usuario");
        $datos[] = $v->getParam("clave");
        $datos[] = $v->getParam("dni");
        $datos[] = $v->getParam("sexo");
        $datos[] = $v->getParam("subs");
        $datos[] = $v->getAttribute("id");
        echo json_encode(actualizar_usu_sc($datos[]));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});

//6 repetido editando
$app->get("/repetido_editar/{tabla}/{columna}/{valor}/{columna_clave}/{valor_clave}", function ($v) {
    session_id($v->getParam('api_key'));
    session_start();
    if (isset($_SESSION['usuario']) && $_SESSION['tipo'] == 'admin') {
        $tabla = $v->getAttribute("tabla");
        $columna = $v->getAttribute("columna");
        $valor = $v->getAttribute("valor");
        $columna_clave = $v->getAttribute("columna_clave");
        $valor_clave = $v->getAttribute("valor_clave");
    
        echo json_encode(repetido_editando($tabla, $columna, $valor, $columna_clave, $valor_clave));
    } else {
        session_destroy();
        $respuesta['no_auth'] = 'No tienes permiso para usar este servicio';
        echo json_encode($respuesta);
    }
});


$app->run();
