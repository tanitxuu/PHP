<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body> 
    <h1>Teoria elemental de PHP DIA: <?php echo date("d-m-y")?></h1>
    <?php 
     define("PI",3.1415);
     $a=8;
     $b=9;
     $c=$a+$b;
     echo "<p>El resultado de sumar ".$a." + ".$b." = ".$c."</p>";
     if($c<3)
     {
        echo "<p>3 es mayor que ".$c."</p>";
     }
     elseif(3==$c)
    {
        echo "<p>3 es igual que ".$c."</p>";
    }
     else
     {
        echo "<p>3 es menor que ".$c."</p>";
     }
     $d=2;
     switch($d){
        case 1: $c=$a-$b; break;
        case 2: $c=$a*PI; break;
        case 3: $c=$a/$b; break;
        default: $c=$a+$b; break;
     }
     echo "<p>El resultado del switch es: ".$c."</p>";

     for($i=0;$i<=8;$i++)
     {
        echo "<p>hola ".($i+1)."</p>";
     }
     $i=0;
     while($i<=8)
     {
        echo "<p>hola ".($i+1)."</p>";
        $i++;
     }
    ?>
    <h2>Y ahora empezamos con los furmularios </h2>

</body>
</html>