<?php
   define("DIR_SERV","http://localhost/Proyectos/Practica_recuperacion/Unidad-1/servicios_web/miprimera_api");
function consumir_servicios_REST($url,$metodo,$datos=null)
{
    $llamada=curl_init();
    curl_setopt($llamada,CURLOPT_URL,$url);
    curl_setopt($llamada,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($llamada,CURLOPT_CUSTOMREQUEST,$metodo);
    if(isset($datos))
        curl_setopt($llamada,CURLOPT_POSTFIELDS,http_build_query($datos));
    $respuesta=curl_exec($llamada);
    curl_close($llamada);
    return $respuesta;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoría Servicios Webs</title>
</head>
<body>
    <?php
//1
    $url=DIR_SERV."/saludo";
    //$respuesta=file_get_contents($url);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);
//la array asociativo de mensaje sera la que muetre
    echo "<p>El mensaje recibido ha sido <strong>".$obj->mensaje."</strong></p>";


//2
    $url=DIR_SERV."/saludo/".urlencode("Pedro Pedro");
    //$respuesta=file_get_contents($url);
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta,true);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$obj["mensaje"]."</strong></p>";


//3
    $url=DIR_SERV."/saludo";
    $datos["nombre"]="Juan Alonso";
    $respuesta=consumir_servicios_REST($url,"POST",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$obj->mensaje."</strong></p>";


//4
    $url=DIR_SERV."/borrar_saludo/37";
    $respuesta=consumir_servicios_REST($url,"DELETE");
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$obj->mensaje."</strong></p>";


//5
    $url=DIR_SERV."/actualizar_saludo/78";
    $datos["nombre"]="Pepe Pérez";
    $respuesta=consumir_servicios_REST($url,"PUT",$datos);
    $obj=json_decode($respuesta);
    if(!$obj)
        die("<p>Error consumiendo el servicio: ".$url."<p>".$respuesta);

    echo "<p>El mensaje recibido ha sido <strong>".$obj->mensaje."</strong></p>";
    ?>
</body>
</html>