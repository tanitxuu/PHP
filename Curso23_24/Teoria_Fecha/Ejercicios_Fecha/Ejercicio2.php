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
//Indicamos que despues X caracteres Y tiene que ser "/"
function buenos_separadores($texto){
    return substr($texto,2,1)=="/" && substr($texto,5,1)=="/";
}
//Decimos si los caracteres que estan en X y cogiendo Y son numericos
function numeros_buenos($texto){
    return is_numeric(substr($texto,0,2)) && is_numeric(substr($texto,3,2)) && is_numeric(substr($texto,6,4));
}
//Comrpueba si la fecha existe o no con true o false con caracteres que estan en X y cogiendo Y son numericos
function fecha_valida($texto){
    return checkdate(substr($texto,3,2),substr($texto,0,2),substr($texto,6,4));
}
 
 //Si los campos estan vacios o no contienen la longitud adecuada
 if (isset($_POST["calcular"])) {
 
 $errorFecha1 = $_POST["fecha1"] == "" || !buenos_separadores($_POST["fecha1"]) || strlen($_POST["fecha1"])!=10 || !numeros_buenos($_POST["fecha1"]) || !fecha_valida($_POST["fecha1"]);

 $errorFecha2 = $_POST["fecha2"] == "" || !buenos_separadores($_POST["fecha2"]) || strlen($_POST["fecha2"])!=10 || !numeros_buenos($_POST["fecha2"]) || !fecha_valida($_POST["fecha2"]);

 $errorFormu = $errorFecha1 || $errorFecha2;
 }


 
 ?>


    <form action="Ejercicio2.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
               Introduzca una fecha:<br>
                <label for="dia">Dia</label>
                    <select id="dia"name="dia">
                        <?php
                        for($i=1;$i<=31;$i++){
                            $array_dias=[$i];
                            echo "<option value='.$i.'>".$i."</option>";
                        }
                        ?>
                      </select>
                      <label for="mes">Mes:</label>
                      <select id="mes"name="mes">
                        <?php
                         $array_meses[1]='Enero';
                         $array_meses[2]='Febrero';
                         $array_meses[3]='Marzo';
                         $array_meses[4]='Abril';
                         $array_meses[5]='Mayo';
                         $array_meses[6]='Junio';
                         $array_meses[7]='Julio';
                         $array_meses[8]='Agosto';
                         $array_meses[9]='Septiembre';
                         $array_meses[10]='Octubre';
                         $array_meses[11]='Noviembre';
                         $array_meses[12]='Diciembre';
                        
                        foreach ($array_meses as $k => $i) {
                            echo "<option value='.$k.'>".$i."</option>";
                        }
                            
                        
                        ?>
                      </select>
                      <label for="año">Año:</label>
                      <select id="año"name="año">
                        <?php
                        for($i=date("Y");$i>=(date("Y")-50);$i++){
                            echo "<option value='.$i.'>".$i."</option>";
                        }
                        ?>
                      </select>
                <?php
                if (isset($_POST["calcular"]) && $errorFecha1) {
                if($_POST["fecha1"]=="")
                    echo "<span class='error'>*Campo vacio*</span>";
                else
                echo "<span class='error'>*Fecha no valida*</span>";}
                
 ?>
            </p>
            <p>
                <label for="fecha2">Introduzca una fecha: (DD//MM/YYYY)</label>
                <input type="text" name="fecha2" id="fecha2"
                    value="<?php if(isset($_POST['fecha2'])) echo $_POST['fecha2']?>" />
                <?php
           if (isset($_POST["calcular"]) && $errorFecha2){
            if($_POST["fecha2"]=="")
                echo "<span class='error'>*Campo vacio*</span>";
           else
            echo "<span class='error'>*Fecha no valida*</span>";}
            
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
 $array_fecha1=explode("/",$_POST["fecha1"]);
 $array_fecha2=explode("/",$_POST["fecha2"]);

 //Pasamos la fecha por MM/DD/YY nos lo pasa a segundos
 $tiempo1=mktime(0,0,0,$array_fecha1[1],$array_fecha1[0],$array_fecha1[2]);
 $tiempo2=mktime(0,0,0,$array_fecha2[1],$array_fecha2[0],$array_fecha2[2]);

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