<?php
if (isset($_POST['datos'])) {
    $respuesta = consumir_servicios_REST(DIR_SERV . "/usuario/" . $_POST['datos'], "GET", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Error examen", "<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));
    }
    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Error examen", "<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));

    }
    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION['seguridad'] = "No tienes permisos para usar este servicio";
        header("Location:index.php");
        exit;

    }
    $profesor = $json['usuario'];
}
$dia = date("w");

$dias[1] = "Lunes";
$dias[] = "Martes";
$dias[] = "Miercoles";
$dias[] = "Jueves";
$dias[] = "Viernes";

$horas[1] = "8:15-9:15";
$horas[] = "9:15-10:15";
$horas[] = "10:15-11:15";
$horas[] = "11:15-11:45";
$horas[] = "11:45-12:45";
$horas[] = "12:45-13:45";
$horas[] = "13:45-14:45";

for ($hora = 1; $hora <= count($horas); $hora++) {
    if ($hora != 4) {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/usuariosGuardia/" . $dia . "/" . $hora, "GET", $datos_env);
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Error examen", "<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));
        }
        if (isset($json['error'])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Error examen", "<h1>Error Examen</h1><p>Error al consumir servicio de api</p>"));

        }
        if (isset($json['no_auth'])) {
            session_unset();
            $_SESSION['seguridad'] = "No tienes permisos para usar este servicio";
            header("Location:index.php");
            exit;

        }
        $profesores[$hora] = $json['usuarios'];
    }


}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Profesor</title>
</head>

<body>
    <h1>Geston de guardia</h1>
    <p>Bienvenido <strong><?php echo $datos_usuario_log['usuario']; ?></strong> -
    <form action="index.php" method="post">
        <button name="salir" class="enlace">Salir</button>
    </form>
    </p>
    <p><strong>Hoy es <?php echo $dias[$dia]; ?></strong></p>
    <table border="1">
        <tr>
            <th>Hora</th>
            <th>Profesor de Guardia</th>
            <?php
            if (isset($_POST['datos'])) {
                echo "<th> Informacion del profesor con id : " . $_POST['datos'] . "</th>";

            } else {
                ?>
                <th>Informacion del profesor con id :</th>
                <?php

            }
            ?>
        </tr>
        <?php
        for ($hora = 1; $hora <= count($horas); $hora++) {
            if ($hora != 4) {
                echo "<tr>";

                echo "<td>" . $horas[$hora] . "</td>";

                echo "<td>";
                echo "<form action='index.php' method='post'>";
                echo "<ol>";
                foreach ($profesores[$hora] as $tupla) {


                    echo "<li>";
                    echo "<button name='datos' value=" . $tupla['id_usuario'] . ">" . $tupla['nombre'] . "</button>";
                    echo "</li>";

                }
                echo "</ol>";
                echo "</form>";
                echo "</td>";

                echo "<td>";
                if (isset($_POST['datos']) && $hora == 1) {



                    echo "<p><strong>Nombre:</strong> " . $profesor['nombre'] . "</p>";
                    echo "<p><strong>Usuario:</strong> " . $profesor['usuario'] . "</p>";
                    echo "<p><strong>Clave:</strong></p>";
                    echo "<p><strong>Email:</strong></p>";
                    if (isset($profesor["email"])) {
                        echo $profesor['email'];
                    } else {
                        echo "Email no desponible";
                    }



                }
                echo "</td>";
                echo "</tr>";
            }
        }

        ?>

    </table>
</body>

</html>