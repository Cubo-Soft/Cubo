var valoresIniciales = [], cantidadesIniciales = [], notasIniciales = [], caracteristicasAEnviar = [];
var productosFinales = [], valores = [], textos = [], cantidades = [], notas = [], preciosVenta = [],
    tabla = null, respuestosCantidados = null, clavesEquipos = [], textosEquipos = [], etiquetasEquipos = [],
    textosGeneralesEquipos = {}, clavesGeneralesEquipos = {}, textosCaracteristicasEquipos = [], clavesCaracteristicasEquipos = [],
    textosCaracteristicas2 = [], arregloCaracteristicas = [],
    textosCaracteristicasRepuestosEnviar = [],
    clavesCaracteristicasRepuestosEnviar = [], cantidadesEquipos = [], cantidadesEquiposEnviar = [], observacionesEquiposEnviar = [],
    datosClientePrisional = {}, id_requerim = null, caracteristicasRepuestos = [], lineasEquipos = [];

$(document).ready(function () {

    $("#divRepuestos").hide();
    $("#divEquipos").hide();
    $("#divServicioMantenimiento").hide();
    $("#divCantidadRepuestos").hide();
    $("#divBotonRecargar").hide();
    $("#adicionarClienteProvisional").hide();
    $("#modificarContacto").hide();
    $("#solicitudACompras").hide();
    $("#iniciarCotizacion").hide();

    starMap();
    retornarParametricas(2);

    //permisos     
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
    retornarNPCiudades(11001, 3);

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
        'nombreDiv': 'estadosRequerimiento'
    };
    retornarIPDTBasicos(data, 13);

    $("#cod_item").on("blur", function () {
        retornarIMItems2(null, 7);
    });

    $("#alter_item").on("blur", function () {
        retornarIMItems2(null, 9);
    });

    $("#nom_item").on("keypress", function () {
        retornarIMItems2(null, 10);
    });

    $("#nom_item").on("blur", function () {
        retornarIMItems2(null, 11);
    });

    $("#solicitudACompras").on("click", function () {
        Swal.fire({
            title: 'Confirmación',
            text: 'Por favor confirme iniciar los requerimientos internos a compras!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                cambiarVRRequerimDet(null, 2);
                $("#iniciarCotizacion").show();
            }
        });
    });

    $("#tomarOtroRequerimiento").on("click", function () {
        window.location = 'toma_requer.php';
    });

    $("#cantidadRepuestos").on("blur", function () {
        if (respuestosCantidados.saldo <= parseFloat($("#cantidadRepuestos").val())) {
            $("#btnLlamarPUBodegas").show();
        }

        var cantidadRepuestos = parseFloat($("#cantidadRepuestos").val());
        var minimo = respuestosCantidados.minimo;
        var saldo = respuestosCantidados.saldo;
        var resultado = saldo - cantidadRepuestos;

        if (resultado <= minimo) {
            $("#divExistenciaMinima").html("<div class='callout callout-danger'>Referencia <strong>" + respuestosCantidados.cod_item + "</strong> por debajo del mínimo</div>");
        }

    });

    $("#btnLlamarPUBodegas").on("click", function () {
        retornarIRSalinve(null, 2);
    });

    $("#modificarPersona").on("click", function () {
        if (validarCampos(4) === 2) {
            actualizarNMPersonas(null, 1);
        }
    });
    $("#actualizarNMContactos").on("click", function () {
        actualizarNMContactos(null, 1);
    });
    $("#nom_contacto").on("keypress", function () {

        if (id_sucursal === null) {
            retornarNMContactos(null, 1);
        }

    });
    $("#modificarContacto").on("click", function () {
        if (validarCampos(2) === 5) {
            actualizarNMContactos(null, 3);
        }
    });
    $("#nom_contacto").on("blur", function () {

        if (id_sucursal === null) {
            if ($("#nom_contacto").val().length <= 0) {
                $("#mensajesContacto").html('<div class="callout callout-danger">Por favor ingrese un nombre de contacto válido</div>');
            } else {
                retornarNMContactos(null, 4);
            }
        }

    });
    $("#modificarSucursal").on("click", function () {
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
    $("#cc_contacto").on("blur", function () {
        if (parseFloat($("#cc_contacto").val()) === 0 || $("#cc_contacto").val().length === 0) {
            $("#mensajes").html('');
            retornarMensajeDeCreacion(1);
        } else {
            retornarNMContactos(null, 3);
        }
    });
    $("#btnBuscarPorContacto").on("click", function () {

        if ($("#fuentes").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione la fuente del requerimiento</div>');
            $("#fuentes").focus();
        } else {
            $("#mensajes").html('');
            $("#divContactosGeneral").show();
            $("#datosInicialesEmpresa").hide();
        }

    });
    $("#btnBuscarPorEmpresa").on("click", function () {

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
    $("#adicionarClienteProvisional").on("click", function () {
        if (validarCampos(6) === 3) {
            crearVMClientesProv(null, 1);
        }
    });
    $("#listarContactos").on("click", function () {
        pintarRetornarNMContactos();
    });
    $("#adicionarContacto").on("click", function () {
        if (validarCampos(2) === 5) {
            crearNMContactos(null, 1);
        }
    });
    $("#listarSucursales").on("click", function () {
        $("#datosSucursales").hide();
        var data = {
            'numid': $("#numid").val()
        };
        retornarNMSucursal(data, 1);
    });
    $("#btnAgregarRepuestos").on("mouseenter", function () {
        if (verificarArregloCaracteristicas() === 0) {
            $("#divMensajesRepuestos").html('<div class="callout callout-warning">Advertencia! No se registran valores válidos para las carácteristicas del repuesto!. Una vez grabado el requerimiento no es posible modificarlo!</div>');
        } else {
            $("#divMensajesRepuestos").html('');
        }
    });
    $("#btnAgregarRepuestos").on("click", function () {

        if ($("#cantidadRepuestos").val().length === 0 || parseInt($("#cantidadRepuestos").val()) === 0) {
            $("#divMensajesRepuestos").html('<div class="callout callout-warning">Por favor digite una cantidad válida</div>');
            $("#cantidadRepuestos").focus();
        } else {
            crearVRRequerimDet(null, 1);
        }
    });

    $("#cantidadRepuestos").focusin(function () {
        verificarArregloCaracteristicas();
        $(this).val('');
    });

    $("#btnCrearRequerimiento").on('mouseenter', function () {

        if (numid === null) {
            numid = $("#numid").val();
        }

        if (cc_contacto === null) {
            cc_contacto = $("#cc_contacto").val();
        }

        id_contacto = $("#id_contacto").val();
        if ($("#clienteProvisional").val() === '1') {
            if (validarCampos(7) === 4) {
                $("#btnCrearRequerimiento").prop("disabled", false);
                $("#divMensajesRequerimientos").html('');
            } else {
                $("#btnCrearRequerimiento").prop("disabled", true);
            }
        }
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

    $("#btnEditarRequerimiento").click(function () {

        if ($("#estadoRequerimiento").val() === '83' || $("#estadoRequerimiento").val() === '84') {

            Swal.fire({
                title: 'Pregunta',
                text: 'El ajuste a este estado impedirá que el requerimiento sea editado. Esta completamente seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    actualizarRequerimiento();
                }
            });
        } else {
            actualizarRequerimiento();
        }
    });

    if ($.urlParam('id_requerim') === null) {

        Swal.fire({
            title: 'Pregunta',
            text: 'No se detecta un requerimiento seleccionado. Desea ir a la tabla de requerimientos para seleccionar uno?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'listados.php?id_alerta=1';
            } else {
                window.location.href = 'toma_requer.php';
            }
        });

    } else {

        id_requerim = $.urlParam('id_requerim');
        retornarVRRequerim($.urlParam('id_requerim'), 2);
    }
});

function actualizarRequerimiento() {

    var datosAEnviar = {
        'estado': $("#estadoRequerimiento").val(),
        'id_requerim': $("#id_requerim").val()
    };

    $.ajax({
        url: "../controladores/CT_vr_requerim.php",
        data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
        type: "POST",
        success: function (respuesta) {
            var obj = JSON.parse(respuesta);
            if (obj) {
                $("#divMensajesRequerimientos").html('<div class="callout callout-success">Estado del requerimiento actualizado</div>');
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
}