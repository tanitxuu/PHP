<?php


if (isset($_POST["btnlogin"])) {
    $error_usuario = $_POST["usuario"]=='';
    $error_clave = $_POST["clave"]=='';
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        $datos["usuario"] = $_POST["usuario"];
        $datos["clave"] = md5($_POST["clave"]);
        $respu=consumir_servicios_REST(DIR_SERV."/login","POST",$datos);
        $json=json_decode($respu,true);
        if(!$json){
            session_destroy();
            die(error_page("Examen colegio","<h1>Error en login</h1><p>Error en la consulta de la api</p>"));
        }
        if(isset($json["error"]))
        {
       
            session_destroy();
            consumir_servicios_REST(DIR_SERV."/salir","POST",$datos_env);
            die(error_page("Práctica Rec 3","<h1>Práctica Rec 3</h1><p>".$json["error"]."</p>"));
        }
        if(isset($json["mensaje"]))
      {
        $error_usuario=true;
      }
        if(isset($json['usuario'])){
            $_SESSION['usuario']=$json['usuario']['usuario'];
            $_SESSION['clave']=$json['usuario']['clave'];
            $_SESSION['api_session']=$json['api_session'];
            $_SESSION["ult_accion"]=time();
           
            header("Location:index.php");
            exit();
           
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen4 DWESE Curso 23-24</title>
    <style>
        .error {
            color: red
        }

        .mensaje {
            color: blue;
            font-size: 1.25em;
        }
    </style>
</head>

<body>
    <h1>Notas de los alumnos</h1>
    <h3>Login</h3>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" value="<?php if (isset($_POST['usuario']))
                echo $_POST['usuario']; ?>" />
            <?php
            if (isset($_POST['btnlogin']) && $error_usuario) {
                if ($_POST['usuario'] == '') {
                    echo "<span class='error'>*Campo vacio*</span>";
                } else {
                    echo "<span class='error'>*Usurio/Clave incorrecta*</span>";
                }
            }
            ?>
        </p>
        <p>
            <label for="clave">Clave:</label>
            <input type="password" name="clave" />
            <?php
            if (isset($_POST['btnlogin']) && $error_clave) {

                echo "<span class='error'>*Campo vacio*</span>";

            }
            ?>
        </p>
        <p>
            <button name="btnlogin">Login</button>
        </p>
    </form>
    <?php
            if (isset($_SESSION['seguridad'])) {

                echo "<p class='mensaje'>".$_SESSION['seguridad']."</p>";
                session_destroy();

            }
    ?>



</body>

</html>