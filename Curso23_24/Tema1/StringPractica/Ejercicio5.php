<?php

function arabicToRoman($number) {
    if ($number < 1 || $number >= 5000) {
        return "Número fuera de rango";
    }

    $roman_numerals = array(
        "M" => 1000,
        "CM" => 900,
        "D" => 500,
        "CD" => 400,
        "C" => 100,
        "XC" => 90,
        "L" => 50,
        "XL" => 40,
        "X" => 10,
        "IX" => 9,
        "V" => 5,
        "IV" => 4,
        "I" => 1
    );

    $roman = "";

    foreach ($roman_numerals as $key => $value) {
        while ($number >= $value) {
            $roman .= $key;
            $number -= $value;
        }
    }

    return $roman;
}

$numero_arabe = "";
$numero_romano = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $numero_arabe = $_POST["numero_arabe"];
    if (is_numeric($numero_arabe) && $numero_arabe >= 1 && $numero_arabe < 5000) {
        $numero_romano = arabicToRoman($numero_arabe);
    } else {
        $numero_romano = "Número no válido";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números Arabes a Romanos</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div style="background-color:lightblue; border:solid; padding:5px;">
            <h1 style="text-align:center">Arabes a Romanos - Formulario</h1>
            <p>Dime un número y te lo devuelvo en números romanos</p>
            <p>
                <label for="numero_arabe">Número:</label>
                <input type="number" name="numero_arabe" id="numero_arabe" min="1" max="4999" value="<?php echo $numero_arabe; ?>" required>
                <?php
                if (isset($_POST["convertir"]) && $errorFormu) {
                    if ($numero_arabe == "") {
                        echo "<span class='error'>*Campo Vacío*</span>";
                    } else {
                        echo "<span class='error'>*Número no válido*</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="convertir">Convertir</button>
            </p>
        </div>
        <?php if ($numero_romano !== "") : ?>
            <div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">
                <h1 style="text-align:center">Arabes a Romanos - Resultado</h1>
                <p>El número arábigo <?php echo $numero_arabe; ?> en números romanos es: <?php echo $numero_romano; ?></p>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>
