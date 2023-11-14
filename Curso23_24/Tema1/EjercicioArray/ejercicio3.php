<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ejercicio 3</h1>
<?php
    $p['Enero']=9;
    $p['Febrero']=12;
    $p['Marzo']=0;
    $p['Abril']=17;


function verPelicula($n){
    foreach($n as $mes => $pelicula){
        if($pelicula !=0){
            if($pelicula == 1){
                
            echo "En El mes ".$mes." se han visto ".$pelicula." pelicula <br/>";
            }else{
            echo "En El mes ".$mes." se han visto ".$pelicula." peliculas <br/>";}
        }
    }
}
echo verPelicula($p);
?>
</body>
</html>