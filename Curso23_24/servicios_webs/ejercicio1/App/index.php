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
    $datos["cod"] = "TNIz";
    $datos["nombre"] = "TANIAaaaaaaa";
    $datos["nombre_corto"] = "TANIAz";
    $datos["descripcion"] = "blablabalblablablasblasblasl";
    $datos["PVP"] = 24.3;
    $datos["familia"] = "MP3";

    $url = DIR_SERV . "/producto/insertar";
    $respuesta = consumir_servicios_REST($url, "post", $datos);
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");

    echo "<p>".$obj->mensaje."</p>";



    ?>
</body>

</html>