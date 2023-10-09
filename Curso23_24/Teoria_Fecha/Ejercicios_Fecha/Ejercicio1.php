<?php
//hacemos los errores 
if(isset($_POST["btenviar"])){
    //la fecha tiene que tener 10 carapteres dd/mm/yyyy
    $error_caracteres=$_POST["fecha1"]!=strlen(10) ||  $_POST["fecha2"]=strlen(10);
    //la fecha no se quede vacia
    $error_fechav=$_POST["fecha1"]="" || $_POST["fecha2"]="";
    //despues de los dos primeros dd el siguiente tiene que se / y despues otros dos mm y / y por ultimo cuatro dijitos yyyy
    $error_orden=;
    //que las fechas sean validas 32/32/22222 eso no existe o 29/02/2023
    $error_fechanovalida!=checkdate($_POST["fecha1"]) || checkdate($_POST["fecha2"]);
    
}


if(isset($_POST["btenviar"]) && !$error_form) { //SI NO HAY UN ERROR EN EL FORMULARIO     
?>


<?php
}else { //SI HAY ERRORES REENVIO PARA QUE LO ARREGLE
    ?>
       <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <style> .inicio{background-color:lightblue; border:solid; padding:5px;}.titulo{text-align:center;}</style>
    </head>
    <body>
        <form method="post">
        <div class="inicio">
            <form>
            <h1 class="titulo">Fechas - Formulario</h1>
            <p>
                <label for="fecha1">Intruduce una Fecha (DD/MM/YYYY)</label>
                <input type="text" id="fecha1" name="fecha1">
                
            </p>
            <p>
                <label for="fecha2">Intruduce una Fecha (DD/MM/YYYY)</label>
                <input type="text" id="fecha2" name="fecha2">
            </p>
            <p>
            <button type="submit" name="btenviar">Calcular</button>
            </p>
        </div>
       
        <?php

            if (isset($_POST["btenviar"]) && !$errorFormu) {
                
                echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';

                    echo'<h1 style="text-align:center">Ripios - Resultado</h1>';

                    if(){

                        echo '<p>''</p>';

                    }elseif(){
                        
                        echo '<p>''</p>';

                    }else {

                        echo '<p>'.$_POST['primera'].' y '.$_POST['segunda'].' no riman</p>';
                    }

                echo'</div>';
                
                
            }

        ?>
    </form>
    </body>
    </html>
<?php
}?>