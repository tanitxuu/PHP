<!DOCTYPE html>
<html lang="en">
<body>
    <h1>Esta es mi primera pagina</h1>
    <form action="recogida.php" method="post" enctype="multipart/form-data">
    <p>
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" id="nombre"><br>
    </p>
    <p>
        <label for="nacido">Nacido en:</label>
        <select id="nacionalidad"name="nacido1">
          <option>Malaga</option>
          <option>Vitoria</option>
          <option>Villacarrillo</option>
        </select>
    </p>
    <p>
    <label >Sexo:</label><br>
    <input type="radio" name="sexo"   id="hombre" value="Hombre">Hombre
    <input type="radio" name="sexo" id="mujer" value="Mujer">Mujer
    </p>
    <p>
    <label>Aficiones:</label><br>
    <input type="checkbox" name="aficiones"   id="deportes" value="Deportes" >Deportes
    <input type="checkbox" name="aficiones" id="lectura" value="Lectura">Lectura
    <input type="checkbox" name="aficiones" id="otros" value="Otros">Otros
    </p>
    <p>
    <label>Comentario:</label>
    <textarea name="textarea" id="text"></textarea>
    </p>
    <p>
   <button type="submit" name="boton1">Enviar</button>
   </p>
   </form>
</body>
</html>