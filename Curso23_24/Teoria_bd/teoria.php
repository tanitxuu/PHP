<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teoria Base de Datos</title>
    <style>
        table,th,td{
            border:1px solid black;
            padding: 4px;
        }
        th{
            background-color: lightslategray;
        }
        table{
            border-collapse: collapse;
            width: 80%;
            text-align: center;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <?php
//Controlamos los errores posibles
    try{
        //con esto decimos a donde nos conectamos,el nombre de ususario,la contraseña y el nombre de la bd
        $conexion=mysqli_connect("localhost","jose","josefa","bd_teoria");
        //para cuando haya una ñ o algun caracter expecial lo controle
        mysqli_set_charset($conexion,"utf8");
    }catch(Exception $e){

        //no sale el mensage del error
        die("<p>No a podido conectarse a la base de datos: ".$e->getMessage()."</p>");
    }

  
    try{
        //decimos la consulta que queremos realizar
        $consulta="select * from t_alumnos";
        //sentencia para realizar la consulta,metemos la ireccion de la base y la consulta y metemos dentro de una variable
        $resultado= mysqli_query($conexion,$consulta);

    }catch(Exception $e){

        mysqli_close($conexion);
        //controlamos cualquier error que pueda pasar
        die("<p>Inposible realizar la consulta: ".$e->getMessage()."</p>");
    }

    //para saber el numero de tupla que hay en la tabla de las bd
    $num_tuplas=mysqli_num_rows($resultado);
    echo "<p>El numero de tuplas obtenidas ha sido: ".$num_tuplas."</p>";

    //nos hace un array asociativo para acceder a la informacion de dentro (1) cada vez que se usa un tupla abja al dato de abajo
    $tupla=mysqli_fetch_assoc($resultado);
    echo "<p>El primer alumno optenido tiene el nombre de: ".$tupla["nombre"]."</p>";
    print_r($tupla);

    //nos la lee de otra manera el cod sera 0 y el nombre el 1 no es asociativo solo se puede acceder por numero (2)
    $tupla=mysqli_fetch_row($resultado);
    echo "<p>El segundo alumno optenido tiene el nombre de: ".$tupla[1]."</p>";
   
    //en este usan las dos de arriba tiene array normal y por asociativo (3)
    $tupla=mysqli_fetch_array($resultado);
    echo "<p>El tercer alumno optenido tiene el nombre de: ".$tupla[1]."</p>";
    echo "<p>El tercer alumno optenido tiene el nombre de: ".$tupla["nombre"]."</p>";
    
    //otra manera para leer el contenido (4)
    $tupla=mysqli_fetch_object($resultado);
    echo "<p>El primer alumno optenido tiene el nombre de: ".$tupla->nombre."</p>";

    //nos manda al principio
    mysqli_data_seek($resultado,0);

    //Creamos una tabla para motrar los datos de las tablas de BD
   echo "<table>";

   echo "<tr><th>Codigo</th><th>Nombre</th><th>Telefono</th><th>CP</th></tr>";
    while($tupla=mysqli_fetch_assoc($resultado)){
        echo "<tr>";
        echo "<td>".$tupla["cod_alu"]."</td>";
        echo "<td>".$tupla["nombre"]."</td>";
        echo "<td>".$tupla["telefono"]."</td>";
        echo "<td>".$tupla["cp"]."</td>";
        echo "</tr>";
    }

    echo "</table>";
    //despues de trabajar con datos los liberamos
    mysqli_free_result($resultado);
  

  //para cerrar la bd
  mysqli_close($conexion);
    ?>
</body>
</html>