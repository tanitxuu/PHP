<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista normal</title>
    <style>
        img{
            width: 30%;
            height: auto;
        }
        #columna{
            display: flex;
            flex-wrap: wrap;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Libreria</h1>
    <p>Bienvenido <strong> <?php echo $datos_usuario_log['lector']; ?> </strong> - <form action="index.php" method="post"><button name="salir">Salir</button></form></p>
    <?php require "vistas/tabla.php"; ?>
</body>
</html>