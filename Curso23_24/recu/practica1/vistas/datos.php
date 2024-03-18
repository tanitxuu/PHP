<?php
echo '<h2>Datos</h2>';
echo '<p>Usuario:'.$_POST['usu'].'</p>';
echo '<p>DNI:'.$_POST['dni'].'</p>';
echo '<p>........</p>';
if($_FILES['img']['name']!=''){
    $nombre_nuevo=md5(uniqid(uniqid(),true));
    $array_nombre=explode(".",$_FILES["img"]["name"]);
    $ext="";
    if(count($array_nombre)>1){
        $ext=".".end($array_nombre);
       
    }
    $nombre_nuevo.=$ext;
    @$var=move_uploaded_file($_FILES["img"]["tmp_name"],"img/".$nombre_nuevo);
    if($var){
        echo "<h3>Foto</h3>";
        echo "<p><strong>Nombre:</strong>".$_FILES["img"]["name"]."</p>";
        echo "<p><strong>Tipo:</strong>".$_FILES["img"]["type"]."</p>";
        echo "<p><strong>Tamaño:</strong>".$_FILES["img"]["size"]."</p>";
        echo "<p><strong>Error:</strong>".$_FILES["img"]["error"]."</p>";
        echo "<p>La imagen se ha subido correctamente</p>";
        echo "<p><img class='tam_imag' src='img/".$nombre_nuevo."' alt='Foto' title='Foto' /></p>";

    }else{
        echo "<span class='error'>No se a podido mover la imagen a la carpeta de destino en el servidor</span>";
    }
}
?>