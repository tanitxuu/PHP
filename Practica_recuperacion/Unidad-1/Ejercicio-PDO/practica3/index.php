<?php
session_name('Practica3');
session_start();

if(isset($_SESSION['usuario'])){

    require "vistas/vista_usuario.php";
}else{
   require "vistas/vista_login.php";
}
?>
