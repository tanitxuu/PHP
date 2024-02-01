<?php
define("SERVIDOR_BD","localhost");
define("USUARIO_BD","jose");
define("CLAVE_BD","josefa");
define("NOMBRE_BD","bd_reactlogin");
header('Access-Control-Allow-Origin: *'); 
if(!isset($conexion))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
    }
}try{
   $consulta="select * from usuarios";
   $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
   mysqli_close($conexion);
   die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

$_POST = json_decode(file_get_contents("php://input"),true);
while($tupla=mysqli_fetch_assoc($resultado)){
 if ($_POST["telefono"]==$tupla["telefono"] && $_POST["password"]==$tupla["clave"]){
    $respuesta["usuario"]=$tupla["usuario"];
    $respuesta["mensaje"]="Acceso correcto";
 }else{
    $respuesta["mensaje"]="Acceso incorrecto";
 }}
 echo json_encode($respuesta);
?>