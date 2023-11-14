<?php
$palabra=trim($_POST["palabra"]);
$l_palabra=strlen($_POST["palabra"]);
$error_form=$palabra=="" || $l_palabra>2;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>-Palabra Caracteres Repetidos-</h1>
    <form action="Practica_examen.php" method="post">
    <p>formulario con un campo de texto que pida que teclee una palabra y quiero que me diga si se  repite un caracter o no .</p>
    <p>
        <label for="palabra">Escribe una palabra:</label>
        <input type="text" name="palabra" id="palabra" value="">
        <?php
        if(isset($_POST["btenviar"]) && $error_form){
            if($_POST["palabra"]==""){
            echo "<span class='error'>*Campo Vacio*</span>";
            }else{
            echo "<span class='error'>*Campo no valido*</span>";
            }
        }
        ?>
    </p>
    <p>
        <button type="submit" name="btenviar">Buscar</button>
    </p>
  

</form>
<?php


 $contador=0;
 $contador2=0;
 
 for ($j=0; $j < $l_palabra; $j++) { 

 $letrarep = $palabra[$j];
 $contador=0;

 for ($i=0; $i < $l_palabra; $i++) { 

 if($palabra[$i] == $letrarep){
 $contador++;
 if($contador > $contador2){
 $contador2 = $contador;
 
 }
 }
 
 }

 }
 if($contador2>1){
 echo "<p>Hay uno o varios caracteres repetidos</p>";
 }else{
 echo "<p>No hay caracteres repetidos</p>";
 }
 

 
 ?>
</body>
</html>
