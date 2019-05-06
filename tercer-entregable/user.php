<?php
    session_start();
    echo "Hola Mundo! soy un ";
    if ($_SESSION["user"] == 2) {
        echo "participante!";
    } else {
        echo "voluntario!";
    }
?>
