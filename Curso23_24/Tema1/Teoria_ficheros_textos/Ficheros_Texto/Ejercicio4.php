<?php
if(isset($_POST["enviar"])){
    $error_archivo=$_FILES["archivo"]["name"]=="" || $_FILES["archivo"]["error"] || $_FILES["archivo"]["size"]>2500*1024 || $_FILES["archivo"]["type"]!="text/plain";
}
if(isset($_POST["enviar"]) && !$error_archivo){
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio4</title>
</head>
<body>
    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data" >
    <p>
        <?php
        $contenido_fichero=file_get_contents($_FILES["archivo"]["tmp_name"]);
        echo "<h3>El numero de palabras que contiene el archivo seleccionado es ".str_word_count($contenido_fichero)."</h3>";
    
      
        ?>
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
    <form action="Ejercicio4.php" method="post" enctype="multipart/form-data" >
    <p>
        <label for="archivo">seleccione un archivo de texto para contar las palabras (Max 2,5MB):</label>
        <input type="file" name="archivo" id="archivo" accept=".txt "/>
        <?php
        if(isset($_POST["enviar"]) && $error_archivo){
            if($_FILES["archivo"]["name"]!=""){
                echo "<span class='error'></span>";
            }elseif($_FILES["archivo"]["error"]){
                echo "<span class='error'>No se ha podido subir el archivo</span>";
            }elseif($_FILES["archivo"]["type"]!="text/pain"){
                echo "<span class='error'>No has selecionado un archivo tipo txt</span>";
            }else{
                echo "<span class='error'>El archivo supera el tamaño</span>";}
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