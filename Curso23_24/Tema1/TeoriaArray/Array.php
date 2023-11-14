<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Array</title>
</head>
<body>
    <?php
       $notas2["Antonio"]["DWESE"]=5;
       $notas2["Antonio"]["DWEC"]=7;
       $notas2["Luis"]["DWESE"]=8;
       $notas2["Luis"]["DWEC"]=5;
       $notas2["Ana"]["DWESE"]=6;
       $notas2["Ana"]["DWEC"]=8;
       $notas2["Eloy"]["DWESE"]=3.5;
       $notas2["Eloy"]["DWEC"]=5;
       $notas2["Gabriela"]["DWESE"]=10;
       $notas2["Gabriela"]["DWEC"]=4;
       $notas2["Berta"]["DWESE"]=7;
       $notas2["Berta"]["DWEC"]=6;
   
       echo "<h1>Notas de los alumnos</h1>";
           foreach ($notas2 as $nombre => $asignaturas) {
               echo "<p>".$nombre."<ul>";
               foreach ($asignaturas as $clase => $notas) {
                   echo "<li><b>".$clase."</b> => ".$notas."</li>"; 
               }
               echo "</ul></p>";
           }

       $capital=array("CAstilla y Leon"=>"Valladolid","Asturias" =>"Oviedo","Aragon"=>"Zaragoza");
       //Sacar el ultimo valor de la array
       echo "<p>Ultimo valor de la array; ".end($capital)."</p>";
       //El current te da el valor de la posicion en la que este el puntero de la array
       echo "<p>Estamos en el valor de la array; ".current($capital)."</p>"; 
       //te muestra el valor del indice
       echo "<p>Provincia ; ".key($capital)."</p>";    
       //Pasamos el puntero una posicion para alante
       next($capital);
       //Es para volver al principio de la array
       reset($capital);
       //Pasamos el puntero uno para atras
       prev($capital);

       reset($capital);
       
           while (current($capital)) {
            echo "<b>".current($capital)."</b><br/>";
            next($capital);
          
           }
   
    ?>
</body>
</html>