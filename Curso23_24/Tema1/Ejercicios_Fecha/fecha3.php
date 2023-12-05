<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <?php

 //Si los campos estan vacios o no contienen la longitud adecuada
 if (isset($_POST["calcular"])) {
 
 $errorFecha1 = $_POST["fecha1"] == "" ;
 $errorFecha2 = $_POST["fecha2"] == "" ;

 $errorFormu = $errorFecha1 || $errorFecha2;
 }


 
 ?>


    <form action="fecha3.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
                <label for="fecha1">Introduzca una fecha:</label>
                <input type="date" name="fecha1" id="fecha1"
                    value="<?php if(isset($_POST['fecha1'])) echo $_POST['fecha1']?>" />
                <?php
                if (isset($_POST["calcular"]) && $errorFecha1) {
                if($_POST["fecha1"]=="")
                    echo "<span class='error'>*No has seleccionado una fecha*</span>";}
               
                
 ?>
            </p>
            <p>
                <label for="fecha2">Introduzca una fecha: </label>
                <input type="date" name="fecha2" id="fecha2"
                    value="<?php if(isset($_POST['fecha2'])) echo $_POST['fecha2']?>" />
                <?php
           if (isset($_POST["calcular"]) && $errorFecha2){
            if($_POST["fecha2"]=="")
                echo "<span class='error'>*No has seleccionado una fecha*</span>";
          }
            
 ?>
            </p>
            <p>
                <button type="submit" name="calcular">Calcular</button>
            </p>
        </div>
        <?php

 if (isset($_POST["calcular"]) && !$errorFormu) {

 echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

 echo'<h1 style="text-align:center">Fechas - Respuesta</h1>';
 //Separamos la fecha con el parametro de serparador "/"
 

 //Pasamos la fecha por MM/DD/YY nos lo pasa a segundos
 $tiempo1=strtotime($_POST["fecha1"]);
 $tiempo2=strtotime($_POST["fecha2"]);

 //restamos los segundos,con numeros enteros
 $dif_segundos=abs($tiempo1-$tiempo2);

 //Combertimos los segundos en dias y redondeamos para abajo
 $dias_pasados=floor($dif_segundos/(60*60*24));

 echo "<p> Han pasado ".$dias_pasados." dias.</p>";

 echo'</div>';
 
 }

 ?>

 </form>
</body>
</html>