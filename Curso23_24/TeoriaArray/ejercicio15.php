<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>table,td,th,caption{border:1px solid black;}</style>
</head>
<body>
    <?php
    $numeros['a']=3;
    $numeros['ab']=2;
    $numeros['abc']=8;
    $numeros['abcd']=123;
    $numeros['abcde']=5;
    $numeros['abcdef']=1;
    asort($numeros);

    echo "<table>";
    echo " <caption>Tabla</caption>";
    echo "<tr>";
    foreach ($numeros as $i => $v){
        echo "<td>";
        echo $i;
        echo "</td>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($numeros as $i => $v){
        echo "<td>";
        echo $v;
        echo "</td>"; 
    }
    echo "</tr>";
    echo "</table>";
?>
    
</body>
</html>