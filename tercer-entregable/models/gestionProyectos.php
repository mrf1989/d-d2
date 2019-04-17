<?php

function getAllProyectos() {
    $query = "SELECT P.NOMBRE AS P_NOMBRE, A.NOMBRE AS A_NOMBRE, A.FECHAINICIO, P.OID_PROJ, P.UBICACION, P.ESEVENTO, P.ESPROGDEP FROM PROYECTOS P LEFT JOIN ACTIVIDADES A ON P.OID_Proj=A.OID_Proj ORDER BY A.fechainicio ASC";
    return $query;
}

function getProyecto($conexion, $oid_proj) {
    try {
        $consulta = "SELECT * FROM PROYECTOS WHERE OID_PROJ =:oid_proj";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':oid_proj', $oid_proj);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        return $_SESSION["excepcion"];
    }
}

?>