<?php
if(isset($_POST["btenviar"])){
    $error_texto1=$_POST["texto1"]=="" || !is_numeric($_POST["texto1"]) || $_POST["texto1"]<1 || $_POST["texto1"]>10;
    $error_texto2=$_POST["texto2"]=="" || !is_numeric($_POST["texto2"]) || $_POST["texto2"]<1 || $_POST["texto2"]>10;
    $error_form=$error_texto1 || $error_texto2;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio3</title>
    <style>.error{color:red;}</style>
</head>
<body>
    <h1>Ejercicio 3</h1>
    <form action="Ejercicio3.php" method="post">
    <p>
        <label for="texto1">Introduzca un numero entre el 1 y el 10</label>
        <input type="text" name="texto1" id="texto1" value="<?php if(isset($_POST["texto1"])) echo $_POST["texto1"];?>">
        <?php
        if(isset($_POST["btenviar"]) && $error_form){
            if($_POST["texto1"]==""){
                echo "<span class=error>Campo vacio</span>";
            }else{
                echo "<span class=error>Error al introducir un numero/span>";
            }
        }
        ?>
    </p>
    <p>
        <label for="texto2">Introduzca un numero entre el 1 y el 10</label>
        <input type="text" name="texto2" id="texto2" value="<?php if(isset($_POST["texto2"])) echo $_POST["texto2"];?>">
        <?php
        if(isset($_POST["btenviar"]) && $error_form){
            if($_POST["texto2"]==""){
                echo "<span class=error>Campo vacio</span>";
            }else{
                echo "<span class=error>Error al introducir un numero/span>";
            }
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btenviar">Crear Fichero</button>
    </p>
    </form>
    <?php
 if (isset($_POST["btenviar"]) && !$error_form) {
 $nombre_fichero = "tablas_".$_POST["texto1"].".txt";
 $ruta_fichero = "Tablas/".$nombre_fichero;
 $numeroLinea = $_POST["texto2"];

 if (file_exists($ruta_fichero)) {

 @$fd1=fopen($ruta_fichero,"r");
 for ($i=0; $i < $numeroLinea; $i++) { 
 $linea=fgets($fd1);
 }
 echo "<p>".$linea."</p>";

 } else {
 echo "<p>Fichero no encontrado</p>";
 }
 fclose($fd1);
 }
 ?>
</body>
</html>