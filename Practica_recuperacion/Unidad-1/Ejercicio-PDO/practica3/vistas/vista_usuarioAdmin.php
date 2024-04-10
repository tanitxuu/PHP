<?php
//BORRAR SI ACEPTA
if (isset($_POST['si'])) {
    try {
        $consulta = "Delete from usuarios where usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_POST['si']]);
        if ($_POST['foto'] != FOTO_DEFECTO) {
            unlink('img/' . $_POST['foto']);
            $_SESSION['mensaje_accion']='Usuario borrado con exito';
            header('Location:index.php');
            exit();
        }
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    $sentencia = null;
}
///CONSULTA DE LISTADO TABLA
try {
    $consulta = "select * from usuarios where tipo='normal'";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute();
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}
$tuplas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
$sentencia = null;
if (isset($_POST['btnborrar'])) {
    unset($_POST);
}
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
            $consulta = "update usuarios set usuario=?,nombre=?,clave=?,dni=?,sexo=?,subcripcion=?,foto=? where id_usuario=?";
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
        $_SESSION['mensaje_registro'] = $mensaje;
        $_SESSION['usuario'] = $_POST['usu'];
        $_SESSION['clave'] = md5($_POST['clave']);
        $_SESSION['ultima_ac'] = time();
        header('Location:index.php');
        exit();
    }
    if (isset($conexion)) {
        $conexion = null;
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
            width: 35%;
            height: auto;
        }
    </style>
</head>

<body>
    <h1>Vista admin</h1>
    <?php
    echo "<div>Bienvenido <form action='index.php' method='post'> <button name='btnverusu' class='btn'>" . $_SESSION['usuario'] . "</button> <button name='btnsalir' class='btn'>Salir</button></form></div>";

    //AÑADIR NUEVO USUARIO
    if (isset($_POST['btnnuevousu'])) {
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

                        echo "<span class='error'>*Debes rellenar el dni*</<span>";
                    } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>Debes rellenar el DNI con 8 digitos seguidos de una letra</<span>";
                    } elseif (!dni_valido(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>El dni no es valido</<span>";
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
    if (isset($_SESSIONT['mensaje_accion'])) {
     echo "<p>".$_SESSION['mensaje_accion']."</p>";
     unset($_SESSION['mensaje_accion']);
    }
    //VER USUARIO DE LA TABLA
    if (isset($_POST['usu'])) {
        try {
            $consulta = "select * from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST['usu']]);
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
        echo "<h2>Datos de usuario</h2>";
        echo "<p><strong>Nombre: </strong>" . $tuplas['nombre'] . "</p>";
        echo "<p><strong>Usuario: </strong>" . $tuplas['usuario'] . "</p>";
        echo "<p><strong>Dni: </strong>" . $tuplas['dni'] . "</p>";
        echo "<p><strong>Sexo: </strong>" . $tuplas['sexo'] . "</p>";
        echo "<p><strong>Foto: </strong><br><img src='img/" . $tuplas['foto'] . "'/></p>";
        echo "<p><strong>Subscripcion: </strong>" . $datos . "</p>";
        echo "<p></form><form action='index.php' method='post'><button name='btnborrrar' class='btn'>Cerrar</button></form></p>";
        $sentencia = null;
    }
    //EDITAR USUARIO
    if (isset($_POST['btneditar'])) {
        try {
            $consulta = "select * from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST['btneditar']]);
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        $tuplas = $sentencia->fetch(PDO::FETCH_ASSOC);
    ?>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Editar Usuario</legend>
                <label for="usu">Usuario:</label><br>
                <input type="text" name="usu" id="usu" value="<?php if (isset($tuplas['usuario'])) echo $tuplas['usuario']; ?>" placeholder="Usuario..."><br>
                <?php
                if (isset($_POST['enviar']) && $error_usu) {
                    if ($_POST['usu'] == '')
                        echo '<span class="error">*Debe rellenar el usuario*</span><br>';
                    else
                        echo '<span class="error">*Usuario repetido*</span><br>';
                }
                ?>
                <label for="nombre">Nombre:</label><br>
                <input type="text" name="nombre" id="nombre" value="<?php if (isset($tuplas['nombre'])) echo $tuplas['nombre']; ?>" placeholder="Nombre..."><br>
                <?php
                if (isset($_POST['enviar']) && $error_nombre) {
                    echo '<span class="error">*Debe rellenar el nombre*</span><br>';
                }
                ?>
                <label for="clave">Contraseña:</label><br>
                <input type="password" name="clave" id="clave" placeholder="Contraseña..." <?php if (isset($tuplas['usuario'])) echo $tuplas['usuario']; ?>><br>
                <?php
                if (isset($_POST['enviar']) && $error_clave) {
                    echo '<span class="error">*Debe rellenar la contraseña*</span><br>';
                }
                ?>
                <label for="dni">DNI:</label><br>
                <input type="text" name="dni" id="dni" placeholder="58938556T" value="<?php if (isset($tuplas['dni'])) echo $tuplas['dni']; ?>"><br>
                <?php

                if (isset($_POST["enviar"]) && $error_dni) {

                    if ($_POST["dni"] == "") {

                        echo "<span class='error'>*Debes rellenar el dni*</<span>";
                    } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>Debes rellenar el DNI con 8 digitos seguidos de una letra</<span>";
                    } elseif (!dni_valido(strtoupper($_POST["dni"]))) {

                        echo "<span class='error'>El dni no es valido</<span>";
                    } else {
                        echo "<span class='error'>*DNI repetido*</span><br>";
                    }
                }

                ?>
                <label for="sexo">Sexo:</label><br>
                <input type="radio" name="sexo" id="h" value="hombre" <?php if (isset($tuplas['sexo']) && $tuplas['sexo'] == "Hombre") echo "checked"; ?>><label for="h">Hombre</label><br>
                <input type="radio" name="sexo" id="m" value="mujer" <?php if (isset($tuplas["sexo"]) && $tuplas["sexo"] == "Mujer") echo "checked"; ?>> <label for="m">Mujer</label><br><br>
                <?php
                echo "<p><strong>Foto: </strong><br><img src='img/" . $tuplas['foto'] . "'/></p>";
                ?>
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
                <input type="checkbox" id="sub" name="sub" <?php if (isset($tuplas['subscripcion']) && $tuplas['subscripcion'] == 1) echo "checked"; ?>>Suscribete al boletin de novedades<br>
                <button type="submit" name="enviar">Guardar Cambios</button><button type="submit" name="btnborrar">Borrar datos</button>

            </fieldset>
        </form>
    <?php
        $sentencia = null;
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
        echo "<p></form><form action='index.php' method='post'><button name='btnborrrar' class='btn'>Cerrar</button></form></p>";
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
                <button name='btneditar' class='btn' value ='" . $value['id_usuario'] . "'>Editar</button>
            </form>
        </td>
        </tr>";
    }

    echo "</table>";
    $sentencia = null;


    ?>
</body>

</html>