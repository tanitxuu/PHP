<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rellena el formulario</title>
</head>
<body>
<form enctype="multipart/form-data" action="index.php" method='post' >
<fieldset>
    <legend>Rellena tu CV</legend>
    <label for="usu">Usuario:</label><br>
    <input type="text" name="usu" id="usu"><br>
    <?php
    if(isset($_POST['enviar']) && $error_usu){
        echo '<span class="error">*Debe rellenar el usuario*</span><br>';
    }
    ?>
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre"><br>
    <?php
    if(isset($_POST['enviar']) && $error_nombre){
        echo '<span class="error">*Debe rellenar el nombre*</span><br>';
    }
    ?>
    <label for="clave">Contraseña:</label><br>
    <input type="password" name="clave" id="clave"><br>
    <?php
    if(isset($_POST['enviar']) && $error_clave){
        echo '<span class="error">*Debe rellenar la contraseña*</span><br>';
    }
    ?>
    <label for="dni">DNI:</label><br>
    <input type="text" name="dni" id="dni"><br>
    <?php
    if(isset($_POST['enviar']) && $error_dni){
        if($_POST['dni']==''){
        echo '<span class="error">*Debe rellenar el DNI con 8 digitos seguidos de una letra*</span><br>';
         }else if(strlen($_POST['dni']) != 8){
            echo '<span class="error">*Los primeros 8 digitos deben ser numeros*</span><br>';
         }else if(!ctype_alpha(substr($_POST['dni'], -1))){
        echo '<span class="error">*El ultimo digito debe ser una letra*</span><br>';}
    }
    ?>
    <label for="sexo">Sexo:</label><br>
    <input type="radio" name="sexo" id="sexo" value="Hombre">Hombre
    <input type="radio" name="sexo" id="sexo" value="Mujer" checked>Mujer<br><br>
    <label for="img">Incluir mi foto</label>
    <input type="file" name="img" id="img" accept="image/*"><br><br>
    <?php
        if(isset($_POST["enviar"]) && $error_img){
            if($_FILES["img"]["name"]!=""){
                if($_FILES["img"]["error"]){
                echo "<span class='error'>No se ha podido subir el archivo</span>";
                }elseif(!getimagesize($_FILES["img"]["tmp_name"])){
                echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                }else{
                echo "<span class='error'>El archivo supera el tamaño</span>";}}
        }
        ?>
    <input type="checkbox" id="sub" name="sub">Suscribete al boletin de novedades<br>
    <?php
    if(isset($_POST['enviar']) && !isset($_POST['sub']) ){
        echo '<span class="error">*Marque la casilla*</span><br>';
    }
    ?>
    <button type="submit" name="enviar">Guardar Cambios</button><button type="reset" name="borrar">Borrar los datos introducidos</button>

</fieldset>
</form>
  
</body>
</html>