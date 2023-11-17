<?php
require "src/ctes_funciones.php";
if (isset($_POST["btnContInsertar"])) // compruebo errores
            {
                $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 50;
                $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 50;
        
                if(!$error_usuario)
                {
                    try{
                        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                        mysqli_set_charset($conexion,"utf8");
                    }
                    catch(Exception $e)
                    {
                        die(error_page("Práctica 8º CRUD","<h1>Práctica 8º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
                    }
        
                    $error_usuario=repetido($conexion,"usuarios","usuario",$_POST["usuario"]);
                    
                    if(is_string($error_usuario))
                        mysqli_close($conexion);
                        die(error_page("Práctica 8º CRUD","<h1>Práctica 8º CRUD</h1><p>No he podido conectarse a la base de batos: ".$error_usuario."</p>"));
        
                }
                $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;

                $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
                if(!$error_dni)
                {
                    try{
                        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
                        mysqli_set_charset($conexion,"utf8");
                    }
                    catch(Exception $e)
                    {
                        die(error_page("Práctica 8º CRUD","<h1>Práctica 8º CRUD</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
                    }
        
                    $error_usuario=repetido($conexion,"usuarios","dni",strtoupper($_POST["dni"]));
                    
                    if(is_string($error_dni))
                        mysqli_close($conexion);
                        die(error_page("Práctica 8º CRUD","<h1>Práctica 8º CRUD</h1><p>No he podido conectarse a la base de batos: ".$error_dni."</p>"));
        
                }

                $error_sexo = !isset($_POST["sexo"]);
        
                $error_archivo = $_FILES["archivo"]["name"] != "" && ($_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024);
               
                $error_form = $error_nombre || $error_usuario || $error_clave || $error_archivo || $error_dni || $error_sexo;
        
                if (!$error_form) {
                    
                    try {
                        $consulta = "insert into usuarios (usuario,clave,nombre,dni,sexo) values ('" . $_POST["usuario"] . "','" . $_POST["clave"] . "','" . $_POST["nombre"] . "','" . $_POST["dni"] . "','" . $_POST["sexo"] . "')";
                        mysqli_query($conexion, $consulta);
                    } catch (Exception $e) {
                        mysqli_close($conexion);
                        die("<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>");
                    }
                    
                    if ($_FILES["archivo"]["name"]!= ""){
                        $last_id=mysqli_insert_id($conexion);
                        $array_nombre=explode(".",$_FILES["archivo"]["name"]);
                        $ext="";
                        if(count($array_nombre)>1){
                            $ext=".".end($array_nombre);
                        $nombre_foto="img_".$last_id.$ext;
                        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"img/".$nombre_foto);
                        
                        if($var){
                            try {
                                $consulta = "update usuarios set foto='".$nombre_foto."' where id_usuario='".$last_id."'";
                                mysqli_query($conexion, $consulta);
                            } catch (Exception $e) {
                                mysqli_close($conexion);
                                die("<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>");
                            }
                        }
                    }
                    mysqli_close($conexion);
                    header("Location:index.php");
                    exit;
                }
            } 
}

if (isset($_POST["btnContBorrar"])) {

    try {
        $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("<h1>Práctica 8", "</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }

    try {
        $consulta = "delete from usuarios where id_usuario='" . $_POST["btnContBorrar"] . "'";
        mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die(error_page("<h1>Práctica 8", "</h1><p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }


    if ($_POST["nombre_foto"] != "no_imagen.jpg") {
        unlink("img/" . $_POST["nombre_foto"]);
    }

    mysqli_close($conexion);
    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;

        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 50%;
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red;
        }

        .foto_detalle {
            width: 20%;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_POST["btnDetalle"])) {

        require "vistas/vistas_detalle.php";
    }

    if (isset($_POST["btnBorrar"])) {
        require "vistas/vistas_borrar.php";
    }


    if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"])) {
        
        ?>
            <!DOCTYPE html>
            <html lang="es">
        
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Práctica 1º CRUD</title>
                <style>
                    .error {
                        color: red
                    }
                </style>
            </head>
        
            <body>
                <h1>Agregar Nuevo Usuario</h1>
                <form action="index.php" method="post">
                    <p>
                        <label for="nombre">Nombre: </label><br />
                        <input type="text" name="nombre" id="nombre" maxlength="50" placeholder="Nombre..." value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                            if ($_POST["nombre"] == "")
                                echo "<span class='error'> Campo vacío</span>";
                            else
                                echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="usuario">Usuario: </label><br />
                        <input type="text" name="usuario" id="usuario" maxlength="50" placeholder="Usuario..." value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                            if ($_POST["usuario"] != "")
                                echo "<span class='error'> Campo vacío</span>";
                            elseif (strlen($_POST["usuario"]) > 50)
                                echo "<span class='error'> Has tecleado más de 50 caracteres</span>";
                            else
                                echo "<span class='error'> Usuario repetido</span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="clave">Contraseña: </label><br />
                        <input type="password" name="clave" maxlength="15" placeholder="Contraseña..." id="clave">
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_clave) {
                            if ($_POST["clave"] == "")
                                echo "<span class='error'> Campo vacío</span>";
                            else
                                echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="dni">DNI: </label><br />
                        <input type="text" name="dni" id="dni" maxlength="50" placeholder="DNI. 11223344Z" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>">
                        <?php
                        if(isset($_POST["btnContInsertar"]) && $error_dni){
                            if($_POST["dni"]==""){
                                echo "<span class='error'>Campo vacio </span>";
                            }elseif(!dni_bien_escrito(strtoupper($_POST["dni"]))){
                                echo "<span class='error'>Dni no esta bien escrito </span>";
                            }else{
                                echo "<span class='error'>El dni no es valido</span>";
                            }
                        }
                        ?>
                    </p>
        
                    <p>
                        Sexo:
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_sexo) {
                            echo "<span class='error'>Debes seleccionar uno</span>";
                        }
                        ?>
                        <br>
                        <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre") echo "checked"; ?>><label for="">Hombre</label><br>
                        <input type="radio" name="sexo" id="mujer" value="Mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer") echo "checked"; ?>><label>Mujer</label><br>
                    </p>
                    <p>
                        <label for="archivo">Seleccione un archivo imagen (Max 500KB):</label>
                        <input type="file" name="archivo" id="archivo" accept="img/*" />
                        <?php
                        if (isset($_POST["btnContInsertar"]) && $error_archivo) {
                            if ($_FILES["archivo"]["name"] != "") {
                                if ($_FILES["archivo"]["error"]) {
                                    echo "<span class='error'>No se ha podido subir el archivo</span>";
                                } elseif (!getimagesize($_FILES["archivo"]["tmp_name"])) {
                                    echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                                } else {
                                    echo "<span class='error'>El archivo supera el tamaño</span>";
                                }
                            }
                        }
                        ?>
                    </p>
        
                    <p>
                        <button type="submit" name="btnContInsertar">Guardar Cambios</button>
                        <button type="submit">Atras</button>
                    </p>
                </form>
        
            </body>
            </html>
    <?php
    }

    require "vistas/vistas_tablaP.php";

    ?>
</body>
</html>