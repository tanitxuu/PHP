<?php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Usuarios</title>
    <style>  table,th,td{
            border:1px solid black;
            padding: 4px;
        }
        th{
            background-color: lightgray;
        }
        table{
            border-collapse: collapse;
            width: 30%;
            text-align: center;
           
        }
        table img{
            height: 50px;
            width: 50px;
        }
        .enlace{
            border: none;
            background: none;
        }
        </style>
</head>
<body>
<h1>Listado de los usuarios</h1>
    <?php
     try{
        //con esto decimos a donde nos conectamos,el nombre de ususario,la contraseña y el nombre de la bd
        $conexion=mysqli_connect("localhost","jose","josefa","bd_foro");
        //para cuando haya una ñ o algun caracter expecial lo controle
        mysqli_set_charset($conexion,"utf8");
    }catch(Exception $e){

        //no sale el mensage del error
        die("<p>No a podido conectarse a la base de datos: ".$e->getMessage()."</p></boby></html>");
    }

  
    try{
        //decimos la consulta que queremos realizar
        $consulta="select * from usuarios";
        //sentencia para realizar la consulta,metemos la ireccion de la base y la consulta y metemos dentro de una variable
        $resultado= mysqli_query($conexion,$consulta);

    }catch(Exception $e){

        mysqli_close($conexion);
        //controlamos cualquier error que pueda pasar
        die("<p>Inposible realizar la consulta: ".$e->getMessage()."</p></boby></html>");
    }
    //metemos el resultado de la consulta en una variable
    $tupla=mysqli_fetch_assoc($resultado);
    
echo "<form action='nuevousu.php' method='post'></form>";

    //nos manda al principio para que nos lea el usuario 0 sino nos lo salta
    mysqli_data_seek($resultado,0);

//con esto digo que si el resultado de la consulta tiene mas de una columna me haga la tabla   


    echo "<table>";
    //creamos los titulos de la tabla
        echo "<tr><th>Nombre de Usuario</th><th>Borrar</th><th>Editar</th></tr>";
        //con un while leemos los datos de la consulta fila por fila
        while($tupla=mysqli_fetch_assoc($resultado)){
            echo "<tr>";
            echo "<td><form action='index.php' method='post'><button tittle='Detalles del usuario' class='enlace' type='submit' value='".$tupla["id_usuario"]."' name='btnDe'>".$tupla["nombre"]."</button></form></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' name='btnBo' value='".$tupla["id_usuario"]."'><img src='img/borrar.png' alt='borrar' title='Borrar Usuario'></buttton></form></td>";
            echo "<td><form action='index.php' method='post'><button class='enlace' type ='submit' name='btnEd' value='".$tupla["id_usuario"]."'><img src='img/editar.png' alt='editar' title='Editar Usuario'></buttton></form></td>";
            echo "</tr>";
        }
       
    echo "</table>";
    if(isset($_POST["btnDe"])){

        echo "<h3> Detalles del usuario con id: ".$_POST["btnDe"]."</h3>";

        try {

            $consulta="select * from usuarios where id_usuario='".$_POST["btnDe"]."'";
            $resultado=mysqli_query($conexion,$consulta);
            
        } catch (Exception $e) {
    
            mysqli_close($conexion);
            die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
            
        }

        //ES BASICAMENTE $tupla con otro nombre
        if(mysqli_num_rows($resultado)>0){
        $datos_usuario=mysqli_fetch_assoc($resultado);

        echo "<p>";
        echo "<strong>Nombre: </strong>".$datos_usuario["nombre"]."</br>";
        echo "<strong>Usuario: </strong>".$datos_usuario["usuario"]."</br>";
        echo "<strong>Email: </strong>".$datos_usuario["email"]."</br>";
        echo "</p>";
        echo "<form action='index.php' method='post'>";
        echo "<p><button type='submit'>Volver</button></p>";
        echo "</form>";
        }else{
        echo "<p>El usuario regristrado ya no se encuentra en la BD</p>";}
    }elseif(isset($_POST["btnBo"])){



    }elseif(isset($_POST["btnEd"])){

        



    }else{
    echo "<form action='usuario_nuevo.php' method='post'>";
    echo "<p><button type='submit' name='btnNuevoUsuario'>Insertar nuevo usuario</button></p>";
    echo "</form>";

}



    

    //despues de trabajar con datos los liberamos
    mysqli_free_result($resultado);
    //cerramos la BD
    mysqli_close($conexion);
    ?>
    
</body>
</html>