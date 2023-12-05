<?php
session_name("ejer_01_23_24");
session_start();
if (isset($_POST["nombre"]) && $_POST["nombre"] != "") {
    if ($_POST["nombre"] = "") {
        unset($_SESSION["nombre"]);
    } else {
        $_SESSION["nombre"] = $_POST["nombre"];
    }
}
if (isset($_POST["btnborrar"])) {
    session_destroy();
    header("Location:ejercicio1.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Formulario nombre 1 (Resultado)</h1>
    <?php
    if (isset($_SESSION["nombre"])) {
        echo "<p>El nombre es : <strong>" . $_SESSION["nombre"] . "</strong></p>";
    } else {
        echo "<p>No has tecleado nada</p>";
    }
    ?>
    <p><a href="ejercicio1.php">Volver a la primera pagina</a></p>
</body>

</html>