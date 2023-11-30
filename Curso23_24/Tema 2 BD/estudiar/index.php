<?php
session_start();
//aqui iran los errores con los isset
function error_page($title,$body)
{
    $page='<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.'</body>
    </html>';
    return $page;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen prueba</title>
</head>

<body>
    <h1>Examen 2 Php</h1>
    <h2>Horario de los profesores</h2>
    <?php
    //comando conexion
    if (!isset($conexion))
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            session_destroy();
            mysqli_close($conexion);
            die("<p>No se a podido conectar a la bd " . $e->getMessage() . "</p>");
        }
    try {
        $consulta = "select * from usuarios";
        $resul = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>No se a podido realizar la consulta " . $e->getMessage() . "</p>");
    }
    if (mysqli_num_rows($resul) > 0) {
    ?>
        <form action="index.php" method="post">
        <p>
        <label for="profesor">Horario de profesor</label>
        <select name="profesor" id="profesor">
            <?php
            while ($tupla = mysqli_fetch_assoc($resul)) {
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            }
            ?>
        </select>
        <button name="btnhorario" id="btnhorario">Ver Horario</button>
        </p>
        </form>
    <?php
    }
    if(isset($_POST["btnhorario"])){
        //comando conexion
    if (!isset($conexion))
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horarios_exam");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>No se a podido conectar a la bd " . $e->getMessage() . "</p>");
    }
try {
    $consulta = "SELECT horario_lectivo.id_horario, usuarios.id_usuario, grupos.id_grupo, grupos.nombre 
    FROM horario_lectivo
    INNER JOIN usuarios ON horario_lectivo.usuario = usuarios.id_usuario
    INNER JOIN grupos ON horario_lectivo.grupo = grupos.id_grupo
    WHERE usuarios.id_usuario = '".$_POST["profesor"]."'";
$resul = mysqli_query($conexion, $consulta);


} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die("<p>No se a podido realizar la consulta " . $e->getMessage() . "</p>");
}
if (mysqli_num_rows($resul) > 0) {
        echo "<table>";
        echo "<tr><th value>horas</th><th value>Lunes</th><th value>martes</th><th value>miercoles</th><th value>jueves</th><th value>viernes</th></tr>";
        while ($tupla = mysqli_fetch_assoc($resul)) {
            echo "<tr>";
            echo "<td>8.15-9.15</td><td>".$tupla["nombre"]."</td><td>".$tupla["nombre"]."</td><td>".$tupla["nombre"]."</td><td>".$tupla["nombre"]."</td>";
            echo "</tr>";
        }


        echo "</table>";
    }
    }else{
        echo "<p>No hay ningun profesor en la bd</p>";
    }
    ?>
</body>

</html>