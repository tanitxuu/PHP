<?php
 session_name("ejer_02_23_24");
 session_start();

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style></style>
</head>
<body>
    <h1>Formulario nombre 1 (formulario)</h1>
    <form action="session02_2.php" method="post">
        <?php
        if(isset($_SESSION["error"])){
            echo "<p>El nombre es : <strong>".$_SESSION["nombre"]."</strong></p>";
        }
        ?>
    <p>
        Escriba su nombre: 
    </p>
    <p>
        <label for="nombre"><strong>nombre:</strong></label>
        <input type="text" name="nombre" id="nombre">
    </p>
    <p>
        <button type="submit" name="btnsig">Siguiente</button>
        <button type="submit" name="btnborrar">Borrar</button>
    </p>
    </form>
</body>
</html>