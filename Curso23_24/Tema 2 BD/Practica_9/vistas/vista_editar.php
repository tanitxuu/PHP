<?php
if(isset($_POST["btnEditar"]))
    $idPelicula=$_POST["btnEditar"];
else
    $idPelicula=$_POST["idPelicula"];

// Abro conexión si aún no ha sido abierta
if(!isset($conexion))
{
    try{
        $conexion=mysqli_connect(SERVIDOR_BD,USUARIO_BD,CLAVE_BD,NOMBRE_BD);
        mysqli_set_charset($conexion,"utf8");
    }
    catch(Exception $e)
    {
        die("<p>No ha podido conectarse a la base de batos: ".$e->getMessage()."</p></body></html>");
    }  
}

try{
    $consulta="select * from peliculas where idPelicula='".$idPelicula."'";
    $resultado=mysqli_query($conexion, $consulta);
}
catch(Exception $e)
{
    mysqli_close($conexion);
    die("<p>No se ha podido realizar la consulta: ".$e->getMessage()."</p></body></html>");
}

if(mysqli_num_rows($resultado)>0)
{
    //recojo datos
    if(isset($_POST["btnEditar"]))
    {
        //recojo de la BD
        $datos_peliculas=mysqli_fetch_assoc($resultado);
        mysqli_free_result($resultado);
        $titulo=$datos_peliculas["titulo"];
        $director=$datos_peliculas["director"];
        $sinopsis=$datos_peliculas["sinopsis"];
        $genero=$datos_peliculas["genero"];
        $caratula=$datos_peliculas["caratula"];
    }
    else
    {
        //recojo del $_POST
        $titulo=$_POST["titulo"];
        $director=$_POST["director"];
        $sinopsis=$_POST["sinopsis"];
        $genero=$_POST["genero"];
        $caratula=$_POST["caratula"];//Lo meto en un hidden porque en el $_POST no está
    }

}
else
{
    $error_existencia="<p>El usuario seleccionado ya no se encuentra en la BD</p>";
}

if(isset($error_existencia))
{
    echo "<h2>Editando el usuario con id ".$idPelicula."</h2>";
    echo $error_existencia;
    echo "<form action='index.php' method='post'>";
    echo "<p><button type='submit'>Volver</button></p>";
    echo "</form>";
}
else
{
    //Pongo el formulario
?>
    <h2>Editando el usuario con id <?php echo $idPelicula;?></h2>
    
    
    <form action="index.php" method="post" enctype="multipart/form-data" class="paralelo">
    <div>
    <p>
            <label for="titulo">Titulo:</label><br/>
            <input type="text" name="titulo" id="titulo" maxlength="15" value="<?php if(isset($_POST["titulo"])) echo $_POST["titulo"];?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_titulo)
            {
                if($_POST["titulo"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["titulo"])>15)
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
                else
                    echo "<span class='error'> Titulo repetido</span>";}
            ?>
        </p>
        <p>
            <label for="director">Director:</label><br/>
            <input type="text" name="director" id="director" maxlength="20" value="<?php if(isset($_POST["director"])) echo $_POST["director"];?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_director)
            {
                if($_POST["director"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                elseif(strlen($_POST["director"])>20)
                    echo "<span class='error'> Has tecleado más de 20 caracteres</span>";
            
            }
                
            ?>
        </p>
        <p>
            <label for="sinopsis">Sinopsis:</label><br/>
            <textarea  name="sinopsis" id="sinopsis"><?php if(isset($_POST["sinopsis"])) echo $_POST["sinopsis"];?></textarea>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_sinopsis)
            {
                if($_POST["sinopsis"]=="")
                    echo "<span class='error'> Campo vacío </span>";
            }
            ?>
        </p>
        <p>
            <label for="genero">Genero:</label><br/>
            <input type="text"  maxlength="15" name="genero" id="genero" value="<?php if(isset($_POST["genero"])) echo $_POST["genero"];?>"/>
            <?php
            if(isset($_POST["btnContEditar"])&& $error_genero)
            {
                if($_POST["genero"]=="")
                    echo "<span class='error'> Campo vacío </span>";
                else
                echo "<span class='error'> Has tecleado más de 15 caracteres</span>";
            }
                
            ?>
        </p>

        <p>
            <label for="caratula">Incluir mi foto (Max. 500KB)</label>
            <input type="file" name="caratula" id="caratula" accept="image/*"/>
            <?php
            if(isset($_POST["btnContEditar"]) && $error_caratula)
            {
                if($_FILES["caratula"]["error"])
                    echo "<span class='error'> No se ha podido subir el archivo al servidor</span>";
                elseif(!getimagesize( $_FILES["caratula"]["tmp_name"]))
                    echo "<span class='error'> No has seleccionado un archivo de tipo imagen</span>";
                elseif(!tiene_extension($_FILES["caratula"]["name"]))
                    echo "<span class='error'> Has seleccionado un archivo imagen sin extensión</span>";
                else
                    echo "<span class='error'> El archivo seleccionado supera los 500KB</span>";
            }
            ?>
        </p>
        <p>
            <input type="hidden" name="caratula_bd" value="<?php echo $caratula;?>">
            <input type="hidden" name="idPelicula" value="<?php echo $idPelicula;?>">
            <button type="submit" name="btnContEditar">Continuar</button>
            <button type="submit" >Atrás</button>
        </p>
        </div>
        <div>
            <p class="centrado">
                <img class="foto_detalle" src="img/<?php echo $caratula;?>" title="Foto de Perfil" alt="Foto de Perfil"><br>
                <?php
                if(isset($_POST["btnBorrarFoto"]))
                    echo "¿Estás seguro que quieres borra la foto?<br><br><button name='btnContBorrarFoto'>Si</button><button name='btnNoBorrarFoto'>No</button>";
                elseif($caratula!="no_imagen.jpg")
                    echo '<button name="btnBorrarFoto">Borrar Foto</button>';
                ?>
            </p>
        </div>
    </form>
    
<?php  
}