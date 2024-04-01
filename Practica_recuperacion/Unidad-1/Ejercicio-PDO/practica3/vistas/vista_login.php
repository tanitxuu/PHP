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
    <title>Login</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>

<body>
    <h2>Practica 3 Login</h2>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>">
            <?php
            if(isset($_POST['btnentrar']) && $error_usuario){
                echo "<span class='error'>*Campo vacio*</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave">
            <?php
            if(isset($_POST['btnentrar']) && $error_clave){
                echo "<span class='error'>*Campo vacio*</span>";
            }
            ?>
        </p>
        <p>
            <button name="btnentrar">Entrar</button>
            <button name="btnregis">Registrarse</button>
        </p>
    </form>
    <?php
    if(isset($_POST['btnentrar']) && !$error_form){
        $_SESSION['usuario']=$_POST['usuario'];
    
     }else if(isset($_POST['btnregis'])){
        require "vista_registrar.php";
    }
    ?>
</body>

</html>