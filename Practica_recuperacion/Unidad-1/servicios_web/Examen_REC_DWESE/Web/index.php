<?php
session_name("API_ExamRec_23_24");
session_start();

//aqui cojemos las funciones
require "src/func_cons.php";

//el boton salir
if(isset($_POST["btnsalir"])){
    $datos_env["api_session"]=$_SESSION["api_session"];
   consumir_servicios_REST(SERV_WEB."/salir","POST",$datos_env);

   //para salir hay que hacer esto
   session_destroy();
   header("Location:index.php");
   exit;
}

//si se a logeado pasamos por aqui
if(isset($_SESSION["usuario"])){

    //aqui hacemos seguridad 
  require "src/seguridad.php";
    //vista principal
    require "vistas/vista_examen.php";
    

}else{
    require "vistas/vista_home.php";
}
?>
