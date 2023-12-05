<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>table,td,th{border:1px solid black;}</style>
</head>
<body>
    <?php
    $lenguaje_cliente['c1']=3453;
    $lenguaje_cliente['c2']=342;
    $lenguaje_cliente['c3']=2424;
    $lenguaje_cliente['c4']=2474;
    $lenguaje_servidor['d1']=24424;
    $lenguaje_servidor['d2']=545;
    $lenguaje_servidor['d3']=5252;
    $lenguaje_servidor['d4']=565;
/*
    $lenguaje=$lenguaje_cliente;
    foreach ($lenguaje_servidor as $i => $v) {
        $lenguaje[$i]=$v;
    }*/
    $lenguaje=$lenguaje_cliente+$lenguaje_servidor;
    echo "<table>";
    echo "<tr><th>Lenguajes</th></tr>";
    foreach ($lenguaje as $leng => $de)
    echo "<tr><td>".$de."</td></tr>";
    echo "</table>";
?>
    
</body>
</html>