
<?php
if(isset($_POST["btborrar"])){
    unset($_POST);
}
   function LetraNI($dni){
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO",$dni % 23,1);
   }
   function dni_bien_escrito($texto){
     $bien_escrito=strlen($texto)==9  && is_numeric(substr($texto,0,8)) && substr($texto,-1)>="A" && substr($texto,-1)<="Z" ;
     return $bien_escrito;
   }
   function dni_valido($texto){
    $numero=substr($texto,0,8);
    $letra= substr($texto,-1);
    $valido=LetraNI($numero)==$letra;
    return $valido;
   }
    if(isset($_POST["btenviar"])) { //COMPRUEBO ERRORES
        $error_archivo=$_FILES["archivo"]["name"]!="" && $_FILES["archivo"]["error"] || !getimagesize($_FILES["archivo"]["tmp_name"])|| $_FILES["archivo"]["size"]>500*1024;
        $error_nombre = $_POST["nombre"]==""; //mete en la variable error nombre , (si esta vacio mete true , y si esta relleno mete false)
        $error_apellido = $_POST["apellido"]=="";
        $error_contraseña = $_POST["contraseña"]=="";
        $error_dni=$_POST["dni"]=="" || !dni_bien_escrito(strtoupper($_POST["dni"]))|| !dni_valido(strtoupper($_POST["dni"]));
        $error_sexo = !isset($_POST["sexo"]);  //Esto te dice si en el sexo se ha marcado alguno (!isset) eso significa SI NO SE HA MARCADO
        $error_comentarios = $_POST["comentarios"]=="";

        $error_form= $error_nombre || $error_apellido || $error_contraseña || $error_sexo ||  $error_comentarios ||$error_archivo;

    }

    if(isset($_POST["btenviar"]) && !$error_form) { //SI NO HAY UN ERROR EN EL FORMULARIO     

        require "vistas/vistas_respuestas.php";


    }else { //SI HAY ERRORES REENVIO PARA QUE LO ARREGLE
  
        require "vistas/vistas_formulario.php";
           
        
    }


?>



