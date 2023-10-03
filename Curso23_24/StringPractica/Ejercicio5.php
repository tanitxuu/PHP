<?php

    const VALOR = array(1000 => "M", 500 => 'D', 100 => 'C', 50 => 'L', 10 => 'X', 5 => 'V', 1=> 'I' );
 
    function letras_bien($texto1){
        $bien=true;
     for ($i=0; $i < strlen($texto1); $i++) { 
         if(!isset(VALOR[$texto1[$i]])){
             $bien=false;
             break;
         }
     }
     return $bien;
    }
 
 
     function orden_bueno($texto1){
        $bien=true;
        for ($i=0; $i < strlen($texto1)-1; $i++) { 
            if(VALOR[$texto1[$i]]<VALOR[$texto1[$i+1]]){
                $bien=false;
                break;
            }
        }
        return $bien;
     }
     function repite_bien($texto1){
        $veces["I"]=4;
        $veces["V"]=1;
        $veces["X"]=4;
        $veces["L"]=1;
        $veces["C"]=4;
        $veces["D"]=1;
        $veces["M"]=4;
        $bien=true;
        for ($i=0; $i < strlen($texto1); $i++) { 
            $veces[$texto1[$i]]--;
            if($veces[$texto1[$i]]==-1){
                $bien=false;
                break;
            }
        }
        return $bien;
     }
     function es_correcto_romano($texto1){
        return letras_bien($texto1) && orden_bueno($texto1) && repite_bien($texto1);
    }

//Si los campos estan vacios o no contienen la longitud adecuada
if (isset($_POST["comparar"])) {
  
    $texto1 = trim($_POST["primera"]);
    $texto_m=strtoupper($texto1);
    $errorFormu = $texto1==""|| !es_correcto_romano($texto_m);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <style>.error{color:red;}</style>
</head>
<body>
<form action="Ejercicio4.php" method="post" enctype="multipart/form-data">

<div style="background-color:lightblue; border:solid; padding:5px;">

    <h1 style="text-align:center">Romanos a Arabes - Formulario</h1>

    <p>Dime un numero  y te lo devuelvo en numeros romanos </p>
    <p>
        <label for="primera">Numero :</label>
        <input type="text" name="primera" id="primera" value ="<?php if(isset($_POST["primera"])) echo $_POST["primera"]?>">
        <?php
            if (isset($_POST["comparar"]) && $errorFormu) {
                if ($texto1==""){
                    echo "<span class='error'>*Campo Vacio*</span>";
                }else{
                    echo "<span class='error'>*No has escrito un numero romano*</span>";
                }
                
            }
        ?>
    </p>
    <p>
        <button type="submit" name="comparar">Comprobar</button>
    </p>

</div>


<?php

    if (isset($_POST["comparar"]) && !$errorFormu) {
        $res=0;
        for ($i=0; $i <strlen($texto_m); $i++) { 
            $res+=VALOR[$texto_m[$i]];
        }
        echo'<div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">';
       
        echo'<h1 style="text-align:center">Romanos a Arabes - Resultado</h1>';
       
        echo '<p> El numero romano '.$texto_m.' en arabe es '.$res.' </p>';
        
       
        echo'</div>';
      
    
    
    
    }    
    

?>

</form>
</body>
</html>