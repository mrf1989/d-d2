EXEC Registrar_Coordinador('45678934Y', 'María', 'Pérez López', '05/11/1991', 'C/ Tajo, 20, 5ºA', 'Madrid', 'Madrid', '28023', 'maperpez@gmail.com', '665453789','marpl45');
EXEC Registrar_Coordinador('23526642H', 'Daniel', 'Fernández Blanco', '03/06/1985', 'C/ Naranjo, 10, 3ºB', 'Madrid', 'Madrid', '28022', 'daniherbla85@gmail.com', '675990143','danielherbl5');

EXEC Registrar_Proyecto('45678934Y', 'Deportes de Raqueta', 'Sevilla Gym Center', 0, 1);
EXEC Registrar_Proyecto('23526642H', 'Descubre Madrid', 'Madrid', 1, 0);
EXEC Registrar_Proyecto('45678934Y', 'Deportes de Balón', 'Gimnasio GoFit, Barcelona', 0, 1);
EXEC Registrar_Proyecto('23526642H', 'Campamentos', 'Salamanca', 0, 1);
EXEC Registrar_Proyecto('45678934Y', 'VII PRO-AM Benéfico De Golf', 'Madrid', 1, 0);
EXEC Registrar_Proyecto('23526642H', 'Deportes Náuticos', 'Toledo', 0, 1);
EXEC Registrar_Proyecto('45678934Y', 'Relajacion y Bienestar', 'Cáceres', 0, 1);
EXEC Registrar_Proyecto('23526642H', 'Nieve', 'Barcelona', 0, 1);
EXEC Registrar_Proyecto('45678934Y', 'Caminando', 'Madrid', 0, 1);
EXEC Registrar_Proyecto('23526642H', 'Terapia Asistida Con Animales', 'Valencia', 0, 1);

EXEC Add_Actividad('Torneo Padel Adaptado', 'Pasar un buen dia con los participantes y enseñarles el deporte del pádel', '24/06/2019', '24/06/2019', 16, 'deportiva', 100, 1);
EXEC Add_Actividad('Torneo Tenis Adaptado', 'Introducir a los participantes en el deporte del tenis', '25/06/2019', '25/06/2019', 20, 'deportiva', 200, 1);
EXEC Add_Actividad('Ciclismo Adaptado', 'Ruta por las calles de Madrid', '01/07/2019', '01/07/2019', 30, 'deportiva', 300, 2);
EXEC Add_Actividad('Running Solidario', 'Carrera solidaria en Madrid', '02/07/2019', '02/07/2019', 50, 'social', 200, 2);
EXEC Add_Actividad('Senderismo', 'Conocer la naturaleza con los participantes', '04/07/2019', '04/07/2019', 20, 'social', 100, 9);
EXEC Add_Actividad('Baloncesto Adaptado', 'Introducción al baloncesto', '06/07/2019', '06/07/2019', 20, 'deportiva', 100, 3);
EXEC Add_Actividad('Fútbol Adaptado', 'Introducción al fútbol', '07/07/2019', '07/07/2019', 20, 'deportiva', 100, 3);
EXEC Add_Actividad('Campamentos Urbanos', 'Que los participantes se relaccionen entre si a traves de pequeñas actividades', '08/07/2019', '10/07/2019', 40, 'social', 400, 4);
EXEC Add_Actividad('Terapia Asistida Con Perros', 'Mostrar la importancia de los animales en para personas con discapacidad', '12/07/2019', '12/07/2019', 20, 'social', 40, 10);
EXEC Add_Actividad('Vela Adaptada', 'Introduccion a los participantes al deporte de vela', '14/07/2019', '15/07/2019', 15, 'deportiva', 300, 6);
EXEC Add_Actividad('Hipoterapia', 'Conectar a los participantes con los caballos', '18/07/2019', '18/07/2019', 25, 'social', 250, 10);
EXEC Add_Actividad('Buceo Adapatado', 'Introducir a los participantes en el maravilloso mundo submarino', '20/07/2019', '22/07/2019', 10, 'deportiva', 200, 6);
EXEC Add_Actividad('VII PRO-AM Benéfico De Golf', 'Relacionarse y conocer jugadores profesionales', '24/07/2019', '24/07/2019', 36, 'social', 400, 5);
EXEC Add_Actividad('Pilates', 'Mejorar el bienestar y la salud de los participantes', '27/07/2019', '27/07/2019', 30, 'deportiva', 100, 7);
EXEC Add_Actividad('Natación Adapatada', 'Introducción a la natación a los participantes', '05/08/2019', '05/08/2019', 30, 'deportiva', 300, 6);
EXEC Add_Actividad('Esqui Nautico', 'Introduccion a los participantes al deporte del esqui nautico', '20/08/2019', '23/08/2019', 15, 'deportiva', 150, 6);
EXEC Add_Actividad('Geocaching y Ecosenderismo', 'Varias jornadas de actividades al aire libre', '01/09/2019', '01/09/2019', 30, 'social',300 , 9);
EXEC Add_Actividad('Escuela Deportiva', 'Introduccion a varios deportes de raqueta', '15/09/2019', '15/09/2019', 30, 'deportiva', 200, 1);
EXEC Add_Actividad('Campamentos', 'Practicar diversos deportes de aventura para participantes jovenes', '10/10/2019', '15/10/2019', 30, 'social', 450, 4);
EXEC Add_Actividad('Esquí Alpino', 'Nueva edición de la actividad alpina', '15/11/2019', '15/11/2019', 30, 'deportiva', 600, 8);

EXEC Registrar_Patrocinador('B12572742', 'Santander, S.A', '912573080', 'Avda de Cantabria s/n', 'Boadilla del Monte, Madrid', 'Madrid', '28660', 'atenclie@gruposantander.com');
EXEC Registrar_Patrocinador('C72752756', 'Fundación Prosegur', '915898414', 'Calle Pajaritos 24', 'Madrid', 'Madrid', '28007', 'fundacion@prosegur.com');
EXEC Registrar_Patrocinador('R48945594', 'Fundación Jesús Serra', '683483495', 'Paseo de la Castellana, 1', 'Madrid', 'Madrid', '28046', 'cliente@jeserra.es');
EXEC Registrar_Patrocinador('T48125945', 'Telefónica Fundación', '900104870', 'Calle Gran Vía. 28 7 Planta', 'Madrid', 'Madrid', '28013', 'contacto@fundaciontelefonica.com');
EXEC Registrar_Patrocinador('Y84568218', 'Deutsche Bank, S.A', '902240028', 'Paseo de la Castellana, 18', 'Madrid', 'Madrid', '28046', 'deutsche.bank@db.com');
EXEC Registrar_Patrocinador('G78941564', 'La Caixa, S.A', '900323232', '	Paseo de la Castellana 51,', 'Madrid', 'Madrid', '28046', 'cliente@lacaixa.es');
EXEC Registrar_Patrocinador('H39489199', 'CETURSA Sierra Nevada, S.A', '958708090', 'Adalucía plaza 4', 'Sierra Nevada', 'Granada', '18196', 'sierranevada@cetursa.es');
EXEC Registrar_Patrocinador('N58121796', 'Fundación AON', '913405137', 'Calle Rosario Pino 14-16', 'Madrid', 'Madrid', '28020', 'cliente@aon.es');
EXEC Registrar_Patrocinador('U43259146', 'Bankia, S.A', '900103050', 'Paseo de la Castellana, 189', 'Madrid', 'Madrid', '28046', 'consultas@bankia.com');
EXEC Registrar_Patrocinador('L47528229', 'ElCorteingles, S.A', '914018500', 'Calle Hermosilla 112', 'Madrid', 'Madrid', '28009', 'comunicacionelcorteingles@elcorteingles.es');


EXEC Add_Patrocinio('C72752756', 1, 2000);
EXEC Add_Patrocinio('R48945594', 2, 2100);
EXEC Add_Patrocinio('T48125945', 3, 1000);
EXEC Add_Patrocinio('Y84568218', 4, 500);
EXEC Add_Patrocinio('G78941564', 5, 3000);
EXEC Add_Patrocinio('H39489199', 6, 200);
EXEC Add_Patrocinio('N58121796', 7, 250);
EXEC Add_Patrocinio('U43259146', 8, 700);
EXEC Add_Patrocinio('N58121796', 9, 240);
EXEC Add_Patrocinio('B12572742', 10, 600);
EXEC Add_Patrocinio('C72752756', 11, 750);
EXEC Add_Patrocinio('R48945594', 12, 500);
EXEC Add_Patrocinio('T48125945', 13, 1000);
EXEC Add_Patrocinio('Y84568218', 14, 200);
EXEC Add_Patrocinio('G78941564', 15, 300);
EXEC Add_Patrocinio('H39489199', 16, 170);
EXEC Add_Patrocinio('N58121796', 17, 1000);
EXEC Add_Patrocinio('L47528229', 18, 350);
EXEC Add_Patrocinio('U43259146', 19, 400);
EXEC Add_Patrocinio('L47528229', 20, 650);

