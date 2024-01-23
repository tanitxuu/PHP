<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicacion web de prueba de servicios</title>
</head>

<body>
    <?php
    define("DIR_SERV", "http://localhost/Proyectos/Curso23_24/servicios_webs/ejercicio1/servicios_rest");

    function consumir_servicios_REST($url, $metodo, $datos = null)
    {
        $llamada = curl_init();
        curl_setopt($llamada, CURLOPT_URL, $url);
        curl_setopt($llamada, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($llamada, CURLOPT_CUSTOMREQUEST, $metodo);
        if (isset($datos))
            curl_setopt($llamada, CURLOPT_POSTFIELDS, http_build_query($datos));
        $respuesta = curl_exec($llamada);
        curl_close($llamada);
        return $respuesta;
    }
    //parte A
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<table>";
    echo "<tr><th>Cod</th><th>Nombre Corto</th></tr>";


    echo "<h1>Nombre ejemplo: ".$obj->productos[0]->nombre_corto."</h1>";
    echo "<p>El numero de tuplas obtenidas ha sido: ".count($obj->productos)."</p>";

    foreach($obj->productos as $tupla){
        echo "<tr>";
        echo "<td>".$tupla->cod."</td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "</tr>";
    }

    echo "</table>";

    //Parte B 
    $url = DIR_SERV . "/productos/KSTMSDHC8GB";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

        echo "<h1>Nombre corto de KSTMSDHC8GB es : ".$obj->productos->nombre_corto."</h1>";

   /* $datos["nombre"] = "TAaaniainsda";
    $datos["nombre_corto"] = "TANIAjdhasjd";
    $datos["descripcion"] = "blabllasdfjsdkffs";
    $datos["PVP"] = 25.3;
    $datos["familia"] = "MP3";

    //INSERTAR
    /*$url = DIR_SERV . "/producto/insertar";
    $respuesta = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>" . $obj->mensaje . "</p>";*/

    //ACTUALIZAR
   /* $url = DIR_SERV . "/producto/actualizar/" . urlencode("TNIzx");
    $respuesta = consumir_servicios_REST($url, "put", $datos);
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>" . $obj->mensaje . "</p>";

    //DELETE
    /*   $url = DIR_SERV . "/producto/borrar/" .urlencode("3DSNG");
      $respuesta = consumir_servicios_REST($url, "delete", $datos);
       $obj = json_decode($respuesta);
       if (!$obj)
           die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);
   
       if (isset($obj->mensaje_error))
           die("<p>" . $obj->mensaje_error . "<p></body></html>");
   
       echo "<p>".$obj->mensaje."</p>";*/




    ?>
</body>

</html>