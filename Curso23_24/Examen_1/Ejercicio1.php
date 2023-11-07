<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="Ejercicio1.php" method="post">
    <p>
        <button type="submit" name="bt">Generar</button>
    </p>
    </form>
    <?php
    if(isset($_POST["bt"])){
        echo "<h2>Respuesta</h2>";
        @$fd=fopen("claves_cesar.txt","w,r");
        $primera_linea="letra/desplazamiento";
        if(!$fd){
            die("<p>No tines permisos para abrirlo</p>");
        }        
    for($i=1; $i <=ord("Z")-ord("A")+1; $i++) { 
        $primera_linea=";".$i;
    }
   $texte=$primera_linea."\n";
    fwrite($fd,$primera_linea.PHP_EOL);

    for($i=ord("A"); $i <=ord("Z"); $i++) { 
        $linea=chr($i);
        for($j=1; $j <=ord("Z")-ord("A")+1; $j++) { 
            if($i+$j<=ord("Z"))
                $linea=";".chr($i+$j);
            else

                $linea=";".chr(ord("A")+($i+$j)-ord("Z")-1);
        }
        fwrite($fd,$linea.PHP_EOL);
    }
    fclose($fd);
           echo "<textarea name='resp' id='rep'>".$texte."</textarea>";
    }

    ?>
</body>
</html>