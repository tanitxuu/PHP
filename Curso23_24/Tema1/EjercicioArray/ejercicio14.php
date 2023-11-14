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
    $estadios_futbol['Barcelona']="Camp Nou";
    $estadios_futbol['Real Madrid']="Santiago Bernabeu";
    $estadios_futbol['Valencia']="Mestalla";
    $estadios_futbol['Real Sociedad']="Anoeta";
    unset($estadios_futbol["Real Madrid"]);
    echo "<table>";
    echo " <caption>Estadios De futbol</caption>";
    echo "<tr>";
    foreach ($estadios_futbol as $equipo => $estadio){
        echo "<td>";
        echo $equipo;
        echo "</td>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($estadios_futbol as $equipo => $estadio){
        echo "<td>";
        echo $estadio;
        echo "</td>"; 
    }
    echo "</tr>";
    echo "</table><br/>";

    $estadio_futbol['Barcelona']="Camp Nou";
    $estadio_futbol['Real Madrid']="Santiago Bernabeu";
    $estadio_futbol['Valencia']="Mestalla";
    $estadio_futbol['Real Sociedad']="Anoeta";

    echo "<table>";
    echo " <caption>Estadios De futbol</caption>";
    echo "<tr>";
    foreach ($estadio_futbol as $equipo => $estadio){
        echo "<td>";
        echo $equipo;
        echo "</td>";
    }
    echo "</tr>";
    echo "<tr>";
    foreach ($estadio_futbol as $equipo => $estadio){
        echo "<td>";
        echo $estadio;
        echo "</td>"; 
    }
    echo "</tr>";
    echo "</table>";
?>
    
</body>
</html>