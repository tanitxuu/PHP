<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Ficheros de texto</title>
</head>
<body>
    <?php
    //la variable sera el puntero
    @$fd1=fopen("ruta.txt","r+");//a=para seguir escribiendo al final del fichero, r=para leer, w=para escribir r+= nos deja tamb escribir
    if(!$fd1)
        die("<p>No se a podido abrir el fichero ruta.txt</p>");
    echo"<h1>Fichero en orden</h1>";

    $linea=fgets($fd1);//me muestra lo q esta escrito en la linea
    echo "<p>".$linea."</p>";

    $linea=fgets($fd1);//al repetirlo me manda a la segunda
    echo "<p>".$linea."</p>";

    $linea=fgets($fd1);//y aqui a la tercera
    echo "<p>".$linea."</p>";

    fseek($fd1,0);//esto te manda la primera linea

    while($linea=fgets($fd1)){//con esto recorremos el fichero y no salen todas las lineas
        echo "<p>".$linea."</p>";
    }
    //fput lo mismo que el write /m el PHP.EOL. nos hace escribir en la linea de abajo
    fwrite($fd1,PHP_EOL."no me vas a dejar escribir");
    fclose($fd1);//para cerrar el fichero
    ?>
</body>
</html>