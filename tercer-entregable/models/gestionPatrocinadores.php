<?php

function getPatrocinadores($conexion) {
    try {
        $consulta = "SELECT * FROM INSTITUCIONES WHERE espatrocinador = 1";
        $stmt = $conexion->query($consulta);
        return $stmt;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function getAllPatrocinadores() {
    $query = "SELECT * FROM INSTITUCIONES WHERE espatrocinador = 1";
    return $query;
}

function getPatrocinador($conexion, $cif) {
    try {
        $consulta = "SELECT * FROM INSTITUCIONES WHERE espatrocinador = 1 AND CIF =:cif";
        $stmt = $conexion->prepare($consulta);
        $stmt->bindParam(':cif', $cif);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function insertarPatrocinador($conexion, $pat) {
    try {
        $stmt = $conexion->prepare("CALL REGISTRAR_PATROCINADOR(:cif, :nombre, :telefono, :direccion, :localidad, :provincia, :cp, :email)");
        $stmt->bindParam(':cif', $pat["cif"]);
        $stmt->bindParam(':nombre', $pat["nombre"]);
        $stmt->bindParam(':telefono', $pat["telefono"]);
        $stmt->bindParam(':direccion', $pat["direccion"]);
        $stmt->bindParam(':localidad', $pat["localidad"]);
        $stmt->bindParam(':provincia', $pat["provincia"]);
        $stmt->bindParam(':cp', $pat["cp"]);
        $stmt->bindParam(':email', $pat["email"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../execepion.php");
    }
}

function actualizarPatrocinador($conexion, $pat) {
    try {
        $stmt = $conexion->prepare("CALL ACT_INSTITUCION(:cif, :nombre, :telefono, :direccion, :localidad, :provincia, :cp, :email)");
        $stmt->bindParam(':cif', $pat["cif"]);
        $stmt->bindParam(':nombre', $pat["nombre"]);
        $stmt->bindParam(':telefono', $pat["telefono"]);
        $stmt->bindParam(':direccion', $pat["direccion"]);
        $stmt->bindParam(':localidad', $pat["localidad"]);
        $stmt->bindParam(':provincia', $pat["provincia"]);
        $stmt->bindParam(':cp', $pat["cp"]);
        $stmt->bindParam(':email', $pat["email"]);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}

function eliminarPatrocinador($conexion, $cif) {
    try {
        $stmt = $conexion->prepare("CALL ELIMINAR_INSTITUCION(:cif)");
        $stmt->bindParam(':cif', $cif);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        $_SESSION["excepcion"] = $e->GetMessage();
        Header("Location: ../excepcion.php");
    }
}
?>