<?php
session_start();
//si no esta iniciada la conexion la abro
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
}
//creamos la consulta de la bbdd para rellenar la tabla
try{
    $consulta="select * from peliculas";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

//empezamos a crear la tabla metemos cada dato del resultado en una tupla de array asociativa
echo "<h2>Video Club</h2>";
echo "<h3>Peliculas</h3>";
echo "<h4>Listado de peliculas</h4>";
echo "<table>";
echo "<tr><th>Id</th><th>Titulo</th><th>Caratula</th><th><form action='index.php' method='post'><button class='enlace' type='submit' name='btnNuevaPelicula'>Peliculas+</button></form></th></tr>";

//con un while recorremos todas las tuplas de la array para rellenar los datos
while($tupla=mysqli_fetch_assoc($resultado))
{
    echo "<tr>";
    echo "<td>".$tupla["idPelicula"]."</td>";
    echo "<td><form action='index.php' method='post'><button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnDetalle' title='Detalles del Usuario'>".$tupla["titulo"]."</button></form></td>";
    echo "<td><img src='img/".$tupla["caratula"]."' alt='Foto de Perfil' title='Foto de Perfil'></td>";
    echo "<td><form action='index.php' method='post'><input type='hidden' name='nombre_caratula' value='".$tupla["caratula"]."'><button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnBorrar'>Borrar</button> - <button class='enlace' type='submit' value='".$tupla["idPelicula"]."' name='btnEditar'>Editar</button></form></td>";
    echo "</tr>";
}
echo "</table>";
mysqli_free_result($resultado);
mysqli_close($conexion);

?>