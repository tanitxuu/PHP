<?php

use Pimple\Tests\Fixtures\Service;

$dia = date("w");
$dia_hoy = date("w");

switch ($dia_hoy) {
    case 1:
        $dia_hoy = "Lunes";
        break;
    case 2:
        $dia_hoy = "Martes";
        break;
    case 3:
        $dia_hoy = "Miercoles";
        break;
    case 4:
        $dia_hoy = "Jueves";
        break;
    case 5:
        $dia_hoy = "Viernes";
        break;
}
$horas[1] = "8:15-9:15";
$horas[2] = "9:15-10:15";
$horas[3] = "10:15-11:15";
$horas[4] = "11:15-11:45";
$horas[5] = "11:45-12:45";
$horas[6] = "12:45-13:45";
$horas[7] = "13:45-14:45";
for ($hora = 1; $hora <= count($horas); $hora++) {
    if ($hora != 4) {
        $respuesta = consumir_servicios_REST(SERV_WEB . "/usuariosGuardia/" . $dia . "/" . $hora, "GET", $datos_env);
        $json = json_decode($respuesta, true);
        if (!$json) {
            session_destroy();
            die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
        }
        if (isset($json["error"])) {

            session_destroy();
            consumir_servicios_REST(SERV_WEB . "/salir", "POST", $datos_env);
            die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>" . $json["error"] . "</p>"));
        }

        if (isset($json["no_auth"])) {
            session_unset();
            $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
            header("Location:index.php");
            exit();
        }
        $profesores_guardia[$hora] = $json['usuarios'];
    }
}
if(isset($_POST['btnDetalles'])){
    
    $respuesta = consumir_servicios_REST(SERV_WEB . "/usuario/" . $_POST["btnDetalles"] , "GET", $datos_env);
    $json = json_decode($respuesta, true);
    if (!$json) {
        session_destroy();
        die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));
    }
    if (isset($json["error"])) {

        session_destroy();
        consumir_servicios_REST(SERV_WEB . "/salir", "POST", $datos_env);
        die(error_page("Práctica Rec 3", "<h1>Práctica Rec 3</h1><p>" . $json["error"] . "</p>"));
    }

    if (isset($json["no_auth"])) {
        session_unset();
        $_SESSION["seguridad"] = "Usted ya no se encuentra registrado en la BD";
        header("Location:index.php");
        exit();
    }
    $profesor_detalles[] = $json['usuario'];
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de guardias</title>
    <style>
        .enlace {
            cursor: pointer;
            border: none;
            color: blue;
            background: none;
            text-decoration: underline;
        }

        .linea {
            display: inline;
        }

        table {
            border-collapse: collapse;
            width: 80%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            text-align: center;
        }

        th {
            background-color: #CCC
        }
    </style>
</head>

<body>
    <h1>Gestion de guardias</h1>
    <div>
        Bienvenido <?php echo $datos_usuario_log["usuario"] ?> - <form action="index.php" method="post" class="linea"><button name="btnsalir" class='enlace'>Salir</button></form>
    </div>
    <p>Hoy es <strong><?php echo $dia_hoy ?></strong></p>
    <?php
    echo "<table>";
    
    echo "<tr><th>Hora</th><th>Profesor de guardia</th>";
    if(isset($_POST['btnDetalles'])){
        echo "<th>Informacion del Profesor con id: ".$_POST["btnDetalles"]." </th>";
    }else{
        echo "<th>Informacion del Profesor con id:  </th>";
    }
  
    echo "</tr>";

    for ($hora = 1; $hora <= count($horas); $hora++) {
        if ($hora != 4) {
            echo "<tr>";
            echo "<td>" . $horas[$hora] . "</td>";
            echo "<td>";
            echo "<form method='post' action='index.php'>";
            echo "<ol>";
            foreach ($profesores_guardia[$hora] as $tupla) {
                echo "<li><button name='btnDetalles' class='enlace' value=" . $tupla['id_usuario'] . ">" . $tupla["nombre"] . "</button></li>";
            }
            echo "</ol>";
            echo "</form>";
            echo "</td>";
            echo "<td>";
                if(isset($_POST['btnDetalles']) && $hora==1){
                    foreach ($profesor_detalles as $tuplas) {
                    echo "<p>Nombre: ".$tuplas['nombre']."</p>";
                    echo "<p>Usuario: ".$tuplas['usuario']."</p>";
                    echo "<p>Clave: </p>";
                    echo "<p>Email: Email no disponible</p>";
                    }
                }
           
            echo "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";

    ?>

</body>

</html>