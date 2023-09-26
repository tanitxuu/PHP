<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Array</title>
</head>
<body>
    <?php
   /* $nota[0]=5;
    $nota[1]=9;
    $nota[2]=8;
    $nota[3]=5;
    $nota[4]=6;
    $nota[5]=7;*/
    $nota9=array(5,6,7,8,9);

    echo "<h1>Recorrido de un array escalar con un sus indices correlativos</h1>";
    for ($i=0; $i < count($nota9); $i++) { 
    echo "<p> En la posicion: ".$i." tiene el valor ".$nota9[$i]." </p>";
}
    /*$notas[0]=15;
    $notas[1]="HOLA";
    $notas[2]=true;
    $notas[3]=3.4;*/

    $notas=array(5,99=>"HOLA",false,7.6,8,9);

    echo "<br>";
    //print solo funciona con arrays
    print_r($notas);
    echo "<br>";
    //funciona con cualquier variable
    var_dump($notas);

    //Si dentro de la variable ponemos false a la hora de mostrar no saldra nada
    $notas1[1]=15;
    $notas1[]="HOLA";
    $notas1[120]=false;
    $notas1[]=3.4;

    echo "<h1>Recorrido de un array escalar con un sus indices NO correlativos</h1>";
    //usamos un foreacho para recorrer una variable con diferentes valores
    foreach ($notas1 as $indice => $contenido) {
        echo "<p> Contenido: ".$indice." tiene el valor: ".$contenido." </p>"; 
    }


    ?>
</body>
</html>