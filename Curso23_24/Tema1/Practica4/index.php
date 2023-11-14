<?php
function en_array($valor,$arr){
    $estar=false;
    for ($i=0; $i <count($arr); $i++) { 
        if($arr[$i]== $valor){
            $estar=true;
            break;
        }
    }
    return $estar;
}
  if(isset($_POST["btenviar"])) { //COMPRUEBO ERRORES
    $error_nombre = $_POST["nombre"]==""; //mete en la variable error nombre , (si esta vacio mete true , y si esta relleno mete false)
    $error_sexo = !isset($_POST["sexo"]);  //Esto te dice si en el sexo se ha marcado alguno (!isset) eso significa SI NO SE HA MARCADO

    $error_form= $error_nombre || $error_sexo;

}
//compruebo vista segun errores
if(isset($_POST["btenviar"]) && !$error_form) { 
    require "vista/vistaRecogida.php";
}else{

    require "vista/vistaFromulario.php";
}



