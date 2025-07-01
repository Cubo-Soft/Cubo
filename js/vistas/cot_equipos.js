var valoresIniciales = [], cantidadesIniciales = [], notasIniciales = [], caracteristicasAEnviar = [];
var productosFinales = [], valores = [], textos = [], cantidades = [], notas = [], preciosVenta = [],
    tabla = null, respuestosCantidados = null, clavesEquipos = [], textosEquipos = [], etiquetasEquipos = [],
    textosGeneralesEquipos = {}, clavesGeneralesEquipos = {}, textosCaracteristicasEquipos = [], clavesCaracteristicasEquipos = [],
    textosCaracteristicas2 = [], arregloCaracteristicas = [],
    textosCaracteristicasRepuestosEnviar = [],
    clavesCaracteristicasRepuestosEnviar = [], cantidadesEquipos = [], cantidadesEquiposEnviar = [], observacionesEquiposEnviar = [],
    datosClientePrisional = {}, caracteristicasRepuestos = [], lineasEquipos = [], id_consecot = null;

$(document).ready(function () {

    $("#divRepuestos").hide();
    $("#divEquipos").hide();
    $("#divServicioMantenimiento").hide();
    $("#divCantidadRepuestos").hide();
    //$("#divBotonRecargar").hide();
    $("#adicionarClienteProvisional").hide();
    $("#modificarContacto").hide();
    $("#btnGenerarPDFCotizacion").hide();
    $("#btnGenerarPDFRepuestos").hide();
    $("#btnEnviarPDFRepuestos").hide();
    $("#btnEnviarCotizacion").hide();
    //por ahora dejemola así mientras deciden si modifican la tabla vr_cotiza para agregar observaciones a la cotizacion
    $("#textAreaObservaciones").hide();
    $("#btnActualizarObservaciones").hide();



    starMap();
    retornarParametricas(2);
    /*
     * permisos
     */
    retornarARRoles(null, 1);
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
    retornarIPGrupos(data, 2);
    retornarNPCiudades(11001, 3);
    retornarIPLineas(null, 2);

    data = {
        'nombreDiv': 'divSubZonas'
    };
    retornarAPRegiones(data, 1);

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
    data = {
        'nombreDiv': 'divFuentes'
    };
    retornarIPDTBasicos(data, 9);
    data = {
        'nombreDiv': 'estadosCotizacion'
    };
    retornarIPDTBasicos(data, 15);

    data = {
        'nombreDiv': 'divValorMonedas'
    };
    retornarIPDTBasicos(data, 16);

    //retornarCMTrm(null, 1);

    data = {
        'nombreDiv': 'divTerminosDePago'
    };
    retornarVPTerminosPago(data, 1);

    data = {
        'nombreDiv': 'divDiasVigencia'
    }
    retornarVPVigencia(data, 1);

    $("#modificarPersona").click(function () {
        if (validarCampos(4) === 2) {
            actualizarNMPersonas(null, 1);
        }
    });
    $("#actualizarNMContactos").click(function () {
        actualizarNMContactos(null, 1);
    });
    $("#nom_contacto").on("keypress", function () {

        if (id_sucursal === null) {
            retornarNMContactos(null, 1);
        }

    });
    $("#modificarContacto").click(function () {
        if (validarCampos(2) === 5) {
            actualizarNMContactos(null, 3);
        }
    });
    $("#nom_contacto").blur(function () {

        if (id_sucursal === null) {
            if ($("#nom_contacto").val().length <= 0) {
                $("#mensajesContacto").html('<div class="callout callout-danger">Por favor ingrese un nombre de contacto válido</div>');
            } else {
                retornarNMContactos(null, 4);
            }
        }

    });
    $("#modificarSucursal").click(function () {
        if (validarCampos(1) === 7) {
            modificarNMSucursal(null, 1);
        }
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
        retornarNMJuridicas(null, 4);
    });
    /*
     * retorna valores a medida que se digita un número en el campo
     */
    $("#cc_contacto").on("keypress", function () {
        retornarNMContactos(null, 2);
    });
    /*
     * retorna los valores del campo según lo digitado
     */
    $("#cc_contacto").blur(function () {
        if (parseFloat($("#cc_contacto").val()) === 0 || $("#cc_contacto").val().length === 0) {
            $("#mensajes").html('');
            retornarMensajeDeCreacion(1);
        } else {
            retornarNMContactos(null, 3);
        }
    });
    $("#btnBuscarPorContacto").click(function () {

        if ($("#fuentes").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione la fuente del requerimiento</div>');
            $("#fuentes").focus();
        } else {
            $("#mensajes").html('');
            $("#divContactosGeneral").show();
            $("#datosInicialesEmpresa").hide();
        }

    });
    $("#btnBuscarPorEmpresa").click(function () {

        $("#divClientesProvisionales").hide();        

        if ($("#fuentes").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione la fuente del requerimiento</div>');
            $("#fuentes").focus();
        } else {
            $("#mensajes").html('');
            $("#datosInicialesEmpresa").show();
            $("#divContactosGeneral").hide();
        }

    });
    $("#adicionarClienteProvisional").click(function () {
        if (validarCampos(6) === 3) {
            crearVMClientesProv(null, 1);
        }
    });
    $("#listarContactos").click(function () {
        pintarRetornarNMContactos();
    });
    $("#adicionarContacto").click(function () {
        if (validarCampos(2) === 5) {
            crearNMContactos(null, 1);
        }
    });
    $("#listarSucursales").click(function () {
        $("#datosSucursales").hide();
        var data = {
            'numid': $("#numid").val()
        };
        retornarNMSucursal(data, 1);
    });
    $("#btnAgregarRepuestos").on("mouseenter", function () {
        if (verificarArregloCaracteristicas() === 0) {
            $("#divMensajesRepuestos").html('<div class="callout callout-warning">No se registran valores válidos para las carácteristicas del repuesto!. Una vez grabado el requerimiento no es posible modificarlo!</div>');
        }
    });
    $("#btnAgregarRepuestos").click(function () {

        if ($("#cantidadRepuestos").val().length === 0 || parseInt($("#cantidadRepuestos").val()) === 0) {

            $("#divMensajesRepuestos").html('<div class="callout callout-warning">Por favor digite una cantidad válida</div>');
            $("#cantidadRepuestos").focus();

        } else {

            crearVRCotizaDet(null, 1);

        }
    });
    $("#cantidadRepuestos").focusin(function () {
        verificarArregloCaracteristicas();
        $(this).val('');
    });

    $("#btnActualizarObservaciones").click(function () {

        var datosAEnviar = {
            'observs': $("#textAreaObservaciones").val(),
            'id_requerim': $("#id_requerim").val()
        };

        $.ajax({
            url: "../controladores/CT_vr_requerim.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj) {
                    $("#divMensajesRequerimientos").html('<div class="callout callout-success">Observaciones actualizadas</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error $('#btnCrearRequerimiento').click(function () {...\nError from server, please call support");
            }
        });
    });

    $("#btnGuardarCotizacion").click(function () {
        if ($("#vp_terminospago").val() === '-1') {
            $("#mensajesTerminosDePago").html("<div class='alert alert-danger alert-dismissible'>Podría por favor seleccionar un \"Termino de pago?\"</div>");
            $("#vp_terminospago").focus();
        } else {
            $("#mensajesTerminosDePago").html("");

            cambiarVRCotiza(null, 1);

        }
    });

    $("#btnGenerarPDFEquipos").click(function () {
        window.open("../pdf/pdf_equipos.php?id_consecot=" + $("#id_consecot").val()), "_blank";
        window.location.reload("cot_equipos.php");
    });

    $("#btnEnviarPDFEquipos").click(function () {
        window.open("../pdf/enviar_cot_equipos.php?id_consecot=" + $("#id_consecot").val(), "_self");
    });

    if ($.urlParam('id_consecot') === null) {

        Swal.fire({
            title: 'Oops!',
            text: 'No se detecta una cotización seleccionada. Se direcciona a la captura del requerimiento.',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                //window.location.href = 'listados.php?id_alerta=2';
                window.location.href = 'toma_requer.php';
            } else {
                window.location.href = 'toma_requer.php';
                //window.location.href = 'toma_requer.php';
            }
        });

    } else {

        id_consecot = $.urlParam('id_consecot');
        retornarVRCotiza($.urlParam('id_consecot'), 1);

    }

});