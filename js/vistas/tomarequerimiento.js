$(document).ready(function () {

    /*
     * permisos
     */    retornarARRoles(null, 1);

    //ocultar el botón para actualizar
    ocultarBotones(1);
    divOcultos(2);
    $("#divClientesProvisionales").hide();    
    $("#datosInicialesEmpresa").hide();

    //muestra el listado de fuentes de para la toma del requerimiento
    //telefono, movil, whatsapp, pagina web, etc.
    var data = {
        'nombreDiv': 'divIPDtbasicos'
    };
    retornarIPDTBasicos(data, 2);
    data = [];
    data = {
        'nombreDiv': 'divLineasMisionales'
    };
    retornarIPDTBasicos(data, 3);
    retornarNPCiudades(11001, 3);
    retornarIPLineas(null, 1);

    data = [];
    data = {
        'nombreDiv': 'divSubZonas'
    };
    retornarAPSubzonas(data, 1);


    data = {
        'nombreDiv': 'divPaises'
    };
    retornarNPPaises(3, data);

    data = {
        'nombreDiv': 'divSexoPersona'
    };
    retornarIPDTBasicos(data, 6);

    data = {
        'nombreDiv': 'divEstadoCivilPersona'
    };
    retornarIPDTBasicos(data, 7);

    data = {
        'nombreDiv': 'divTipoSangrePersona'
    };
    retornarIPDTBasicos(data, 8);

    $("#nuevaBusqueda").click(function () {
        location.reload();
    });

    $("#actualizarNMContactos").click(function () {
        actualizarNMContactos(null, 1);
    });

    /*
     * verifica si al entrar en el foco la lista de fuentes había sido seleccionada
     */
    $("#cc_contacto").focusin(function () {
        evaluarSelccionDeFuente();
    });

    $("#nm_contactos").focusin(function () {
        evaluarSelccionDeFuente();
    });

    $("#tel_contacto").focusin(function () {
        evaluarSelccionDeFuente();
    });

    $("#numid").focusin(function () {
        ocultarBotones(1);
        evaluarSelccionDeFuente();
    });

    $("#razon_social").focusin(function () {
        evaluarSelccionDeFuente();
    });

    $("#nom_contacto").focusin(function () {
        evaluarSelccionDeFuente();
    });

    $("#numid").on("keypress", function () {
        retornarNMJuridicas(null, 1);
    });

    $("#numid").blur(function () {
        retornarNMJuridicas(null, 2);
    });

    $("#razon_social").on("keypress", function () {
        retornarNMJuridicas(null, 3);
    });

    $("#razon_social").blur(function () {
        if ($("#ip_dtbasicos").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione una opción válida de misionales</div>');
        } else {
            $("#mensajes").html('');
            retornarNMJuridicas(null, 4);
        }
    });
    
//por ahora dejarlo desabilitado
//    /*
//     * retorna valores a medida que se digita un número en el campo
//     */
//    $("#cc_contacto").on("keypress", function () {
//        retornarNMContactos(null, 2);
//    });
//
//
//    /*
//     * retorna los valores del campo según lo digitado
//     */
//    $("#cc_contacto").blur(function () {
//        if ($("#ip_dtbasicos").val() === '-1') {
//            $("#mensajes").html('<div class="callout callout-danger">Por favor seleccione una opción válida de misionales</div>');
//        } else if (parseFloat($("#cc_contacto").val()) === 0 || $("#cc_contacto").val().length === 0) {
//            $("#mensajes").html('');
//            retornarMensajeDeCreacion(1);
//        } else {
//            retornarNMContactos(null, 3);
//        }
//    });

    $("#nom_contacto").on("keypress", function () {
        retornarNMContactos(null, 1);
    });

    $("#nom_contacto").blur(function () {
        if ($("#ip_dtbasicos").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione una opción válida de misionales</div>');
        } else {
            retornarNMContactos(null, 4);
        }
    });

    $("#nuevaBusqueda").click(function () {
        location.reload();
    });
    
    $("#btnBuscarPorContacto").click(function () {
        $("#divContactosGeneral").show();        
        $("#datosInicialesEmpresa").hide();
    });
    
    $("#btnBuscarPorEmpresa").click(function () {
        $("#datosInicialesEmpresa").show();
        $("#divContactosGeneral").hide();    
    });

});

function retornarMensajeDeCreacion(opcion) {
    if (opcion === 1) {
        $("#mensajes").html('<div class="callout callout-info">Por favor ingrese como mínimo <strong>Apellidos y nombres</strong> y el número de <strong>Teléfono</strong></div>');
        $("#crearVMClientesProv").show();
        $("#actualizarNMContactos").hide();

        $("#direccion").val('');
        $("#razon_social").val('');
        $("#telefono").val('');
        $("#np_ciudades").val('');
        $("#np_paises").val('');

    }
}

function evaluarSelccionDeFuente() {
    if ($("#ip_dtbasicos").val() === '-1') {
        $("#mensajes").html('<div class="callout callout-danger">Por favor seleccione una opción válida de misionales</div>');
        $("#ip_dtbasicos").focus();
    } else {
        $("#mensajes").html('');
    }
}