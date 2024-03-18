<?php
     if(isset($_POST['enviar'])){
        $error_usu=$_POST['usu']=='';
        $error_nombre=$_POST['nombre']=='';
        $error_clave=$_POST['clave']=='';
        $error_dni = $_POST['dni'] == '' || !strlen($_POST['dni']) == 9 || !is_numeric(substr($_POST['dni'], 0, 8)) || !ctype_alpha(substr($_POST['dni'], -1));
        $error_img=$_FILES["img"]["error"] || !getimagesize($_FILES["img"]["tmp_name"]) || $_FILES["img"]["size"]>500*1024;

        $error_form=$error_clave || $error_dni || $error_nombre || $error_usu || !$_POST['sub'] ||  $error_img;
     }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica recuperacion 1</title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <?php
    if(isset($_POST['enviar']) && !$error_form){
        require "vistas/datos.php";
    }else{
        require "vistas/form.php";
    }
    ?>
    
 
</body>
</html>