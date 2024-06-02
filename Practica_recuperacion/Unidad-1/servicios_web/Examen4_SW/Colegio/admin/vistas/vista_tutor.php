<?php
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
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>
        <p class="linea">Bienvenido <strong><?php echo $_SESSION['usuario']; ?></strong> -
        <form method="post" action="index.php" class="linea"><button name="salir" class="enlace">Salir</button></form>
        </p>
        <form method="post" action="index.php">
            <p class="linea">Seleccione un Alumno:</p>
            <select name="alumno_id">
                <?php
                foreach ($alumnos as $alumno) {
                    echo "<option value='" . $alumno['cod_usu'] . "'>" . $alumno['nombre'] . "</option>";
                }
                ?>
            </select>
            <button name="btnselect">Ver notas</button>
        </form>
    </div>

    <?php 
    if (isset($_POST['btnselect']) || isset($_POST['editar'])) {
        $alumno_id =  $_POST['alumno_id'];

        foreach ($alumnos as $alumno) {
            if ($alumno['cod_usu'] == $alumno_id) {
                $nombre_alumno = $alumno['nombre'];
                break;
            }
        }

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

        $notas = $json["notas"];
        $notasNO = $json2['notas'];
    ?>

        <h3>Notas del Alumno <strong><?php echo $nombre_alumno; ?></strong></h3>
        <table>
            <tr><th>Asignaturas</th><th>Nota</th><th>Acción</th></tr>
            <?php 
            foreach ($notas as $nota) {

            ?>
                <tr>
                    <td><?php echo $nota['denominacion']; ?></td>
                    <td>
                        <?php if (isset($_POST['editar']) && $nota['cod_asig']==$_POST['cod_asig']) { ?>
                            <form action="index.php" method="post" class="linea">
                                <input type="text" name="notaeditar" value='<?php echo $nota['nota']; ?>'/>
                                <input type="hidden" name="alumno_id" value='<?php echo $alumno_id; ?>'/>
                                <input type="hidden" name="nota_id" value='<?php echo $nota['cod_usu']; ?>'/>
                            </form>
                        <?php } else { ?>
                            <?php echo $nota['nota']; ?>
                        <?php } ?>
                    </td>
                    <td>
                        <form action="index.php" method="post">
                        <?php if (isset($_POST['editar']) && $nota['cod_asig']==$_POST['cod_asig']) { ?>
                            <button name="editarcambios" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Cambiar</button>-
                            <button name="atras" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Borrar</button>
                        <?php } else { ?>
                            <button name="editar" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Editar</button>-
                            <button name="borrar" value='" <?php $nota['cod_usu'] ?>"' class="enlace">Borrar</button>
                            <input type="hidden" name="alumno_id" value="<?php echo $alumno_id; ?>"/>
                            <input type="hidden" name="cod_asig" value="<?php echo $nota['cod_asig']; ?>"/>
                        <?php } ?>
                        </form>
                    </td>
                </tr>
            <?php 
            }
            ?>
        </table>
        <p></p>
        <div>
        <form method="post" action="index.php">
            <p class="linea">Asignaturas que a <strong><?php echo $nombre_alumno; ?> </strong> aun le quedan por calificar:</p>
            <select name="ponernotas">
                <?php
                foreach ($notasNO as $nota) {
                    echo "<option value='" . $nota['cod_asig'] . "'>" . $nota['denominacion'] . "</option>";
                }
                ?>
            </select>
            <button name="btnselect">Calificar</button>
        </form>
        </div>

    <?php 
    }
    ?>
</body>
</html>
