<?php

function getProximasActividades($conexion) {
    try {
        $consulta = "SELECT NOMBRE, PROJ_LUGAR, FECHAINICIO, OID_ACT FROM (SELECT P.nombre AS Proj_nombre, P.ubicacion AS Proj_lugar, A.* FROM PROYECTOS P LEFT JOIN ACTIVIDADES A ON P.OID_Proj=A.OID_Proj WHERE A.fechainicio >= (SYSDATE + 5) ORDER BY A.fechainicio ASC) WHERE ROWNUM <= 5";
        $stmt = $conexion->query($consulta);
        return $stmt;
    } catch (PDOException $e) {
        return 0;
    }
}

function getActividad($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM ACTIVIDADES WHERE OID_ACT =:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getInscripciones($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM PERSONAS P JOIN PARTICIPANTES PART ON P.dni=PART.dni JOIN INSCRIPCIONES INS ON PART.OID_Part=INS.OID_Part WHERE INS.OID_Act=:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getColaboraciones($conexion, $oid_act) {
    $consulta = "SELECT * FROM PERSONAS P JOIN VOLUNTARIOS VOL ON P.dni=VOL.dni JOIN COLABORACIONES COLAB ON VOL.OID_Vol=COLAB.OID_Vol WHERE COLAB.OID_Act=:oid_act";
    try {
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function getPatrocinios($conexion, $oid_act) {
    try {
        $consulta = "SELECT * FROM INSTITUCIONES INS JOIN PATROCINIOS FIN ON INS.cif=FIN.cif WHERE OID_Act=:oid_act";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_act', $oid_act);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

function inscribirParticipante($conexion, $inscripcion) {
    try {
        $stmt = $conexion->prepare("CALL INSCRIBIR_PARTICIPANTE(:dni, :oid_act)");
        $stmt->bindParam(':dni', $inscripcion["dni"]);
        $stmt->bindParam(':oid_act', $inscripcion["oid_act"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

function inscribirVoluntario($conexion, $inscripcion) {
    try {
        $stmt = $conexion->prepare("CALL INSCRIBIR_VOLUNTARIO(:dni, :oid_act)");
        $stmt->bindParam(':dni', $inscripcion["dni"]);
        $stmt->bindParam(':oid_act', $inscripcion["oid_act"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}

function addPatrocinio($conexion, $patrocinio) {
    try {
        $stmt = $conexion->prepare("CALL ADD_PATROCINIO(:cif, :oid_act, :cantidad)");
        $stmt->bindParam(':cif', $patrocinio["cif"]);
        $stmt->bindParam(':oid_act', $patrocinio["oid_act"]);
        $stmt->bindParam(':cantidad', $patrocinio["cantidad"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->getMessage();
        Header("Location: ../excepcion.php");
    }
}
function validarAltaActividad($actividad){
    //validar nombre 
    if ($actividad["nombre"]=="") {
        $errores[] = "<p>El nombre de la actividad debe completarse</p>";
    }
    //validar número de plazas
    if ($actividad["numeroplazas"]=="") {
        $errores[]="<p>El numero de plazas debe indicarse</p>";
    }elseif (is_int($actividad["numeroplazas"])) {
        $errores[]="<p>El numero de plazas :". $actividad["numeroplazas"] ." debe ser un entero</p>";
    }
    //validar tipo actividad
    if ($actividad["tipo"]=="") {
        $errores[]="<p>El tipo de actividad debe completarse";
    }elseif (!($actividad["tipo"] == "deportiva" || $actividad["tipo"] == "formativa" || $actividad["tipo"] = "social")) {
        $errores[]="<p>El tipo de actividad: ". $actividad["tipo"] . " no es correcto</p>";
    }

   

    $fechaActual = strtotime("now");
    $fechaInicio = strtotime($actividad["fechainicio"]);
    $fechaFin = strtotime($actividad["fechafin"]);

    //validar fecha inicio
    if ($actividad["fechainicio"]=="") {
        $errores[]="<p>La fecha de inicio debe completarse</p>";
    } elseif ($fechaActual > $fechaInicio){ 
        $errores[]="<p>La fecha: ". $actividad["fechainicio"]. " no puede ser anterior a la fecha actual</p>";
    }
    //validar fecha fin
    if ($actividad["fechafin"]=="") {
        $errores[]="<p>La fecha de fin debe completarse</p>";
    }elseif ($fechaActual > $fechaFin){
        $errores[]="<p>La fecha de fin: ". $actividad["fechafin"]. " no puede ser anterior a la fecha actual</p>";
    }
    //Comprobar si fecha inicio es anterior que fecha fin
    if ($fechaInicio > $fechaFin) {
        $errores[]="<p>La fecha de inicio no puede ser posterior a la fecha de fin</p>";
    }


    //Validar coste total
    if ($actividad["costetotal"]=="") {
        $errores[]="<p>El coste total debe indicarse</p>";
    }elseif (is_int($actividad["costetotal"])) {
        $errores[]="<p>El coste total :". $actividad["costetotal"] ." debe ser un entero</p>";
    }
    //Validar objetivo
    if ($actividad["objetivo"]=="") {
        $errores[]="<p>El objetivo de la actividad debe completarse</p>";
    }
    return $errores;
}

function validarVoluntariado($colaboracion, $colaboradores){
    if(count($colaboradores) > 0){
        foreach ($colaboradores as $col) {
            if($colaboracion["dni"] == $col["DNI"]){
                $errores[] = "<p>El voluntario con dni " . $col["DNI"] ." ya está inscrito</p>";
            }
        }
    }

    return $errores;
}

function validarInscripcion($inscripcion, $inscritos){
    if(count($inscritos) > 0){
        foreach ($inscritos as $ins) {
            if($inscripcion["dni"] == $ins["DNI"]){
                $errores[] = "<p>El participante con dni " . $ins["DNI"] ." ya está inscrito</p>";
            }
        }
    }

    return $errores;
}

function validarPatrocinio($patrocinio, $patrocinadores){
    if(count($patrocinadores) > 0){
        foreach ($patrocinadores as $pat) {
            if($patrocinio["cif"] == $pat["CIF"]){
                $errores[] = "<p>El patrocinador con cif " . $pat["CIF"] ." ya está inscrito</p>";
            }
        }
    }

    return $errores;
}


?>
