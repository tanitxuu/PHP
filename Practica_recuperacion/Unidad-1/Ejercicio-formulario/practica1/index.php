<?php
if(isset($_POST['borrar'])){
    header('Location:index.php');
    exit;
}
function LetraNI($dni)
{
    return substr("TRWAGMYFPDXBNJZSQVHLCKEO", $dni % 23, 1);
}
function dni_bien_escrito($texto)
{
    $bien_escrito = strlen($texto) == 9  && is_numeric(substr($texto, 0, 8)) && substr($texto, -1) >= "A" && substr($texto, -1) <= "Z";
    return $bien_escrito;
}
function dni_valido($texto)
{
    $numero = substr($texto, 0, 8);
    $letra = substr($texto, -1);
    $valido = LetraNI($numero) == $letra;
    return $valido;
}
     if(isset($_POST['enviar'])){
        $error_usu=$_POST['usu']=='';
        $error_nombre=$_POST['nombre']=='';
        $error_clave=$_POST['clave']=='';
        $error_dni = $_POST["dni"] == "" || !dni_bien_escrito(strtoupper($_POST["dni"])) || !dni_valido(strtoupper($_POST["dni"]));
        //no es obligatorio
        $error_img= $_FILES["img"]["name"]!='' && ($_FILES["img"]["error"] || !explode('.',$_FILES['img']['name']) || !getimagesize($_FILES["img"]["tmp_name"]) || $_FILES["img"]["size"]>500*1024);
        $error_sub=isset($_POST['sub']); 

        $error_form=$error_clave || $error_dni || $error_nombre || $error_usu || !$error_sub ||  $error_img;
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