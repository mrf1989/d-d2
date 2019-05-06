<header>
    <div class="content-header">
        <div class="logo">
            <a href="/index.php"><img src="images/logo/logo-horizontal.jpg" alt="Logotipo Deporte y Desafío" width="300"></a>
        </div>
        <div id="menu-mobile" class="menu-mobile">
            <div id="btn-nav" class="btn-nav">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div id="navbar" class="navbar navbar-mobile">
            <nav>
                <ul class="nav-items">
                <?php if ($_SESSION["admin"]) { ?>
                    <li><a href="/participantes.php">Participantes</a></li>
                    <li><a href="/tutores.php">Tutores</a></li>
                    <li><a href="/voluntarios.php">Voluntarios</a></li>
                    <li><a href="/proyectos.php">Proyectos</a></li>
                    <li><a href="/patrocinadores.php">Patrocinadores</a></li>
                <?php } else { ?>
                    <li><a href="perfilUsuario.php">Mi perfil</a></li>
                    <li><a href="formIntereses.php">Actividades</a></li>
                <?php } ?>
                <?php if (isset($_SESSION["login"])) { ?>
                    <li><a class="logout" href="logout.php">Cerrar sesión</a></li>
                <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</header>