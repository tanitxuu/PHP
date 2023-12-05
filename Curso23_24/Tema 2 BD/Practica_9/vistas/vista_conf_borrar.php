<?php
echo "<p>Se dispone usted a borrar la Pelicula con Id: <strong>".$_POST["btnBorrar"]."</strong></p>";
echo "<form action='index.php' method='post'>";
echo "<input type='hidden' name='nombre_caratula' value='".$_POST["nombre_caratula"]."'>";
echo "<p><button type='submit' name='btnContBorrar' value='".$_POST["btnBorrar"]."'>Continuar</button> ";
echo "<button type='submit'>Atrás</button></p>";
echo "</form>";
?>