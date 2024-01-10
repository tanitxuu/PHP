<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ejercicio 3 POO</h1>
    <?php
    require "classfruta.php";

    echo "<h2>Imformacion de Frutas</h2>";
    echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";
    $pera = new Fruta("verde", "mediano");
    echo "<p>Creando la pera...</p>";
    echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";
    $manzana = new Fruta("roja", "mediano");
    echo "<p>Creando la manzana...</p>";
    echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";

    //se destruye de las dos maneras
    //unset($manzana);
    $manzana = null;
    echo "<p>Creando la destruyendo manzana...</p>";
    echo "<p>Frutas creadas hasta el momento: " . Fruta::cuantaFruta() . "</p>";

    ?>
</body>

</html>