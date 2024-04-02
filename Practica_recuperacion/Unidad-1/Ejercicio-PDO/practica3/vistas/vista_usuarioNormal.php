
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        .btn{
            border-style: none;
            background: none;
            font-weight: bolder;
            color: blue;
            text-decoration-line: underline;
            cursor: pointer;
         
        }
    </style>
</head>
<body>
    <h2>Estas Logeado Normal</h2>
    <img src="" alt="">
   <?php
  
        echo "<div>Bienvenido <a>".$_SESSION['usuario']."</a> <form action='index.php' method='post'><button name='btnsalir' class='btn'>Salir</button></form></div>";
   
   ?>
</body>
</html>