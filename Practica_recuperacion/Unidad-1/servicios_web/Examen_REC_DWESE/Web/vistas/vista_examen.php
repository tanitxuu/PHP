<?php
$dia_hoy = date("w");

switch ($dia_hoy) {
    case 1:
        $dia_hoy="Lunes";
        break;
    case 2:
        $dia_hoy="Martes";
        break;
    case 3:
        $dia_hoy="Miercoles";
        break;
    case 4:
        $dia_hoy="Jueves";
        break;
    case 5:
        $dia_hoy="Viernes";
        break;
   
  
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
    </style>
</head>

<body>
    <h1>Gestion de guardias</h1>
    <div>
        Bienvenido <?php echo $datos_usuario_log["usuario"] ?> - <form action="index.php" method="post" class="linea"><button name="btnsalir" class='enlace'>Salir</button></form>
    </div>
    <p>Hoy es <strong><?php echo $dia_hoy ?></strong></p>
    <table>
        <tr><th>Hora</th><th>Profesor de guardia</th><th>Informacion del Profesor con id: <?php echo $datos_usuario_log["id_usuario"]?></th></tr>
    <?php

    ?>
    </table>
</body>

</html>