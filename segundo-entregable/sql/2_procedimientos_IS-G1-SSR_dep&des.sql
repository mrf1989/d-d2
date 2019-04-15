-------------------------------------------------------------------------------
-- Proyecto: Deporte y Desaf�o
-- ID Proyecto: IS-G1-SSR_dep&des
-- Grupo de trabajo:
-- Mario Ruano Fern�ndez
-- Mar�a Elena Molino Pe�a
-- Alejandro Jos� Mu�oz Aranda
-- Juan Carlos Cort�s Mu�oz

-- script: 2_procedimientos_IS-G1-SSR_dep&des.sql
-------------------------------------------------------------------------------

-------------------------------------------------------------------------------
-- FUNCIONES
-------------------------------------------------------------------------------

-- Funci�n auxiliar para pruebas de paquetes
CREATE OR REPLACE FUNCTION ASSERT_EQUALS (salida BOOLEAN, salida_esperada BOOLEAN)
RETURN VARCHAR2 AS 
BEGIN
    IF (salida = salida_esperada) THEN
        RETURN 'EXITO';
    ELSE
        RETURN 'FALLO';
    END IF;
END ASSERT_EQUALS;
/

-- Funci�n auxiliar para calcular precio de inscripci�n a actividad
CREATE OR REPLACE FUNCTION calcularCosteInscripcion (w_costeTotal IN ACTIVIDADES.costeTotal%TYPE, w_numeroPlazas IN ACTIVIDADES.numeroPlazas%TYPE)
RETURN NUMBER IS w_costeInscripcion ACTIVIDADES.costeInscripcion%TYPE;
BEGIN
    w_costeInscripcion := w_costeTotal / w_numeroPlazas;
RETURN (w_costeInscripcion);
END;
/

-- Funci�n auxiliar para calcular la fecha de vencimiento de pago de un recibo.
CREATE OR REPLACE FUNCTION calcularFechaVencimiento (w_fechaEmision IN RECIBOS.fechaEmision%TYPE)
RETURN DATE IS w_fechaVencimiento RECIBOS.fechaVencimiento%TYPE;
BEGIN
    SELECT ADD_MONTHS(w_fechaEmision, 2) INTO w_fechaVencimiento FROM DUAL;
RETURN (w_fechaVencimiento);
END;
/

-- Funci�n auxiliar para determinar si una persona es mayor de edad.
CREATE OR REPLACE FUNCTION esMayorDeEdad (w_fechaNacimiento DATE)
RETURN BOOLEAN IS
w_edad NUMBER;
BEGIN
    SELECT FLOOR(MONTHS_BETWEEN(SYSDATE, w_fechaNacimiento) / 12) INTO w_edad FROM DUAL;
    RETURN (w_edad >= 18);
END esMayorDeEdad;
/

-------------------------------------------------------------------------------
-- PROCEDIMIENTOS
-------------------------------------------------------------------------------
-------------------------------------------------------------------------------
-- 1. Asociados a personas
-- 2. Asociados a patrocinadores, patrocinios y donaciones
-- 3. Asociados a proyectos y actividades
-- 4. Asociados a recibos
-- 5. Asociados a inscripciones y colaboraciones
-- 6. Asociados a mensajes y env�os
-- 7. Asociados a informes m�dicos de participantes
-- 8. Asociados a cuestionarios
-------------------------------------------------------------------------------
-------------------------------------------------------------------------------
-- 1. Asociados a personas
-------------------------------------------------------------------------------

-- Registrar PERSONA en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Persona (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE, 
    w_pass IN PERSONAS.pass%TYPE) IS
BEGIN
    INSERT INTO PERSONAS (dni, nombre, apellidos, fechaNacimiento, direccion, localidad, provincia, codigoPostal,
        email, telefono, pass) VALUES (w_dni, w_nombre, w_apellidos, w_fechaNacimiento, w_direccion, w_localidad, 
        w_provincia, w_codigoPostal, w_email, w_telefono, w_pass);
    COMMIT WORK;
END Registrar_Persona;
/

-- Actualizar PERSONA en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_Persona (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE,
    w_pass IN PERSONAS.pass%TYPE) IS
BEGIN
    UPDATE PERSONAS SET nombre=w_nombre, apellidos=w_apellidos, fechaNacimiento=w_fechaNacimiento, direccion=w_direccion,
        localidad=w_localidad, provincia=w_provincia, codigoPostal=w_codigoPostal,email=w_email, telefono=w_telefono, pass=w_pass
    WHERE dni=w_dni;
    COMMIT WORK;
END Act_Persona;
/

-- Eliminar PERSONA (con efecto cascada) en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Eliminar_Persona (w_dni IN PERSONAS.dni%TYPE) IS
    dniPersona PERSONAS.dni%TYPE;
BEGIN
    SELECT dni INTO dniPersona FROM PERSONAS WHERE dni=w_dni;
    IF (dniPersona=w_dni) THEN
        DELETE FROM PERSONAS WHERE dni=w_dni;
    END IF;
    COMMIT WORK;
END Eliminar_Persona;
/

-- Registrar COORDINADOR en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Coordinador (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE,
    w_pass IN personas.pass%TYPE) IS
BEGIN
    Registrar_Persona(w_dni, w_nombre, w_apellidos, w_fechaNacimiento, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, w_telefono, w_pass);
    INSERT INTO COORDINADORES (dni) VALUES (w_dni);
    COMMIT WORK;
END Registrar_Coordinador;
/

-- Registrar VOLUNTARIO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Voluntario (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE,
    w_pass IN personas.pass%TYPE) IS
BEGIN
    Registrar_Persona(w_dni, w_nombre, w_apellidos, w_fechaNacimiento, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, w_telefono, w_pass);
    INSERT INTO VOLUNTARIOS (dni, prioridadParticipacion) VALUES (w_dni, 'baja');
    COMMIT WORK;
END Registrar_Voluntario;
/

-- Registrar TUTOR LEGAL en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_TutorLegal (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE,
    w_pass IN personas.pass%TYPE) IS
BEGIN
    Registrar_Persona(w_dni, w_nombre, w_apellidos, w_fechaNacimiento, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, w_telefono, w_pass);
    INSERT INTO TUTORESLEGALES (dni) VALUES (w_dni);
    COMMIT WORK;
END Registrar_TutorLegal;
/

-- Registrar PARTICIPANTE en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Participante (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PERSONAS.nombre%TYPE,
    w_apellidos IN PERSONAS.apellidos%TYPE, w_fechaNacimiento IN PERSONAS.fechaNacimiento%TYPE, w_direccion IN
    PERSONAS.direccion%TYPE, w_localidad IN PERSONAS.localidad%TYPE, w_provincia IN PERSONAS.provincia%TYPE,
    w_codigoPostal IN PERSONAS.codigoPostal%TYPE, w_email IN PERSONAS.email%TYPE, w_telefono IN PERSONAS.telefono%TYPE,
    w_pass IN personas.pass%TYPE, w_gradoDiscapacidad IN PARTICIPANTES.gradoDiscapacidad%TYPE, w_dniVol IN VOLUNTARIOS.dni%TYPE, w_dniTut IN TUTORESLEGALES.dni%TYPE) IS
    w_OID_Vol INTEGER;
    w_OID_Tut INTEGER;
BEGIN
    IF w_dniVol IS NOT NULL AND w_dniTut IS NOT NULL THEN
        SELECT OID_Tut INTO w_OID_Tut FROM TUTORESLEGALES WHERE dni=w_dniTut;
        SELECT OID_Vol INTO w_OID_Vol FROM VOLUNTARIOS WHERE dni=w_dniVol;
    ELSIF w_dniTut IS NOT NULL AND w_dniVol IS NULL THEN
        w_OID_Vol:=NULL;
        SELECT OID_Tut INTO w_OID_Tut FROM TUTORESLEGALES WHERE dni=w_dniTut;
    ELSIF w_dniVol IS NOT NULL AND w_dniTut IS NULL THEN
        w_OID_Tut:=NULL;
        SELECT OID_Vol INTO w_OID_Vol FROM VOLUNTARIOS WHERE dni=w_dniVol;
    ELSE
        w_OID_Vol:=NULL;
        w_OID_Tut:=NULL;
    END IF;
    Registrar_Persona(w_dni, w_nombre, w_apellidos, w_fechaNacimiento, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, w_telefono, w_pass);
    INSERT INTO PARTICIPANTES (dni, gradoDiscapacidad, prioridadParticipacion, OID_Vol, OID_Tut)
        VALUES (w_dni, w_gradoDiscapacidad, 'alta', w_OID_Vol, w_OID_Tut);
    COMMIT WORK;
END Registrar_Participante;
/

-------------------------------------------------------------------------------
-- 2. Asociados a patrocinadores, patrocinios y donaciones
-------------------------------------------------------------------------------

-- Registrar INSTITUCION en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Institucion (w_cif IN INSTITUCIONES.cif%TYPE, w_nombre IN INSTITUCIONES.nombre%TYPE,
    w_telefono IN INSTITUCIONES.telefono%TYPE, w_direccion IN INSTITUCIONES.direccion%TYPE, w_localidad IN INSTITUCIONES.localidad%TYPE,
    w_provincia IN INSTITUCIONES.provincia%TYPE, w_codigoPostal IN INSTITUCIONES.codigoPostal%TYPE, w_email IN INSTITUCIONES.email%TYPE) IS
BEGIN
    INSERT INTO INSTITUCIONES VALUES (w_cif, w_nombre, w_telefono, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, 0, null);
    COMMIT WORK;
END Registrar_Institucion;
/

-- Actualizar INSTITUCION en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_Institucion (w_cif IN INSTITUCIONES.cif%TYPE, w_nombre IN INSTITUCIONES.nombre%TYPE,
    w_telefono IN INSTITUCIONES.telefono%TYPE, w_direccion IN INSTITUCIONES.direccion%TYPE, w_localidad IN INSTITUCIONES.localidad%TYPE,
    w_provincia IN INSTITUCIONES.provincia%TYPE, w_codigoPostal IN INSTITUCIONES.codigoPostal%TYPE, w_email IN INSTITUCIONES.email%TYPE) IS
    cifPatrocinador INSTITUCIONES.cif%TYPE;
BEGIN
    SELECT cif INTO cifPatrocinador FROM INSTITUCIONES WHERE cif=w_cif;
    IF (cifPatrocinador=w_cif) THEN
        UPDATE INSTITUCIONES SET nombre=w_nombre, telefono=w_telefono, direccion=w_direccion, localidad=w_localidad, provincia=w_provincia,
            codigoPostal=w_codigoPostal, email=w_email WHERE cif=w_cif;
    END IF;
    COMMIT WORK;
    
    EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No existe la instituci�n con CIF: ' || w_cif);
    ROLLBACK;
END Act_Institucion;
/

-- Eliminar INSTITUCION en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Eliminar_Institucion (w_cif IN INSTITUCIONES.cif%TYPE) IS
    cifPatrocinador INSTITUCIONES.cif%TYPE;
BEGIN
    SELECT cif INTO cifPatrocinador FROM INSTITUCIONES WHERE cif=w_cif;
    IF (cifPatrocinador=w_cif) THEN
        DELETE FROM INSTITUCIONES WHERE cif=w_cif;
    END IF;
    COMMIT WORK;
    
    EXCEPTION
    WHEN OTHERS THEN
        DBMS_OUTPUT.PUT_LINE('No existe la instituci�n con CIF: ' || w_cif);
    ROLLBACK;
END Eliminar_Institucion;
/

-- Registrar PATROCINADOR en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Patrocinador (w_cif IN INSTITUCIONES.cif%TYPE, w_nombre IN INSTITUCIONES.nombre%TYPE,
    w_telefono IN INSTITUCIONES.telefono%TYPE, w_direccion IN INSTITUCIONES.direccion%TYPE, w_localidad IN INSTITUCIONES.localidad%TYPE,
    w_provincia IN INSTITUCIONES.provincia%TYPE, w_codigoPostal IN INSTITUCIONES.codigoPostal%TYPE, w_email IN INSTITUCIONES.email%TYPE) IS
BEGIN
    INSERT INTO INSTITUCIONES VALUES (w_cif, w_nombre, w_telefono, w_direccion, w_localidad, w_provincia, w_codigoPostal, w_email, 1, null);
    COMMIT WORK;
END Registrar_Patrocinador;
/

-- A�adir PATROCINIO a ACTIVIDAD en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Add_Patrocinio (w_cif IN INSTITUCIONES.cif%TYPE, w_OID_Act IN ACTIVIDADES.OID_Act%TYPE,
    w_cantidad IN PATROCINIOS.cantidad%TYPE) IS
BEGIN
    INSERT INTO PATROCINIOS(cif, OID_Act, cantidad) VALUES (w_cif, w_OID_Act, w_cantidad);
    COMMIT WORK;
END Add_Patrocinio;
/

-- Registrar DONACION en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Donacion (w_dni IN PERSONAS.dni%TYPE, w_cif IN INSTITUCIONES.cif%TYPE, w_nombre IN TIPODONACIONES.nombre%TYPE,
    w_tipoUnidad IN TIPODONACIONES.tipoUnidad%TYPE, w_cantidad IN DONACIONES.cantidad%TYPE, w_valorUnitario IN DONACIONES.valorUnitario%TYPE) IS
    tipoDonacion TIPODONACIONES%ROWTYPE;
    w_OID_TDon INTEGER;
BEGIN
    SELECT OID_TDon INTO w_OID_TDon FROM TIPODONACIONES WHERE nombre=w_nombre AND tipoUnidad=w_tipoUnidad;
    IF (w_OID_TDon>0) THEN
        INSERT INTO DONACIONES(fecha, cantidad, valorUnitario, dni, cif, OID_TDon) VALUES (SYSDATE, w_cantidad, w_valorUnitario, w_dni, w_cif, w_OID_TDon);
    END IF;
    COMMIT WORK;
    
    EXCEPTION
    WHEN OTHERS THEN
        INSERT INTO TIPODONACIONES(nombre, tipoUnidad) VALUES (w_nombre, w_tipoUnidad);
        SELECT OID_TDon INTO w_OID_TDon FROM TIPODONACIONES WHERE nombre=w_nombre AND tipoUnidad=w_tipoUnidad;
        INSERT INTO DONACIONES(fecha, cantidad, valorUnitario, dni, cif, OID_TDon) VALUES (SYSDATE, w_cantidad, w_valorUnitario, w_dni, w_cif, w_OID_TDon);
    COMMIT WORK;
END Registrar_Donacion;
/

-------------------------------------------------------------------------------
-- 3. Asociados a proyectos y actividades
-------------------------------------------------------------------------------

-- Registrar PROYECTO por un COORDINADOR en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Proyecto (w_dni IN PERSONAS.dni%TYPE, w_nombre IN PROYECTOS.nombre%TYPE, w_ubicacion IN PROYECTOS.ubicacion%TYPE,
    w_esEvento IN PROYECTOS.esEvento%TYPE, w_esProgDep IN PROYECTOS.esProgDep%TYPE) IS
    w_OID_Coord INTEGER;
    w_OID_Proj INTEGER;
BEGIN
    INSERT INTO PROYECTOS(nombre, ubicacion, esEvento, esProgDep) VALUES (w_nombre, w_ubicacion, w_esEvento, w_esProgDep);
    w_OID_Proj := SEC_Proj.CURRVAL;
    w_OID_Coord := SEC_Coord.CURRVAL;
    INSERT INTO ENCARGADOS(OID_Proj, OID_Coord) VALUES (w_OID_Proj, w_OID_Coord);
    COMMIT WORK;
END Registrar_Proyecto;
/

-- A�ADIR ACTIVIDAD a PROYECTO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Add_Actividad (w_nombre IN ACTIVIDADES.nombre%TYPE, w_objetivo IN ACTIVIDADES.objetivo%TYPE,
    w_fechaInicio IN ACTIVIDADES.fechaInicio%TYPE, w_fechaFin IN ACTIVIDADES.fechaFin%TYPE, w_numeroPlazas IN ACTIVIDADES.numeroPlazas%TYPE,
    w_tipo IN ACTIVIDADES.tipo%TYPE, w_costeTotal IN ACTIVIDADES.costeTotal%TYPE, w_OID_Proj IN ACTIVIDADES.OID_Proj%TYPE) IS
    w_costeInscripcion ACTIVIDADES.costeInscripcion%TYPE;
BEGIN
    w_costeInscripcion := calcularCosteInscripcion(w_costeTotal, w_numeroPlazas);
    INSERT INTO ACTIVIDADES(OID_Proj, nombre, objetivo, fechaInicio, fechaFin, numeroPlazas, voluntariosRequeridos, tipo, costeTotal, costeInscripcion)
    VALUES (w_OID_Proj, w_nombre, w_objetivo, w_fechaInicio, w_fechaFin, w_numeroPlazas, 0, w_tipo, w_costeTotal, w_costeInscripcion);
    COMMIT WORK;
END Add_Actividad;
/

-------------------------------------------------------------------------------
-- 4. Asociados a recibos
-------------------------------------------------------------------------------

-- Registrar RECIBO de INSCRIPCION en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Add_ReciboInscripcion (w_OID_Act IN ACTIVIDADES.OID_Act%TYPE, w_OID_Part IN PARTICIPANTES.OID_Part%TYPE,
    w_fechaEmision IN RECIBOS.fechaEmision%TYPE, w_importe IN RECIBOS.importe%TYPE, w_estado IN RECIBOS.estado%TYPE) IS
    w_fechaVencimiento RECIBOS.fechaVencimiento%TYPE;
BEGIN
    w_fechaVencimiento := calcularFechaVencimiento(w_fechaEmision);
    INSERT INTO RECIBOS (fechaEmision, fechaVencimiento, importe, estado, OID_Act, OID_Part)
    VALUES (w_fechaEmision, w_fechaVencimiento, w_importe, w_estado, w_OID_Act, w_OID_Part);
    COMMIT WORK;
END Add_ReciboInscripcion;
/

-- Actualizar RECIBO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_Recibo (w_OID_Rec IN RECIBOS.OID_Rec%TYPE, w_fechaVencimiento IN RECIBOS.fechaVencimiento%TYPE,
    w_importe IN RECIBOS.importe%TYPE, w_estado IN RECIBOS.estado%TYPE) IS
BEGIN
    UPDATE RECIBOS SET fechaVencimiento=w_fechaVencimiento, importe=w_importe, estado=w_estado WHERE OID_Rec=w_OID_Rec;
    COMMIT WORK;
END Act_Recibo;
/

-- Cambiar estado de RECIBO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_EstadoRecibo (w_OID_Rec IN RECIBOS.OID_Rec%TYPE, w_estado IN RECIBOS.estado%TYPE) IS
BEGIN
    UPDATE RECIBOS SET estado=w_estado WHERE OID_Rec=w_OID_Rec;
    COMMIT WORK;
END Act_EstadoRecibo;
/

-------------------------------------------------------------------------------
-- 5. Asociados a inscripciones y colaboraciones
-------------------------------------------------------------------------------

-- Inscribir PARTICIPANTE en ACTIVIDAD en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Inscribir_Participante (w_dni IN PERSONAS.dni%TYPE, w_OID_Act IN ACTIVIDADES.OID_Act%TYPE) IS
w_OID_Part PARTICIPANTES.OID_Part%TYPE;
w_importe RECIBOS.importe%TYPE;
w_OID_Rec RECIBOS.OID_Rec%TYPE;
w_OID_Ins INSCRIPCIONES.OID_Ins%TYPE;
BEGIN
    SELECT OID_Part INTO w_OID_Part FROM PARTICIPANTES WHERE dni=w_dni;
    SELECT costeInscripcion INTO w_importe FROM ACTIVIDADES WHERE OID_Act=w_OID_Act;
    IF (w_importe<>0) THEN
        INSERT INTO INSCRIPCIONES(OID_Part, OID_Act, OID_Rec) VALUES (w_OID_Part, w_OID_Act, null);
        Add_ReciboInscripcion(w_OID_Act,w_OID_Part,SYSDATE,w_importe,'pendiente');
        SELECT OID_Rec INTO w_OID_Rec FROM RECIBOS WHERE OID_Act=w_OID_Act AND OID_Part=w_OID_Part;
        w_OID_Ins:=SEC_Ins.CURRVAL;
        UPDATE INSCRIPCIONES SET OID_Rec = w_OID_Rec WHERE OID_Ins=w_OID_Ins;    
    ELSE
        INSERT INTO INSCRIPCIONES(OID_Part, OID_Act, OID_Rec) VALUES (w_OID_Part, w_OID_Act, null);
    END IF;
    COMMIT WORK;
END Inscribir_Participante;
/

-- Inscribir VOLUNTARIO en ACTIVIDAD en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Inscribir_Voluntario (w_dni IN PERSONAS.dni%TYPE, w_OID_Act IN ACTIVIDADES.OID_Act%TYPE) IS
w_OID_Vol VOLUNTARIOS.OID_Vol%TYPE;
BEGIN
    SELECT OID_Vol INTO w_OID_Vol FROM VOLUNTARIOS WHERE dni=w_dni;
    INSERT INTO COLABORACIONES(OID_Vol, OID_Act) VALUES (w_OID_Vol, w_OID_Act);
    COMMIT WORK;
END Inscribir_Voluntario;
/

-- Actualizar ESTADO DE INTERES de un VOLUNTARIO en una ACTIVIDAD en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_InteresVoluntariado (w_dni IN VOLUNTARIOS.dni%TYPE, w_OID_Act IN ACTIVIDADES.OID_Act%TYPE,
w_estado IN ESTAINTERESADOEN.estado%TYPE) IS
w_OID_Vol VOLUNTARIOS.OID_Vol%TYPE;
BEGIN
    SELECT OID_Vol INTO w_OID_Vol FROM VOLUNTARIOS WHERE dni=w_dni;
    UPDATE ESTAINTERESADOEN SET estado = w_estado WHERE OID_Vol=w_OID_Vol AND OID_Act=w_OID_Act;
    COMMIT WORK;
END Act_InteresVoluntariado;
/

-- Actualizar ESTADO DE INTERES de un PARTICIPANTE en una ACTIVIDAD en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Act_InteresParticipante (w_dni IN PARTICIPANTES.dni%TYPE, w_OID_Act IN ACTIVIDADES.OID_Act%TYPE,
w_estado IN ESTAINTERESADOEN.estado%TYPE) IS
w_OID_Part PARTICIPANTES.OID_Part%TYPE;
BEGIN
    SELECT OID_Part INTO w_OID_Part FROM PARTICIPANTES WHERE dni=w_dni;
    UPDATE ESTAINTERESADOEN SET estado = w_estado WHERE OID_Part=w_OID_Part AND OID_Act=w_OID_Act;
    COMMIT WORK;
END Act_InteresParticipante;
/

-------------------------------------------------------------------------------
-- 6. Asociados a mensajes y env�os
-------------------------------------------------------------------------------

-- Registrar MENSAJE en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Mensaje (w_tipo IN MENSAJES.tipo%TYPE, w_fechaEnvio IN MENSAJES.fechaEnvio%TYPE,
    w_asunto IN MENSAJES.asunto%TYPE, w_contenido IN MENSAJES.contenido%TYPE, w_OID_Coord IN COORDINADORES.OID_Coord%TYPE) IS
BEGIN
    INSERT INTO MENSAJES (tipo, fechaEnvio, asunto, contenido, OID_Coord) VALUES (w_tipo, w_fechaEnvio, w_asunto, w_contenido, w_OID_Coord);
    COMMIT WORK;
END Registrar_Mensaje;
/

-- Registrar ENVIO de MENSAJE en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Envio (w_dni IN PERSONAS.dni%TYPE, w_cif IN INSTITUCIONES.cif%TYPE,
    w_OID_M IN MENSAJES.OID_M%TYPE) IS
BEGIN
    INSERT INTO ENVIOS (OID_M, dni, cif) VALUES (w_OID_M, w_dni, w_cif);
    COMMIT WORK;
END Registrar_Envio;
/

-------------------------------------------------------------------------------
-- 7. Asociados a informes m�dicos de participantes
-------------------------------------------------------------------------------

-- A�adir INFORME MEDICO a un PARTICIPANTE en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Add_InformeMedico (w_OID_Part IN INFORMESMEDICOS.OID_Part%TYPE, w_descripcion IN INFORMESMEDICOS.descripcion%TYPE) IS
BEGIN
    INSERT INTO INFORMESMEDICOS (descripcion, fecha, OID_Part) VALUES (w_descripcion, SYSDATE, w_OID_Part);
    COMMIT WORK;
END Add_InformeMedico;
/

-------------------------------------------------------------------------------
-- 8. Asociados a cuestionarios
-------------------------------------------------------------------------------

-- Registrar PREGUNTA en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Pregunta (w_tipo IN PREGUNTAS.tipo%TYPE, w_enunciado IN PREGUNTAS.enunciado%TYPE) IS
BEGIN
    INSERT INTO PREGUNTAS (tipo, enunciado) VALUES (w_tipo, w_enunciado);
    COMMIT WORK;
END Registrar_Pregunta;
/

-- Registrar CUESTIONARIO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Registrar_Cuestionario (w_OID_Act IN CUESTIONARIOS.OID_Act%TYPE) IS
BEGIN
    INSERT INTO CUESTIONARIOS (fechaCreacion, OID_Act) VALUES (SYSDATE, w_OID_Act);
    COMMIT WORK;
END Registrar_Cuestionario;
/

-- A�adir PREGUNTA a CUESTIONARIO en el sistema de informaci�n
CREATE OR REPLACE PROCEDURE Add_Formulario (w_OID_Q IN PREGUNTAS.OID_Q%TYPE, w_OID_Cues IN CUESTIONARIOS.OID_Cues%TYPE) IS
BEGIN
    INSERT INTO FORMULARIOS (OID_Cues, OID_Q) VALUES (w_OID_Cues, w_OID_Q);
    COMMIT WORK;
END Add_Formulario;
/

-- Registrar RESPUESTA a PREGUNTA de un CUESTIONARIO
CREATE OR REPLACE PROCEDURE Registrar_Respuesta (w_OID_Vol IN VOLUNTARIOS.OID_Vol%TYPE, w_OID_Part IN PARTICIPANTES.OID_Part%TYPE,
    w_OID_Form IN FORMULARIOS.OID_Form%TYPE, w_contenido IN RESPUESTAS.contenido%TYPE) IS
BEGIN
    INSERT INTO RESPUESTAS (OID_Vol, OID_Part, OID_Form, contenido) VALUES (w_OID_Vol, w_OID_Part, w_OID_Form, w_contenido);
    COMMIT WORK;
END Registrar_Respuesta;
/

-- Actualizar PREGUNTA de un CUESTIONARIO
CREATE OR REPLACE PROCEDURE Act_Pregunta (w_OID_Cues IN CUESTIONARIOS.OID_Cues%TYPE, w_OID_Q IN PREGUNTAS.OID_Q%TYPE,
    w_tipo IN PREGUNTAS.tipo%TYPE, w_enunciado IN PREGUNTAS.enunciado%TYPE) IS
    w_OID_Form FORMULARIOS.OID_Form%TYPE;
    n_OID_Q PREGUNTAS.OID_Q%TYPE;
BEGIN
    SELECT OID_Form INTO w_OID_Form FROM FORMULARIOS WHERE OID_Cues=w_OID_Cues AND OID_Q=w_OID_Q;
    Registrar_Pregunta(w_tipo, w_enunciado);
    n_OID_Q := SEC_Q.CURRVAL;
    UPDATE FORMULARIOS SET OID_Q=n_OID_Q WHERE OID_Form=w_OID_Form AND OID_Cues=w_OID_Cues;
    COMMIT WORK;
END Act_Pregunta;
/
