<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario php</title>
</head>
<body>
    <form action="formulario.php" method='get'>
        <fieldset>
            <legend>Rellena tu CV</legend>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre"><br>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido"><br>
            <label for="clave">Contraseña:</label>
            <input type="password" name="clave" id="clave"><br>
            <label for="dni">Dni:</label>
            <input type="text" name="dni" id="dni" maxlength="9"><br>
            <label for="sexo">Sexo:</label><br>
            <input type="radio" name="sexo" id="sexo" value="Hombre">Hombre
            <input type="radio" name="sexo" id="sexo" value="Mujer" checked>Mujer<br>
            <label for="nacido">Nacido en :</label>
            <select name="nacido" id="nacido">
                <option value="malaga">Malaga</option>
                <option value="malaga">Vitoria</option>
                <option value="malaga">Jaen</option>
            </select><br>
            <input type="checkbox">Voletin de novedades
            <button type='submit'>Enviar</button>
            <button type='reset'>Borrar</button>
        </fieldset>
    </form>
</body>
</html>