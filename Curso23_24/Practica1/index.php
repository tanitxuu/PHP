<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Rellena tu CV</h1>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
    <p>
    <label for="nombre">Nombre:</label><br>
    <input type="text" name="nombre" id="nombre"><br>
    </p>

    <p>
    <label for="apellido">Apellido:</label><br>
    <input type="text" name="apellido" id="apellido"><br>
    </p>

    <p>
    <label for="contraseña">Contraseña:</label><br>
    <input type="password" name="contraseña" id="contraseña"><br>
    </p>

    <p>
    <label for="dni">DNI:</label><br>
    <input type="text" name="dni" id="dni"><br>
    </p>

    <p>// en el radio hay que poner el value para saber el valor
        Sexo:<br>
    <input type="radio" name="sexo" id="hombre" value="Hombre">Hombre<br>
    <input type="radio" name="sexo" id="mujer" value="Mujer">Mujer<br>
    </p>

    <p>//con la etiqueta accept (image/*)decimos que solo se puenden imagenes
    <label for="foto">Incluir mi foto </label>
    <input type="file" name="foto" id="foto" accept="image/*">
    </p>

    <p>
        Nacido en:
        <select name="nacionalidad">
          <option>Malaga</option>
          <option>Vitoria</option>
          <option>Villacarrillo</option>
        </select>
    </p>

    <p>
    <label>Comentario:</label>
    <textarea name="textarea" rows="10" cols="50">Write something here</textarea>
    </p>

   <p>
   <input type="checkbox" name="subscripcion" checked="checked" />
    Subscribirse al boletin Nacional<br/>
   </p>
   
</form>
</body>
</html>