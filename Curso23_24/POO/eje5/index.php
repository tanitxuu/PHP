<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ejercicio 4 POO</h1>
    <?php
    require "class_empleado.php";

    
   $empleado1=new Empleado("Manolo Palomo","1500");
   $empleado2=new Empleado("Maria Pomo","3500");

   echo "<h2>Imformacion de Empleados</h2>";

   $empleado1->impuestos();
   $empleado2->impuestos();
  

    ?>
</body>

</html>