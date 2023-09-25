<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style> .error{color:red} </style>
            </head>
            <body>
                <h1>Rellena tu CV</h1>
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <p>
                        <label for="nombre">Nombre:</label><br>
                        <input type="text" name="nombre" id="nombre" value="<?php if(isset($_POST["nombre"])) echo $_POST["nombre"];?>"><br>

                        <?php
                        if(isset($_POST["btenviar"])&&$error_nombre){
                            echo "<span class='error'>Campo vacio </span>";
                        }
                        ?>
                    </p>
            
                    <p>
                        <label for="apellido">Apellido:</label><br>
                        <input type="text" name="apellido" id="apellido" value="<?php if(isset($_POST["apellido"])) echo $_POST["apellido"];?>"><br>

                        <?php
                        if(isset($_POST["btenviar"])&&$error_apellido){
                            echo "<span class='error'>Campo vacio </span>";
                        }
                        ?>
                    </p>
            
                    <p>
                        <label for="contraseña">Contraseña:</label><br>
                        <input type="password" name="contraseña" id="contraseña"><br>
                        <?php
                        if(isset($_POST["btenviar"])&&$error_contraseña){
                            echo "<span class='error'>Campo vacio </span>";
                        }
                        ?>
                    </p>
            
                    <p>
                        Sexo:
                        <?php
                        if(isset($_POST["btenviar"])&&$error_sexo){
                            echo "<span class='error'>Debes seleccionar uno</span>";
                        }
                        ?>
                        <br>
                        <input type="radio" name="sexo" id="hombre" value="Hombre" <?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="Hombre")echo "checked"?>>Hombre<br>
                        <input type="radio" name="sexo" id="mujer" value="Mujer"<?php if(isset($_POST["sexo"])&& $_POST["sexo"]=="Mujer")echo "checked"?>>Mujer<br>
                    </p>
            
                    <p>
                        <label for="foto">Incluir mi foto </label>
                        <input type="file" name="foto" id="foto" accept="image/*">
                    </p>
            
                    <p>
                        <label for="nacido">Nacido en:</label>
                        <select id="nacido" name="nacido">
                            <option value="Malaga"<?php if(isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Malaga")echo "selected"?>>Malaga</option>
                            <option value="Sevilla"<?php if(!isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Sevilla")echo "selected"?>>Sevilla</option>
                            <option value="Jaen" <?php if(!isset($_POST["nacido"])||isset ($_POST["nacido"])&&$_POST["nacido"]=="Jaen")echo "selected"?>>Jaen</option>
                        </select>
                    </p>
            
                    <p>
                        <label for="comentarios">Comentario:</label>
                        <textarea id="comentarios" name="comentarios" rows="10" cols="50" <?php if(isset($_POST["comentarios"])) echo $_POST["comentarios"];?>></textarea>
                        <?php
                        if(isset($_POST["btenviar"])&&$error_comentarios){
                            echo "<span class='error'>Campo vacio uno</span>";
                        }
                        ?>
                    </p>
            
                <p>
                    <input type="checkbox" name="subscripcion" id="subscripcion" checked />
                    <label for="subscripcion">Subscribirse al boletin de Novedades</label><br/>
                </p>
            
                <p>
                    <button type="submit" name="btenviar">Guardar Cambios</button>
                    <button type="submit" name="btborrar">Borrar los datos introducidos</button>
                </p>
            </form>
            </body>
            </html>


    
