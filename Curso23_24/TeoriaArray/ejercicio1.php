<?php
function generar_pares($n){
    for ($i=0; $i <2*$n ; $i+=2) { 
        $pares[]=$i;
    }
    return $pares;
}
define("INPARES",20);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inpares</title>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <?php
    $pares=generar_pares(INPARES);
    echo "<p>";
    for ($i=0; $i < count($pares); $i++) { 
        echo $pares[$i]."<br/>";
    }
    echo "</p>";
    ?>

</body>
</html>