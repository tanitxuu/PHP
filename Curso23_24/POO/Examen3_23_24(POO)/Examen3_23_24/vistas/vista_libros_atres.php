<?php
echo "<h3>Listado de los libros</h3>";
        

try{

    $consulta="select * from libros";
    $sentencia=$conexion->prepare($consulta);
    $sentencia->execute();
}
catch(PDOException $e)
{
    $sentencia=null;
    $conexion=null;
    session_destroy();
    die("<p>No he podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}
$resultado=$sentencia->fetchAll(PDO::FETCH_ASSOC);
foreach($resultado as $tupla)
{
    echo "<p class='libros'>";
    echo "<img src='img/".$tupla["portada"]."' alt='imagen libro' title='imagen libro'><br>";
    echo $tupla["titulo"]." - ".$tupla["precio"]."€";
    echo "</p>";
}

$sentencia=null;
     
?>