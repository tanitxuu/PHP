<?php
//BORRAR SI ACEPTA
if (isset($_POST['si'])) {
    try {
        $consulta = "Delete from usuarios where usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST['si']]);
        if ($_POST['foto'] != FOTO_DEFECTO && file_exists('img/' . $_POST['foto'])) {
            unlink('img/' . $_POST['foto']);
        }
        $conexion = null;
        $sentencia = null;
        $_SESSION['mensaje_accion'] = 'Usuario borrado con exito';
        header('Location:index.php');
        exit();
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
}
//VER USUARIO TABLA
if (isset($_POST['usu'])) {
    try {
        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST['usu']]);
        if ($sentencia->rowCount() > 0) {
            $detalles_usu = $sentencia->fetch(PDO::FETCH_ASSOC);
            if ($detalles_usu['subscripcion'] == 1)
                $datos = 'Si';
            else
                $datos = 'No';
        } else {
            $detalles_usu = false;
        }

        $sentencia = null;
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
}


///CONSULTA DE LISTADO TABLA
try {
    $consulta = "select * from usuarios where tipo='normal'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
    $tuplas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    $sentencia = null;
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}

//Comprobacion errores
if (isset($_POST['enviar'])) {
    $error_usu = $_POST['usu'] == '';
    if (!$error_usu) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            session_destroy();
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        //comprobamos si esta repetido
        $error_usu = repetido($conexion, 'usuarios', 'usuario', $_POST['usu']);
        if (is_string($error_usu)) {
            $conexion = null;
            session_destroy();
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>" . $error_usu . "</p>"));
        }
    }
    $error_nombre = $_POST['nombre'] == '';
    $error_clave = $_POST['clave'] == '';
    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
    if (!$error_dni) {
        if (!isset($conexion)) {
            try {
                $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            } catch (PDOException $e) {
                session_destroy();
                die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
            }
        }


        $error_dni = repetido($conexion, "usuarios", "dni", strtoupper($_POST["dni"]));
        if (is_string($error_dni)) {

            $conexion = null;
            session_destroy();
            die(error_page("Practica Rec 2", "<h1>Practica Rec 2</h1><p>" . $error_dni . "</p>"));
        }
    }

    $error_img = $_FILES["img"]["name"] != '' && ($_FILES["img"]["error"] || !explode('.', $_FILES['img']['name']) || !getimagesize($_FILES["img"]["tmp_name"]) || $_FILES["img"]["size"] > 500 * 1024);

    $error_form = $error_clave || $error_dni || $error_nombre || $error_usu  ||  $error_img;
    if (!$error_form) {
        //creo el try de insertar
        try {
            if (isset($_POST['sub'])) {
                $subs = 1;
            } else {
                $subs = 0;
            }
            //insertamos sin imagen primero para que se ponga la por defecto
            $consulta = "insert into usuarios (usuario,nombre,clave,dni,sexo,subscripcion) values (?,?,?,?,?,?)";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST['usu'], $_POST['nombre'], md5($_POST['clave']), strtoupper($_POST['dni']), $_POST['sexo'], $subs]);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        $mensaje = 'Se ha registrado con exito';

        if ($_FILES["img"]["name"] != '') {
            $ult_id = $conexion->lastInsertId();
            $array_ext = explode('.', $_FILES["img"]["name"]);
            $ext = '.' . end($array_ext);
            $nombre_nuevo = 'img_' . $ult_id . $ext;
            @$var = move_uploaded_file($_FILES["img"]["tmp_name"], 'img/' . $nombre_nuevo);
            if ($var) {
                try {
                    //aqui si habia img se la subimos
                    $consulta = "update usuarios set foto=? where id_usuario=?";
                    $sentencia = $conexion->prepare($consulta);
                    $sentencia->execute([$nombre_nuevo, $ult_id]);
                    $sentencia = null;
                } catch (PDOException $e) {
                    //para borrar una img
                    if (file_exists('img/' . $nombre_nuevo))
                        unlink('img/' . $nombre_nuevo);
                    $sentencia = null;
                    $conexion = null;
                    $mensaje = 'Se ha registrado con exito pero con la imagen por defecto por un problema en la BD del servidor';
                }
            } else {
                $mensaje = 'Se ha registrado con exito pero con la imagen por defecto ya que no se ha podido mover la imagen a la carpeta de destino en el servidor ';
            }
        }
        $conexion = null;
        header('Location:index.php');
        exit();
    }
    if (isset($conexion)) {
        $conexion = null;
    }
}
//PARA EDITAR
if (isset($_POST["btnContEditar"])) {
    $id_usuario = $_POST["btnContEditar"];
    $usuario = $_POST["usuario"];
    $nombre = $_POST["nombre"];
    $dni = $_POST["dni"];
    $foto = $_POST["foto_bd"];
    $sexo = $_POST["sexo"];
    if (isset($_POST["subscripcion"]))
        $subscripcion = 1;
    else
        $subscripcion = 0;

    //Una vez recogido valores compruebo errores
    $error_nombre = $_POST["nombre"] == "";
    $error_usuario = $_POST["usuario"] == "";
    if (!$error_usuario) {
        $error_usuario = repetido_editando($conexion, "usuarios", "usuario", $_POST["usuario"], "id_usuario", $id_usuario);
        if (is_string($error_usuario)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_usuario . "</p>"));
        }
    }

    $error_dni = $_POST["dni"] == "" || !dni_bien_escrito($_POST["dni"]) || !dni_valido($_POST["dni"]);
    if (!$error_dni) {
        $error_dni = repetido_editando($conexion, "usuarios", "dni", strtoupper($_POST["dni"]), "id_usuario", $id_usuario);
        if (is_string($error_dni)) {
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>" . $error_dni . "</p>"));
        }
    }

    $error_foto = $_FILES["foto"]["name"] != "" && ($_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"]) || !getimagesize($_FILES["foto"]["tmp_name"]) || $_FILES["foto"]["size"] > 500 * 1024); //Foto no obligatoria
    //$error_foto=$_FILES["foto"]["name"]=="" || $_FILES["foto"]["error"] || !explode(".", $_FILES["foto"]["name"])|| !getimagesize($_FILES["foto"]["tmp_name"] ) || $_FILES["foto"]["size"]>500*1024;//Foto obligatoria
    $error_form = $error_nombre || $error_usuario || $error_dni || $error_foto;

    if (!$error_form) {
        //No hay errores

        try {

            if ($_POST["clave"] == "") {
                $consulta = "update usuarios set nombre=?, usuario=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit = [$nombre, $usuario, strtoupper($dni), $sexo, $subscripcion, $id_usuario];
            } else {
                $consulta = "update usuarios set nombre=?, usuario=?, clave=?, dni=?, sexo=?, subscripcion=? where id_usuario=?";
                $datos_edit = [$nombre, $usuario, md5($_POST["clave"]), strtoupper($dni), $sexo, $subscripcion, $id_usuario];
            }

            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($datos_edit);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            session_destroy();
            die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
        }

        $mensaje = "Usuario editado con éxito";
        if ($_FILES["foto"]["name"] != "") {
            // generar nombre nueva foto
            $array_ext = explode(".", $_FILES["foto"]["name"]);
            $ext = "." . end($array_ext);
            $nombre_nuevo = "img_" . $id_usuario . $ext;
            //mover nueva foto a images
            @$var = move_uploaded_file($_FILES["foto"]["tmp_name"], "img/" . $nombre_nuevo);
            if ($var) {
                //si nombre nueva foto es distinta a $foto(bd)
                if ($foto != $nombre_nuevo) {
                    try {
                        $consulta = "update usuarios set foto=? where id_usuario=?";
                        $sentencia = $conexion->prepare($consulta);
                        $sentencia->execute([$nombre_nuevo, $id_usuario]);
                        $sentencia = null;
                        if ($foto != FOTO_DEFECTO && file_exists("img/" . $foto))
                            unlink("img/" . $foto);
                    } catch (PDOException $e) {
                        $sentencia = null;
                        $conexion = null;
                        if (file_exists("img/" . $nombre_nuevo))
                            unlink("img/" . $nombre_nuevo);
                        $mensaje = "Usuario editado con éxito pero sin cambiar a la nueva imagen por un problema con la BD del servidor";
                    }
                }
            } else
                $mensaje = "Usuario editado con éxito pero sin cambiar a la nueva imagen, ya que ésta no se ha podido mover a la carpeta destino en el servidor";
        }
        $conexion = null;
        $_SESSION["mensaje_accion"] = $mensaje;
        header("Location:index.php");
        exit();
    }
}
if (isset($_POST["btnEditar"]) || isset($_POST["btnBorrarEditar"]) ||isset($_POST['btnborrarimg']))  {
    if (isset($_POST["btnEditar"]))
        $id_usuario = $_POST["btnEditar"];
    else
        $id_usuario = $_POST["btnBorrarEditar"];

    try {

        $consulta = "select * from usuarios where id_usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$id_usuario]);
        if ($sentencia->rowCount() > 0) {
            $detalles_usu = $sentencia->fetch(PDO::FETCH_ASSOC);
            $usuario = $detalles_usu["usuario"];
            $nombre = $detalles_usu["nombre"];
            $dni = $detalles_usu["dni"];
            $foto = $detalles_usu["foto"];
            $sexo = $detalles_usu["sexo"];
            $subscripcion = $detalles_usu["subscripcion"];
        }


        $sentencia = null;
    } catch (PDOException $e) {
        $sentencia = null;
        $conexion = null;
        session_destroy();
        die(error_page("Práctica Rec 2", "<h1>Práctica Rec 2</h1><p>Imposible realizar la consulta. Error:" . $e->getMessage() . "</p>"));
    }
}

if (isset($_POST['siborrar'])) {
    if ($_POST['foto'] != FOTO_DEFECTO) {
        unlink("img/" . $_POST['foto']);
        try {
            $consulta = "update usuarios set foto=? where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([FOTO_DEFECTO, $_POST['siborrar']]);
            $sentencia = null;
        } catch (PDOException $e) {
            $sentencia = null;
            $conexion = null;
            if (file_exists("img/" . $nombre_nuevo))
                unlink("img/" . $nombre_nuevo);
            $mensaje = "Usuario editado con éxito pero sin cambiar a la nueva imagen por un problema con la BD del servidor";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        .error {
            color: red;
        }

        .btn {
            border-style: none;
            background: none;
            font-weight: bolder;
            color: blue;
            text-decoration-line: underline;
            cursor: pointer;

        }

        table,
        td,
        th {
            border: 1px solid black;
        }

        table {
            border-collapse: collapse;
            text-align: center;
            width: 90%;
            margin: 0 auto
        }

        th {
            background-color: #CCC
        }

        table img {
            height: 100px;
        }

        img {
            width: 60%;
            height: auto;
        }

        .centrar {
            width: 80%;
            margin: 0 auto;
        }

        #t_editar,
        #t_editar td {
            border: none
        }

        .centrado {
            text-align: center;
        }

        .img_editar {
            width: 100%
        }

        .centrar {
            width: 80%;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <h1>Vista admin</h1>
    <?php
    echo "<div>Bienvenido <form action='index.php' method='post'> <button name='btnverusu' class='btn'>" . $_SESSION['usuario'] . "</button> <button name='btnsalir' class='btn'>Salir</button></form></div>";

    //AÑADIR NUEVO USUARIO
    if (isset($_POST['btnnuevousu']) || isset($_POST['btnborrar']) || isset($_POST['enviar'])) {
        if (isset($_POST['btnborrar'])) {
            unset($_POST);
        }
    ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Añadir nuevo usuario</legend>
                <label for="usu">Usuario:</label><br>
                <input type="text" name="usu" id="usu" value="<?php if (isset($_POST['usu'])) echo $_POST['usu']; ?>" placeholder="Usuario..."><br>
                <?php
                if (isset($_POST['enviar']) && $error_usu) {
                    if ($_POST['usu'] == '')
                        echo '<span class="error">*Debe rellenar el usuario*</span><br>';
                    else
                        echo '<span class="error">*Usuario repetido*</span><br>';
                }
                ?>
                <label for="nombre">Nombre:</label><br>
                <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" placeholder="Nombre..."><br>
                <?php
                if (isset($_POST['enviar']) && $error_nombre) {
                    echo '<span class="error">*Debe rellenar el nombre*</span><br>';
                }
                ?>
                <label for="clave">Contraseña:</label><br>
                <input type="password" name="clave" id="clave" placeholder="Contraseña..."><br>
                <?php
                if (isset($_POST['enviar']) && $error_clave) {
                    echo '<span class="error">*Debe rellenar la contraseña*</span><br>';
                }
                ?>
                <label for="dni">DNI:</label><br>
                <input type="text" name="dni" id="dni" placeholder="58938556T" value="<?php if (isset($_POST['dni'])) echo $_POST['dni']; ?>"><br>
                <?php

                if (isset($_POST["enviar"]) && $error_dni) {

                    if ($_POST["dni"] == "") {

                        echo "<span class='error'>*Debes rellenar el dni*</span><br>";
                    } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>Debes rellenar el DNI con 8 digitos seguidos de una letra</span><br>";
                    } elseif (!dni_valido(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>El dni no es valido</<span><br>";
                    } else {
                        echo "<span class='error'>*DNI repetido*</span><br>";
                    }
                }

                ?>
                <label for="sexo">Sexo:</label><br>
                <input type="radio" name="sexo" id="h" value="hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?> checked><label for="h">Hombre</label><br>
                <input type="radio" name="sexo" id="m" value="mujer" <?php if (!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")) echo "checked"; ?>> <label for="m">Mujer</label><br><br>
                <label for="img">Incluir mi foto (Max. 500KB)</label>
                <input type="file" name="img" id="img" accept="image/*"><br><br>
                <?php
                if (isset($_POST["enviar"]) && $error_img) {
                    if ($_FILES["img"]["name"] != "") {
                        if ($_FILES["img"]["error"]) {
                            echo "<span class='error'>No se ha podido subir el archivo</span>";
                        } elseif (!explode('.', $_FILES['img']['name'])) {
                            echo "<span class='error'>El archivo no tiene extension</span>";
                        } elseif (!getimagesize($_FILES["img"]["tmp_name"])) {
                            echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                        } else {
                            echo "<span class='error'>El archivo supera el tamaño</span>";
                        }
                    }
                }
                ?>
                <input type="checkbox" id="sub" name="sub" <?php if (isset($_POST["sub"])) echo "checked"; ?>>Suscribete al boletin de novedades<br>
                <button type="submit" name="enviar">Guardar Cambios</button><button type="submit" name="btnborrar">Borrar datos</button>

            </fieldset>
        </form>
        <?php
    }
    //PREGUNTA BORRAR
    if (isset($_POST['borrar'])) {
        echo "<p>
        <h2> Desea borrar el usuario: " . $_POST['borrar'] . " <br> </h2>
        <form method='post' action='index.php'>
        <input type='hidden' name='foto' value='" . $_POST['foto'] . "'/>
        <button name='si' value=" . $_POST['borrar'] . ">Si</button> <button name='btnborrar'>No</button>
        </form></p>";
    }
    //BORRAR SI ACEPTA
    if (isset($_SESSION['mensaje_accion'])) {
        echo "<p>" . $_SESSION['mensaje_accion'] . "</p>";
        unset($_SESSION['mensaje_accion']);
    }
    //VER USUARIO DE LA TABLA
    if (isset($_POST['usu'])) {

        echo "<h2>Datos de usuario " . $_POST['usu'] . "</h2>";
        if ($detalles_usu) {
            echo "<p><strong>Nombre: </strong>" .  $detalles_usu['nombre'] . "</p>";
            echo "<p><strong>Usuario: </strong>" . $detalles_usu['usuario'] . "</p>";
            echo "<p><strong>Dni: </strong>" . $detalles_usu['dni'] . "</p>";
            echo "<p><strong>Sexo: </strong>" . $detalles_usu['sexo'] . "</p>";
            echo "<p><strong>Foto: </strong><br><img src='img/" . $detalles_usu['foto'] . "'/></p>";
            echo "<p><strong>Subscripcion: </strong>" . $datos . "</p>";
            echo "<p></form><form action='index.php' method='post'><button name='btnborrrar'>Cerrar</button></form></p>";
        } else {
            echo '<p>El usuario ' . $_POST['usu'] . ' ya no se encuentra en la BBDD</p>';
        }
    }
    //EDITAR USUARIO
    if (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarEditar"]) || isset($_POST['btnborrarimg']) || isset($_POST['siborrar'])) {
        echo "<h2>Detalles del usuario con id:" . $id_usuario . "</h2>";
        if (!isset($usuario)) {
            echo "<p>El usuario seleccionado ya no se encuentra en la BD</p>";
        } else {
            //Por aquí el formulario de edición
        ?>
            <form action="index.php" method="post" enctype="multipart/form-data">
                <table id="t_editar" class='sin_bordes'>
                    <tr>
                        <td>
                            <p>
                                <label for="usuario">Usuario: </label><br>
                                <input type="text" id="usuario" name="usuario" value="<?php echo $usuario; ?>" placeholder="Usuario...">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_usuario) {
                                    if ($_POST["usuario"] == "")
                                        echo "<span class='error'> Campo vacío</span>";
                                    else
                                        echo "<span class='error'> Usuario repetido</span>";
                                }

                                ?>
                            </p>
                            <p>
                                <label for="nombre">Nombre: </label><br>
                                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" placeholder="Nombre...">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_nombre)
                                    echo "<span class='error'> Campo vacío</span>";
                                ?>
                            </p>
                            <p>
                                <label for="clave">Contraseña: </label><br>
                                <input type="password" id="clave" name="clave" placeholder="Teclee nueva contraseña...">
                            </p>
                            <p>
                                <label for="dni">DNI: </label><br>
                                <input type="text" id="dni" name="dni" value="<?php echo $dni; ?>" placeholder="DNI: 11223344Z">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_dni) {
                                    if ($_POST["dni"] == "")
                                        echo "<span class='error'> Campo vacío</span>";
                                    else if (!dni_bien_escrito($_POST["dni"]))
                                        echo "<span class='error'> DNI no está bien escrito</span>";
                                    else if (!dni_valido($_POST["dni"]))
                                        echo "<span class='error'> DNI no es válido</span>";
                                    else
                                        echo "<span class='error'> DNI repetido</span>";
                                }
                                ?>
                            </p>
                            <p>
                                <label>Sexo: </label><br>
                                <input type="radio" id="hombre" name="sexo" value="hombre" <?php if ($sexo == "Hombre") echo "checked"; ?>>
                                <label for="hombre">Hombre: </label><br>
                                <input type="radio" id="mujer" name="sexo" value="mujer" <?php if ($sexo == "Mujer") echo "checked"; ?>>
                                <label for="mujer">Mujer: </label><br>
                            </p>
                            <p>
                                <label for="foto">Cambiar la foto (Máx. 500 KB)</label>
                                <input type="file" name="foto" id="foto" accept="image/*">
                                <?php
                                if (isset($_POST["btnContEditar"]) && $error_foto) {
                                    if ($_FILES["foto"]["error"])
                                        echo "<span class='error'> Error en la subida del fichero al servidor </span>";
                                    else if (!explode(".", $_FILES["foto"]["name"]))
                                        echo "<span class='error'> El fichero subido debe tener extensión </span>";
                                    else if (!getimagesize($_FILES["foto"]["tmp_name"]))
                                        echo "<span class='error'> El fichero subido debe ser una imagen</span>";
                                    else
                                        echo "<span class='error'> El tamaño del fichero no debe superar los 500 KB</span>";
                                }
                                ?>
                            </p>
                            <p>
                                <input type="checkbox" id="subsc" name="subscripcion" <?php if ($subscripcion) echo "checked"; ?>>
                                <label for="subsc">Suscribirme al boletín de novedades: </label><br>
                            </p>

                            <p>
                                <input type="hidden" name="foto_bd" value='<?php echo $foto; ?>'>
                                <input type="hidden" name="id_usuario" value='<?php echo $id_usuario; ?>'>
                                <button type="submit" name="btnContEditar" value='<?php echo $id_usuario; ?>'>Guardar Cambios</button>
                                <button type="submit" name="btnBorrarEditar" value='<?php echo $id_usuario; ?>'>Borrar los datos introducidos</button>
                            </p>
                        </td>
                        <td>
                            <p class='centrado'>
                                <img class='img_editar' src='img/<?php echo $foto; ?>' title='Foto' alt='Foto' name='fotoya'>
                                
                                <?php
                                if (isset($_POST['btnborrarimg']) ) {
                                    echo "
                               
                                <span>Deseas borrar la foto</span>
                                <input type='hidden' name='foto' value='" . $_POST['fotoya'] . "'/>
                                <button name='siborrar' value=" . $_POST['btnborrarimg'] . ">Si</button> <button name='btnborrar'>No</button>
                                ";
                                }else{
                                    echo " <button name='btnborrarimg' value=" .$id_usuario.">Borrar Imagen</button>";
                                }
                                ?>
                            </p>
                        </td>
                    </tr>
                </table>
            </form>

    <?php
        }
    }

    //VER USUARIO ADMIN
    if (isset($_POST['btnverusu'])) {
        try {
            $consulta = "select * from usuarios where usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_SESSION['usuario']]);
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        $tuplas = $sentencia->fetch(PDO::FETCH_ASSOC);
        if ($tuplas['subscripcion'] == 1) {
            $datos = 'Si';
        } else {
            $datos = 'No';
        }
        echo "<h2>Datos de " . $_SESSION['usuario'] . "</h2>";
        echo "<p><strong>Nombre: </strong>" . $tuplas['nombre'] . "</p>";
        echo "<p><strong>Usuario: </strong>" . $tuplas['usuario'] . "</p>";
        echo "<p><strong>Dni: </strong>" . $tuplas['dni'] . "</p>";
        echo "<p><strong>Sexo: </strong>" . $tuplas['sexo'] . "</p>";
        echo "<p><strong>Foto: </strong><br><img src='img/" . $tuplas['foto'] . "'/></p>";
        echo "<p><strong>Subscripcion: </strong>" . $datos . "</p>";
        echo "<p><strong>Tipo: </strong>" . $tuplas['tipo'] . "</p>";
        echo "<p>form action='index.php' method='post'><button name='btnborrrar' class='btn'>Cerrar</button></form></p>";
    }
    //TABLA USUARIOS
    echo "<h4>Listado de usuarios</h4>";
    echo "<table>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button name='btnnuevousu' class='btn'>Usuario+</button></form></th></tr>";
    foreach ($tuplas as $value) {

        echo "<tr>
        <td>" . $value['id_usuario'] . "</td>
        <td><img src='img/" . $value['foto'] . "'/></td>
        <td>
            <form action='index.php' method='post'>
                <button name='usu' class='btn' value ='" . $value['id_usuario'] . "'>" . $value['nombre'] . "</button>
            </form>
        </td>
        <td>
            <form action='index.php' method='post'>
                <input type='hidden' name='foto' value='" . $value['foto'] . "'/>
                <button name='borrar' class='btn' value='" . $value['usuario'] . "'>Borrar</button>
                <button name='btnEditar' class='btn' value ='" . $value['id_usuario'] . "'>Editar</button>
            </form>
        </td>
        </tr>";
    }

    echo "</table>";
    $sentencia = null;


    ?>
</body>

</html>