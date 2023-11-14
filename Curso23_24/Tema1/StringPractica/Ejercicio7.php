<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Números</title>
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <?php
    $numeros = "";
    $numeros_con_puntos = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $numeros = $_POST["numeros"];
        // Reemplazamos comas por puntos
        $numeros_con_puntos = str_replace(",", ".", $numeros);
    }
    ?>

    <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <div style="background-color:lightblue; border:solid; padding:5px;">
            <h1 style="text-align:center">Formulario de Números</h1>
            <p>Ingrese números enteros o decimales separados por espacios, comas o puntos:</p>
            <p>
                <label for="numeros">Números:</label>
                <input type="text" name="numeros" id="numeros" value="<?php echo $numeros; ?>" required>
                <?php
                if (isset($_POST["convertir"])) {
                    if ($numeros_con_puntos === "") {
                        echo "<span class='error'>*Campo Vacío*</span>";
                    }
                }
                ?>
            </p>
            <p>
                <button type="submit" name="convertir">Convertir</button>
            </p>
        </div>
        <?php if ($numeros_con_puntos !== "") : ?>
            <div style="background-color:lightgreen; border:solid; margin-top:10px; padding:5px;">
                <h1 style="text-align:center">Resultado</h1>
                <p>Números con puntos como separadores decimales:</p>
                <p><?php echo $numeros_con_puntos; ?></p>
            </div>
        <?php endif; ?>
    </form>
</body>
</html>
