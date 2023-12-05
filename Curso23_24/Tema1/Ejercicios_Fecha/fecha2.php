<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <?php



//Comrpueba si la fecha existe o no con true o false con caracteres que estan en X y cogiendo Y son numericos

 //Si los campos estan vacios o no contienen la longitud adecuada
 if (isset($_POST["calcular"])) {
 
 $errorFecha1 =  !checkdate($_POST["mes1"],$_POST["dia1"],$_POST["año1"]);

 $errorFecha2 =  !checkdate($_POST["mes2"],$_POST["dia2"],$_POST["año2"]);

 $errorFormu = $errorFecha1 || $errorFecha2;
 }


 
 ?>


    <form action="fecha2.php" method="post" enctype="multipart/form-data">

        <div style="background-color:lightblue; border:solid; padding:5px;">

            <h1 style="text-align:center">Fechas - Formulario</h1>

            <p>
               Introduzca una fecha:<br>
                <label for="dia1">Dia</label>
                    <select id="dia1"name="dia1">
                        <?php
                        for($i=1;$i<=31;$i++){
                            if(isset($_POST["calcular"])&& $_POST["dia1"]==$i){
                                echo "<option selected value=".sprintf("%02d",$i).">".sprintf("%02d",$i)."</option>"; 
                            }
                            echo "<option value=".sprintf("%02d",$i).">".sprintf("%02d",$i)."</option>";
                        }
                        ?>
                      </select>
                      <label for="mes1">Mes:</label>
                      <select id="mes1"name="mes1" >
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
                            if(isset($_POST["calcular"])&& $_POST["mes1"]==$k){
                                echo "<option selected value=".$k.">".$i."</option>"; 
                            }
                            echo "<option value=".$k.">".$i."</option>";
                        }
                         
                            
                        ?>
                      </select>
                      <label for="año1">Año:</label>
                      <select id="año1"name="año1">
                        <?php
                        $este_año=date("Y");
                        for($i=$este_año;$i>=($este_año-50);$i--){
                            if(isset($_POST["calcular"])&& $_POST["año1"]==$i){
                                echo "<option selected value=".$i.">".$i."</option>";
                            }                    
                            echo "<option value=".$i.">".$i."</option>";
                        }
                        ?>
                      </select>
                <?php
                if (isset($_POST["calcular"]) && $errorFecha1) {
                    echo "<span class='error'>*Fecha no valida*</span>";
               }
                
 ?>
            </p>
            <p>
                Introduzca una fecha:<br>
                <label for="dia2">Dia</label>
                    <select id="dia2"name="dia2" >
                        <?php
                        for($i=1;$i<=31;$i++){
                            if(isset($_POST["calcular"])&& $_POST["dia2"]==$i){
                                echo "<option selected value=".sprintf("%02d",$i).">".sprintf("%02d",$i)."</option>"; 
                            }
                            echo "<option value=".sprintf("%02d",$i).">".sprintf("%02d",$i)."</option>";
                        }
                        ?>
                      </select>
                      <label for="mes2">Mes:</label>
                      <select id="mes2"name="mes2" >
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
                            if(isset($_POST["calcular"])&& $_POST["mes2"]==$k){
                                echo "<option selected value=".$k.">".$i."</option>"; 
                            }
                            echo "<option value=".$k.">".$i."</option>";
                        }
                            
                        ?>
                      </select>
                      <label for="año2">Año:</label>
                      <select id="año2"name="año2" >
                        <?php
                        for($i=date("Y");$i>=(date("Y")-50);$i--){
                            if(isset($_POST["calcular"])&& $_POST["año2"]==$i){
                                echo "<option selected value=".$i.">".$i."</option>";
                            }                    
                            echo "<option value=".$i.">".$i."</option>";
                        }
                        ?>
                      </select>
                <?php
           if (isset($_POST["calcular"]) && $errorFecha2){
                echo "<span class='error'>*Fecha no valida*</span>";
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
 $tiempo1=mktime(0,0,0,$_POST["mes1"],$_POST["dia1"],$_POST["año1"]);
 $tiempo2=mktime(0,0,0,$_POST["mes2"],$_POST["dia2"],$_POST["año2"]);

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