<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> .error{color:red} </style>
</head>
<body>
    <h1>Esta es mi super pagina</h1>
    <form action="index.php" method="post"> 
        <p>
            <label for="i1">Nombre:</label>
            <input type="text" name="nombre" id="i1" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"/>
            <?php
            if(isset($_POST["btenviar"])&&$error_nombre){
                echo "<span class='error'>*Campo vacio *</span>";
            }
            ?>
        </p>
        <p>
            <label for="i2">Nacido en:</label>
             <select id="i2" name="nacido">
                <option value="Malaga"<?php if(isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Malaga")echo "selected"?>>Malaga</option>
                <option value="Sevilla"<?php if(!isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Sevilla")echo "selected"?>>Sevilla</option>
                <option value="Jaen" <?php if(!isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Jaen")echo "selected"?>>Jaen</option>
            </select>
        </p>
        <p>
            Sexo:
           
             <label for="hombre">Hombre</label>
            <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="Hombre")echo "checked"?>/>
            <label for="mujer">Mujer</label>
            <input type="radio" name="sexo" id="mujer" value="Mujer"<?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="Mujer")echo "checked"?>/>
            <?php
            if(isset($_POST["btenviar"])&&$error_sexo){
         echo "<span class='error'>*Debes seleccionar uno*</span>";
            }
            ?>
        </p>
        <p>
            Aficiones:   <label for="deportes">Deportes</label>
            <input type="checkbox" name="aficiones[]"   id="deportes" value="Deportes" <?php if(isset($POST["aficiones[]"]) && en_array("Deportes", $POST["aficiones"])) echo "checked"?>/>
            <label for="lectura">Lectura</label>
            <input type="checkbox" name="aficiones[]" id="lectura" value="Lectura" <?php if(isset($POST["aficiones[]"]) && en_array("Lectura", $POST["aficiones"])) echo "checked"?>/>
            <label for="otros">Otros</label>
            <input type="checkbox" name="aficiones[]" id="otros" value="Otros" <?php if(isset($POST["aficiones[]"]) && en_array("Otros", $POST["aficiones"])) echo "checked"?>/>
        </p>
        <p>
            <label for="comentarios">Comentario:</label>
            <textarea id="comentarios" name="comentarios" <?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"];?>></textarea>
          
        </p>
        <p>
            <button type="submit" name="btenviar">Enviar</button>
                  
        </p>

    </form>
</body>
</html>