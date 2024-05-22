<?php
if (isset($_POST["btnAgregar"])) {
    $error_referencia = $_POST["referencia"] == "" || !is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0;
    if (!$error_referencia) {
        $datos_env["api_key"] = $_SESSION["api_key"];
        $respuesta = consumir_servicios_REST(DIR_SERV . "/repetido_insert/libros/referencia/".$_POST["referencia"], "GET", $datos_env);
        $json = json_decode($respuesta, true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        if (isset($json["no_auth"])) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }
        $error_referencia=$json["repetido"];

    }
    $error_titulo = $_POST["titulo"] == "";
    $error_autor = $_POST["autor"] == "";
    $error_descripcion = $_POST["descripcion"] == "";
    $error_precio = $_POST["precio"] == "" || !is_numeric($_POST["precio"]) || $_POST["precio"] <= 0;
    $array_nombre = explode(".", $_FILES["portada"]["name"]);
    $error_portada = $_FILES["portada"]["name"] != "" && ($_FILES["portada"]["error"] || !$array_nombre || !getimagesize($_FILES["portada"]["tmp_name"]) || $_FILES["portada"]["size"] > 750 * 1024);
    $error_form = $error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio || $error_portada;
    if (!$error_form) {

        $datos_env["api_key"] = $_SESSION["api_key"];
        $datos_env["referencia"]=$_POST["referencia"];
        $datos_env["titulo"]=$_POST["titulo"];
        $datos_env["autor"]=$_POST["autor"];
        $datos_env["descripcion"]=$_POST["descripcion"];
        $datos_env["precio"]=$_POST["precio"];

        $respuesta = consumir_servicios_REST(DIR_SERV . "/insertar_libro", "POST", $datos_env);
        $json = json_decode($respuesta, true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }

        if(isset($json["error_bd"]))
        {
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
        if (isset($json["no_auth"])) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }
        $mensaje="Usuario insertado con éxito";
    
        if ($_FILES["portada"]["name"] != "") {

            $array_ext=explode(".", $_FILES["portada"]["name"]);
            $ext = ".".end($array_nombre);
            $nombre_nuevo = "img_" . $_POST["referencia"] . $ext;
            @$var = move_uploaded_file($_FILES["portada"]["tmp_name"], "../img/" . $nombre_nuevo);
            if ($var) {
                $datos_env_act["nombre_foto"]=$nombre_nuevo;
                $datos_env_act["id_usuario"]=$ultm_id;
                $respuesta=consumir_servicios_REST(DIR_SERV."/actualizar_foto","PUT",$datos_env_act);
                $json=json_decode($respuesta,true);
                if(!$json)
                {
                    session_destroy();
                    die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
                }
            
                if(isset($json["error_bd"]))
                {
                    if(file_exists("images/".$nombre_nuevo))
                        unlink("images/".$nombre_nuevo);
                    
                    $mensaje="Usuario insertado con éxito pero con la imagen por defecto por un problema en la BD del servidor";
                }
                
            }
            else
            {
                $mensaje="Usuario insertado con éxito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta destino en el servidor";
            }
        }

        $_SESSION["accion"]=$mensaje;
        header("Location:index.php");
        exit();
    }
}


if (isset($_POST["btnBorrar"])) {
    $respuesta=consumir_servicios_REST(DIR_SERV."/borrar_libro/".$_POST["btnBorrar"],"DELETE",$datos_env);
    $json=json_decode($respuesta,true);
    if(!$json)
    {
        session_destroy();
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
    }

    if(isset($json["error_bd"]))
    {

        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
    }

    if(isset($json["no_auth"]))
    {
        session_unset();
        $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
        header("Location:index.php");
        exit();
    }

    if($_POST["portada"]!=FOTO_DEFECTO && file_exists("img/".$_POST["foto"]))
         unlink("img/".$_POST["foto"]);

    $_SESSION["accion"]="Usuario borrado con éxito";
    $_SESSION["pag"]=1;//Al poner paginación cuándo borro siempre me voy página
    header("Location:index.php");
    exit;
    
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen3 Curso 23-24</title>
    <style>
        .enlinea {
            display: inline
        }

        .enlace {
            border: none;
            background: none;
            text-decoration: underline;
            color: blue;
            cursor: pointer
        }

        table {
            width: 80%;
            margin: 0 auto;
            text-align: center;
            border-collapse: collapse
        }

        table,
        th,
        td {
            border: 1px solid black
        }

        th {
            background-color: #CCC
        }

        .mensaje {
            font-size: 1.25em;
            color: blue
        }

        label {
            width: 100px;
            float: left
        }

        .error {
            color: red
        }
        .img_editar{
            width: 20%;
        }
    </style>
</head>

<body>
    <h1>Librería</h1>
    <div>Bienvenido <strong><?php echo $datos_usuario_log["lector"]; ?></strong> -
        <form class='enlinea' action="index.php" method="post">
            <button class='enlace' type="submit" name="btnSalir">Salir</button>
        </form>
    </div>
    <?php
    if (isset($_SESSION["accion"])) {
        echo "<p class='mensaje'>" . $_SESSION["accion"] . "</p>";
        unset($_SESSION["accion"]);
    }

    echo "<h3>Listado de los libros</h3>";


    $url=DIR_SERV."/obtener_libros";
    $respuesta=consumir_servicios_REST($url,"GET");
    $obj=json_decode($respuesta);
    if(!$obj)
    {
        session_destroy();
        die(error_page("LIBRERIA","<h1>Libreria</h1><p>Error consumiendo el servicio: ".$url."</p>"));
    }
    
    if(isset($obj->error))
    {
        session_destroy();
        die(error_page("LIBRERIA","<h1>Libreria</h1><p>".$obj->error."</p>"));
    }
    
    echo "<table>";
    echo "<tr><th>Ref</th><th>Título</th><th>Acción</th></tr>";
    foreach ($obj->libros as $tupla) {
        echo "<tr>";
        echo "<td>" . $tupla->referencia . "</td>";
        echo "<td>" . $tupla->titulo. "</td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' name='btnBorrar' value='" . $tupla->referencia. "'>Borrar</button> - <button class='enlace' name='btnEditar' value='" . $tupla->referencia . "'>Editar</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";

    if (isset($_POST["btnEditar"])) {
        $respuesta=consumir_servicios_REST(DIR_SERV."/obtener_detalles/".$_POST["btnEditar"],"GET",$datos_env);
        $json=json_decode($respuesta,true);
        if(!$json)
        {
            session_destroy();
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
        }
    
        if(isset($json["error_bd"]))
        {
    
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error_bd"]."</p>"));
        }
    
        if(isset($json["no_auth"]))
        {
            session_unset();
            $_SESSION["seguridad"]="Usted ha dejado de tener acceso a la API. Por favor vuelva a loguearse.";
            header("Location:index.php");
            exit();
        }
    
        $detalles_libro=$json["libro"];
        if($detalles_libro)
        {
            $referencia=$detalles_libro["referencia"];
            $titulo=$detalles_libro["titulo"];
            $autor=$detalles_libro["autor"];
            $descripcion=$detalles_libro["descripcion"];
            $precio=$detalles_libro["precio"];
            $portada=$detalles_libro["portada"];
          
        }
        echo "<h2>Nombre del libro a editar:".$titulo."</h2>";
     
    ?>
     <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="referencia">Referencia:</label>
            <input type="text" name="referencia" id="referencia"  value="<?php echo $referencia;?>">
            <?php
            if (isset($_POST["referencia"]) && $error_referencia) {
                if ($_POST["referencia"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                elseif (!is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0)
                    echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                else
                    echo "<span class='error'> Referencia repetida</span>";
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo $titulo;?>">
            <?php
            if (isset($_POST["titulo"]) && $error_titulo)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?php echo $autor;?>">
            <?php
            if (isset($_POST["autor"]) && $error_autor)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php  echo $descripcion;?></textarea>
            <?php
            if (isset($_POST["descripcion"]) && $error_descripcion)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" id="precio" value="<?php echo $precio;?>">
            <?php
            if (isset($_POST["precio"]) && $error_precio) {
                if ($_POST["precio"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                else
                    echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada:</label>
            <input type="file" name="portada" id="portada" accept="image/*">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_portada) {
                if ($_FILES["portada"]["error"])
                    echo "<span class='error'>Error en la subida del fichero</span>";
                elseif (!explode(".", $_FILES["portada"]["name"]))
                    echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                    echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                else
                    echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
            }
            ?>
        </p>
        <p class='centrado'>
                 <img class='img_editar' src='img/<?php echo $portada;?>' title='Foto' alt='Foto'>
             
             <?php
             if(isset($_POST["btnBorrarFoto"]))
             {
                 echo "<br>¿Estás seguro?<br>";
                 echo "<button type='submit' name='btnContBorrarFoto'>Sí</button> <button type='submit' name='btnNoBorrarFoto'>No</button>";
             }
             elseif($portada!=FOTO_DEFECTO)
             {
                 echo "<br><button name='btnBorrarFoto' type='submit'>Borrar Foto</button>";
             }
             ?>
             </p>
        <p>
            <button type="submit" name="btnAgregar">Agregar</button>
        </p>
    </form>
      
<?php
}?>

    <h3>Agregar un libro nuevo</h3>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <p>
            <label for="referencia">Referencia:</label>
            <input type="text" name="referencia" id="referencia" value="<?php if (isset($_POST["referencia"])) echo $_POST["referencia"]; ?>">
            <?php
            if (isset($_POST["referencia"]) && $error_referencia) {
                if ($_POST["referencia"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                elseif (!is_numeric($_POST["referencia"]) || $_POST["referencia"] < 0)
                    echo "<span class='error'> Referencia no es un número mayor o igual que cero</span>";
                else
                    echo "<span class='error'> Referencia repetida</span>";
            }
            ?>
        </p>
        <p>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php if (isset($_POST["titulo"])) echo $_POST["titulo"]; ?>">
            <?php
            if (isset($_POST["titulo"]) && $error_titulo)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="autor">Autor:</label>
            <input type="text" name="autor" id="autor" value="<?php if (isset($_POST["autor"])) echo $_POST["autor"]; ?>">
            <?php
            if (isset($_POST["autor"]) && $error_autor)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion"><?php if (isset($_POST["descripcion"])) echo $_POST["descripcion"]; ?></textarea>
            <?php
            if (isset($_POST["descripcion"]) && $error_descripcion)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <label for="precio">Precio:</label>
            <input type="text" name="precio" id="precio" value="<?php if (isset($_POST["precio"])) echo $_POST["precio"]; ?>">
            <?php
            if (isset($_POST["precio"]) && $error_precio) {
                if ($_POST["precio"] == "")
                    echo "<span class='error'> Campo Vacío</span>";
                else
                    echo "<span class='error'> El precio debe ser un número mayor que cero</span>";
            }
            ?>
        </p>
        <p>
            <label for="portada">Portada:</label>
            <input type="file" name="portada" id="portada" accept="image/*">
            <?php
            if (isset($_POST["btnAgregar"]) && $error_portada) {
                if ($_FILES["portada"]["error"])
                    echo "<span class='error'>Error en la subida del fichero</span>";
                elseif (!explode(".", $_FILES["portada"]["name"]))
                    echo "<span class='error'>El archivo seleccionado no tiene extensión</span>";
                elseif (!getimagesize($_FILES["portada"]["tmp_name"]))
                    echo "<span class='error'>El archivo seleccionado no es un archivo imagen</span>";
                else
                    echo "<span class='error'>El archivo seleccionado supera los 750KB</span>";
            }

            ?>
        </p>
        <p>
            <button type="submit" name="btnAgregar">Agregar</button>
        </p>
    </form>
</body>

</html>