<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $c[]="Madrid";
    $c[]="Barcelona";
    $c[]="Londres";
    $c[]="New York";
    $c[]="Los Angeles";
    $c[]="Chicago";

foreach ($c as $i => $ciudad) {
    echo "<p>La ciudad con el indice ".$i." tiene el nombre ".$ciudad."</p>";
}



    ?>
    
</body>
</html>