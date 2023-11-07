<?php
if(isset($_POST["bt"])){
    $error_texto1=$_POST["texto1"]=="";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="Ejercicio2.php" method="post">
        <p>
            <label for="texto1">Introduzca un texto:</label>
            <input type="text" name="texto1" id="texto1">
            <?php
            if(isset($_POST["bt"]) && $error_texto1){
                echo "<span class='error'>*Campo Vacio</span>";
            }
            ?>
        </p>
        <p>
            <label for="separador">Elija un separador</label>
            
          
        
            <select name="separador" id="separador">
                <option value=",">,(Coma)</option>
                <option value=";">;(Punto yComa)</option>
                <option value=".">.(Punto)</option>
                <option value=" "> (Espacio)</option>
                <option value=":">:(Dos Puntos)</option>
            </select>
        </p>
        <p>
            <button type="submit" name="bt">Contar</button>
        </p>
    </form>
    <?php
    if(isset($_POST["bt"]) && !$error_texto1){
       function contar($texto){
        $cont="";
        while ($a <= $texto) {
            $cont++;
        }
       return $cont;
    }
       function comparar($texto,$sep){
        $texto_long=contar($texto);
        for($i=0;$i<$texto_long;$i++){
            if($texto_long[$i]==$sep){
                $k=$texto_long[$i];
            }
            

        }
       }
    }

    ?>
</body>
</html>