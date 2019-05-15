function validarPersona() {
    // Expresiones regulares
    var rxNombre = /[^a-zñáéíóúA-ZÑÁÉÍÓÚ\s]/;
    var rxEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var rxDni = /[0-9]{8}[A-ZÑ]{1}/;
    var rxTlf = /[0-9]{9}/;
    var rxCp = /[0-9]{5}/;

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

    var grado = document.getElementById('discapacidad');

    var res = validarPersona();

    if ($('#discapacidad').val().trim() == "") {
        grado.setCustomValidity("Introduzca un grado de discapacidad entre 0 y 1");
        res = false;
    } else if (!rxGrado.test($('#discapacidad').val().trim())) {
        grado.setCustomValidity("Introduzca un grado de discapacidad entre 0 y 1");
        res = false;
    } else {
        grado.setCustomValidity("");
    }
    return res;
}
