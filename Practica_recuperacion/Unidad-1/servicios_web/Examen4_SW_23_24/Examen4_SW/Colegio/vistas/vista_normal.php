<?php
$respuesta=consumir_servicios_REST(DIR_SERV."/notasAlumno/".$datos_usuario_log['cod_usu'],"GET",$datos_env);
$json=json_decode($respuesta,true);
if(!$json){
    session_destroy();
    die(error_page("Examen Colegio","<h1>Notas de los Alumnbos</h1><p>Error al obtener notas</p>"));
}
if(isset($json['error'])){
    session_destroy();
    consumir_servicios_REST(DIR_SERV . "/salir", "POST", $datos_env);
    die(error_page("Examen Colegio","<h1>Notas de los Alumnbos</h1><p>Error al conectarse a la bbdd</p>"));
}
$notas=$json["notas"];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>notas alumnos</title>
    <style>
        .enlace{
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
        .linea{
            display: inline;
        }
    </style>
</head>
<body>
    <h1>Notas de los alumnos</h1>
    <div>
    <p class="linea">Bienvenido <strong><?php echo $datos_usuario_log['usuario'];?></strong> - <form method="post" action="index.php" class="linea"><button name="salir" class="enlace">Salir</button></form></p>
    </div>
    <h3>Notas del Alumno <strong><?php echo $datos_usuario_log['nombre']; ?></strong></h3>
    <table>
        <tr><th>Asignaturas</th><th>Nota</th></tr>
        <?php
        foreach ($notas as $nota) {
            echo "<tr><td>" . $nota['denominacion'] . "</td><td>" . $nota['nota'] . "</td></tr>";
        }
        ?>
    </table>
    
</body>
</html>