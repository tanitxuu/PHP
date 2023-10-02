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
<form action="Ejercicio4.php" method="post" enctype="multipart/form-data">

<div style="background-color:lightblue; border:solid; padding:5px;">

    <h1 style="text-align:center">Romanos a Arabes - Formulario</h1>

    <p>Dime un numero en romano y te lo devuelvo a cifras arabes </p>
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
       
        echo'<h1 style="text-align:center">Romanos a Arabes - Resultado</h1>';
       
        $stringC = trim(strtolower($_POST['primera']));
    
       function romanoEntero($romano){

        $resultado=0;
        $romanos = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    
        foreach ($romanos as $llave => $valor) {
    
            while (strpos($romano, $llave) === 0) {
    
                $resultado += $valor;
    
                $romano     = substr($romano, strlen($llave));
    
            }
    
        }
    
        return $resultado;
    
    }
        
       
        echo '<p>'.$_POST['primera'].' en arabe es '.romanoEntero($stringC).'</p>';
        
       
        
        }
       
        echo'</div>';
        
        
        
        
        
    

?>

</form>
</body>
</html>