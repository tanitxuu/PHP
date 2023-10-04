<?php
if(isset($_POST["enviar"])){
    $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"])|| $_FILES["archivo"]["size"]>500*1024;
}
if(isset($_POST["enviar"]) && !$error_archivo){
echo "Contesto con la info del archivo subido";
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