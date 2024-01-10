<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ejercicio 4 POO</h1>
    <?php
    require "class_uva.php";

    echo "<h2>Imformacion de mi Uva</h2>";
    
    $uva = new Uva("verde", "pequeña",false);
    if($uva->tieneSemilla()){
        echo "<p>La uva es de color: ".$uva->get_color()." , tamaño: ".$uva->get_tamanyo()." y tiene semillas...</p>";

    }else{
        echo "<p>La uva es de color: ".$uva->get_color()." , tamaño: ".$uva->get_tamanyo()." y no tiene semillas...</p>";
    }
  

    ?>
</body>

</html>