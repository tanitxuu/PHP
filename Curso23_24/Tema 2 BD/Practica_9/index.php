<?php
require "src/funciones.php";
//errores para borrar
if(isset($_POST["btnContBorrar"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }

    try{
        $consulta="delete from peliculas where idPelicula='".$_POST["btnContBorrar"]."'";
        mysqli_query($conexion, $consulta);

    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No ha podido realizarse la consulta: ".$e->getMessage()."</p>"));
    }

    if($_POST["nombre_caratula"]!="no_imagen.jpg")
        unlink("img/".$_POST["nombre_caratula"]);

    mysqli_close($conexion);
    header("Location:index.php");
    exit();
}
//para borrar la foto
if(isset($_POST["btnContBorrarFoto"]))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
    }
    try{
        $consulta="update peliculas set caratula='no_imagen.jpg' where idPelicula='".$_POST["idPelicula"]."'";
        mysqli_query($conexion,$consulta);
    }
    catch(Exception $e)
    {
        mysqli_close($conexion);
        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
    }
    if(file_exists("img/".$_POST["caratula_videoclub"]))
        unlink("img/".$_POST["caratula_videoclub"]);
    $_POST["caratula_bd"]="no_imagen.jpeg";

    //No voy a saltar hasta que veamos sesiones....
}

//errores para nueva Pelicula
if(isset($_POST["btnContNuevo"]))
{
    $error_titulo=$_POST["titulo"]=="" || strlen($_POST["titulo"])>15;
    $error_director=$_POST["director"]=="" || strlen($_POST["director"])>20;
    if(!$error_titulo)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die(error_page("Práctica 9","<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }

        $error_titulo=repetido($conexion,"peliculas","titulo",$_POST["titulo"]);
        
        if(is_string($error_titulo))
        {
            mysqli_close($conexion);
            die(error_page("Práctica 9","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$error_titulo."</p>"));
        }
    }
    $error_sinopsis=$_POST["sinopsis"]=="";
    $error_genero=$_POST["genero"]=="" || strlen($_POST["genero"])>15;
    
    $error_caratula=$_FILES["caratula"]["name"]!="" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || !tiene_extension($_FILES["caratula"]["name"]) || $_FILES["caratula"]["size"]>500 *1024);

    $error_form=$error_titulo||$error_director|| $error_sinopsis || $error_genero || $error_caratula;

    //Si no hay errores
    if(!$error_form)
    {
        //Inserto base de datos
        try{
            $consulta="insert into peliculas (titulo, director, sinopsis, tematica) values ('".$_POST["titulo"]."','".$_POST["director"]."','".$_POST["sinopsis"]."','".$_POST["genero"]."')";
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
        }

        if($_FILES["caratula"]["name"]!="")
        {
            $last_id=mysqli_insert_id($conexion);
            $array_nombre=explode(".",$_FILES["caratula"]["name"]);
            $nombre_caratula="img_".$last_id.".".end($array_nombre);

            @$var=move_uploaded_file($_FILES["caratula"]["tmp_name"],"img/".$nombre_caratula);
            if($var)
            {
                try{
                    $consulta="update usuarios set caratula='".$nombre_caratula."' where id_usuario='".$last_id."'";
                    mysqli_query($conexion,$consulta);
                }
                catch(Exception $e)
                {
                    unlink("img/".$nombre_caratula);//Al no poder actualizar borro la nueva que acabo de mover
                    mysqli_close($conexion);
                    die(error_page("Práctica 8","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
                }
            }    

        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    }
}
//errores editar
if(isset($_POST["btnContEditar"]))
{

    $error_titulo=$_POST["titulo"]=="" || strlen($_POST["titulo"])>15;
    $error_director=$_POST["director"]=="" || strlen($_POST["director"])>20;
    if(!$error_titulo)
    {
        try{
            $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
            mysqli_set_charset($conexion,"utf8");
        }
        catch(Exception $e)
        {
            die(error_page("Práctica 9","<h1>Práctica 8</h1><p>No he podido conectarse a la base de batos: ".$e->getMessage()."</p>"));
        }

        $error_titulo=repetido($conexion,"peliculas","titulo",$_POST["titulo"]);
        
        if(is_string($error_titulo))
        {
            mysqli_close($conexion);
            die(error_page("Práctica 9","<h1>Práctica 8</h1><p>No se ha podido realizar la consulta: ".$error_titulo."</p>"));
        }
    }
    $error_sinopsis=$_POST["sinopsis"]=="";
    $error_genero=$_POST["genero"]=="" || strlen($_POST["genero"])>15;
    
    $error_caratula=$_FILES["caratula"]["name"]!="" && ($_FILES["caratula"]["error"] || !getimagesize($_FILES["caratula"]["tmp_name"]) || !tiene_extension($_FILES["caratula"]["name"]) || $_FILES["caratula"]["size"]>500 *1024);

    $error_form=$error_titulo||$error_director|| $error_sinopsis || $error_genero || $error_caratula;

    if(!$error_form)
    {
        //TODO el código para actualizar
        try{
            
            $consulta="update peliculas set titulo='".$_POST["titulo"]."', director='".$_POST["director"]."', sinopsis='".$_POST["sinopsis"]."', tematica='".$_POST["genero"]."' where idPelicula='".$_POST["idPelicula"]."'";
            
            mysqli_query($conexion,$consulta);
        }
        catch(Exception $e)
        {
            mysqli_close($conexion);
            die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta:".$e->getMessage()."</p>"));
        }

        if($_FILES["caratula"]["name"]!="")
        {
            
            $array_nombre=explode(".",$_FILES["caratula"]["name"]);
            $nombre_caratula="img_".$_POST["idPelicula"].".".end($array_nombre);

            @$var=move_uploaded_file($_FILES["caratula"]["tmp_name"],"img/".$nombre_caratula);
            if($var)
            {
                if($_POST["caratula_bd"]!=$nombre_caratula)
                {
                    //Actualizo en BD
                    try{
                        $consulta="update peliculas set caratula='".$nombre_caratula."' where idPeliculas='".$_POST["idPeliculas"]."'";
                        mysqli_query($conexion,$consulta);
                    }
                    catch(Exception $e)
                    {
                        //Al no poder actualizar borro la nueva que acabo de mover
                        unlink("img/".$nombre_caratula);
                        mysqli_close($conexion);
                        die(error_page("Práctica 9","<h1>Práctica 9</h1><p>No se ha podido realizar la consulta: ".$e->getMessage()."</p>"));
                    }
                    //Borro la antigua que había con otra extensión
                    unlink("img/".$_POST["caratula_bd"]);
                }
            }    

        }

        mysqli_close($conexion);
        header("Location:index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 8</title>
    <style>
        table,td,th{border:1px solid black;}
        table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
        th{background-color:#CCC}
        table img{width:50px;}
        .enlace{border:none;background:none;cursor:pointer;color:blue;text-decoration:underline}
        .error{color:red}
        .foto_detalle{height:250px}
       
    </style>
</head>
<body>
    <h1>Práctica 9</h1>
    <?php

    require "vistas/vista_tabla.php";

    if(isset($_POST["btnEditar"]) || isset($_POST["btnContEditar"]) || isset($_POST["btnBorrarFoto"]) || isset($_POST["btnNoBorrarFoto"]) || isset($_POST["btnContBorrarFoto"])  )
    {
        
        require "vistas/vista_editar.php";
    }

    if(isset($_POST["btnDetalle"]))
    {
        require "vistas/vista_detalle.php"; 
    }

    if(isset($_POST["btnBorrar"]))
    {
        require "vistas/vista_conf_borrar.php";
    }

    if(isset($_POST["btnNuevaPelicula"]) || isset($_POST["btnContNuevo"]))
    {
        require "vistas/vista_nueva_pelicula.php";
    }

    
    ?>
    
</body>
</html>