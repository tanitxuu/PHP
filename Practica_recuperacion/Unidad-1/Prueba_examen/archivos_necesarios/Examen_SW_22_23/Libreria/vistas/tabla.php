<?php
$respuesta=consumir_servicios_REST(DIR_SERV."/obtenerLibros","GET");
$json=json_decode($respuesta,true);
$libros=$json['libros'];
?>
<h2>Listado de libros</h2>
<div id="columna">
    
<?php
foreach ($libros as  $value) {
    echo "<div>";
    echo "<img src='images/".$value['portada']."' alt='portada'>";
    echo "<p>".$value['titulo']." - ".$value['precio']."€</p>";
    echo "</div>";
}
?>
</div>