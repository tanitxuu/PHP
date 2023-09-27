<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $familias = array(
        "Los Simpson"=> array("Padre"=>"Homer","Madre"=>"Marge","Hijos"=>array(
            "Hijo1"=>"Bart","Hijo2"=>"Lisa","Hijo3"=>"Magie")),
        "Los Griffin"=>array("Padre"=>"Peter","Madre"=>"Loise","Hijos"=>array(
            "Hijo1"=>"Chris","Hijo2"=>"Meg","Hijo3"=>"Stewie")));
            
        echo "<h1>Ejercicio 17</h1>";
        echo "<ul>";
        foreach ($familias as $f => $nom) {
            echo "<li>";
            echo $f;
            echo "<ul>";
                foreach ($nom as $padres => $n) {
                    echo "<li>";
                    echo $padres.": ";
                    
                    if(is_array($n)){
                        echo "<ul>";
                        foreach($n as $hi => $hn){
                           
                            echo "<li>";
                            echo $hi.": ".$hn;
                           
                            echo "</li>";
                        }
                    }else{
                        echo $n;
                    }
                    echo "</ul>";
                    echo "</li>";
                }
            echo "</ul>";
            echo "</li>";

        }
      
        echo "</ul>";
    ?>
    
</body>
</html>