
<!DOCTYPE html>
<html lang="en">
<body>  
    <h1>Recogiendo datos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
    echo "<p><strong>Apellido: </strong>".$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>".$_POST["contraseña"]."</p>";
    
    
        echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
    

    if(isset ($_POST["nacido"])){
        echo "<p><strong>Nacionalidad: </strong>".$_POST["nacido"]."</p>";
    }else{
    echo "<p><strong>Nacionalidad: </strong>  No seleccionado </p>";}
    
    echo "<p><strong>Comentario: </strong>".$_POST["comentarios"]."</p>";
    if(isset ($_POST["subscripcion"])){
        echo "<p><strong>Subscripcion: </strong> Si</p>";
    }else{
    echo "<p><strong>Subscripcion: </strong>  No</p>";}  
    ?>
</body>
</html>
<?php
