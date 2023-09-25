<!DOCTYPE html>
<html lang="en">
<body>  
    <h1>Recogiendo datos</h1>
    <p>
        <strong>El nombre enviado a sido:</strong>
        <?php
            echo $_POST["nombre"];
        ?>
    </p>
    <p>
        <strong>Soy:</strong>
        <?php
            echo $_POST["sexo"];
    ?>
    </p>
  
    <p>
    
        <?php
            if(!isset($_POST["aficiones"])){

                echo "<p><b>No has selccionada ninguna aficion</b></p>";

            }elseif(count($_POST["aficiones"])==1){

                echo "<p><b>La aficion seleccionada ha sido:</b></p>";
                echo "<ol>";
                echo "<li>".$_POST["aficiones"][0]."</li>";

                echo "</ol>";
            }else{

                echo "<p><b>Las aficiones seleccionadas han sido:</b></p>";
                echo "<ol>";
                for ($i=0; $i < count($_POST["aficiones"]); $i++) { 
                    
                    echo "<li>".$_POST["aficiones"][$i]."</li>";

                }
                echo "</ol>";
            }

        ?>
    </p>


    <p>
        <strong>He nacido en:</strong>
        <?php
        if(isset ($_POST["nacido"])){
            echo $_POST["nacido"];
        }else{
            echo "<p> No seleccionado </p>";}
        ?>
    </p>
    <p>
        <strong>Comentario:</strong>
        <?php
        if($_POST["comentarios"]!=""){
            echo $_POST["comentarios"];
        }else{
            echo "<p> VACIO </p>";}
    ?>
   </p>
    
</body>
</html>
<?php
