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

?>