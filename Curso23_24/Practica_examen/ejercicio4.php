<?php

  if(isset($_POST["btEnviar"])){                                                       //ESTO SE HACE PARA VER SI UN ARCHIVO ES IMAGEN O NO      //ESTO PARA DECIR QUE LA IMAGEN SEA MYOR DE 500KB

    $error_archivo=$_FILES["archivo"]["name"]=="" && $_FILES["archivo"]["error"] || $_FILES["archivo"]["type"]!="text/plain"|| $_FILES["archivo"]["size"] > 1000*1024; 

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejercicio 4 Examen anterior</title>
    <style>.error{color:red}
        .text_centrado{text-align:center}
        table,th,td{border:1px solid black}
        table{border-collapse:collapse;width:90%;margin:0 auto;text-align:center}
        th{background-color:#CCC}</style>
</head>
<body>
    <h1>Ejercicio 4</h1>
    <?php
    if(isset($_POST["btEnviar"]) && !$error_archivo) {


        @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"Horario/horarios.txt"); //PARA MOVER LA IMAGEN SUBIDA A OTRO SITIO
        if(!$var){ //LO DEL @$var y esto es porque si no pega un error raro

            echo "<p>No se ha podido mover el archivo a la carpeta destino en el servidor</p>";

    } 
        
}
    @$fd=fopen("Horario/horarios.txt","r");
if ($fd) {
        $options="";
        while ($linea = fgets($fd)) {
            $datos_linea = explode("\t", $linea);
            if (isset($_POST["bthorario"]) && $_POST["profesor"] == $datos_linea[0]) {
                $options .= "<option selected value='" . $datos_linea[0] . "'>" . $datos_linea[0] . "</option>";
                $nombre_prof = $datos_linea[0];
                for($i=1;$i<count($datos_linea);$i+=3){
                   if(isset($horario_profe[$datos_linea[$i]][$datos_linea[$i+1]])) {
                    $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]]= "/" $datos_linea[$i+2];
                   }else{
                    $horario_profe[$datos_linea[$i]][$datos_linea[$i+1]]=$datos_linea[$i+2];
                   }
                }
            } else {
                $options .= "<option value='" . $datos_linea[0] . "'>" . $datos_linea[0] . "</option>";
            }
        }
        fclose($fd);

    ?>
        <h1>Ahora hago la otra parte</h1>
        <form action="ejercicio4.php" method="post">
            <p>
                <label for="profesor">Horario del Profesor</label>
                <select name="profesor" id="profesor">
                    <?php
                    
                        echo $options;
                
                    ?>
                    <option value=""></option>
                </select>
                <button name="bthorario" type="submit"> Ver horario</button>
            </p>
        </form>
<?php
    if(isset($_POST["bthorario"])){
    echo "<h3 class='text-centrado'>Horario Profesor: ".$nombre_prof[0]."</h3>";
    $horas[1]="8:15-915";
    $horas[]="9:15-10:15";
    $horas[]="10:15-11:15";
    $horas[]="11:15-11:45";
    $horas[]="11:45-12:45";
    $horas[]="12:45-13:45";
    $horas[]="13:45-14:45";
    echo "<table>";
    echo "<tr><th></th><th>Lunes</th><th>Martes</th><th>Miercoles</th><th>Jueves</th><th>Viernes</th></tr>";
        for ($h=1; $h <=7 ; $h++) { 
            echo "<tr>";
            echo "<th>".$horas[$h]."</th>";
            if($h==4){
                echo "<td colspan='5'>RECREO</td>";
            }else{
                for ($d=1; $d <= 5 ; $d++) { 
                    if(isset($horario_profe[$d][$h])){
                        echo "<td>".$horario_profe[$d][$h]."</td>";
                    }
                    echo "<td></td>";
                }
            }
            echo "</tr>";


        }
        echo "</table>";
    }


}else{
?>
<h2>Nose encuentra el archivo<em>Horario/horarios.txt</em></h2>
<form method="post" action="ejercicio4.php" enctype="multipart/form-data">
        <p>
            <label>Sube el fichero: max(1MB)</label>
            <input type="file" name="archivo" id="archivo" accept="text/plain">
        </p>

        <p>
        <button type="submit" name="btEnviar">Enviar</button>
        </p>
    </form>
    <?php

        if(isset($_POST["btEnviar"]) && $error_archivo) {

            if($_FILES["archivo"]["name"]!=""){ //Si he seleccionado algo

                if($_FILES["archivo"]["error"]){ //Si da error

                    echo "<span class='error'>No se ha podido subir el archivo</<span>";

                }elseif($_FILES["archivo"]["type"]!="text/plain"){ //SI no selecciona una texto

                    echo "<span class='error'>No has seleccionado un archivo de tipo texto</<span>";

                }else{ //SI supera el peso

                    echo "<span class='error'>El archivo seleccionado supera los 500KB</<span>";
                }
            }
    }
}
    ?>
</body>
</html>