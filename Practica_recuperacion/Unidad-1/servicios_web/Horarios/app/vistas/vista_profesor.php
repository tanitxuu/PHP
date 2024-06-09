<?php
if (isset($_POST['add'])) {
    $datos_env['dia'] = $_POST['dia'];
    $datos_env['hora'] = $_POST['hora'];
    $datos_env['id_grupo'] = $_POST['colegio'];
    $respuesta = consumir_servicios_REST(DIR_SERV . "/insertar/" . $_POST['profesor'], "post", $datos_env);
    $json = json_decode($respuesta, true);


    if (!$json) {
        session_destroy();
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
    }

    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
    }

    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit();
    }

    $_SESSION['mensaje'] = "Grupo insertado con exito";
    $_SESSION['dia'] = $_POST['dia'];
    $_SESSION['hora'] = $_POST['hora'];
    $_SESSION['profesor'] = $_POST['profesor'];
    header("Location:index.php");
    exit;
}
if (isset($_POST['borrar'])) {
    $datos_env['dia'] = $_POST['dia'];
    $datos_env['hora'] = $_POST['hora'];
    $datos_env['id_grupo'] = $_POST['id_grupo'];
    $respuesta = consumir_servicios_REST(DIR_SERV . "/borrar/" . $_POST['profesor'], "DELETE", $datos_env);
    $json = json_decode($respuesta, true);


    if (!$json) {
        session_destroy();
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
    }

    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
    }

    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit();
    }

    $_SESSION['mensaje'] = "Borrado con exito";
    $_SESSION['dia'] = $_POST['dia'];
    $_SESSION['hora'] = $_POST['hora'];
    $_SESSION['profesor'] = $_POST['profesor'];
    header("Location:index.php");
    exit;


}
if (isset($_SESSION['dia'])) {
    $_POST['hora'] = $_SESSION['hora'];
    $_POST['dia'] = $_SESSION['dia'];
    $_POST['editar'] = true;
    $_POST['profesor'] = $_SESSION['profesor'];
    unset($_SESSION['dia']);
    unset($_SESSION['hora']);
    unset($_SESSION['profesor']);
}
if (isset($_POST['editar'])) {
    $datos_env['dia'] = $_POST['dia'];
    $datos_env['hora'] = $_POST['hora'];
    $respuesta = consumir_servicios_REST(DIR_SERV . "/editar/" . $_POST['profesor'], "GET", $datos_env);

    $json = json_decode($respuesta, true);


    if (!$json) {
        session_destroy();
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
    }

    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
    }

    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit();
    }

    $editar = $json['editar'];
    
    $respuesta2 = consumir_servicios_REST(DIR_SERV . "/curso/" . $_POST['profesor'], "GET", $datos_env);
    $json2 = json_decode($respuesta2, true);

    if (!$json2) {
        session_destroy();
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
    }

    if (isset($json2['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
    }

    if (isset($json2['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit();
    }

    $cursos = $json2['cursos'];

}
$horas = [
    1 => "8:15-9:15",
    2 => "9:15-10:15",
    3 => "10:15-11:15",
    4 => "11:15-11:45",
    5 => "11:45-12:45",
    6 => "12:45-13:45",
    7 => "13:45-14:45"
];

$dias = [
    0 => "",
    1 => "Lunes",
    2 => "Martes",
    3 => "Miércoles",
    4 => "Jueves",
    5 => "Viernes"
];



$respuesta = consumir_servicios_REST(DIR_SERV . "/profesores", "GET", $datos_env);
$json = json_decode($respuesta, true);

if (!$json) {
    session_destroy();
    die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
}

if (isset($json['error'])) {
    session_destroy();
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
}

if (isset($json['no_auth'])) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location: index.php");
    exit();
}

$profesores = $json['profesores'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notas alumnos</title>
    <style>
        .enlace {
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        .linea {
            display: inline;
        }

        .mensaje {
            color: blue;

        }

        table {
            text-align: center;
            border-collapse: collapse;
            border: 1px solid black;
            width: 40%;
        }

        th,
        td {
            border: 1px solid black;
        }

        th {
            background-color: gray;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <div>
        <p class="linea">Bienvenido <strong><?php echo $datos_usuario_log['usuario']; ?></strong> -
        <form method="post" action="index.php" class="linea"><button name="salir" class="enlace"
                class="linea">Salir</button></form>
        </p>

        <p class="linea">
        <form action="index.php" class="linea" method="post">
            Seleccione un profesor para ver el horario:
            <select name="profesor" id="profesor">
                <?php
                foreach ($profesores as $value) {
                    if (isset($_POST['profesor']) && $_POST['profesor'] == $value['id_usuario']) {
                        echo " <option value='" . $value['id_usuario'] . "' selected>" . $value['nombre'] . "</option>";
                        $nombre_profesor = $value['nombre'];
                    } else {
                        echo " <option value='" . $value['id_usuario'] . "'>" . $value['nombre'] . "</option>";
                    }
                }
                ?>
            </select>
            <button name="verHorario">Ver Horario</button>
        </form>
        </p>
    </div>
    <?php
    if (isset($_POST['profesor'])) {
        $respuesta = consumir_servicios_REST(DIR_SERV . "/horarios/" . $_POST['profesor'], "GET", $datos_env);
        $json = json_decode($respuesta, true);

        if (!$json) {
            session_destroy();
            die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
        }

        if (isset($json['error'])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
        }

        if (isset($json['no_auth'])) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location: index.php");
            exit();
        }

        $horario = $json['horario'];
       
        ?>
        <h2>Horario del Profesor: <?php echo $nombre_profesor; ?></h2>
        <table>
            <tr>
                <th>Hora/Día</th>
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo "<th>" . $dias[$i] . "</th>";
                }
                ?>
            </tr>
            <?php
            for ($i = 1; $i <= count($horas); $i++) {
                echo "<tr>";
                echo "<td>" . $horas[$i] . "</td>";
                if ($i != 4) { // Recreo
                    for ($j = 1; $j <= 5; $j++) {
                        $grupos = [];
                        foreach ($horario as $value) {
                            if ($value['dia'] == $j && $value['hora'] == $i) {
                                $grupos[] = $value['nombre'];
                            }
                        }
                        echo "<td>";
                        if (!empty($grupos)) {
                            echo implode(', ', $grupos) . "<br>";
                        }
                        ?>

                        <form action="index.php" method="post" class="linea">
                            <button class="enlace" name="editar">Editar</button>
                            <input type="hidden" name="dia" value="<?php echo $j ?>">
                            <input type="hidden" name="hora" value="<?php echo $i ?>">
                            <input type="hidden" name="profesor" value="<?php echo $_POST['profesor'] ?>">

                        </form>
                        <?php
                        echo "</td>";
                    }
                } else {
                    echo "<td colspan='5'>Recreo</td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
        <?php

        if (isset($_POST['editar'])) {
            $datos_env['dia'] = $_POST['dia'];
            $datos_env['hora'] = $_POST['hora'];
            $respuesta = consumir_servicios_REST(DIR_SERV . "/curso/" . $_POST['profesor'], "GET", $datos_env);
            $json = json_decode($respuesta, true);

            if (!$json) {
                session_destroy();
                die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>Error al consumir servicio API</p>"));
            }

            if (isset($json['error'])) {
                session_destroy();
                consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
                die(error_page("Examen_horarios", "<h1>Examen Horarios</h1><p>" . $json['error'] . "</p>"));
            }

            if (isset($json['no_auth'])) {
                session_unset();
                $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
                header("Location: index.php");
                exit();
            }

            $cursos = $json['cursos'];

            echo "<h2>Editando " . $_POST['hora'] . "º hora(" . $horas[$_POST['hora']] . ") del " . $dias[$_POST['dia']] . "</h2>";
            echo "<table>";
            echo "<tr><th>Grupo</th><th>Acción</th></tr>";

            if (!empty($editar)) {
                foreach ($editar as $value) {
                    echo "<tr><td>" . $value['nombre'] . "</td><td><form action='index.php' method='post'>
                    <button name='borrar' class='enlace'>Quitar</button>
                    <input type='hidden' value=" . $_POST['profesor'] . " name='profesor'>
                    <input type='hidden' value=" . $value['id_grupo'] . " name='id_grupo'>
                    <input type='hidden' value=" . $_POST['dia'] . " name='dia'>
                    <input type='hidden' value=" . $_POST['hora'] . " name='hora'>
                    </form></td></tr>";
                }
            }
            echo "</table>";

            if (isset($_SESSION['mensaje'])) {
                echo "<span class='mensaje'>" . $_SESSION['mensaje'] . "</span>";
                unset($_SESSION['mensaje']);
            }
            $datos_env['dia'] = $_POST['dia'];

            ?>
            <br>
            <form action="index.php" method="post">
                <select name="colegio" id="colegio">

                    <?php
                    foreach ($cursos as $value) {
                        echo "<option value='" . $value['id_grupo'] . "'>" . $value['nombre'] . "</option>";
                    }
                    ?>
                </select>
                <button type="submit" name="add">Agregar</button>
                <input type="hidden" name="dia" value="<?php echo $_POST['dia'] ?>">
                <input type="hidden" name="hora" value="<?php echo $_POST['hora'] ?>">
                <input type="hidden" name="profesor" value="<?php echo $_POST['profesor'] ?>">

            </form>
            <?php
        }

    }
    ?>
</body>

</html>