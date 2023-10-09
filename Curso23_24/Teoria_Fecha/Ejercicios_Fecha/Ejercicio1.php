<?php
//hacemos los errores 
if(isset($_POST[btenviar])){
  /*  //la fecha tiene que tener 10 carapteres dd/mm/yyyy
    $error_caracteres=;
    //la fecha no se quede vacia
    $error_fechav=;
    //despues de los dos primeros dd el siguiente tiene que se / y despues otros dos mm y / y por ultimo cuatro dijitos yyyy
    $error_orden=;
    //que las fechas sean validas 32/32/22222 eso no existe o 29/02/2023
    $error_fechanovalida=;*/
    //
}


if(isset($_POST["btenviar"]) && !$error_form) { //SI NO HAY UN ERROR EN EL FORMULARIO     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
    <div class="inicio">
        <form>
        <h1> Fechas - Formulario</h1>
        <p>
            <label for="fecha1">Intruduce una Fecha (DD/MM/YYYY)</label>
            <input type="text" id="fecha1" name="fecha1">
            
        </p>
        <p>
        <button type="submit" name="btenviar">Calcular</button>
        </p>
    </div>
    <div class="respuesta">
        <h1> Fechas - Formulario</h1>
        <p>
            <label for="fecha2">Intruduce una Fecha (DD/MM/YYYY)</label>
            <input type="text" id="fecha2" name="fecha2">
        </p>
    </div>
</form>
</body>
</html>

<?php
}else { //SI HAY ERRORES REENVIO PARA QUE LO ARREGLE

require "vistas/vistas_formulario.php";
   

}?>