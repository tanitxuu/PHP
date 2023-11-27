<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        td,
        th {
            border: 1px solid black;
            margin: 5px;
            padding: 5px;
        }

        table {
            border-collapse: collapse;
            text-align: center
        }

        th {
            background-color: #CCC
        }

        table img {
            width: 50px;
        }

        .enlace {
            border: none;
            background: none;
            cursor: pointer;
            color: blue;
            text-decoration: underline
        }

        .error {
            color: red
        }
    </style>
</head>
<body>
    <h1>Notas de alumnos</h1>
    <?php
    try{
        $conexion=mysqli_connect("localhost","jose","josefa","bd_exam_colegio");
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p>");
    }
    try{
        //decimos la consulta que queremos realizar
        $consulta="select * from alumnos";
        //sentencia para realizar la consulta,metemos la ireccion de la base y la consulta y metemos dentro de una variable
        $resultado= mysqli_query($conexion,$consulta);

    }catch(Exception $e){

        mysqli_close($conexion);
        //controlamos cualquier error que pueda pasar
        die("<p>Inposible realizar la consulta: ".$e->getMessage()."</p>");
    }
    $tupla=mysqli_fetch_assoc($resultado);
    if($tupla["cod_alu"]==""){
        echo "<p>En estos momentos no tenemos ningun alumno registrado en la BD</p>";
    }else{
        echo "<form action='index.php' method='post'>";
        echo "<p>";
        echo "<label for='nombre'>Seleccione un alumno </label>";
        echo "<select name='alumno' id='alumno'>";
        mysqli_data_seek($resultado,0);
        while($tupla=mysqli_fetch_assoc($resultado)){
            if(isset($_POST["alumno"]) && $_POST["alumno"]== $tupla["cod_alu"]){
        echo "<option selected value='".$tupla["cod_alu"]."'>".$tupla["nombre"]."</option>";
            $nombre_alu=$tupla["nombre"];
            }else{
            echo "<option value='".$tupla["cod_alu"]."'>".$tupla["nombre"]."</option>";
        }}
        echo "</select>";
        echo " <button type='submit' name='btnotas'> Ver notas</button>";
        echo "</p>";
        echo "</form>";
        //se pulsa el boton ver notas
        if(isset($_POST["btnotas"])){
            try {
                $consulta = "select asignaturas.denominacion,notas.nota, asignaturas.cod_asig from asignaturas,notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$_POST["alumno"]."'";
                $consulta_vacio = "select * 
                FROM asignaturas 
                WHERE cod_asig NOT IN (
                    SELECT asignaturas.cod_asig 
                    FROM asignaturas 
                    INNER JOIN notas 
                    ON asignaturas.cod_asig = notas.cod_asig 
                    WHERE notas.cod_alu = '".$_POST["alumno"]."'
                )";
                $resultado = mysqli_query($conexion, $consulta);
                $resul_vacio=mysqli_query($conexion, $consulta_vacio);
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
            }
            echo "<h2>Notas del alumno ".$nombre_alu."</h2>";
            echo "<table>";
            echo "<tr><th>Asignatura</th><th>Notas</th><th>Accion</th></tr>";
            $tupla1=mysqli_fetch_assoc($resultado);
            mysqli_data_seek($resultado,0);
            while($tupla1=mysqli_fetch_assoc($resultado)){
                echo "<tr>";
                echo "<td>".$tupla1["denominacion"]."</td>";
                echo "<td>".$tupla1["nota"]."</td>";
                echo "<td><form action='index.php' method='post'><input type='hidden' name='alumno' value='".$_POST["alumno"]."'>
               <button class='enlace' type='submit' value='" . $tupla1["cod_asig"] . "' name='btnBorrar'>Borrar</button>
               <button class='enlace' type='submit' value='" . $tupla1["cod_asig"] . "' name='btnEditar'>Editar</button>
               </form></td>";
                echo "";
                echo "</tr>";
            }
            echo "</table>";
            echo "<form action='index.php' method='post'>";
            $tupla2=mysqli_fetch_assoc($resul_vacio);
            mysqli_data_seek($resul_vacio,0);
            while($tupla2=mysqli_fetch_assoc($resul_vacio)){
            echo "<p>Asignaturas que a ".$nombre_alu." aun le quedan por calificar <select name='alumno' id='alumno'>";
            if(isset($_POST["alumno"]) && $_POST["alumno"]== $tupla["cod_alu"]){
                echo "<option selected value='".$tupla2["cod_asig"]."'>".$tupla2["denominacion"]."</option>";
                    $nombre_alu=$tupla["nombre"];
                    }else{
                    echo "<option value='".$tupla2["cod_asig"]."'>".$tupla2["denominacion"]."</option>";
                }
                echo "</select>";
                echo " <button type='submit' value='".$_POST["alumno"]."' name='btcalificar'>Calificar</button>";
            }}
            echo "</form>";
        if(isset($_POST["btnBorrar"])){
            try {
                $consulta = "select asignaturas.denominacion,notas.nota, asignaturas.cod_asig from asignaturas,notas where asignaturas.cod_asig=notas.cod_asig and notas.cod_alu='".$_POST["alumno"]."'";
                $resultado = mysqli_query($conexion, $consulta);
               
            } catch (Exception $e) {
                mysqli_close($conexion);
                die("<p>No se ha podido realizar la consulta: " . $e->getMessage() . "</p></body></html>");
            }
        }
        mysqli_free_result($resultado);
        mysqli_close($conexion);

    }



?>
</body>
</html>