<?php
session_name('Practica3');
session_start();
define("SERVIDOR_BD", "localhost");
define("USUARIO_BD", "jose");
define("CLAVE_BD", "josefa");
define("NOMBRE_BD", "bd_rec_cv");

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
if (isset($_POST['btnsalir'])) {
    session_destroy();
    header('Location:index.php');
    exit;
}
try {
    $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
} catch (PDOException $e) {
    echo "<p>No se puedo conectar a la bbdd : " . $e->getMessage() . "</p></body></html>";
}
if (isset($_SESSION['usuario'],$_SESSION['si'])) {
    try {
        $consulta = "select * from usuarios where usuario=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$_SESSION['usuario']]);
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        echo "<p>No se puedo conectar a la bbdd : " . $e->getMessage() . "</p></body></html>";
    }
    if ($sentencia->rowCount() > 0) {
        $sino=true;
        $tupla = $sentencia->fetch(PDO::FETCH_ASSOC);
        if ($tupla['tipo'] === 'admin') {
            require "vistas/vista_usuarioAdmin.php";
        } else {
            require "vistas/vista_usuarioNormal.php";

        }
    } else {
        echo "<p>no he obtenido una tupla </p>";
    }
} else {
    require "vistas/vista_login.php";
}
