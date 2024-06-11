<?php
if(isset($_POST['login'])){
$error_usuario=$_POST['usuario']=='';
$error_clave=$_POST['clave']=='';
$error_form= $error_usuario || $error_clave;

if(!$error_form){
    $datos['usuario']=$_POST['usuario'];
    $datos['clave']=md5($_POST['clave']);

    $respuesta=consumir_servicios_REST(DIR_SERV."/login","POST",$datos);
    $json=json_decode($respuesta,true);

    if(!$json){
        session_destroy();
        die(error_page("Error Examne","<h1>Error Examen</h1><p>Error al consumir servicio api</p>"));
    }
    if(isset($json['error'])){
        session_destroy();
        consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
        die(error_page("Error Examne","<h1>Error Examen</h1><p>".$json['error']."</p>"));

    }
    if(isset($json['mensaje'])){
        $error_usuario=true;
    }else{

    

    $_SESSION['usuario']=$json['usuario']['lector'];
    $_SESSION['clave']=$json['usuario']['clave'];
    $_SESSION['api_session']=$json['api_session'];
    $_SESSION['ult_accion']=time();
    
    header("Location:index.php");
    exit;}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen Libreria</title>
    <style>
        img{
            width: 30%;
            height: auto;
        }
        #columna{
            display: flex;
            flex-wrap: wrap;
      
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Libreria</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" value="<?php if(isset($_POST['usuario'])) echo $_POST['usuario']; ?>">
            <?php
            if(isset($_POST['login']) && $error_usuario){
                if($_POST['usuario']==''){
                    echo "<span class='error'>*Campo vacio*</span>";
                }else{
                    echo "<span class='error'>*Usuario/Contraseña incorrecta*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Clave:</label>
            <input type="password" name="clave">
            <?php
            if(isset($_POST['login']) && $error_clave){
               
                    echo "<span class='error'>*Campo vacio*</span>";
                
            }
            ?>
        </p>
        <p>
            <button name="login">Login</button>
        </p>
    </form>
    <?php
            if(isset($_SESSION['seguridad'])){
               
                    echo "<p class='mensaje'>".$_SESSION['seguridad']."</p>";
                    session_destroy();
            }
            require "vistas/tabla.php";
            ?>

    
</body>
</html>