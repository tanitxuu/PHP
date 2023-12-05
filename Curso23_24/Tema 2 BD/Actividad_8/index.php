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
}

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
if (isset($_POST["btnNuevoUsuario"]) || isset($_POST["btnContInsertar"])) {
    require "usuario.php";
} elseif (isset($_POST["btnBorrar"])) {
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        die(error_page("Práctica 1º CRUD", "<h1>Práctica 1º CRUD</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
    }
    echo "<p>Se dispone usted a borrar a usuario <strong>" . $_POST["nombre_usuario"] . "</strong></p>";
    echo "<form action='index.php' method='post'>";
    echo "<input type='hidden' name='name_foto' value='" . $_POST['name_foto'] . "'>";
    echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
    echo "<button type='submit'>Atrás</button></p>";
    echo "</form>";
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
    if (isset($_POST["btnDetalle"])) {
        echo "<h3>Detalles del usuario con id: " . $_POST["btnDetalle"] . "</h3>";
        if (!isset($conexion)) {
            try {
                $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
                mysqli_set_charset($conexion, "utf8");
            } catch (Exception $e) {
                die("<p>No ha podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
            }
        }
        try {
            $consulta = "select * from usuarios where id_usuario='" . $_POST["btnDetalle"] . "'";
            $resultado = mysqli_query($conexion, $consulta);
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
        }

        if (mysqli_num_rows($resultado) > 0) {
            $datos_usuario = mysqli_fetch_assoc($resultado);
            mysqli_free_result($resultado);

            echo "<p>";
            echo "<strong>Nombre: </strong>" . $datos_usuario["nombre"] . "<br>";
            echo "<strong>Usuario: </strong>" . $datos_usuario["usuario"] . "<br>";
            echo "<strong>Dni: </strong>" . $datos_usuario["dni"] . "<br>";
            echo "<strong>sexo: </strong>" . $datos_usuario["sexo"] . "<br>";
            echo "<img class='fotodetalle' src='img/" . $datos_usuario["foto"] . "' alt='Foto'";

            echo "</p>";
        } else
            echo "<p>El usuario seleccionado ya no se encuentra registrado en la BD</p>";


        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit'>Volver</button></p>";
        echo "</form>";
    }

    if (!isset($conexion)) {
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_cv");
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
        echo "<td><form action='index.php' method='post'>
        <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='id' title='ID del Usuario'>" . $tupla["id_usuario"] . "</button>
        </form></td>";
        echo "<td><img src='img/" . $tupla["foto"] . "' alt='Foto de perfil' title=''Foto de perfil</td>";
        echo "<td><form action='index.php' method='post'>
        <button class='enlace' type='submit' value='" . $tupla["id_usuario"] . "' name='btnDetalle' title='Detalles del Usuario'>" . $tupla["nombre"] . "</button>
        </form></td>";
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

    if (isset($_POST["btnBorrar"])) {
        echo "<p>Se dispone usted a borrar a usuario <strong>" . $_POST["nombre_usuario"] . "</strong></p>";
        echo "<form action='index.php' method='post'>";
        echo "<input type='hidden' name='name_foto' value='" . $_POST['name_foto'] . "'>";
        echo "<p><button type='submit' name='btnContBorrar' value='" . $_POST["btnBorrar"] . "'>Continuar</button> ";
        echo "<button type='submit'>Atrás</button></p>";
        echo "</form>";
    } elseif (isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"])) {
        require "vistas/vista_editar.php";
    }
    mysqli_close($conexion);

    ?>
</body>

</html>