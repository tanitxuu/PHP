<?php
function error_page($title, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $title . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}

function repetido($conexion, $tabla, $columna, $valor, $columna_clave = null, $valor_clave = null)
{

    try {
        if (isset($columna_clave))
            $consulta = "select * from " . $tabla . " where " . $columna . "='" . $valor . "' AND " . $columna_clave . "<>'" . $valor_clave . "'";
        else
            $consulta = "select * from " . $tabla . " where " . $columna . "='" . $valor . "'";

        $resultado = mysqli_query($conexion, $consulta);
        $respuesta = mysqli_num_rows($resultado) > 0;
        mysqli_free_result($resultado);
    } catch (Exception $e) {
        mysqli_close($conexion);
        $respuesta = error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>");
    }
    return $respuesta;

    function LetraNI($dni)
    {
        return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
    }
    function dni_bien_escrito($texto)
    {
        $bien_escrito = strlen($texto) == 9  && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
        return $bien_escrito;
    }
    function dni_valido($texto)
    {
        $numero = substr($texto, 0, 8);
        $letra = substr($texto, -1);
        $valido = LetraNI($numero) == $letra;
        return $valido;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 1º CRUD</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            margin: 5px;
            padding: 5px;
        }

        table {
            border-collapse: collapse;
            text-align: center
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
            color: red
        }
    </style>
</head>

<body>
    <h1>Listado de los usuarios</h1>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_cv");
    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect(SERVIDOR_BD, USUARIO_BD, CLAVE_BD, NOMBRE_BD);
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
        }
    }

    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }

    echo "<table>";
    echo "<tr><th>#</th><th>Foto</th><th>Nombre de Usuario</th><th>Borrar</th></tr>";
    while ($tupla = mysqli_fetch_assoc($resultado)) {
        echo "<tr>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='id' title='ID del Usuario'>" . $tupla["id_usuario"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='foto' title='ID del Usuario'>" . $tupla["foto"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button></form></td>";
        echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_usuario' value='" . $tupla["nombre"] . "'>
       <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnBorrar'>Borrar</button>
       <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnEditar'>Editar</button>
       </form></td>";
        echo "";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_free_result($resultado);
    echo "<form action='index.php' method='post'>";
    echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo Usuario</button></p>";
    echo "</form>";

    if (isset($_POST["btnDetalle"])) {
        require "vistas/vista_detalle.php";
    } elseif (isset($_POST["btnBorrar"])) {
        require "vistas/vista_conf_borrar.php";
    } elseif (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {
        require "vistas/vista_editar.php";
    } elseif (isset($_POST["btnNuevoUsuario"])) {

        if (isset($_POST["btnContInsertar"])) // compruebo errores
        {
            $error_nombre = $_POST["nombre"] == "" || strlen($_POST["nombre"]) > 30;
            $error_usuario = $_POST["usuario"] == "" || strlen($_POST["usuario"]) > 20;
            if (!$error_usuario) {
                try {
                    $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
                    mysqli_set_charset($conexion, "utf8");
                } catch (Exception $e) {
                    die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
                }

                $error_usuario = repetido($conexion, "usuarios", "usuario", $_POST["usuario"]);

                if (is_string($error_usuario))
                    die($error_usuario);
            }
            $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
            $error_clave = $_POST["clave"] == "" || strlen($_POST["clave"]) > 15;
            $error_sexo = !isset($_POST["sexo"]);


            $error_archivo = $_FILES["archivo"]["name"] != "" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"]) || $_FILES["archivo"]["size"] > 500 * 1024;
            $error_form = $error_nombre || $error_usuario || $error_clave || $error_email || $error_archivo || $error_dni || $error_sexo;

            if (!$error_form) {
                try {
                    $consulta = "insert into usuarios (usuario,clave,nombre,dni,sexo,foto) values ('" . $_POST["usuario"] . "','" . $_POST["clave"] . "','" . $_POST["nombre"]. "','" . $_POST["dni"]."','" .$_POST["sexo"]."','" .$_FILES["foto"]. "')";
                    mysqli_query($conexion, $consulta);
                } catch (Exception $e) {
                    mysqli_close($conexion);
                    die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No se ha podido hacer la consulta: " . $e->getMessage() . "</p>"));
                }

                mysqli_close($conexion);

                header("Location:index.php");
                exit;
            }
        }

    ?>
        <h1>Usuario Nuevo</h1>
        <form action="index.php" method="post">
            <p>
                <label for="nombre">Nombre: </label>
                <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if (isset($_POST["nombre"])) echo $_POST["nombre"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_nombre) {
                    if ($_POST["nombre"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    else
                        echo "<span class='error'> Has tecleado más de 30 caracteres</span>";
                }
                ?>
            </p>
            <p>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_usuario) {
                    if ($_POST["usuario"] == "")
                        echo "<span class='error'> Campo vacío</span>";
                    elseif (strlen($_POST["usuario"]) > 20)
                        echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                    else
                        echo "<span class='error'> Usuario repetido</span>";
                }
                ?>
            </p>
            <p>
                <label for="clave">Contraseña: </label>
                <input type="password" name="clave" maxlength="15" id="clave">
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
                <label for="dni">DNI:</label>
                <input type="text" placeholder="DNI: 12435664Z" name="dni" id="dni" value="<?php if (isset($_POST["dni"])) echo $_POST["dni"]; ?>"><br>
                <?php
                if (isset($_POST["btnContInsertar"]) && $error_dni) {
                    if ($_POST["dni"] == "") {
                        echo "<span class='error'>Campo vacio </span>";
                    } elseif (!dni_bien_escrito(strtoupper($_POST["dni"]))) {
                        echo "<span class='error'>Dni no esta bien escrito </span>";
                    } else {
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
                <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Hombre") echo "checked" ?>>Hombre<br>
                <input type="radio" name="sexo" id="mujer" value="Mujer" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "Mujer") echo "checked" ?>>Mujer<br>
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
                <button type="submit" name="btnContInsertar">Continuar</button>
                <button type="submit">Volver</button>
            </p>
        </form>
    <?php
    }


    mysqli_close($conexion);

    ?>
</body>

</html>