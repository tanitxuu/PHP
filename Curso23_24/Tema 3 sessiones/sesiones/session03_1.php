<?php
 session_name("contador");
 session_start();

if(!isset($_SESSION["contador"])){
    $_SESSION["contador"]=0;
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
    <h1>Subir y Bajar numero</h1>
    <form action="session03_2.php">
    <p>Haga click en los botones para modificar el valor</p>
    <button type="submit" name="btnContador" value="menos">-</button>
    <span><?php echo $_SESSION["contador"]; ?></span>
    <button type="submit" name="btnContador" value="mas">+</button>
    <button type="submit" name="btnContador" value="cero">Poner a cero</button>
    </form>
</body>
</html>