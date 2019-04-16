<header>
    <div class="content-header">
        <div class="logo">
            <a href="/index.php"><img src="images/logo/logo-horizontal.jpg" alt="Logotipo Deporte y Desafío" width="300"></a>
        </div>
        <div class="navbar">
            <nav>
                <ul class="nav-items">
                    <li><a href="/participantes.php">Participantes</a></li>
                    <li><a href="#">Tutores</a></li>
                    <li><a href="#">Voluntarios</a></li>
                    <li><a href="#">Proyectos</a></li>
                    <li><a href="#">Patrocinadores</a></li>
                <?php if (isset($_SESSION["login"])) { ?>
                    <li><a href="logout.php">Cerrar sesión</a></li>
                <?php } ?>
                </ul>
            </nav>
        </div>
    </div>
</header>