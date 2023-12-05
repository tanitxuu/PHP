<?php
 session_name("ejer_02_23_24");
 session_start();

if(isset($_POST["btnsig"]) || isset($_POST["btnborrar"])){
        if(isset($_POST["btnborrar"])){
            session_destroy();
            header("Location:session02_1.php");
            exit;
        }else{
            if($_POST["nombre"]==""){
                $_SESSION["error"]="no has tecleado nada";
                unset($_SESSION["nombre"]);
            }else{
                $_SESSION["nombre"]=$_POST["nombre"];
            }
        }
}
header("Location:session02_1.php");
exit;
?>