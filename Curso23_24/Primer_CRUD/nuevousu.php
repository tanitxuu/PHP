<?php
if(isset($_POST["btnNuevoUsu"]) || isset($_POST["btnContinuar"])){
    if(isset($_POST["btnContinuar"])){
        $error_nombre=$_POST["nombre"]=="";
        $error_usuario=$_POST["usuario"]=="";
        $error_contraseña=$_POST["contraseña"]=="";
        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
        $error_form=$error_contraseña||$error_email||$error_usuario||$error_nombre;
    
        if(!$error_form){

        }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo usuario</title>
    <style>.error{color: red;}</style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="nuevousu.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" maxlength="30" value="<?php if(isset($_POST["nombre"]))echo $_POST["nombre"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_nombre){
            echo "<span class='error'>*Campo Vacio*</span>";
        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if(isset($_POST["usuario"]))echo $_POST["usuario"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_usuario){
            echo "<span class='error'>*Campo Vacio*</span>";
        }
        ?>
    </p>
    <p>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" maxlength="50">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_contraseña){
            echo "<span class='error'>*Campo Vacio*</span>";
        }
        ?>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($_POST["email"]))echo $_POST["email"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_email){
            if($_POST["email"]==""){
            echo "<span class='error'>*Campo Vacio*</span>";
            }else{
            echo "<span class='error'>*Email no valido*</span>"; 
            }
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btnContinuar">Continuar</button>
        <button type="submit" name="volver">Volver</button>
    </p>
    </form>
    <?php
    if(isset($_POST["btnContinuar"])&& !$error_form){

    }
    ?>
</body>
</html>
<?php
}else{
    header("Location:index.php");
    exit;
}
?>