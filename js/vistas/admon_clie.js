$(document).ready(function () {

    $("#divEmpleadosGeneral").hide();
    $("#divUsuariosGeneral").hide();
    $("#divSubirFoto").hide();

    starMap();

    //permisos    
    retornarARRoles(null, 1);

    divOcultos(1);

    var data = {
        'nombreDiv': 'divTipoNIT'
    };
    retornarNPTiponit(data, 1);

    retornarNPCiudades(null, 2);
        
    data = {
        'nombreDiv': 'divTipoEntidad'
    };
    retornarIPDTBasicos(data, 4);

    data = {
        'nombreDiv': 'divEstadoEntidad'
    };
    retornarIPDTBasicos(data, 5);


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

    data = {
        'nombreDiv': 'divContratoEmpleado'
    };
    retornarIPDTBasicos(data, 17);

    data = {
        'nombreDiv': 'divCesantiasEmpleado'
    };
    retornarIPDTBasicos(data, 18);

    data = {
        'nombreDiv': 'divPensionEmpleado'
    };
    retornarIPDTBasicos(data, 19);

    data = {
        'nombreDiv': 'divEPSEmpleado'
    };
    retornarIPDTBasicos(data, 20);

    data = {
        'nombreDiv': 'divTipoDePersona'
    };
    retornarIPDTBasicos(data, 24);

    data = {
        'nombreDiv': 'divActividades'
    };
    retornarNPActiveco(data, 1);
    
    data = {
        'nombreDiv': 'divSubZonas'
    };    
    retornarAPRegiones(data, 1);

    data = {
        'nombreDiv': 'divCargoEmpleado'
    };    
    retornarNPCargos(data,1);

    $("#numid").keypress(function () {
        retornarNMNits(null, 3);
    });

    $("#numid").focusin(function () {
        if ($("#np_tiponit").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-info">Si va a crear una nueva entidad, por favor seleccione el "Tipo de identificación" primero</div>');
        }
        $(this).val('');
    });

    $("#numid").blur(function () {
        if ($("#numid").val().length <= 5 || $("#numid").val() === '0') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor ingrese un valor válido para iniciar la búsqueda. Mientras va digitando en este campo, el sistema le va mostrando sugerencias!</div>');
            $("#np_tiponit").focus();
        } else {
            retornarNMNits(null, 4);
        }
    });


    if ($.urlParam('numid') !== null) {           

        $("#numid").val($.urlParam('numid'));        
        retornarNMNits(null, 4);
    }


    $("#listarSucursales").click(function () {
        $("#datosSucursales").hide();
        retornarNMNits(null, 4);
    });

    $("#modificarContacto").on('mouseenter', function () {
        if (validarCampos(2) !== 5) {
            $("#mensajesContacto").html('<div class="callout callout-warning">Realmente quiere "Modificar" un contacto nuevo?</div>');
        }
    });

    $("#modificarContacto").click(function () {
        if (validarCampos(2) === 5) {
            actualizarNMContactos(null, 2);
        }
    });

    $("#listarContactos").click(function () {
        $("#mensajesContacto").html('');
        pintarRetornarNMContactos();
    });

    $("#adicionarContacto").on('mouseenter', function () {
        if (validarCampos(2) !== 5) {
            $("#mensajesContacto").html('<div class="callout callout-warning">Realmente quiere "Adicionar" un contacto nuevo?</div>');
        } else {
            $("#mensajesContacto").html('<div class="callout callout-info">Tiene buena pinta!</div>');
        }
    });

    $("#adicionarContacto").click(function () {
        if (validarCampos(2) === 5) {
            crearNMContactos(null, 1);
        }
    });

    $("#crearClientes").on('mouseenter', function () {
        if (validarCampos(3) !== 3) {
            $("#mensajes").html('<div class="callout callout-warning">Realmente quiere "Adicionar" un cliente nuevo?</div>');
        } else {
            $("#mensajes").html('<div class="callout callout-info">Parece que todo esta acorde con la realidad. Por favor antes de dar click sobre el boton "Adicionar" verifique que los datos sean correctos.<br>Por favor!!!</div>');
        }
    });

    $("#crearClientes").click(function () {
        if (validarCampos(3) === 3) {
            crearNMNits(null, 1);
        }
    });

    $("#modificarClientes").click(function () {
        actualizarNMNits(null, 1);
    });

    $("#adicionarPersona").on('mouseenter', function () {
        if (validarCampos(4) !== 2) {
            $("#mensajesPersonas").html('<div class="callout callout-warning">Realmente quiere "Adicionar" una persona nueva?</div>');
        } else {
            $("#mensajesPersonas").html('<div class="callout callout-info">Tiene buena pinta!</div>');
        }
    });

    $("#adicionarPersona").click(function () {
        if (validarCampos(4) === 2) {
            crearNMPersonas(null, 1);
        }
    });

    $("#modificarPersona").click(function () {
        if (validarCampos(4) === 2) {
            actualizarNMPersonas(null, 1);
        }
    });

    $("#adicionarJuridica").click(function () {
        if ($("#razon_social").val().length === 0) {
            $("#mensajesJuridicas").html('<div class="callout callout-warning">Por favor ingrese el nombre de la entidad y presione el botón "Adicionar".</div>');
            $("#razon_social").focus();
        } else {
            $("#mensajesJuridicas").html('');
            crearNMJuridicas(null, 1);
        }
    });

    $("#modificarJuridica").click(function () {
        if ($("#razon_social").val().length === 0) {
            $("#mensajesJuridicas").html('<div class="callout callout-warning">Por favor ingrese el nombre de la entidad y presione el botón "Adicionar".</div>');
            $("#razon_social").focus();
        } else {
            $("#mensajesJuridicas").html('');
            actualizarNMJuridicas(null, 1);
        }
    });

    $("#adicionarComplementosNIT").on('mouseenter', function () {
        if (validarCampos(5) === 0) {
            $("#mensajesComplementosNIT").html('<div class="callout callout-warning">Realmente quiere "Adicionar" un complemento nuevo?</div>');
        } else {
            $("#mensajesComplementosNIT").html('<div class="callout callout-info">Tiene buena pinta!</div>');
        }
    });

    $("#adicionarComplementosNIT").click(function () {
        if (validarCampos(5) === 1) {
            crearNMCompleme(null, 1);
        }
    });

    $("#modificarComplementosNIT").click(function () {
        if (validarCampos(5) === 1) {
            actualizarNMCompleme(null, 1);
        }
    });

    $("#modificarUsuario").on('click',function(){
        $("#divSubirFoto").show();
        $("#divFotoEmpleado2").hide();
        $("#modificarUsuario").hide();
    });
    

});