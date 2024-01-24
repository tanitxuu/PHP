
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicacion web de prueba de servicios</title>
    <style> table,td,th{border:1px solid black;}
        table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        h1{
            text-align: center;
        }
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        </style>
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
    if(isset($_POST["btnNuevoProducto"])){
        $url = DIR_SERV . "/familias";
        $respuesta = consumir_servicios_REST($url, "GET");
        $obj = json_decode($respuesta);
        if (!$obj)
            die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);
    
        if (isset($obj->mensaje_error))
            die("<p>" . $obj->mensaje_error . "<p></body></html>");

        echo "<h3>Insertar producto</h3>";
        
        echo "<p><label for='codigo'>Codigo:</label>";
        echo "<input type='text' name='codigo'/></p>";
     
        echo "<p><label for='nombre'>Nombre:</label>";
        echo "<input type='text' name='nombre'/></p>";
     
        echo "<p><label for='nombre_corto'>Nombre Corto:</label>";
        echo "<input type='text' name='nombre_corto'/></p>";
     
        echo "<p><label for='descripcion'>Descripcion:</label>";
        echo "<input type='textarea' name='descripcion'/></p>";
     
        echo "<p><label for='pvp'>PVP:</label>";
        echo "<input type='text' name='pvp'/></p>";
     
        echo "<p><label for='pvp'>Seleccione una familia:</label>";
        echo "<select  name='familia'/></p>";
        foreach($obj->productos as $tupla){
         echo "<option value=''>".$tupla->nombre."</option>";
        }
        echo "</select>";
        echo "<form action='index.php' method='post'><button  type='submit' name='btnVolver'>Volver</button> <button type='submit' name='btnContinuar'>Continuar</button></form>";
     
       
    }
    if(isset($_POST["btnverproducto"])){
        $url = DIR_SERV . "/productos/" ;

        $respuesta = consumir_servicios_REST($url, "GET",$datos);
        $obj = json_decode($respuesta);
        if (!$obj)
            die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);
    
        if (isset($obj->mensaje_error))
            die("<p>" . $obj->mensaje_error . "<p></body></html>");
    
            foreach($obj->producto as $tupla){
                echo "<h1>Producto cod: ".$tupla->cod."</h1>";
                echo "<p><label for='nombre'>Nombre:".$tupla->nombre."</label></p>";
                echo "<p><label for='nombre'>Nombre Corto:".$tupla->nombre_corto."</label></p>";
                echo "<p><label for='nombre'>Descripcion:".$tupla->descripcion."</label></p>";
                echo "<p><label for='nombre'>PVP:".$tupla->PVP."</label></p>";
                echo "<p><label for='nombre'>Familia:".$tupla->familia."</label></p>";
            }
            echo "<form action='index.php' method='post'><button  type='submit' name='btnVolver'>Volver</button></form>";
    }

     
    $url = DIR_SERV . "/productos";
    $respuesta = consumir_servicios_REST($url, "GET");
    $obj = json_decode($respuesta);
    if (!$obj)
        die("<p>Error consumiendo el servicio: " . $url . "<p>" . $respuesta);

    if (isset($obj->mensaje_error))
        die("<p>" . $obj->mensaje_error . "<p></body></html>");
    
    echo "<h1>Lista de productos</h1>";
    echo "<table>";
    echo "<tr><th>Cod</th><th>Nombre</th><th>PVP</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevoProducto'>Productos+</button></form></th></tr>";

    foreach($obj->productos as $tupla){
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><form action='index.php' method='post'><button class='enlace' type='submit' name='btnverproducto'>".$tupla->cod."</button></form></td>";
        echo "<td>".$tupla->nombre_corto."</td>";
        echo "<td>".$tupla->PVP."</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla->cod."' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='".$tupla->cod."' name='btnEditar'>Editar</button></form></td>";
        echo "</tr>";
    }

    echo "</table>";
    ?>
    
</body>

</html>