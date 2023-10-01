
   <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>
                <style> .error{color:red} div{background-color:lightblue; border:1px solid black;}</style>
            </head>
            <body>
            <div>
                <h1>Ripios-Formulario</h1>
                <form action="index.php" method="post" enctype="multipart/form-data">
                    <p>dime dos palabras y te dire si riman o no</p>
                    <p>
                        <label for="primerap">Primera palabra:</label>
                        <input type="text" name="primerap" id="primerap" value="<?php if(isset($_POST["primerap"])) echo $_POST["primerap"];?>"><br>

                        <?php
                        if(isset($_POST["btcomparar"])&&$error_nombre){
                            echo "<span class='error'>*Campo vacio*</span>";
                        }
                        ?>
                    </p>
                    <p>
                        <label for="segundap">Segunda palabra:</label>
                        <input type="text" name="segundapa" id="apellido" value="<?php if(isset($_POST["apellido"])) echo $_POST["apellido"];?>"><br>

                        <?php
                        if(isset($_POST["btenviar"])&&$error_apellido){
                            echo "<span class='error'>Campo vacio </span>";
                        }
                        ?>
                    </p>
                    <button type="submit" name="btcomparar">Comparar</button>
                    </form>
                </div>
                <div>
                    <p>
                     
                    </p>
                   
                </div>
            </body>
            </html>
