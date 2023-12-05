<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $c['MD']="Madrid";
    $c['BC']="Barcelona";
    $c['LD']="Londres";
    $c['NY']="New York";
    $c['LAG']="Los Angeles";
    $c['CC']="Chicago";

foreach ($c as $i => $ciudad) {
    echo "<p>El indice del array contiene como valor ".$ciudad." es: ".$i."</p>";
}



    ?>
    
</body>
</html>