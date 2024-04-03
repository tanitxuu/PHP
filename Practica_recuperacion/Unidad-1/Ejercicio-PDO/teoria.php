<?php
session_name('teoriaPDO');
session_start();
//la usaremos para loggearnos cuando hagamos el login
//$_SESSION['usuario']='Un usuario';
//session_destroy();
//borra todas las sessiones creadas
//session_unset();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    define("SERVIDOR_BD", "localhost");
    define("USUARIO_BD", "jose");
    define("CLAVE_BD", "josefa");
    define("NOMBRE_BD", "bd_foro");

    try {
        $conexion = new PDO("mysql:host=" . SERVIDOR_BD . ";dbname=" . NOMBRE_BD, USUARIO_BD, CLAVE_BD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    } catch (PDOException $e) {
        die("<p>No he podido conectarse a la base de batos: " . $e->getMessage() . "</p></body></html>");
    }

    try {
        $usu = 'Laurita2';
        $clave = md5("123456");
        $consulta = "select * from usuarios where usuario=? and clave=?";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute([$usu, $clave]);
    } catch (PDOException $e) {
        //cerrar siempre conexion y destruir sentencias si falla
        $sentencia = null;
        $conexion = null;
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    if ($sentencia->rowCount() > 0) {

        echo "<p>he obtenido una tupla</p>";
        //con esto convertimos las sentencia sql en un array asociativo
        $tupla=$sentencia->fetch(PDO::FETCH_ASSOC);
        echo "<p>Nombre:".$tupla['nombre']."</p>";
        echo "<p>Usuario:".$tupla['usuario']."</p>";

    } else {
        echo "<p>no he obtenido una tupla</p>";
    }
    try {

        $consulta = "select * from usuarios";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        //cerrar siempre conexion y destruir sentencias si falla
        $sentencia = null;
        $conexion = null;
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    //primera forma de recorrer mas de una tupla fetchAll
  /*  $tuplas=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    for ($i=0; $i < count($tuplas); $i++) { 
        $tupla=$tuplas[$i];
        echo "<p>Nombre:".$tupla['nombre']."</p>";
        echo "<p>Usuario:".$tupla['usuario']."</p>";
    }
    //este es mas facil
    foreach ($tuplas as $tupla) {
        echo "<p>Nombre:".$tupla['nombre']."</p>";
        echo "<p>Usuario:".$tupla['usuario']."</p>";
    }*/
    //segunda forma con fetch
    while($tuplas=$sentencia->fetch(PDO::FETCH_ASSOC)){
        echo "<p>Nombre:".$tuplas['nombre']."</p>";
    }
    //insertar un usuario
    try {

        $consulta = "insert into usuarios (nombre,usuario,clave,email) values (?,?,?,?)";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute(['pepa','pepa123',md5('12345'),'pepa@gmail.com']);
    } catch (PDOException $e) {
        //cerrar siempre conexion y destruir sentencias si falla
        $sentencia = null;
        $conexion = null;
        die("<p>No he podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
    }
    echo "<p>Insertado con clave autonumerica a valor:".$conexion->lastInsertId()."</p>";
    $sentencia = null;
    $conexion = null;
    ?>
</body>

</html>