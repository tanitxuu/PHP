<?php
if (isset($_POST['btnentrar'])) {
    $error_usuario = $_POST['usuario'] == '';
    $error_clave = $_POST['clave'] == '';
    $error_form = $error_usuario || $error_clave;

    if (!$error_form) {
        try {
            $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            session_destroy();
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        try {
            $dato[0]=$_POST['usuario'];
            $dato[1]=md5($_POST['clave']);
            $consulta = "select * from usuarios where usuario=? and clave=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute($dato);
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;
            session_destroy();
            die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
        }
        if ($sentencia->rowCount() > 0) {
            $_SESSION['usuario'] = $dato[0];
            $_SESSION['ultima_ac'] = time();
            $_SESSION['clave'] = $dato[1];
            $conexion = null;
            $sentencia = null;
            header('Location:index.php');
            exit();
        } else {
        
            $error_usuario=true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h2>Practica 3 Login</h2>
    <form action="index.php" method="post">
        <p>
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" value="<?php if (isset($_POST['usuario'])) echo $_POST['usuario']; ?>">
            <?php
            if (isset($_POST['btnentrar']) && $error_usuario) {
                if($_POST['usuario']==''){
                    echo "<span class='error'>*Campo vacio*</span>";
                }else{
                    echo "<span class='error'>*Usuario o contraseña incorrecta*</span>"; 
                }
              
            }
            ?>
        </p>
        <p>
            <label for="clave">Contraseña</label>
            <input type="password" name="clave" id="clave">
            <?php
            if (isset($_POST['btnentrar']) && $error_clave) {
                if($_POST['clave']==''){
                    echo "<span class='error'>*Campo vacio*</span>";}
               
            }
            ?>
        </p>
        <p>
            <button name="btnentrar">Entrar</button>
            <button name="btnregis">Registrarse</button>
        </p>
    </form>
    <?php
    if(isset($_SESSION['seguridad'])){
        echo "<p class='mensaje'>".$_SESSION['seguridad']."</p>";
        session_destroy();
    }
    ?>
</body>

</html>