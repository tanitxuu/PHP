
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Normal</title>
    <style>
        .btn{
            border-style: none;
            background: none;
            font-weight: bolder;
            color: blue;
            text-decoration-line: underline;
            cursor: pointer;
         
        }
        .mensaje{
            color: blue;
        }
    </style>
</head>
<body>
    <h2>Estas Logeado Normal</h2>
    <img src="" alt="">
   <?php
  
        echo "<div>Bienvenido <a>".$_SESSION['usuario']."</a> <form action='index.php' method='post'><button name='btnsalir' class='btn'>Salir</button></form></div>";
   if(isset($_SESSION['mensaje_registro'])){
    echo '<p class="mensaje">'.$_SESSION['mensaje_registro'].'</p>';
    unset($_SESSION['mensaje_registro']);
   }
   ?>
</body>
</html>