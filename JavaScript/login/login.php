<?php
$parametro1=$_REQUEST["nombre"];
$parametro2=$_REQUEST["clave"];

    if($parametro1 == "Admin" && $parametro2 == "1234"){
        echo "VALIDO";
    }else{
        echo "NO VALIDO";
    }
?>