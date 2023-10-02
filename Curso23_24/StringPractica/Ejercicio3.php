<?php

//Si los campos estan vacios o no contienen la longitud adecuada
if (isset($_POST["comparar"])) {

    
    $errorPrimera = $_POST["primera"] == "" || strlen(trim($_POST["primera"])) <3;
   
    $errorFormu = $errorPrimera;
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
<form action="Ejercicio2.php" method="post" enctype="multipart/form-data">

<div style="background-color:lightblue; border:solid; padding:5px;">

    <h1 style="text-align:center">Palindromos - Formulario</h1>

    <p>Dime una palabra  y te dire si es un palindromo </p>
    <p>
        <label for="primera">Palabra :</label>
        <input type="text" name="primera" id="primera" value ="<?php if(isset($_POST["primera"])) echo $_POST["primera"]?>">
        <?php
            if (isset($_POST["comparar"]) && $errorPrimera) {
                echo "<span class='error'>*Introduce una palabra de al menos 3 letras*</span>";
            }
        ?>
    </p>
    <p>
        <button type="submit" name="comparar">Comprobar</button>
    </p>

</div>


<?php

    if (isset($_POST["comparar"]) && !$errorFormu) {

        echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';
       
        echo'<h1 style="text-align:center">Palindromos / capicuas - Resultado</h1>';
       
        $stringC = trim(strtolower($_POST['primera']));
        $reversa = strrev($stringC);
    
       
        if($reversa == $stringC){
       
        echo '<p>'.$_POST['primera'].' es un palindromo</p>';
        
        }else{
       
        echo '<p>'.$_POST['primera'].' no es un palindromo</p>';
       
        }
        
        }
       
        echo'</div>';
        
        
        
        
        
    

?>

</form>
</body>
</html>