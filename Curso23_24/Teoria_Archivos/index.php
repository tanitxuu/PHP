<?php
if(isset($_POST["enviar"])){
    $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"])|| $_FILES["archivo"]["size"]>500*1024;
}
if(isset($_POST["enviar"]) && !$error_archivo){
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria subir fichero al servidor</title>
</head>
<body>
    <h1> Teoria subir ficheros al servidor</h1>
    <h2>Datos del archico subidos</h2>
    <form action="index.php" method="post" enctype="multipart/form-data" >
    <p>
        <?php
        $nombre_nuevo=md5(uniqid(uniqid(),true));
        $array_nombre=explode(".",$_FILES["archivo"]["name"]);
        $ext="";
        if(count($array_nombre)>1){
            $ext=".".end($array_nombre);
           
        }
        $nombre_nuevo.=$ext;
        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"img/".$nombre_nuevo);
        if($var){
            echo "<h3>Foto</h3>";
            echo "<p><strong>Nombre:</strong>".$_FILES["archivo"]["name"]."</p>";
            echo "<p><strong>Tipo:</strong>".$_FILES["archivo"]["type"]."</p>";
            echo "<p><strong>Tamaño:</strong>".$_FILES["archivo"]["size"]."</p>";
            echo "<p><strong>Error:</strong>".$_FILES["archivo"]["error"]."</p>";
            echo "<p>La imagen se ha subido correctamente</p>";
            echo "<p><img class='tam_imag' src='img/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";

        }else{
            echo "<span class='error'>No se a podido mover la imagen a la carpeta de destino en el servidor</span>";
        }
        ?>
    </p>
    <p>
        <button type="submit" name="enviar">Enviar</button>
    </p>
    </form>
</body>
</html>
<?php
}else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria subir fichero al servidor</title>
    <style>.error{color:red}</style>
</head>
<body>
    <h1> Teoria subir ficheros al servidor</h1>
    <h2></h2>
    <form action="index.php" method="post" enctype="multipart/form-data" >
    <p>
        <label for="archivo">seleccione un archivo imagen (Max 500KB):</label>
        <input type="file" name="archivo" id="archivo" accept="img/*"/>
        <?php
        if(isset($_POST["enviar"]) && $error_archivo){
            if($_FILES["archivo"]["name"]!=""){
                if($_FILES["archivo"]["error"]){
                echo "<span class='error'>No se ha podido subir el archivo</span>";
                }elseif(!getimagesize($_FILES["archivo"]["tmp_name"])){
                echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                }else{
                echo "<span class='error'>El archivo supera el tamaño</span>";}}
        }
        ?>
    </p>
    <p>
        <button type="submit" name="enviar">Enviar</button>
    </p>
    </form>
</body>
</html>
<?php
}
?>