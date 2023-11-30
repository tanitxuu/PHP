<?php
session_start();
function error_page($titulo, $body)
{
    $page = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . $titulo . '</title>
    </head>
    <body>' . $body . '</body>
    </html>';
    return $page;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examen2 PHP</title>
</head>

<body>
    <h1>Examen2 PHP</h1>
    <h2>Horario de los Profesores</h2>
    <?php
    if (!isset($conexion))
        try {
            $conexion = mysqli_connect("localhost", "jose", "josefa", "bd_horario_exam");
            mysqli_set_charset($conexion, "utf8");
        } catch (Exception $e) {
            mysqli_close($conexion);
            die("<p>No se a podido conectar a la BD: " . $e->getMessage() . "</p></body></html>");
        }
    try {
        $consulta = "select * from usuarios";
        $resultado = mysqli_query($conexion, $consulta);
    } catch (Exception $e) {
        mysqli_close($conexion);
        session_destroy();
        die("<p>no se a podido conectar a la BD: " . $e->getMessage() . "</p></body></html>");
    }
    if (mysqli_num_rows($resultado) > 0) 
    ?>
        <form action="index.php" method="post" ></form>
        <label for="profesro">Horario del profesor</label>
        <select name="profesor" id="profesor">
            <?php
            while ($tupla = mysqli_fetch_assoc($resultado))
                echo "<option value='" . $tupla["id_usuario"] . "'>" . $tupla["nombre"] . "</option>";
            $nombre_prof = $tupla["nombre"];
            
       echo "</select>";
       echo "<button type='submit' name='botonhora' id='botonhora' >Ver Horario</button>";
        ?>    
    
    <?php
    /*if(isset($_POST["botonhora"])){*/
    ?>
    <h2></h2>
    <?php
        echo "<h4>Horario del profesor ".$nombre_prof."</h4>";
            try {
                $consulta2 = "select * from grupos,horario_lectivo,usuarios where grupos.id_grupo=horario_lectivo.grupo AND usuarios.id_usuario=horario_lectivo.usuario AND usuario='".$tupla["id_usuario"]."'";
                
                $resultado2 = mysqli_query($conexion, $consulta2);
            } catch (Exception $e) {
                mysqli_close($conexion);
                session_destroy();
                die("<p>no se a podido conectar a la BD: " . $e->getMessage() . "</p></body></html>");
            }
        if (mysqli_num_rows($resultado2) > 0) {
        echo "<h4>Horario del profesor ".$nombre_prof."</h4>";
        echo "<table >";
        while ($tupla2 = mysqli_fetch_assoc($resultado2))
      
            echo "<tr><th>horarios</th><th>".$tupla2["dia"]."</th><th>".$tupla2["dia"]."</th><th>".$tupla2["dia"]."</th><th>".$tupla2["dia"]."</th><th>".$tupla2["dia"]."</th></tr>";
            echo "<tr><th><form action='index.php' mehod='post'><button class='enlace' type='submit' name='btneditar'>".$tupla2["hora"]."</button></form></th><th><form action='index.php' mehod='post'><button class='enlace' type='submit' name='btneditar'>".$tupla2["hora"]."</button></form></th><th><form action='index.php' mehod='post'><button class='enlace' type='submit' name='btneditar'>".$tupla2["hora"]."</button></form></th><th><form action='index.php' mehod='post'><button class='enlace' type='submit' name='btneditar'>".$tupla2["hora"]."</button></form></th><th><form action='index.php' mehod='post'><button class='enlace' type='submit' name='btneditar'>".$tupla2["hora"]."</button></form></th></tr>";
        echo "</table>";
        }
  
    
    
    ?>
   
    </form>
</body>

</html>