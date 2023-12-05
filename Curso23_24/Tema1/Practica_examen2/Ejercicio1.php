<?php

    function primera_linea()
    {
        //me deja el i/j en la posicion 0 y me pone numeros al lado
        $res="i/j";
        //le ponemos que tiene 5 posiciones (0-4) y que empieza en la 1
        for($j=1;$j<=5;$j++)
            $res.=";".$j;
        return $res;
    }

    function generar_fichero_clavesPolybios()
    {
        //abrimos el fichero y le damos permisos de ecritura
        @$fd=fopen("claves_polybios.txt","w");
        //si el archivo no existe se muere
        if(!$fd)
            die("NO se ha podido crear el fichero 'claves_polybios.txt'");
        //declaramos que el valor de la linea es la fila de la funcion de arriba
        $linea=primera_linea();
        //metemos en el fichero la linea de arriba y le metemos un salto de linea con PHP_EOL
        fputs($fd,$linea.PHP_EOL);
        //decimos la la k Devuelve el número de la tabla ASCII correspondiente a la letra “A”.
        $k=ord("A");
        
        for($i=1;$i<=5;$i++)
        {
            $linea=$i;
            for($j=1;$j<=5;$j++)
            {
                if($i==2 && $j==5)
                    $k++;
                $linea.=";".chr($k);
                $k++;
            }
            
            fputs($fd,$linea.PHP_EOL);
        }
        fclose($fd);
        return file_get_contents("claves_polybios.txt");
    }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Ejercicio 1 PHP</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1>Ejercicio 1. Generador de "claves_polybios.txt"</h1>
        <form method="post" action="ejercicio1_b.php">
            <input type="submit" name="btnEnviar" value="Generar"/>
        </form>
        <?php
        if(isset($_POST["btnEnviar"]))
        {
            echo "<h1>Respuesta</h1>";
            echo "<textarea>".generar_fichero_clavesPolybios()."</textarea>";
            echo "<p>Fichero generado con éxito</p>";
        }
        ?>
    </body>
</html>>