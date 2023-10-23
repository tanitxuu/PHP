<?php
if(isset($_POST["contar"])){
    $error=$_POST["texto"]=="";
 }
 function miexplore($separador,$texto){
for ($i=0; $i <strlen($texto) ; $i++) { 
   
}
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
    <form action="ejercicio3.php" method="post">
    <p>
        <label for="sep">Elija Separador</label>
        <select name="sep" id="sep">
            <option value=",">, (coma)</option>
            <option value=";">; (punto y coma)</option>
            <option value=" "> (espacio)</option>
            <option value=":">: (dos puntos)</option>
        </select>
    </p>

    <p>
        <label for="texto">Introduzca una frase</label>
        <input type="text" name="texto" id="texto" value="<?php if(isset($_POST["texto"])) echo $_POST["texto"];?>">
        <?php
        if(isset($_POST["contar"]) && $error){
            echo "<span class='error'>*Campo vacio*</span>";
         }
        ?>
    </p>

    <p>
        <button type="submit" name="contar">Contar</button>
    </p>

</body>
</html>