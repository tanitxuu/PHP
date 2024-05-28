<?php
//aqui vamos a controlar los errores
if(isset($_POST["btnlogin"])){
    $error_usu=$_POST["usuario"]=="";
    $error_clave=$_POST["clave"]=="";
    $error_form=$error_clave ||$error_usu;
    if(!$error_form){
        //recogemos los datos del post en una array para enviarla a login
        $datos["usuario"]=$_POST["usuario"];
        $datos["clave"]=md5($_POST["clave"]);
       $resp= consumir_servicios_REST(SERV_WEB."/login","POST",$datos);
       $json=json_decode($resp,true);
       if(!$json)
       {
           session_destroy();
           die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>Sin respuesta oportuna de la API</p>"));  
       }
       if(isset($json["error"]))
       {
      
           session_destroy();
           consumir_servicios_REST(SERV_WEB."/salir","POST",$datos_env);
           die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error"]."</p>"));
       }
      
      if(isset($json["mensaje"]))
      {
          session_unset();
          consumir_servicios_REST(SERV_WEB."/salir","POST",$datos_env);
          $_SESSION["seguridad"]="Usted ya no se encuentra registrado en la BD";
          header("Location:index.php");
          exit();
      }
      if(isset($json["usuario"]))
      {
          $_SESSION["usuario"]=$json["usuario"]["usuario"];
          $_SESSION["clave"]=$json["usuario"]["clave"];
          $_SESSION["ultm_accion"]=time();
          $_SESSION["api_session"]=$json["api_session"];

          header("Location:index.php");
          exit();
      }
      else
          $error_usu=true;

    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" value="<?php if(isset($_POST["usuario"])) echo $_POST["usuario"] ?>"/>
            <?php
            if(isset($error_usu)){
                echo "<span class='error'>*usuario/clave incorrecta*</span>";
            }
            ?>
        </p>
        <p>
            <label for="clave">Clave:</label>
            <input type="password" name="clave"/>
            <?php
            if(isset($error_clave)){
                echo "<span class='error'>*Campo vacio*</span>";
            }
            ?>
        </p>
        <p><button name="btnlogin">Entrar</button></p>
    </form>
    <?php
    //y hacemos session_destroy
    if(isset($_SESSION['seguridad'])){
        echo "<p>".$_SESSION['seguridad']."</p>";
        session_destroy();
    }
    ?>
</body>
</html>
