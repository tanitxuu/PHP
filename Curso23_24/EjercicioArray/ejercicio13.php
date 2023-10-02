<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $animales=array("Lagartija","Araña","Perro","Gato","Raton");
    $numeros=array(2,34,45,52,12);
    $mezcla=array("Sauce","Pino","Naranjo","Chopo","Perro",34);
    $resultado= array_merge($animales,$numeros,$mezcla);
    print_r(array_reverse($resultado));
    
    
    ?>
</body>
</html>