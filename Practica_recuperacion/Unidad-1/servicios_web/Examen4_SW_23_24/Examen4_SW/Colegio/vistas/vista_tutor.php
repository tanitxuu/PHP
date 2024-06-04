<?php
if (isset($_POST['borrar'])) {
    $alumno_id = $_POST['alumno_id'];
    $datos_env['cod_asig'] = $_POST['cod_asig'];
    $respuesta = consumir_servicios_REST(DIR_SERV . "/quitarNota/" . $alumno_id, "DELETE", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
    }
    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
    }
    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit;
    }

    $_SESSION['mensaje'] = "¡Asignatura descalificada con exito!";
    $_SESSION['id'] = $alumno_id;
    header("Location:index.php");
    exit();
}
if (isset($_POST['calificar'])) {
    $alumno_id = $_POST['alumno_id'];
    $datos_env['cod_asig'] = $_POST['cod_asig'];
    $respuesta = consumir_servicios_REST(DIR_SERV . "/ponerNota/" . $alumno_id, "post", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
    }
    if (isset($json['error'])) {
        session_destroy();
        consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
        die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
    }
    if (isset($json['no_auth'])) {
        session_unset();
        $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
        header("Location: index.php");
        exit;
    }
    
        $_SESSION['mensaje'] = "¡Asignatura calificada con 0 presione editar para cambiar la nota!";
        $_SESSION['id'] = $alumno_id;
    header("Location:index.php");
    exit();
   
}
if (isset($_POST['editarcambios'])) {
    $error_nota = $_POST['notaeditar'] == '' || !is_numeric(($_POST['notaeditar'])) || floatval($_POST['notaeditar']) < 0;
    if (!$error_nota) {
        $alumno_id = $_POST['alumno_id'];
        $datos_env['cod_asig'] = $_POST['cod_asig'];
        $datos_env['nota'] = floatval($_POST['notaeditar']);
        $respuesta = consumir_servicios_REST(DIR_SERV . "/cambiarNota/" . $alumno_id, "PUT", $datos_env);
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
        }
        if (isset($json['error'])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Examen colegio", "<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
        }
        if (isset($json['no_auth'])) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location: index.php");
            exit;
        }
        
            $_SESSION['mensaje'] = "¡Nota cambiada con exito!";
            $_SESSION['id'] = $alumno_id;
    header("Location:index.php");
    exit();
        
    }
}
if (isset($_SESSION['id'])) {
    $_POST['alumno_id'] = $_SESSION['id'];
    unset($_SESSION['alumno_id']);
}


$respuesta = consumir_servicios_REST(DIR_SERV . "/alumnos", "GET", $datos_env);
$json = json_decode($respuesta, true);

if (!$json) {
    session_destroy();
    die(error_page("Examen Colegio", "<h1>Notas alumnos</h1><p>Error al consumir API</p>"));
}
if (isset($json['error'])) {
    session_destroy();
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    die(error_page("Examen Colegio", "<h1>Notas alumnos</h1><p>Error al consumir API</p>"));
}
if (isset($json['no_auth'])) {
    session_unset();
    $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
    header("Location: index.php");
    exit;
}

$alumnos = $json["alumnos"];

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
            display: inline;
        }

        .linea {
            display: inline;
        }

        .mensaje {
            color: blue;
        }

        table {
            border-collapse: collapse;
            border: 1px solid black;
            text-align: center;
            width: 30%;
        }

        th {
            background-color: gray;
            border: 1px solid black;
        }

        td {
            border: 1px solid black;
        }
        .error{
            color: red;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <div>
        <p class="linea">Bienvenido <strong><?php echo $datos_usuario_log['usuario']; ?></strong> -
        <form method="post" action="index.php" class="linea"><button name="salir" class="enlace">Salir</button></form>
        </p>
        <form method="post" action="index.php">
            <p class="linea">Seleccione un Alumno:</p>
            <select name="alumno_id">
                <?php
                foreach ($alumnos as $alumno) {
                    if (isset($_POST['alumno_id']) && $_POST['alumno_id'] == $alumno['cod_usu']) {
                        echo "<option value='" . $alumno['cod_usu'] . "' selected>" . $alumno['nombre'] . "</option>";
                        $nombre_alumno = $alumno['nombre'];
                    } else {
                        echo "<option value='" . $alumno['cod_usu'] . "'>" . $alumno['nombre'] . "</option>";
                    }
                }
                ?>
            </select>
            <button name="btnselect">Ver notas</button>
        </form>
    </div>

    <?php
    if (isset($_POST['alumno_id'])  || isset($_POST['calificar']) || isset($_POST['editarcambios'])) {
        $alumno_id = $_POST['alumno_id'];

        $respuesta = consumir_servicios_REST(DIR_SERV . "/notasAlumno/" . $alumno_id, "GET", $datos_env);
        $resp = consumir_servicios_REST(DIR_SERV . "/NotasNoEvalAlumno/" . $alumno_id, "GET", $datos_env);
        $json = json_decode($respuesta, true);
        $json2 = json_decode($resp, true);

        if (!$json || !$json2) {
            session_destroy();
            die(error_page("Examen Colegio", "<h1>Notas de los Alumnos</h1><p>Error al obtener notas</p>"));
        }
        if (isset($json['error']) || isset($json2['error'])) {
            session_destroy();
            consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
            die(error_page("Examen Colegio", "<h1>Notas de los Alumnos</h1><p>Error al conectarse a la BBDD</p>"));
        }
        if (isset($json['no_auth']) || isset($json2['no_auth'])) {
            session_unset();
            $_SESSION["seguridad"] = "El tiempo de sesión de la API ha caducado";
            header("Location: index.php");
            exit();
        }

        $notas = $json["notas"];
        $notasNO = $json2['notas'];
        if (count($alumnos) <= 0) {
            echo "<p>En estos momentos no tenemos registrado ningun alumno en la BD</p>";
        } else {
    ?>
            <h3>Notas del Alumno <strong><?php echo $nombre_alumno; ?></strong></h3>
            <table>
                <tr>
                    <th>Asignaturas</th>
                    <th>Nota</th>
                    <th>Acción</th>
                </tr>
                <?php
                foreach ($notas as $nota) {

                ?>
                    <tr>
                        <td><?php echo $nota['denominacion']; ?></td>
                        <td>
                            <?php if (isset($_POST['editar']) && $nota['cod_asig'] == $_POST['cod_asig'] || isset($_POST['editarcambios']) && $nota['cod_asig'] == $_POST['cod_asig'] ) { ?>
                                <form action="index.php" method="post" class="linea">
                                    <input type="text" name="notaeditar" value='<?php echo $nota['nota']; ?>' />
                                    <?php
                                    if (isset($_POST['editarcambios']) && $error_nota) {
                                        echo "<span class='error'>*Nota no valida*</span>";
                                    }
                                    ?>
                                    <input type="hidden" name="alumno_id" value='<?php echo $alumno_id; ?>' />
                                    <input type="hidden" name="nota_id" value='<?php echo $nota['cod_usu']; ?>' />
                                </form>
                            <?php } else { ?>
                                <?php echo $nota['nota']; ?>
                            <?php } ?>
                        </td>
                        <td>
                            <form action="index.php" method="post">
                                <?php if (isset($_POST['editar']) && $nota['cod_asig'] == $_POST['cod_asig'] || isset($_POST['editarcambios']) && $nota['cod_asig'] == $_POST['cod_asig'] ) { ?>
                                    <button name="editarcambios" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Cambiar</button>-
                                    <button name="atras" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Atras</button>
                                    <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>" />
                                    <input type="hidden" name="cod_asig" value="<?php echo $nota['cod_asig']; ?>" />
                                <?php } else { ?>

                                    <button name="editar" class="enlace">Editar</button>-
                                    <button name="borrar" class="enlace">Borrar</button>
                                    <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>" />
                                    <input type="hidden" name="cod_asig" value="<?php echo $nota['cod_asig']; ?>" />
                                <?php } ?>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </table>
        <?php
        }
        ?>
        <p class="mensaje"> <?php
                            if (isset($_SESSION['mensaje']))
                                echo $_SESSION['mensaje'];
                            unset($_SESSION['mensaje']);
                            ?></p>
        <?php
        if (count($notasNO) <= 0) {
            echo "<p>Al alumno no le queda ninguna asignatura por calificar</p>";
        } else {
        ?>
            <div>
                <form method="post" action="index.php">
                    <p class="linea">Asignaturas que a <strong><?php echo $nombre_alumno; ?> </strong> aun le quedan por
                        calificar:</p>
                    <select name="cod_asig">
                        <?php
                        foreach ($notasNO as $nota) {
                            echo "<option value='" . $nota['cod_asig'] . "'>" . $nota['denominacion'] . "</option>";
                        }
                        ?>
                    </select>
                    <button name="calificar">Calificar</button>
                    <input type="hidden" name="alumno_id" value="<?php echo $_POST['alumno_id'];; ?>" />
                </form>
            </div>

    <?php
        }
    }
    ?>
</body>

</html>