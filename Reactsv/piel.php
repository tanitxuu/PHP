<?php
header("Access-Control-Allow-Origin: *");
$data = json_decode(file_get_contents('php://input'), true);

$fichero = $data['fichero'];
$nombre = "resultado.txt";
$contador = [];

// Intentamos abrir el fichero en modo de lectura/escritura
$fd = fopen($nombre, "a+");
if (!$fd) {
    die("<p>No se ha podido abrir el fichero</p>");
}

// Leer el contenido actual del archivo para obtener los valores anteriores
$linea_actual = fgets($fd);
if ($linea_actual !== false) {
    $contador = explode("||", $linea_actual);
    array_shift($contador); // Eliminar primer elemento (vacio) generado por el explode
    $contador = array_map('intval', $contador); // Convertir valores a enteros
} else {
    // Si no hay contenido, inicializamos el contador con ceros
    $contador = array_fill(0, 6, 0);
}



// Actualizar el contador según las respuestas recibidas
foreach ($fichero as $key => $value) {
    switch ($value) {
        case 1:
            $contador[0]++;
            break;
        case 2:
            $contador[1]++;
            break;
        case 3:
            $contador[2]++;
            break;
        case 4:
            $contador[3]++;
            break;
        case 5:
            $contador[4]++;
            break;
        case 6:
            $contador[5]++;
            break;
        default:
            // En caso de que el valor no sea ninguno de los esperados
            break;
    }
}

// Retroceder el puntero al principio del archivo
rewind($fd);
echo $contador;
// Escribir los valores actualizados en el archivo
ftruncate($fd, 0); // Borramos el contenido anterior

fputs($fd, "||" . implode("||", $contador));

fclose($fd);
echo "<p>Contador actualizado con éxito</p>";

?>


