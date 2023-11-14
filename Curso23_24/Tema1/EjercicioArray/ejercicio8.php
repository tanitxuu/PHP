<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $c[]="Pedro";
    $c[]="Ismael";
    $c[]="Sonia";
    $c[]="Clara";
    $c[]="Susana";
    $c[]="Alfonso";
    $c[]="Teresa";

    echo"<p>Numero de elementos: ".count($c);
foreach ($c as $i => $nombre) {
    echo "<ul><li>".$nombre."</li></ul></p>";
}
?>
    
</body>
</html>