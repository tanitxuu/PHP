<form enctype="multipart/form-data" action="index.php" method='post'>
    <fieldset>
        <legend>Rellena tu CV</legend>
        <label for="usu">Usuario:</label><br>
        <input type="text" name="usu" id="usu" value="<?php if (isset($_POST['usu'])) echo $_POST['usu']; ?>" placeholder="Usuario..."><br>
        <?php
        if (isset($_POST['enviar']) && $error_usu) {
            echo '<span class="error">*Debe rellenar el usuario*</span><br>';
        }
        ?>
        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" value="<?php if (isset($_POST['nombre'])) echo $_POST['nombre']; ?>" placeholder="Nombre..."><br>
        <?php
        if (isset($_POST['enviar']) && $error_nombre) {
            echo '<span class="error">*Debe rellenar el nombre*</span><br>';
        }
        ?>
        <label for="clave">Contraseña:</label><br>
        <input type="password" name="clave" id="clave" placeholder="Contraseña..."><br>
        <?php
        if (isset($_POST['enviar']) && $error_clave) {
            echo '<span class="error">*Debe rellenar la contraseña*</span><br>';
        }
        ?>
        <label for="dni">DNI:</label><br>
        <input type="text" name="dni" id="dni" placeholder="58938556T" value="<?php if (isset($_POST['dni'])) echo $_POST['dni']; ?>"><br>
        <?php
        if (isset($_POST['enviar']) && $error_dni) {
            if ($_POST['dni'] == '') {
                echo '<span class="error">*Debe rellenar el DNI*</span><br>';
            } else if (!dni_bien_escrito($_POST['dni'])) {
                echo '<span class="error">*Los primeros 8 digitos deben ser numeros*</span><br>';
            } else if (!dni_valido($_POST['dni'])) {
                echo '<span class="error">*El dni no es valido*</span><br>';
            }
        }
        ?>
        <label for="sexo">Sexo:</label><br>
        <input type="radio" name="sexo" id="h" value="Hombre" <?php if (isset($_POST["sexo"]) && $_POST["sexo"] == "hombre") echo "checked"; ?>><label for="h">Hombre</label><br>
        <input type="radio" name="sexo" id="m" value="Mujer" <?php if (!isset($_POST["sexo"]) || (isset($_POST["sexo"]) && $_POST["sexo"] == "mujer")) echo "checked"; ?>> <label for="m">Mujer</label><br><br>
        <label for="img">Incluir mi foto (Max. 500KB)</label>
        <input type="file" name="img" id="img" accept="image/*"><br><br>
        <?php
        if (isset($_POST["enviar"]) && $error_img) {
            if ($_FILES["img"]["name"] != "") {
                if ($_FILES["img"]["error"]) {
                    echo "<span class='error'>No se ha podido subir el archivo</span>";
                } elseif (!explode('.', $_FILES['img']['name'])) {
                    echo "<span class='error'>El archivo no tiene extension</span>";
                } elseif (!getimagesize($_FILES["img"]["tmp_name"])) {
                    echo "<span class='error'>No has selecionado un archivo tipo img</span>";
                } else {
                    echo "<span class='error'>El archivo supera el tamaño</span>";
                }
            }
        }
        ?>
        <input type="checkbox" id="sub" name="sub" <?php if(isset($_POST["sub"])) echo "checked"; ?>?>>Suscribete al boletin de novedades<br>
        <?php
        if (isset($_POST['enviar']) && !isset($_POST['sub'])) {
            echo '<span class="error">*Marque la casilla*</span><br>';
        }
        ?>
        <button type="submit" name="enviar">Guardar Cambios</button><button type="submit" name="borrar">Borrar los datos introducidos</button>

    </fieldset>
</form>