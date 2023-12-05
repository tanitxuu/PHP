<?php
session_start();
if (!isset($conexion)) {
    try {
        $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_exam_colegio");
        mysqli_set_charset($conexion, "utf8");
    } catch (Exception $e) {
        session_destroy();
        mysqli_close($conexion);
        die("<p>No se a podido iniciar sesion " . $e->getMessage() . "</p></body></html>");
    }
}
try {
    $consulta = "select * from alumnos";
    $resultado = mysqli_query($conexion, $consulta);
} catch (Exception $e) {
    session_destroy();
    mysqli_close($conexion);
    die("<p>No se a podido iniciar sesion " . $e->getMessage() . "</p></body></html>");
}
if (mysqli_num_rows($resultado) > 0) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>

    <body>
        <h1>Alumnos</h1>
        <select name="alumno" id="alumno">
        <?php
        while($tupla=mysqli_fetch_assoc($resultado))
         echo "<option value='".$tupla["cod_alu"]."'>".$tupla["nombre"]."</option>";
        ?>
        </select>



    <?php
}
    ?>
    </body>

    </html>