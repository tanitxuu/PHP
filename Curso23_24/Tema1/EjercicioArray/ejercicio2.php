<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Ejercicio 2</h1>
    <?php
    $v[1]=90;
    $v[30]=7;
    $v['e']=99;
    $v['hola']=43;
    echo "<p>";
    foreach ($v as $i => $valor) {
        echo "La clave ".$i." vale: ".$valor."<br/>";
    }
    echo "</p>";

    ?>
</body>
</html>