function validarPersona() {
    // Expresiones regulares
    var rxNombre = /[^a-zñáéíóúA-ZÑÁÉÍÓÚ\s]/;
    var rxEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var rxDni = /[0-9]{8}[A-ZÑ]{1}$/;
    var rxTlf = /[0-9]{9}$/;
    var rxCp = /[0-9]{5}$/;

    var nombre = document.getElementById('nombre');
    var apellidos = document.getElementById('apellidos');
    var email = document.getElementById('email');
    var dni = document.getElementById('dni');
    var tlf = document.getElementById('telefono');
    var cp = document.getElementById('cp');

    var res = true;

    // validación nombre
    if ($('#nombre').val().trim() == "") {
        nombre.setCustomValidity("Introduzca un nombre");
        res = false;
    } else if (rxNombre.test($('#nombre').val().trim())) {
        nombre.setCustomValidity("Introduzca un nombre correcto");
        res = false;
    } else {
        nombre.setCustomValidity("");
    }
    // validación apellido
    if ($('#apellidos').val().trim() == "") {
        apellidos.setCustomValidity("Introduzca los apellidos");
        res = false;
    } else if (rxNombre.test($('#apellidos').val().trim())) {
        apellidos.setCustomValidity("Introduzca unos apellidos correctos");
        res = false;
    } else {
        apellidos.setCustomValidity("");
    }
    // validación email
    if ($('#email').val().trim() == "") {
        email.setCustomValidity("Introduzca un email");
        res = false;
    } else if (!rxEmail.test($('#email').val().trim())) {
        email.setCustomValidity("Introduzca un email correcto");
        res = false;
    } else {
        email.setCustomValidity("");
    }
    // validación dni
    if ($('#dni').val().trim() == "") {
        dni.setCustomValidity("Introduzca un dni");
        res = false;
    } else if (!rxDni.test($('#dni').val().trim())) {
        dni.setCustomValidity("Introduzca un dni correcto");
        res = false;
    } else {
        dni.setCustomValidity("");
    }
    // validación tlf
    if ($('#telefono').val().trim() == "") {
        tlf.setCustomValidity("Introduzca un telefono");
        res = false;
    } else if (!rxTlf.test($('#telefono').val().trim())) {
        tlf.setCustomValidity("Introduzca un telefono correcto");
        res = false;
    } else {
        tlf.setCustomValidity("");
    }
    // validación cp
    if ($('#cp').val().trim() == "") {
        cp.setCustomValidity("Introduzca un código postal");
        res = false;
    } else if (!rxCp.test($('#cp').val().trim())) {
        cp.setCustomValidity("Introduzca un código postal correcto");
        res = false;
    } else {
        cp.setCustomValidity("");
    }
    return res;
}

function validarParticipante() {
    var rxGrado = /0[,]{0,1}[0-9]{0,3}$|1$/;
    var rxFecha = /^((19|20)?[0-9]{2})[-](0?[1-9]|1[0-2])[-](0?[1-9]|[12][0-9]|3[01])$/;

    var grado = document.getElementById('discapacidad');
    var fecha = document.getElementById('fechaNacimiento');

    var res = validarPersona();

    //Validación discapacidad
    if ($('#discapacidad').val().trim() == "") {
        grado.setCustomValidity("Introduzca un grado de discapacidad entre 0 y 1");
        res = false;
    } else if (!rxGrado.test($('#discapacidad').val().trim())) {
        grado.setCustomValidity("Introduzca un grado de discapacidad entre 0 y 1");
        res = false;
    } else {
        grado.setCustomValidity("");
    }

    //Validación fecha nacimiento
    if ($('#fechaNacimiento').val().trim() == "") {
        fecha.setCustomValidity("Introduzca una fecha");
        res = false;
    } else if (!rxFecha.test($('#fechaNacimiento').val().trim())) {
        fecha.setCustomValidity("Introduzca un formato de fecha correcto");
        res = false;
    } else {
        fecha.setCustomValidity("");
    }

	var hoy = new Date();

    var fechNam = $('#fechaNacimiento').val().split('-');

    if(parseInt(fechNam[0]) > hoy.getFullYear()-5){
    	fechaNacimiento.setCustomValidity("El participante debe tener al menos 5 años");
    	res = false;
    }else if (parseInt(fechNam[0]) == hoy.getFullYear()-5 ) {
    		if (parseInt(fechNam[1]) > hoy.getMonth()+1) {
    			fechaNacimiento.setCustomValidity("El participante debe tener al menos 5 años");
    			res = false;
    		}else if (parseInt(fechNam[1]) == hoy.getMonth()+1) {
    				if(parseInt(fechNam[2]) > hoy.getDate()){
    					fechaNacimiento.setCustomValidity("El participante debe tener al menos 5 años");
    				    res=false;
                    }else{
    					fechaNacimiento.setCustomValidity("");
    				}
    		}else{
    			fechaNacimiento.setCustomValidity("");
    		}
    }else{
    	fechaNacimiento.setCustomValidity("");
    }
    return res;
}

function validarPatrocinador() {
	var rxNombre = /[^a-zñáéíóúA-ZÑÁÉÍÓÚ\s]/;
	var rxEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var rxCif = /[A-ZÑ]{1}[0-9]{8}$/;
	var rxTlf = /[0-9]{9}$/;
    var rxCp = /[0-9]{5}$/;

    var nombre = document.getElementById('nombre');
    var email = document.getElementById('email');
    var cif = document.getElementById('cif');
    var tlf = document.getElementById('telefono');
    var cp = document.getElementById('cp');

    var res = true;

    // validación nombre
    if ($('#nombre').val().trim() == "") {
        nombre.setCustomValidity("Introduzca un nombre");
        res = false;
    } else if (rxNombre.test($('#nombre').val().trim())) {
        nombre.setCustomValidity("Introduzca un nombre correcto");
        res = false;
    } else {
        nombre.setCustomValidity("");
    }
    // validación email
    if ($('#email').val().trim() == "") {
        email.setCustomValidity("Introduzca un email");
        res = false;
    } else if (!rxEmail.test($('#email').val().trim())) {
        email.setCustomValidity("Introduzca un email correcto");
        res = false;
    } else {
        email.setCustomValidity("");
    }
    // validación cif
    if ($('#cif').val().trim() == "") {
        cif.setCustomValidity("Introduzca un cif");
        res = false;
    } else if (!rxCif.test($('#cif').val().trim())) {
        cif.setCustomValidity("Introduzca un cif correcto");
        res = false;
    } else {
        cif.setCustomValidity("");
    }
    // validación tlf
    if ($('#telefono').val().trim() == "") {
        tlf.setCustomValidity("Introduzca un telefono");
        res = false;
    } else if (!rxTlf.test($('#telefono').val().trim())) {
        tlf.setCustomValidity("Introduzca un telefono correcto");
        res = false;
    } else {
        tlf.setCustomValidity("");
    }
    // validación cp
    if ($('#cp').val().trim() == "") {
        cp.setCustomValidity("Introduzca un código postal");
        res = false;
    } else if (!rxCp.test($('#cp').val().trim())) {
        cp.setCustomValidity("Introduzca un código postal correcto");
        res = false;
    } else {
        cp.setCustomValidity("");
    }
    return res;

}

function validarActividades() {
	var rxNombre = /[^a-zñáéíóúA-ZÑÁÉÍÓÚ\s]/;
	var rxNumPlazas = /^[1-9]{1}\d{0,2}$/;
	var rxCosteTotal = /^[1-9]{1}\d*$/;
	var rxFecha = /^((19|20)?[0-9]{2})[-](0?[1-9]|1[0-2])[-](0?[1-9]|[12][0-9]|3[01])$/;

	var nombre = document.getElementById('nombre');
    var numeroPlazas = document.getElementById('numeroPlazas');
    var costeTotal = document.getElementById('costeTotal');
    var fechaInicio = document.getElementById('fechaInicio');
    var fechaFin = document.getElementById('fechaFin');

    var res = true;

    // validación nombre
    if ($('#nombre').val().trim() == "") {
        nombre.setCustomValidity("Introduzca un nombre");
        res = false;
    } else if (rxNombre.test($('#nombre').val().trim())) {
        nombre.setCustomValidity("Introduzca un nombre correcto");
        res = false;
    } else {
        nombre.setCustomValidity("");
    }

    // validación plazas
    if ($('#numeroPlazas').val().trim() == "") {
        numeroPlazas.setCustomValidity("Introduzca un número de plazas");
        res = false;
    } else if (!rxNumPlazas.test($('#numeroPlazas').val().trim())) {
        numeroPlazas.setCustomValidity("Introduzca un número de plazas entre 1 y 999");
        res = false;
    } else {
        numeroPlazas.setCustomValidity("");
    }
    // validación coste
    if ($('#costeTotal').val().trim() == "") {
        costeTotal.setCustomValidity("Introduzca un coste total");
        res = false;
    } else if (!rxCosteTotal.test($('#costeTotal').val().trim())) {
        costeTotal.setCustomValidity("Introduzca un coste mayor que 0");
        res = false;
    } else {
        costeTotal.setCustomValidity("");
    }
    //Validación fecha inicio
    if ($('#fechaInicio').val().trim() == "") {
        fechaInicio.setCustomValidity("Introduzca una fecha");
        res = false;
    } else if (!rxFecha.test($('#fechaInicio').val().trim())) {
        fechaInicio.setCustomValidity("Introduzca un formato de fecha correcto");
        res = false;
    } else {
        fechaInicio.setCustomValidity("");
    }
    //Validación fecha fin
    if ($('#fechaFin').val().trim() == "") {
        fechaFin.setCustomValidity("Introduzca una fecha");
        res = false;
    } else if (!rxFecha.test($('#fechaFin').val().trim())) {
        fechaFin.setCustomValidity("Introduzca un formato de fecha correcto");
        res = false;
    } else {
        fechaFin.setCustomValidity("");
    }

    var hoy = new Date();

    var fechIni = $('#fechaInicio').val().split('-');
    var fechFin = $('#fechaFin').val().split('-');

    //Validación fecha inicio posterior a actual
    if(parseInt(fechIni[0]) < hoy.getFullYear()){
    	fechaInicio.setCustomValidity("La fecha de inicio no puede ser anterior a hoy");
    	res = false;
    }else if (parseInt(fechIni[0]) == hoy.getFullYear()) {
    		if (parseInt(fechIni[1]) < hoy.getMonth()+1) {
    			fechaInicio.setCustomValidity("La fecha de inicio no puede ser anterior a hoy");
    			res = false;
    		}else if (parseInt(fechIni[1]) == hoy.getMonth()+1) {
    				if(parseInt(fechIni[2]) < hoy.getDate()){
    					fechaInicio.setCustomValidity("La fecha de inicio no puede ser anterior a hoy");
    				    res = false;
                    }else{
    					fechaInicio.setCustomValidity("");
    				}
    		}else{
    			fechaInicio.setCustomValidity("");
    		}
    }else{
    	fechaInicio.setCustomValidity("");
    }

    //Validación fecha inicio anterior a fecha fin
    if(parseInt(fechIni[0]) > parseInt(fechFin[0])){
    	fechaInicio.setCustomValidity("La fecha de inicio no puede ser posterior a la fecha de fin");
    	res = false;
    }else if (parseInt(fechIni[0]) == parseInt(fechFin[0])) {
    		if (parseInt(fechIni[1]) > parseInt(fechFin[1])) {
    			fechaInicio.setCustomValidity("La fecha de inicio no puede ser posterior a la fecha de fin");
    			res = false;
    		}else if (parseInt(fechIni[1]) == parseInt(fechFin[1])) {
    				if(parseInt(fechIni[2]) > parseInt(fechFin[2])){
    					fechaInicio.setCustomValidity("La fecha de inicio no puede ser posterior a la fecha de fin");
    				    res=false;
                    }else{
    					fechaInicio.setCustomValidity("");
    				}
    		}else{
    			fechaInicio.setCustomValidity("");
    		}
    }else{
    	fechaInicio.setCustomValidity("");
    }
}

function validarPatrocinio() {
	var rxCantidad = /^[1-9]{1}\d*$/;

	var cantidad = document.getElementById('cantidad');

	var res = true;

	if ($('#cantidad').val().trim() == "") {
        cantidad.setCustomValidity("Introduzca una cantidad");
        res = false;
    } else if (!rxCantidad.test($('#cantidad').val().trim())) {
        cantidad.setCustomValidity("Introduzca una cantidad mayor a 0");
        res = false;
    } else {
        cantidad.setCustomValidity("");
    }

}

function validarUsuario() {
	var rxFecha = /^((19|20)?[0-9]{2})[-](0?[1-9]|1[0-2])[-](0?[1-9]|[12][0-9]|3[01])$/;

	var fecha = document.getElementById('fechaNacimiento');

	var res = validarPersona();

	//Validación fecha nacimiento
    if ($('#fechaNacimiento').val().trim() == "") {
        fecha.setCustomValidity("Introduzca una fecha");
        res = false;
    } else if (!rxFecha.test($('#fechaNacimiento').val().trim())) {
        fecha.setCustomValidity("Introduzca un formato de fecha correcto");
        res = false;
    } else {
        fecha.setCustomValidity("");
    }

	var hoy = new Date();

    var fechNam = $('#fechaNacimiento').val().split('-');

    if(parseInt(fechNam[0]) > hoy.getFullYear()-18){
    	fechaNacimiento.setCustomValidity("El usuario debe tener al menos 18 años");
    	res = false;
    }else if (parseInt(fechNam[0]) == hoy.getFullYear()-18) {
    		if (parseInt(fechNam[1]) > hoy.getMonth()+1) {
    			fechaNacimiento.setCustomValidity("El usuario debe tener al menos 18 años");
    			res = false;
    		}else if (parseInt(fechNam[1]) == hoy.getMonth()+1) {
    				if(parseInt(fechNam[2]) > hoy.getDate()){
    					fechaNacimiento.setCustomValidity("El usuario debe tener al menos 18 años");
    				    res=false;
                    }else{
    					fechaNacimiento.setCustomValidity("");
    				}
    		}else{
    			fechaNacimiento.setCustomValidity("");
    		}
    }else{
    	fechaNacimiento.setCustomValidity("");
    }

}
