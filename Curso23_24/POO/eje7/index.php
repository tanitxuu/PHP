<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ejercicio 6 POO</h1>
    <?php
    require "class_menu.php";

    $m=new Menu();
    $m->cargar('http://www.marca.com','Marca');
    $m->cargar('http://www.nintendo.com','Nintendo');
    $m->cargar('http://www.msn.com','MSN');
    $m->vertical();
    $m->horizontal();


  

    ?>
</body>

</html>