<?php
if(isset($_POST["boton1"])){
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Recogiendo datos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
    if(isset ($_POST["nacido1"])){
        echo "<p><strong>Nacionalidad: </strong>".$_POST["nacido1"]."</p>";
    }else{
    echo "<p><strong>Nacionalidad: </strong>  No seleccionado </p>";}
   
    if(isset ($_POST["sexo"])){
        echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
    }else{
    echo "<p><strong>Sexo: </strong>  No seleccionado </p>";}

    if(isset ($_POST["aficiones1"])){
        echo "<p><strong>Aficiones: </strong>".$_POST["aficiones1"]."</p>";
    }else{
    echo "<p><strong>Aficiones: </strong>  No seleccionado </p>";}
    
    echo "<p><strong>Comentario: </strong>".$_POST["textarea"]."</p>";
   
    ?>
</body>
</html>
<?php
}else
    header("Location:index.php");

?>