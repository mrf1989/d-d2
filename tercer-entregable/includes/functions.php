<?php
// retorna la fecha apta para usar en un input[type=date], 2001-02-01
function getFechaForm($fecha){
	$fechaNacimiento = date_create_from_format('j/m/y', $fecha);
    return date_format($fechaNacimiento, 'Y-m-d');
}
// retorna la fecha apta para ser usada en Oracle SQL, 01/02/2001
function getFechaBD($fecha) {
	$fechaNacimiento = date('d/m/Y', strtotime($fecha));
	return $fechaNacimiento;
}
function formatFecha($fecha){
	$fechaNacimiento = date_create_from_format('d/m/Y', $fecha);
	return date_format($fechaNacimiento, "Y/m/d");
}
function getFechaFormatView($fecha){
	$fechaNacimiento = date_create_from_format('d/m/y', $fecha);
	return date_format($fechaNacimiento, "d/m/Y");
}

?>