<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Teoria Fecha</h1>
    <?php
    //saca el tiempo en seg
    echo "<p>".time()."</p>";

    //dd/mm/yy con la Y mayus te pone el año entero
    echo "<p>".date('d/m/Y')."</p>";

    //con h:i:s ponemos la hora los minutos y segundos
    echo "<p>".date('h:i:s')."</p>";

    //te dice si la fecha existe o no
    if(checkdate(32,2,2023)){
       echo  "<p>Fecha buena</p>";
    }else{
       echo  "<p>Fecha Mala</p>";
    }

    //mktime(hora,minutos,seg,mes,dia,año)
    echo "<p>".date('d/m/Y',mktime(9,30,0,3,13,2000))."</p>";

    //strtotime (d/m/y) y te da lo mismo que el de arriba
    echo "<p>".date('d/m/Y',strtotime('03/13/2000'))."</p>";
   
    //FUNCIONES MATEMATICAS

    //redondear hacia bajo   tambien podemos usar print al igual que echo
    echo "<p>".floor(5.5)."</p>";

    //redondear hacia arriba
    echo "<p>".ceil(5.5)."</p>";

    //nos da el valor absoluto
    echo "<p>".abs(-8)."</p>";

    //printf nos saca el float con 2 decimales y te lo muestra por pantalla
    printf("<p>%.2f</p>",5.666666*7.88888);

    //podemos meter printf en una variable para que no salga por pantalla
    $resul=printf("<p>%.2f</p>",5.666666*7.88888);
    echo $resul;

    for ($i=0; $i <=5; $i++) { 
        if($i<10)
        echo "<p>0".$i."</p>";
        else
        echo "<p>".$i."</p>";
    }
    //pone 3 digitos y los que no llegen les pone un0 delante
    for ($j=0; $j <=20; $j++) { 
        echo "<p>".printf('%03d',$j)."</p>";
      
    }
    ?>
</body>
</html>