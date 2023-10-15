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



//Comrpueba si la fecha existe o no con true o false con caracteres que estan en X y cogiendo Y son numericos
function fecha_valida($d,$m,$y){
    return checkdate($d,$m,$y);
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
                            echo "<option value='.0.$i.'>'.$i.'</option>";
                        }
                        ?>
                      </select>
                      <label for="mes">Mes:</label>
                      <select id="mes"name="mes">
                        <?php
                         $array_meses[01]='Enero';
                         $array_meses[02]='Febrero';
                         $array_meses[03]='Marzo';
                         $array_meses[04]='Abril';
                         $array_meses[05]='Mayo';
                         $array_meses[06]='Junio';
                         $array_meses[07]='Julio';
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
                <label for="fecha2">Introduzca una fecha: </label>
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
                           $array_meses[01]='Enero';
                           $array_meses[02]='Febrero';
                           $array_meses[03]='Marzo';
                           $array_meses[04]='Abril';
                           $array_meses[05]='Mayo';
                           $array_meses[06]='Junio';
                           $array_meses[07]='Julio';
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
 $tiempo1=mktime(0,0,0,$_POST["mes"],$_POST["dia"],$_POST["año"]);
 $tiempo2=mktime(0,0,0,$_POST["mes"],$_POST["dia"],$_POST["año"]);

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