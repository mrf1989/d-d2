<?php 
	// $page_title = "Descripción de la aplicación";
	// include_once("head.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/grid.css">
	<link rel="stylesheet" href="../css/styles.css">
	<link rel="stylesheet" href="../css/doc.css">
    <title>Deporte y Desafío - Descripción de la aplicación</title>
</head>
<header>
    <div class="content-header">
        <div class="logo">
            <a href="../index.php"><img src="../images/logo/logo-horizontal.jpg" alt="Logotipo Deporte y Desafío" width="300"></a>
        </div>
		<div class="header_title">
			Proyecto de IISSI-2
		</div>
    </div>
</header>
<body>
	<div class="container">
        <div class="content">
            <div class="row">
                <div class="col-12 col-tab-12">
                    <div class="content__module">
                        <div class="module-title">
							<h1>Descripción de la aplicación</h1>
						</div>
						<div>
							<h2>1. Introducción</h2>
							<p ALIGN="justify">El proyecto <em>Deporte y Desafío</em>, consiste en el desarrollo de una herramienta para facilitar a los coordinadores el manejo de la información de los usuarios, los patrocinadores y los proyectos que se llevan a cabo en la fundación, junto con sus respectivas actividades. Además, existe un apartado dedicado a los usuarios en el que pueden acceder a su perfil y editar su información personal, ver un listado de las próximas actividades y mostrar su interés en ellas.</p>
						</div>
						<div>
							<h2>2. Arquitectura de la aplicación</h2>
							<p ALIGN="justify">Nuestra aplicación web está basada en una arquitectura que sigue el estilo centrado en datos y el patrón <em>MVC (Modelo-Vista-Controlador)</em>. La vista representa la interfaz visual la cual muestra al usuario toda la información que puede manejar y redirige las peticiones del usuario al controlador. El controlador es el coordinador de la aplicación, es decir, el encargado de procesar las peticiones de los usuarios y enviárselas al modelo, y las consultas del modelo para mostrar nuevas vistas a los usuarios. El modelo es el nexo de unión con la base de datos, gestiona la comunicación con esta y se encarga de realizar las consultas.</p>

							<p ALIGN="justify">Todas las ramas de nuestra aplicación siguen el esquema anterior. Un ejemplo es la inserción de un nuevo participante. En primer lugar se muestra la vista del formulario (formParticipante.php), donde se deben insertar los datos. Seguidamente, al pulsar el botón de "Guardar", se acciona el controlador (controlParticipantes.php), el cual procesa la información e invoca al modelo (gestionParticipantes.php), que la añade en la base de datos. Finalmente, el controlador consulta la información a la base de datos a través del modelo y la redirige a la vista participantes.php, mostrándose así el nuevo listado de participantes.</p>
						</div>
						<div>
							<h2>3. Modo de uso</h2>
							<p ALIGN="justify">Prestamos dos tipos de permiso, de admministrador, para los coordinadores, y de usuario, para los participantes y voluntarios. </p>

							<h3>Administradores</h3>

							<p ALIGN="justify">En el caso de los administradores, tienen todos los permisos de inserción, consulta, actualización y borrado. Los coordinadores se autentican con su DNI y su contraseña. En primer lugar, en la pantalla de inicio se muestra un listado con las actividades más próximas. En la cabecera, se encuentra un menú de navegación, donde se diferencian todas las secciones sobre las que se manejan datos (participantes, tutores, voluntarios, proyectos y patrocinadores). En cada una de ellas, pueden editar, borrar, añadir nuevos perfiles u obtener información más detallada sobre estos. Otra sección a comentar es la de actividades, que se encuentra dentro de proyectos, sobre la que se pueden realizar las mismas operaciones ya mencionadas.</p>

							<h3>Usuarios</h3>
							<p ALIGN="justify">Los usuarios también se autentican con su DNI y su contraseña; en primer lugar, se encuentran con una vista en la que aparecen sus inscripciones o colaboraciones, y las próximas actividades. En la cabecera, disponen de un menú para ver su perfil, en el cual pueden ver y editar sus datos personales, su historial de participación, así como los datos personales de su tutor legal en el caso de ser participantes. En dicho menú, también se encuentra un botón para ver todas las actividades próximas propuestas, sobre las que pueden mostrar su interés.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>
</html>