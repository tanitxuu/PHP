<?php
if(isset($_POST["bt"])){
    $error_texto1=$_POST["texto1"]=="" ;
    $error_texto2=$_POST["texto2"]==""|| !is_numeric($_POST["texto2"]) ||is_numeric($_POST["texto2"])<1 || is_numeric($_POST["texto2"])>26;
    $error_archivo=$_FILES["fichero"]["name"]=="" || $_FILES["fichero"]["error"]|| $_FILES["fichero"]["type"]!="text/plain" || $_FILES["fichero"]["size"]>= 1250*1024;
    $error_formulario=$error_archivo||$error_texto1||$error_texto2;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>.error{color:red;}</style>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <form action="Ejercicio3.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="texto1">Introduzca un Texto:</label>
        <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"]?>">
        <?php
        if(isset($_POST["bt"]) && $error_texto1){
          if($_POST["texto1"]==""){
            echo "<span class='error'>*Campo Vacio*</span>";
          }
        }
        ?>
    </p>
    <p>
        <label for="texto2">Desplazamiento:</label>
        <input type="text" name="texto2" id="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"]?>">
        <?php
        if(isset($_POST["bt"]) && $error_texto2){
            if($_POST["texto2"]==""){
                echo "<span class='error'>*Campo Vacio*</span>";
              }else{
                echo "<span class='error'>*Desplazamiento no valido*</span>";

              }
        }
        ?>
    </p>
    <p>
        <label for="fichero">Seleccione el archivo de clave:</label>
        <input type="file" name="fichero" id="fichero" accept="text/plain">
        <?php
        if(isset($_POST["bt"]) && $error_archivo){
            if($_FILES["fichero"]["name"]==""){
              echo "<span class='error'>*</span>";
            }elseif($_FILES["fichero"]["type"]!="text/plane"){
                echo "<span class='error'>*Introduzca un archivo tipo texto*</span>";
            }elseif($_FILES["fichero"]["error"]){
                echo "<span class='error'>*Error al subir el archivo*</span>";
            }else{
                echo "<span class='error'>*Tamaño del archivo superado*</span>";
            }
        }
      
        ?>
    </p>
    <p>
        <button type="submit" name="bt">Codificar</button>
    </p>
    </form>
    <?php
if(isset($_POST["bt"]) && !$error_formulario){

  echo "<h2>Respuesta</h2>";
    @$fd=fopen($_FILES["fichero"]["tmp_name"],"r");
    if(!$fd){
      die("<p>No tines permisos para abrirlo</p>");
    }
    $Primera_linea=fgets($fd);
    while($linea=fgets($fd)){
      $datos_linea=explode(";",$linea);
      $claves[$datos_linea[0]]=$datos_linea;
    }
    fclose($fd);
    $texto=$_POST["texto1"];
    $desplazamiento=$_POST["texto2"];
    for ($i=0; $i <strlen($texto) ; $i++) { 
      if($texto[$i]>="A" && $texto[$i]<="Z" ){
        $respuesta=$claves[$texto[$i]][$desplazamiento];
      }else{
        $respuesta=$texto[$i];
      }
    }
    echo "<p>El texto codificado seria:<br>".$respuesta."</p>";
  }
    
    ?>
</body>
</html>