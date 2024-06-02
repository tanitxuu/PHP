<?php


if (isset($_POST["btnLogin"])) {
    $error_usuario = empty($_POST["usuario"]);
    $error_clave = empty($_POST["clave"]);
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);

        $respuesta = consumir_servicios_REST(DIR_SERV . "/login", "POST", $datos);
        $json = json_decode($respuesta, true);

        if (!$json) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>Error consumiendo el servicio: CONSULTA NOMBRES</p>"));
        }

        if (isset($json['error'])) {
            session_destroy();
            die(error_page("Examen4 DWESE Curso 23-24", "<h1>Notas de los alumnos</h1><p>" . $json['error'] . "</p>"));
        }

        if (isset($json['mensaje'])) {
            session_unset();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header('Location:index.php');
            exit();
        }

        if (isset($json['usuario'])) {
            $_SESSION["usuario"] = $json['usuario']['usuario'];
            $_SESSION["clave"] = $json['usuario']['clave'];
            $_SESSION["ult_accion"] = time();
            $_SESSION["api_session"] = $json['api_session'];

            header('Location:index.php');
            exit();
        } else {
            $error_usuario = true;
            $mensaje_error = "Usuario o clave incorrectos.";
        }
    } else {
        $mensaje_error = "Por favor, complete todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .error {
            color: red
        }

        .mensaje {
            color: blue;
            font-size: 1.25em;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" value="<?php if (isset($_POST["usuario"])) echo $_POST["usuario"]; ?>">
            <?php
            if (isset($_POST["btnLogin"]) && $error_usuario) {
                echo "<span class='error'>" . ($error_usuario ? "Campo Vacío" : "Usuario/clave incorrectos") . "</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña:</label>
            <input type="password" id="clave" name="clave">
            <?php
            if (isset($_POST["btnLogin"]) && $error_clave)
                echo "<span class='error'> Campo Vacío</span>";
            ?>
        </p>
        <p>
            <button type="submit" name="btnLogin">Login</button>
        </p>
    </form>

    <?php
    if (isset($mensaje_error)) {
        echo "<p class='error'>" . $mensaje_error . "</p>";
    }

    if (isset($_SESSION["seguridad"])) {
        echo "<p class='mensaje'>" . $_SESSION["seguridad"] . "</p>";
        session_destroy();
    }
    ?>
</body>

</html>
