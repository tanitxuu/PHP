<?php
if(isset($_POST['editar'])){
    
}
if(isset($_POST['borrar'])){

}
if (isset($_POST['agregar'])) {
    $error_referencia = $_POST['referencia'] == '' || !is_numeric($_POST['referencia']) || $_POST['referencia']<0;

    if(!$error_referencia){
        //repetido
    }

    $error_titulo=$_POST['titulo']=='';

    if(!$error_titulo){
        //repetido
    }

    $error_autor=$_POST['autor']=='';
    $error_descripcion=$_POST['descripcion']=='';
    $error_precio=$_POST['precio']=='' || !is_numeric($_POST['precio']) || $_POST['precio']<0;
    $error_form=$error_referencia || $error_titulo || $error_autor || $error_descripcion || $error_precio ;
    
    if(!$error_form){
        //insertar

    }
}
$respuesta = consumir_servicios_REST(DIR_SERV . "/obtenerLibros", "GET");
$json = json_decode($respuesta, true);
$libros = $json['libros'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista normal</title>
    <style>
        img {
            width: 30%;
            height: auto;
        }

        #columna {
            display: flex;
            flex-wrap: wrap;
            text-align: center;
        }

        table {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Libreria</h1>
    <p>Bienvenido <strong> <?php echo $datos_usuario_log['lector']; ?> </strong> -
    <form action="index.php" method="post"><button name="salir">Salir</button></form>
    </p>
    <h3>Listado de los Libros</h3>
    <table border="1" width="20%">
        <tr>
            <th>Ref</th>
            <th>Titulo</th>
            <th>Accion</th>
        </tr>
        <?php
        foreach ($libros as $value) {
            echo "<tr>";
            echo "<td>" . $value['referencia'] . "</td>";
            echo "<td><form action='index.php' method='post'><button name='datos' value='" . $value['referencia'] . "' class='enlace'>" . $value['titulo'] . "</button>
     </form></td>";


            echo "<td>
    <form action='index.php' method='post'>
    <button name='borrar' value='" . $value['referencia'] . "' class='enlace'>Borrar</button>
     - 
     <button name='editar' value='" . $value['referencia'] . "' class='enlace'>Editar</button>
     </form></td>";
            echo "</tr>";
        }
        ?>
    </table>
    <h3>Agregar un nuevo libro</h3>
    <form action="index.php" method="post">
        <p>
            <label for="referencia">Referencia: </label>
            <input type="text" name="referencia"
                value="<?php if (isset($_POST['referencia']))
                    echo $_POST['referencia'] ?>">
                <?php
                if (isset($_POST['agregar']) && $error_referencia) {
                    if ($_POST['referencia'] == '') {
                        echo "<span class='error'>*Campo Vacio*</span>";
                    } else {
                        echo "<span class='error'>*Numero de referencia repetido*</span>";
                    }
                }
                ?>
        </p>
        <p>
            <label for="titulo">Titulo: </label>
            <input type="text" name="titulo" value="<?php if (isset($_POST['titulo']))
                echo $_POST['titulo'] ?>">
                <?php
            if (isset($_POST['agregar']) && $error_titulo) {

                echo "<span class='error'>*Campo Vacio*</span>";

            }
            ?>
        </p>
        <p>
            <label for="autor">Autor: </label>
            <input type="text" name="autor" value="<?php if (isset($_POST['autor']))
                echo $_POST['autor'] ?>">
                <?php
            if (isset($_POST['agregar']) && $error_autor) {

                echo "<span class='error'>*Campo Vacio*</span>";

            }
            ?>
        </p>
        <p>
            <label for="descripcion">Descripcion: </label>
            <textarea name="descripcion"><?php if (isset($_POST['descripcion']))
                echo $_POST['descripcion'] ?></textarea>

                <?php
            if (isset($_POST['agregar']) && $error_descripcion) {

                echo "<span class='error'>*Campo Vacio*</span>";

            }
            ?>
        </p>
        <p>
            <label for="precio">Precio: </label>
            <input type="text" name="precio" value="<?php if (isset($_POST['precio']))
                echo $_POST['precio'] ?>">
                <?php
            if (isset($_POST['agregar']) && $error_autor) {

                echo "<span class='error'>*Campo Vacio*</span>";

            }
            ?>
        </p>
        <p>
            <button name="agregar">Agregar</button>
        </p>

    </form>
</body>

</html>