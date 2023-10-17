<?php
if(isset($_POST["btenviar"])){
    $error_form=$_POST["texto1"]=="" || !is_numeric($_POST["texto1"]) || $_POST["texto1"]<1 || $_POST["texto1"]>10;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>.error{color:red;}</style>
</head>
<body>
    <h1>Ejercicio 1</h1>
    <form action="Ejercicio1.php" method="post">
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
        <button type="submit" name="btenviar">Crear Fichero</button>
    </p>
    </form>
    <?php
    if(isset($_POST["btenviar"]) && !$error_form){
        $nombre="tablas_".$_POST["texto1"].".txt";
        @$fd=fopen("Tablas/".$nombre,"w");
        if(!$fd){
            die("<p>No se a podido crear el fichero</p>");
        }
        for($i=1;$i<=10;$i++){
            fputs($fd,$i." x ".$_POST["texto1"]." = ".($i*$_POST["texto1"]).PHP_EOL);
        }
        fclose($fd);
        echo "<p>Fichero generado con exito</p>";
    }
    ?>
</body>
</html>