<?php
session_start();

// cierra y elimina sesión
if (isset($_SESSION['login'])) {
    $_SESSION['login'] = null;
    session_destroy();
} else {
    Header("Location: index.php");
}

Header("Location: index.php");
?>
