<?php
session_name("contador");
session_start();

if (isset($_POST["btnContador"])) {

    if($_POST["btnContador"] == "cero") {
        session_destroy();
    }elseif($_POST["btnContador"] == "mas") {

        $_SESSION["contador"]++;
    }else{
        $_SESSION["contador"]--;
    }
}
header("Location:session03_1.php");
exit;
?>