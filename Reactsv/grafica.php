<?php
header("Access-Control-Allow-Origin: *");

$nombre = "resultado.txt";
$fd = fopen($nombre, "a+");

if ($fd) {
    // Array para almacenar todos los datos como números enteros
    $datos_totales = array();

    // Leer todo el contenido del archivo
    while (!feof($fd)) {
        // Leer una línea
        $linea = fgets($fd);
        
        // Eliminar espacios en blanco al inicio y al final de la línea
        $linea = trim($linea);
        
        // Si la línea no está vacía, procesarla
        if (!empty($linea)) {
            // Dividir la línea en un array
            $datos = explode("||", $linea);
            
            // Convertir los elementos a números enteros
            $datos = array_map('intval', $datos);
            
            // Eliminar el primer elemento si está vacío
            if ($datos[0] === "") {
                array_shift($datos);
            }
            
            // Agregar los datos a nuestro array principal
            $datos_totales[] = $datos;
        }
    }

    fclose($fd);
    
    // Devolver los datos como JSON
    echo json_encode($datos_totales);
} else {
    die("<p>El archivo $nombre no se pudo abrir</p>");
}
?>
