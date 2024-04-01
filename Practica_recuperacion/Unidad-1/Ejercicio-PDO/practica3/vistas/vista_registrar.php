<?php
if(isset($_POST['btnentrar'])){
    $error_usuario=$_POST['usuario']=='';
    $error_clave=$_POST['clave']=='';
    $error_form=$error_usuario || $error_clave;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <h2>Registrarse</h2>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            
        </p>
    </form>
</body>
</html>