<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        .btn {
            border-style: none;
            background: none;
            font-weight: bolder;
            color: blue;
            text-decoration-line: underline;
            cursor: pointer;

        }
        table,td,th{border:1px solid black;}
            table{border-collapse:collapse;text-align:center;width:90%;margin:0 auto}
            th{background-color:#CCC}
            table img{height:100px;}
        
    </style>
</head>

<body>
    <h1>Vista Admin</h1>
    <?php

    echo "<div>Bienvenido <form action='index.php' method='post'><button name='btnverusu' class='btn'>".$_SESSION['usuario']."</button></form><form action='index.php' method='post'><button name='btnsalir' class='btn'>Salir</button></form></div>";
    if(isset($_POST['btnnuevousu'])){
    ?>
    <h4>Agregar nuevo usuario</h4>
    <form action="index.php" method="post"  enctype="multipart/form-data" >
    <fieldset>
        <legend>Agregar nuevo usuario</legend>
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
        <input type="checkbox" id="sub" name="sub" <?php if(isset($_POST["sub"])) echo "checked"; ?>>Suscribete al boletin de novedades<br>
        <?php
        if (isset($_POST['enviar']) && !isset($_POST['sub'])) {
            echo '<span class="error">*Marque la casilla*</span><br>';
        }
        ?>
        <button type="submit" name="enviar">Guardar Cambios</button><button type="submit" name="borrar">Borrar los datos introducidos</button>

    </fieldset>
    </form>
    <?php
    }
    if(isset($_POST['btnborrar'])){
        try {
            $consulta = "Delete from usuarios where id_usuario=?";
            $sentencia = $conexion->prepare($consulta);
            $sentencia->execute([$_POST['btnborrar']]);
        } catch (PDOException $e) {
            $conexion = null;
            $sentencia = null;
            echo "<p>No se puedo conectar a la bbdd : " . $e->getMessage() . "</p></body></html>";}
    }
    if(isset($_POST['usu'])){
        
    }
    if(isset($_POST['btneditar'])){
        
    }
    try {
        $consulta = "select * from usuarios where tipo='normal'";
        $sentencia = $conexion->prepare($consulta);
        $sentencia->execute();
    } catch (PDOException $e) {
        $conexion = null;
        $sentencia = null;
        echo "<p>No se puedo conectar a la bbdd : " . $e->getMessage() . "</p></body></html>";
    }
    if ($sentencia->rowCount() > 0) {
        $tuplas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        echo "<h4>Listado de usuarios</h4>";
        echo "<table>";
        echo "<tr><th>#</th><th>Foto</th><th>Nombre</th><th><form action='index.php' method='post'><button name='btnnuevousu' class='btn'>Usuario+</button></form></th></tr>";
        foreach ($tuplas as $value) {
    
            echo "<tr><td>" . $value['id_usuario'] . "</td><td><img src='img/" . $value['foto'] . "'/></td><td><form action='index.php' method='post'><button name='usu' class='btn'>" . $value['nombre'] . "</button></form></td><td><form action='index.php' method='post'><button name='btnborrar' class='btn' value='".$value['id_usuario']."'>Borrar</button><button name='btneditar' class='btn'>Editar</button></form></th></tr>";
        }

        echo "</table>";
    } else {
        echo "<p>no he obtenido una tupla </p>";
    }

    ?>
</body>

</html>