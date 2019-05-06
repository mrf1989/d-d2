<?php
session_start();
// comprueba si hay una sesión de login iniciada con éxito
if ( isset( $_SESSION['login'] ) ) {
    // comprueba si el usuario es admin
    if ($_SESSION["admin"]) {
        Header('Location: admin.php');
    } else {
        // si no, redireccina a página principal user
        Header('Location: user.php');
    }
} else {
    // si no, redirecciona a form login
    Header('Location: login.php');
}
?>