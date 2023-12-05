
<!DOCTYPE html>
<html lang="en">
<body>  
    <h1>Recogiendo datos</h1>
    <?php
    echo "<p><strong>Nombre: </strong>".$_POST["nombre"]."</p>";
    echo "<p><strong>Apellido: </strong>".$_POST["apellido"]."</p>";
    echo "<p><strong>Contraseña: </strong>".$_POST["contraseña"]."</p>";
    
    echo "<p><strong>Dni: </strong>".$_POST["dni"]."</p>";
    echo "<p><strong>Sexo: </strong>".$_POST["sexo"]."</p>";
    if($_FILES["archivo"]["name"]!=""){
    //con el comdando uniqid creamos un nombre unico
    $nombre_nuevo=md5(uniqid(uniqid(),true));
    $array_nombre=explode(".",$_FILES["archivo"]["name"]);
    $ext="";
    if(count($array_nombre)>1){
        $ext=".".end($array_nombre);
       
    }
    $nombre_nuevo.=$ext;
    //la @ es por si da error poder controlarlo
    @$var=move_uploaded_file($_FILES["archivo"]["tmp_name"],"img/".$nombre_nuevo);
    if($var){
        echo "<h3>Foto</h3>";
        echo "<p><strong>Nombre:</strong>".$_FILES["archivo"]["name"]."</p>";
        echo "<p><strong>Tipo:</strong>".$_FILES["archivo"]["type"]."</p>";
        echo "<p><strong>Tamaño:</strong>".$_FILES["archivo"]["size"]."</p>";
        echo "<p><strong>Error:</strong>".$_FILES["archivo"]["error"]."</p>";
        echo "<p>La imagen se ha subido correctamente</p>";
        echo "<p><img class='tam_imag' src='img/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";

    }else{
        echo "<span class='error'>No se a podido mover la imagen a la carpeta de destino en el servidor</span>";
    }}
    if(isset ($_POST["nacido"])){
        echo "<p><strong>Nacionalidad: </strong>".$_POST["nacido"]."</p>";
    }else{
    echo "<p><strong>Nacionalidad: </strong>  No seleccionado </p>";}
    
    echo "<p><strong>Comentario: </strong>".$_POST["comentarios"]."</p>";
    if(isset ($_POST["subscripcion"])){
        echo "<p><strong>Subscripcion: </strong> Si</p>";
    }else{
    echo "<p><strong>Subscripcion: </strong>  No</p>";}  
    else{
        echo "<p><strong>Foto: </strong>  No selecionada</p>";
    }
    ?>
</body>
</html>
<?php
