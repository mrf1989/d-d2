function validacion() {
    
    function validarPersona() {
        // Expresiones regulares
        var rxNombre = /[^a-zñáéíóúA-ZÑÁÉÍÓÚ\s]/;
        var rxEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var rxDni = /[0-9]{8}[A-Z]/;
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

        // validación email

        // validación dni

        // validación tlf

        // validación cp
    
        return res;
    
    }

    $('.guardar').click(function () {
        validarPersona();
    })

}

