<?php
$dinero=$_REQUEST["dinero"];
$interes=$_REQUEST["interes"];
$meses=$_REQUEST["meses"];

    if ($dinero == 0 || $interes == 0 || $meses == 0 ){
        echo "Rellena todos los campos";
    }else{
        $cuota= $dinero * (1+($interes/100)) / $meses;
        echo "La cuota mensual sera de: ".$cuota."€";
    }
?>