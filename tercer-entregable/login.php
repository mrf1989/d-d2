<?php
session_start();

include_once("models/gestionBD.php");
include_once("models/gestionUsuarios.php");

// Si viene del form de login, toma los datos (dni, pass)
if (isset($_POST["submit"])) {
    $dni = $_POST["dni"];
    $pass = $_POST["pass"];
    
    // consulta de credenciales
    $conexion = crearConexionBD();
    $consulta = consultarUsuario($conexion, $dni, $pass);
            
    if ($consulta != 0) {
        // Credenciales OK
        $_SESSION["login"] = $dni;
        $_SESSION["admin"] = 0;
        // consulta si es un administrador (coordinador deportivo)
        //$conexion = crearConexionBD();
        $consulta = consultarTipoUsuario($conexion, $dni);
        if ($consulta != 0) {
            // vista para coordinador
            $_SESSION["admin"] = 1;
            Header("Location: admin.php");
        } else {
            // vista para usuarios
            Header("Location: user.php");
        }
    } else {
        $login = "Error de inicio de sesión";
    }
    
    cerrarConexionBD($conexion);
}
?>
<?php $page_title = "Acceso"; ?>
<?php include_once("includes/head.php"); ?>

<body>
    <div class="container">
        <div class="content">
            <div class="content__logo">
                <img class="logo" src="images/logo/logo-horizontal.jpg" alt="Logotipo de Deporte y Desafío">
            </div>
            <div class="content__copy">
                <h1>Si puedo hacer esto, puedo hacer cualquier cosa</h1>
            </div>
        </div>
        <div class="content">
            <?php
            // muestra el error de login
            if (isset($login)) {
		        echo "<div class=\"content__error\">";
		        echo "$login: usuario no registrado o credenciales incorrectos.";
		        echo "</div>";
	        }	
	        ?>
            <div class="content__form">
                <fieldset>
                    <legend>Formulario de acceso</legend>
                    <form method="POST" class="form-login">
                        <input type="text" name="dni" placeholder="DNI" autofocus="autofocus">
                        <input type="password" name="pass" placeholder="Contraseña">
                        <button type="submit" name="submit" value="submit">Acceder</button>
                    </form>  
                </fieldset>
            </div>
        </div>
    </div>
    <?php include_once("includes/footer.php") ?>
</body>
</html>