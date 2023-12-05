<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php


$string1="     Hola que tal?";
$string1=trim($string1);
$string2="Juan";

echo "<h1>".$string1." ".$string2."</h1>";

$longitud=strlen($string1); //Longitud de un string
echo "<p>La longitud del String: '".$string1."' es: ".$longitud."</p>";


$a=$string1[3]; //Accede a la posicion del string es decir como string es "Hola" accederia a las 3 que es la letra "a"

echo "<p>".$a."</p>";

$string1[12]="!"; //Cambio la letra de la posicion 12 que seria "?" por una "!"

echo "<p>".$string1."</p>";

echo "<p>".strtoupper($string1)."</p>"; //Lo escribe en mayuscula !NO LO CONVIERTE!
echo "<p>".strtolower($string1)."</p>"; //Lo escribe en minuscula !NO LO CONVIERTE!



?>
</body>
</html>