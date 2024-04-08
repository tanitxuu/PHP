<?php
  try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}
try {
    $dato[0] = $_SESSION['usuario'];
    $dato[1] = $_SESSION['clave'];
    $consulta = "select * from usuarios where usuario=? and clave=?";
    $sentencia = $conexion->prepare($consulta);
    $sentencia->execute($dato);
} catch (PDOException $e) {
    $conexion = null;
    $sentencia = null;
    session_destroy();
    die(error_page("Primer Login", "<h1>Primer Login</h1><p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p>"));
}
if ($sentencia->rowCount() <= 0) {
    $conexion = null;
    $sentencia = null;
    session_unset();
    $_SESSION['seguridad'] = "Usted ya no se encuentra en la bbdd";
    header('Location:index.php');
    exit();
}
$datos_usu_log = $sentencia->fetch(PDO::FETCH_ASSOC);
$sentencia = null;

if (time() - $_SESSION['ultima_ac'] > MINUTOS * 60) {
    $conexion = null;
    session_unset();
    $_SESSION['seguridad'] = "Su tiempo de seguridad a expirado.Por favor vuelva a logearse";
    header('Location:index.php');
    exit();
}
$_SESSION['ultima_ac']=time(); 
?>