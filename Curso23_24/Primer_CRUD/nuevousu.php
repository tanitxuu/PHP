<?php

function error_page($title,$body){
    $page= '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>'.$title.'</title>
    </head>
    <body>'.$body.' </body>
    </html>';
    return $page;
}
//una funcion para saber si esta repetido.
function repetir($conexion,$tabla,$columna,$valor){
    try{
        //decimos la consulta que queremos realizar
        $consulta="select * from ".$tabla." where ".$columna."='".$valor."';";
        //sentencia para realizar la consulta,metemos la ireccion de la base y la consulta y metemos dentro de una variable
        $resultado= mysqli_query($conexion,$consulta);
        $respuesta=mysqli_num_rows($resultado)>0;
        mysqli_free_result($resultado);

    }catch(Exception $e){
        mysqli_close($conexion);
        //controlamos cualquier error que pueda pasar
        $respuesta= error_page("Practica Primer Grud","<h1>Practica Primer Grud</h1><p>No a podido hacer la consulta: ".$e->getMessage()."</p></boby></html>");
    }
    return $respuesta;
}

//con esto hacemos que vuelva a la pagina index
if(isset($_POST["btnNuevoUsu"]) || isset($_POST["btnContinuar"])){
    if(isset($_POST["btnContinuar"])){
        $error_nombre=$_POST["nombre"]=="" || strlen($_POST["nombre"])>30;
        $error_usuario=$_POST["usuario"]=="" || strlen($_POST["usuario"])>20;
        if(!$error_usuario){
            try{
                //con esto decimos a donde nos conectamos,el nombre de ususario,la contraseña y el nombre de la bd
                $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
                //para cuando haya una ñ o algun caracter expecial lo controle
                mysqli_set_charset($conexion,"utf8");
            }catch(Exception $e){
                //nos muetra otra pagina con el error pero sin otro html
                die(error_page("Practica Primer Grud","<h1>Practica Primer Grud</h1><p>No a podido conectarse a la base de datos: ".$e->getMessage()."</p></boby></html>"));
            }
           $error_usuario= repetir($conexion,"usuarios","usuario",$_POST["usuario"]);
            if(is_string($error_usuario))
                die($error_usuario);
        }
        $error_contraseña=$_POST["contraseña"]=="" || strlen($_POST["contraseña"])>15;
        $error_email=$_POST["email"]=="" || !filter_var($_POST["email"],FILTER_VALIDATE_EMAIL) || strlen($_POST["email"])>50 ;
        if(!$error_email){
            if(!isset($conexion)){
                try{
                    //con esto decimos a donde nos conectamos,el nombre de ususario,la contraseña y el nombre de la bd
                    $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
                    //para cuando haya una ñ o algun caracter expecial lo controle
                    mysqli_set_charset($conexion,"utf8");
                }catch(Exception $e){
                    //nos muetra otra pagina con el error pero sin otro html
                    die(error_page("Practica Primer Grud","<h1>Practica Primer Grud</h1><p>No a podido conectarse a la base de datos: ".$e->getMessage()."</p></boby></html>"));
                }
            }
            $error_email= repetir($conexion,"usuarios","email",$_POST["email"]);
            if(is_string($error_email))
                die($error_email);
        }
        $error_form=$error_contraseña||$error_email||$error_usuario||$error_nombre;
    
        if(!$error_form){
            try{
                $consulta="insert into usuarios (nombre,usuario,clave,email) values ('".$_POST["nombre"]."','".$_POST["usuario"]."','".md5($_POST["contraseña"])."','".$_POST["email"]."')";
                mysqli_query($conexion,$consulta);
            
             }catch(Exception $e){
                mysqli_close($conexion);
            //controlamos cualquier error que pueda pasar
                die(error_page("Practica Primer Grud","<h1>Practica Primer Grud</h1><p>No a podido Insertar los datos: ".$e->getMessage()."</p></boby></html>"));
            }
            mysqli_close($conexion);
            header("Location:index.php");
            exit;
        }
        //por aqui continuo solo si hay errores en los formulario
        if(isset(($conexion)))
            mysqli_close($conexion);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear nuevo usuario</title>
    <style>.error{color: red;}</style>
</head>
<body>
    <h1>Nuevo Usuario</h1>
    <form action="nuevousu.php" method="post" enctype="multipart/form-data">
    <p>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"  maxlength="20" value="<?php if(isset($_POST["nombre"]))echo $_POST["nombre"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_nombre){
            if($_POST["nombre"]=="")
                echo "<span class='error'>*Campo Vacio*</span>";
            else
                echo "<span class='error'>*A superado la longitud*</span>";
        }
        ?>
    </p>
    <p>
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" id="usuario" maxlength="20" value="<?php if(isset($_POST["usuario"]))echo $_POST["usuario"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_usuario){
            if($_POST["usuario"]=="")
                echo "<span class='error'>*Campo Vacio*</span>";
            elseif(strlen($_POST["usuario"])>20)
                echo "<span class='error'>*A superado la longitud*</span>";
            else
                echo "<span class='error'>*Usuario repetido*</span>";
        }
        ?>
    </p>
    <p>
        <label for="contraseña">Contraseña:</label>
        <input type="password" name="contraseña" id="contraseña" maxlength="50">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_contraseña){
            if($_POST["usuario"]=="")
                echo "<span class='error'>*Campo Vacio*</span>";
            else
                echo "<span class='error'>*A superado la longitud*</span>";
        }
        ?>
    </p>
    <p>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" maxlength="50" value="<?php if(isset($_POST["email"]))echo $_POST["email"] ?>">
        <?php
        if(isset($_POST["btnContinuar"]) && $error_email){
            if($_POST["email"]=="")
                echo "<span class='error'>*Campo Vacio*</span>";
            elseif(strlen($_POST["email"])>50)
                echo "<span class='error'>*A superado la longitud*</span>";
            elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL))
                echo "<span class='error'>*Email no valido*</span>"; 
            else
                echo "<span class='error'>*Email repetido*</span>"; 
        }
        
        ?>
    </p>
    <p>
        <button type="submit" name="btnContinuar">Continuar</button>
        <button type="submit" name="volver">Volver</button>
    </p>
    </form>
    <?php
    if(isset($_POST["btnContinuar"])&& !$error_form){
        


    }
    ?>
</body>
</html>
<?php
}else{
    header("Location:index.php");
    exit;
}
?>