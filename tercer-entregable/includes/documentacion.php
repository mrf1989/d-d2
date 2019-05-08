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
							<p ALIGN="justify">El proyecto <em>Deporte y Desafío</em>, consiste en el desarrollo de una herramienta de gestión de proyectos que facilita, a los coordinadores deportivos de la fundación, el manejo de la información de los usuarios registrados en el sistema, los patrocinadores de las actividades y los proyectos que se llevan a cabo a lo largo del año en la fundación "Deporte y Desafío". Además, a esta herramienta pueden acceder los usuarios registrados en el sistema, pudiendo consultar su perfil y editar su información personal, ver un listado de las próximas actividades y actualizar su estado de interés en ellas.</p>
						</div>
						<div>
							<h2>2. Arquitectura de la aplicación</h2>
							<p ALIGN="justify">Nuestra aplicación web está basada en una arquitectura que sigue el estilo centrado en datos y el patrón <em>MVC (Modelo-Vista-Controlador)</em>. La vista representa la interfaz visual, la cual muestra al usuario toda la información que puede manejar y redirige las decisiones del usuario al controlador. El controlador se encarga de coordinar las acciones de la aplicación, es decir, procesa las peticiones de los usuarios y se las envía al modelo para, posteriormente, mostrar nuevas vistas a los usuarios. El modelo es el nexo de unión con la base de datos, gestiona la comunicación con esta y se encarga de realizar las consultas.</p>

							<p ALIGN="justify">Todas las interfaces de usuario de nuestra aplicación siguen el esquema anterior. Un ejemplo es la inserción en el sistema de un nuevo participante por parte de un coordinador deportivo. En primer lugar, se muestra la vista del formulario (formParticipante.php), donde se deben insertar los datos. Seguidamente, al pulsar el botón de "Guardar", se acciona el controlador (controlParticipantes.php), el cual recoge y procesa la información del formulario e invoca al modelo (gestionParticipantes.php), que la añade en la base de datos. Finalmente, el controlador consulta la información a la base de datos a través del modelo y la redirige a la vista participantes.php, mostrándose así el nuevo listado de participantes con el nuevo registro.</p>
						</div>
						<div>
							<h2>3. Permisos de la aplicación</h2>
							<p ALIGN="justify">La herramienta cuenta con dos tipos de roles, los cuales brindan una serie de permisos: el rol de admministrador, para los coordinadores deportivos, y el rol de usuario, para los participantes y voluntarios.</p>

							<h3>Administradores</h3>

							<p ALIGN="justify">En el caso de los administradores, tienen todos los permisos de inserción, consulta, actualización y borrado. Los coordinadores se autentican con su DNI y su contraseña. En primer lugar, en la pantalla de inicio se muestra un listado con las actividades más próximas a su realización. En la cabecera, y en todas las vistas, se encuentra un menú de navegación, donde se diferencian todas las secciones sobre las que se manejan datos (participantes, tutores, voluntarios, proyectos y patrocinadores). En cada una de ellas, pueden editar, borrar, añadir nuevos perfiles y obtener información más detallada sobre estos. Otra sección a comentar es la de actividades, que se encuentra dentro de proyectos, sobre la que se pueden realizar las mismas operaciones ya mencionadas.</p>

							<h3>Usuarios</h3>
							<p ALIGN="justify">Los usuarios también se autentican con su DNI y su contraseña. En primer lugar, se encuentran con una vista en la que aparecen sus inscripciones, en el caso de que sean participantes, o colaboraciones, en el caso de que sean voluntarios, y las actividades más próximas a su realización. En la cabecera, y en todas las vistas, disponen de un menú para ver su perfil, en el cual pueden ver y editar sus datos personales. Aquí también pueden consultar su historial de participación en actividades, así como los datos personales de su tutor legal en el caso de ser participantes. En dicho menú, también se encuentra un botón para ver todas las actividades próximas propuestas, sobre las que pueden actualizar su estado de interés en ellas de manera individual.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer">
		<p>&copy; 2019, Deporte y Desafío, IISSI-2</p>
	</div>
		
</body>
</html>