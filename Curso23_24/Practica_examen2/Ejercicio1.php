<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ejercicio 1.Generador de "claves_polybios.txt"</h1>
    <button type="submit" name="generar">Generar</button>
    <?php
      //esto es para generar el fichero cuando se pulse el boton
      if(isset($_POST["generar"]) && !$error_form){
        echo "<h2>Respuesta</h2>";
        //le ponemos el nombre al fichero
          $nombre="claves_polybios.txt";
          //abrimos el fichero y le dasmos permisos
          @$fd=fopen("Fichero/".$nombre,"w");
          //para leer el fichero
          $linea=fgets($fd);
          //si el fichero no existe muere
          if(!$fd){
              die("<p>No se a podido crear el fichero</p>");
          }
          //aqui tendremos que hacer los patrones para mete dentro del fichero
          for($i=1;$i<=10;$i++){
            //esto es para escribir en el fichero
              fputs($fd,$i." x ".$_POST["texto1"]." = ".($i*$_POST["texto1"]).PHP_EOL);

          }
          echo "<input type=text-area name='leer'>";
          //en este bucle leemos todo el fichero
          while($linea=fgets($fd)){
            echo "<input type=text-area name='leer'>";
            }
          //cerramos el fichero
          fclose($fd);
          //decimos que el fichero se ha creado
          echo "<p>Fichero generado con exito</p>";
      }
    
    ?>
</body>
</html>