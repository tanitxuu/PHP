<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $p['Nombre']="Pedro Torres";
    $p['Direccion']="C/Mayor,37";
    $p['Telefono']=123456789;
    foreach ($p as $d => $datos) {
        echo "<p><b>".$d.":</b> ".$datos."</p>";
    };



    
    ?>
</body>
</html>