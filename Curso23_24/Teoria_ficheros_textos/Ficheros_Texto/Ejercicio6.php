<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 6</title>
</head>
<body>
    <h1>Ejercicio 6</h1>
    <?php
        @$fd1=fopen("http://dwese.icarosproject.com/PHP/datos_ficheros.txt","r");
        die("<h3>No se ha podido abrir el fichero: http://dwese.icarosproject.com/PHP/datos_ficheros.txt");

        else{
        $linea=fgets($fd1);
        $datos_linea=explode("\t",$linea);
        
        }
    ?>
</body>
</html>