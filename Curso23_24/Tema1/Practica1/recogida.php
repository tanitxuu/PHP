<?php
if(isset($_POST["boton1"])){
?>
<!DOCTYPE html>
<html lang="en">
<body>  
    <h1>Recogiendo datos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
    echo "<p><strong>Apellido: </strong>".$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>".$_POST["contraseña"]."</p>";
    echo "<p><strong>Dni: </strong>".$_POST["dni"]."</p>";
    if(isset ($_POST["sexo"])){
        echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
    }else{
    echo "<p><strong>Sexo: </strong>  No seleccionado </p>";}

    if(isset ($_POST["nacido1"])){
        echo "<p><strong>Nacionalidad: </strong>".$_POST["nacido1"]."</p>";
    }else{
    echo "<p><strong>Nacionalidad: </strong>  No seleccionado </p>";}
    
    echo "<p><strong>Comentario: </strong>".$_POST["textarea"]."</p>";
    if(isset ($_POST["subscripcion"])){
        echo "<p><strong>Subscripcion: </strong> Si</p>";
    }else{
    echo "<p><strong>Subscripcion: </strong>  No</p>";}  
    ?>
</body>
</html>
<?php
}else
    header("Location:index.php");

?>
