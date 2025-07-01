var textosIniciales = [], valoresIniciales = [], cantidadesIniciales = [], notasIniciales = [], caracteristicasAEnviar = [];
var productosFinales = [], valores = [], textos = [], cantidades = [], notas = [], //preciosVenta = [],
    tabla = null, respuestosCantidados = null, clavesEquipos = [], textosEquipos = [], etiquetasEquipos = [],
    textosGeneralesEquipos = {}, clavesGeneralesEquipos = {}, textosCaracteristicasEquipos = [], clavesCaracteristicasEquipos = [],
    textosCaracteristicas2 = [], arregloCaracteristicas = [], textosCaracteristicas = [],
    caracteristicasRepuestos = [], caracteristicasRepuestosEnviar = [], textosCaracteristicasRepuestosEnviar = [],
    clavesCaracteristicasRepuestosEnviar = [], cantidadesEquipos = [], cantidadesEquiposEnviar = [], observacionesEquiposEnviar = [],
    datosClientePrisional = {}, lineasRepuestos = [], lineasEquipos = [], lineasProyectos = [], lineasServManteni = [],
    datosRequerimiento = {}, repNoExiste = [], valoresRepuestoNoExiste = [], aCompras = [], enviarACompras = 0, textosRepuestosNoExiste = {},
    textosMostrarRepuestosNoExiste = [], mantenimientoARealizar = [];

$(document).ready(function () {

    $("#divRepuestos").hide();
    $("#divEquipos").hide();
    $("#divServicioMantenimiento").hide();
    $("#divCantidadRepuestos").hide();
    $("#divEstadosRequerimiento").hide();
    $("#divBotonRecargar").hide();
    $("#adicionarClienteProvisional").hide();
    $("#modificarContacto").hide();
    $("#iniciarCotizacion").hide();
    $("#solicitudACompras").hide();
    $("#tomarOtroRequerimiento").hide();
    $("#btnLlamarPUBodegas").hide();

    starMap();

    retornarParametricas(2);

    //retornar permisos
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
    retornarIPGrupos(data, 1);

    retornarNPCiudades(11001, 3);

    var datos = {};
    datos.opcionSeleccionada = null;
    retornarIPLineas(datos, 1);

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

    data = {
        'nombreDiv': 'divSubZonas'
    };
    retornarAPRegiones(data, 1);

    data = {
        'nombreDiv': 'divRegionCP'
    };
    retornarAPRegiones(data, 2);

    /*$("#cantidadRepuestos").blur(function(){
        if(respuestosCantidados.saldo<=parseFloat($("#cantidadRepuestos").val())){
            $("#btnLlamarPUBodegas").show();                    }
    });    
    */

    $("#cod_item").on("keypress", function () {
        retornarIMItems2(null, 6);
    });

    $("#cod_item").on("blur", function () {
        retornarIMItems2(null, 7);
    });

    $("#alter_item").on("keypress", function () {
        retornarIMItems2(null, 8);
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

    $("#razon_social").on("keypress", function () {
        retornarNMJuridicas(null, 3);
    });

    $("#razon_social").blur(function () {
        retornarNMJuridicas(null, 4);
    });

    $("#btnLlamarPUBodegas").click(function () {
        retornarIRSalinve(null, 2);
    });

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

    $("#nom_contacto").blur(function () {
        if (id_sucursal === null) {
            if ($("#nom_contacto").val().length <= 0) {
                $("#mensajesContacto").html('<div class="callout callout-danger">Por favor ingrese un nombre de contacto válido</div>');
            } else {
                retornarNMContactos(null, 4);
            }
        }
    });

    $("#modificarContacto").click(function () {
        if (validarCampos(2) === 5) {
            actualizarNMContactos(null, 3);
        }
    });

    $("#modificarSucursal").click(function () {
        if (validarCampos(1) === 6) {
            modificarNMSucursal(null, 1);
        }
    });

    $("#numid").on("keypress", function () {
        retornarNMJuridicas(null, 1);
    });

    $("#numid").blur(function () {
        retornarNMJuridicas(null, 2);
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

    $("#tomarOtroRequerimiento").click(function () {
        location.reload();
    });

    $("#btnAgregarRepuestos").on("mouseenter", function () {
        if (verificarArregloCaracteristicas() === 0) {
            $("#divMensajesRepuestos").html('<div class="callout callout-warning">Advertencia! No se registran valores válidos para las carácteristicas del repuesto!. Una vez grabado el requerimiento no es posible modificarlo!</div>');
        } else {
            $("#divMensajesRepuestos").html('');
        }
    });

    $("#btnAgregarRepuestos").on("click", function () {

        $("#cod_item").val('');
        $("#alter_item").val('');
        $("#nom_item").val('');

        $("#divFoto").html("");
        $("#modalBodegasProductos").hide();

        if ($("#cantidadRepuestos").val().length === 0 || parseInt($("#cantidadRepuestos").val()) === 0) {

            $("#divMensajesRepuestos").html('<div class="callout callout-warning">Por favor digite una cantidad válida</div>');
            $("#cantidadRepuestos").focus();

        } else {

            if ($("#repuesto_existe").val() === '0') {
                valoresRepuestoNoExiste[0] = $("#grup_items").val()[0];
                valoresRepuestoNoExiste[1] = $("#ip_tipos").val()[0];
                valoresRepuestoNoExiste[2] = $("#ip_marcas").val()[0];
                valoresRepuestoNoExiste["cantidadRepuestos"] = $("#cantidadRepuestos").val();
                valoresRepuestoNoExiste["notasRepuestos"] = $("#notasRepuestos").val();
                textosRepuestosNoExiste["articulo"] = $("#grup_items").find('option:selected').text();
                textosRepuestosNoExiste["tipo"] = $("#ip_tipos").find('option:selected').text();
                textosRepuestosNoExiste["marca"] = $("#ip_marcas").find('option:selected').text();
                //cuando un elemento no existe necesariamente se va para compras
                aCompras.push(1);
                respuestosCantidados = [0];
            } else {
                valoresRepuestoNoExiste[0] = 0;
                valoresRepuestoNoExiste[1] = 0;
                valoresRepuestoNoExiste[2] = 0;
                valoresRepuestoNoExiste["cantidadRepuestos"] = 0;
                valoresRepuestoNoExiste["notasRepuestos"] = 0;

                textosRepuestosNoExiste["articulo"] = 0;
                textosRepuestosNoExiste["tipo"] = 0;
                textosRepuestosNoExiste["marca"] = 0;

                //cuando existe, puede ser que la persona decida enviarlo o no
                if ($("#chkACompras").prop("checked")) {
                    aCompras.push(1);
                } else {
                    aCompras.push(0);
                }
            }

            textosMostrarRepuestosNoExiste.push(textosRepuestosNoExiste);
            notasIniciales.push($("#notasRepuestos").val());
            //preciosVenta.push($("#precio_vta").val());
            cantidadesIniciales.push($("#cantidadRepuestos").val());
            lineasRepuestos.push($("#ip_grupos").val());
            textosIniciales.push(respuestosCantidados);
            repNoExiste.push(valoresRepuestoNoExiste);
            caracteristicasRepuestosEnviar.push(caracteristicasRepuestos);
            textosCaracteristicasRepuestosEnviar.push(textosCaracteristicas);
            clavesCaracteristicasRepuestosEnviar.push(arregloCaracteristicas);

            arregloCaracteristicas = [];
            textosCaracteristicas = [];
            caracteristicasRepuestos = [];
            valoresRepuestoNoExiste = [];
            textosRepuestosNoExiste = [];

            respuestosCantidados = null;
            armarTablaProductos(null, 1);

        }
    });

    $("#cantidadRepuestos").focusin(function () {
        verificarArregloCaracteristicas();
        $(this).val('');
    });

    //revisa las variables iniciales antes de ser enviadas en
    //el evento click de este botón
    $("#btnCrearRequerimiento").on('mouseenter', function () {

        id_contacto = 0;

        if (numid === null || numid === '0') {
            numid = $("#numid").val();
        }

        if (cc_contacto === null) {
            cc_contacto = $("#cc_contacto").val();
        }

        cc_contacto = parseInt(cc_contacto);

        id_contacto = parseInt($("#id_contacto").val());

        if ($("#ip_grupos").val() !== '03') {
            if (id_contacto === 0 || isNaN(id_contacto)) {
                $("#divMensajesRequerimientos").html('<div class="callout callout-warning">De la lista de contactos de la sede, podría por favor seleccionar uno?</div>');
                $("#btnCrearRequerimiento").prop("disabled", true);
            } else if ($("#clienteProvisional").val() === '1') {
                if (validarCampos(7) === 4) {
                    $("#btnCrearRequerimiento").prop("disabled", false);
                    $("#divMensajesRequerimientos").html('');
                } else {
                    $("#btnCrearRequerimiento").prop("disabled", true);
                }
            } else if (textosIniciales.length === 0 && clavesCaracteristicasEquipos.length === 0) {
                $("#divMensajesRequerimientos").html('<div class="callout callout-warning">No encontramos repuestos ni equipos para crear el requerimiento. Por favor revise</div>');
                $("#btnCrearRequerimiento").prop("disabled", true);
            } else {
                $("#btnCrearRequerimiento").prop("disabled", false);
                $("#divMensajesRequerimientos").html('');
            }
            $("#id_mantenimiento").val('0');
        } else {

            if ($("#ip_lineas").val() === '-1') {

                $("#btnCrearRequerimiento").prop("disabled", true);
                $("#ip_lineas").focus();
                $("#divMensajesRequerimientos").html('<div class="callout callout-warning">Se va a crear un requerimiento para el mantenimiento de un equipo. Por favor seleccione la "Sub linea"</div>');

            } else {

                textosIniciales = ['0'];
                clavesCaracteristicasEquipos = ['0'];

                // Obtener todos los elementos <select> con ID que comienza con "tm_"
                const selects = $('select[id^="tm_"]');
                var bandera = false;

                // Recorrer cada elemento <select>
                selects.each(function () {
                    // Obtener el valor del ID
                    const id = $(this).attr('id');

                    // Obtener el valor del elemento seleccionado
                    const valor = $(this).find('option:selected').val();

                    if (valor.toString() === "-1") {
                        bandera = true;
                    } else {
                        mantenimientoARealizar += valor + '|';                        
                    }
                   
                });

                if (bandera) {
                    $("#btnCrearRequerimiento").prop("disabled", true);
                    $("#divMensajesRequerimientos").html('<div class="alert alert-danger">Por favor seleccione los tipos de mantenimiento a realizar a los equipos. Están al final de cada registro de cada equipo en una lista desplegable!</div>');
                } else {
                    $("#btnCrearRequerimiento").prop("disabled", false);
                    $("#divMensajesRequerimientos").html('');
                }

            }
        }
    });


    $("#btnCrearRequerimiento").click(function () {
        Swal.fire({
            title: 'Pregunta',
            text: '¿Está completamente seguro de crear el requerimiento?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {

            if (result.isConfirmed) {

                if (textosIniciales.length === 0 && clavesCaracteristicasEquipos.length === 0) {

                    $("#divMensajesRequerimientos").html('<div class="callout callout-warning">No encontramos repuestos ni equipos para crear el requerimiento. Puede empezar por seleccionar la <strong>Línea</strong> para luego seleccionar la <strong>Sub línea</strong></div>');
                    $("#ip_grupos").focus();

                } else {

                    $("#divMensajesRequerimientos").html('');

                    if ($("#clienteProvisional").val() === '1') {
                        datosClientePrisional["nit_cliente"] = $("#nit_cliente_cp").val();
                        datosClientePrisional["nombre"] = $("#nombre_cp").val();
                        datosClientePrisional["direccion"] = $("#direccion_cp").val();
                        datosClientePrisional["telefono"] = $("#telefono_cp").val();
                        datosClientePrisional["email"] = $("#email_cp").val();
                        datosClientePrisional["contacto"] = $("#contacto_cp").val();
                        datosClientePrisional["id_region"] = $("#ap_regiones2").val();
                    }

                    $("#mensajesClientesProvisionales").html('');
                    $("#divMensajesRequerimientos").html('');

                    datosRequerimiento.numid = numid;
                    datosRequerimiento.nom_cliente = $("#razon_social").val();
                    datosRequerimiento.cc_contacto = cc_contacto;
                    datosRequerimiento.id_contacto = id_contacto;
                    datosRequerimiento.id_sucursal = id_sucursal;
                    datosRequerimiento.de_linea = $("#ip_lineas").val();
                    datosRequerimiento.misional = $("#ip_grupos").val();
                    datosRequerimiento.observs = $("#textAreaObservaciones").val();
                    datosRequerimiento.id_fuente = $("#fuentes").val();
                    datosRequerimiento.textosIniciales = textosIniciales;
                    datosRequerimiento.valoresIniciales = valoresIniciales;
                    datosRequerimiento.cantidadesIniciales = cantidadesIniciales;
                    datosRequerimiento.notasIniciales = notasIniciales;
                    datosRequerimiento.caracteristicasRespuestos = caracteristicasRepuestosEnviar;
                    datosRequerimiento.textosCaracteristicasRepuestos = textosCaracteristicasRepuestosEnviar;
                    datosRequerimiento.clavesCaracteristicasRespuestos = clavesCaracteristicasRepuestosEnviar;
                    datosRequerimiento.clavesEquipos = clavesEquipos;
                    datosRequerimiento.textosEquipos = textosEquipos;
                    datosRequerimiento.etiquetasEquipos = etiquetasEquipos;
                    datosRequerimiento.cantidadesEquiposEnviar = cantidadesEquiposEnviar;
                    datosRequerimiento.observacionesEquiposEnviar = observacionesEquiposEnviar;
                    datosRequerimiento.texCaracteristicasEquipos = textosCaracteristicasEquipos;
                    datosRequerimiento.clvCaracteristicasEquipos = clavesCaracteristicasEquipos;
                    datosRequerimiento.clienteProvisional = $("#clienteProvisional").val();
                    datosRequerimiento.datosClientePrisional = datosClientePrisional;
                    datosRequerimiento.clienteProvisionalExiste = $("#clienteProvisionalExiste").val();
                    datosRequerimiento.id_provis = $("#id_provis").val();
                    datosRequerimiento.personaNatural = $("#personaNatural").val();
                    datosRequerimiento.lineasRepuestos = lineasRepuestos;
                    datosRequerimiento.lineasEquipos = lineasEquipos;
                    datosRequerimiento.lineasServManteni = lineasServManteni;
                    datosRequerimiento.lineasProyectos = lineasProyectos;
                    datosRequerimiento.repuestosSinExistencia = repuestosSinExistencia;
                    datosRequerimiento.vp_asesor_zona = $("#vp_asesor_zona").val();
                    datosRequerimiento.repNoExiste = repNoExiste;
                    datosRequerimiento.aCompras = aCompras;
                    datosRequerimiento.id_mantenimientos = $("#id_mantenimientos").val();
                    datosRequerimiento.mantenimientoARealizar=mantenimientoARealizar;

                    console.log(datosRequerimiento);

                    $.ajax({
                        url: "../controladores/CT_grabar_requerimiento.php",
                        data: { 'datosAEnviar': datosRequerimiento },
                        type: "POST",
                        success: function (respuesta) {
                            try {
                                var obj = JSON.parse(respuesta);
                                if (obj["id_requerim"] !== '0' && obj["id_reqdet"].length !== 0) {

                                    $("#estadoRequerimiento").val('82');
                                    $("#divBotonGrabarRequerimiento").hide();
                                    $("#divEstadosRequerimiento").show();
                                    $("#divRepuestos").hide();
                                    $("#divMensajesRequerimientos").html('<div class="callout callout-success"><strong>Requerimiento número: ' + obj["id_requerim"] + ' asignado a '+obj["asesor_asignado"]+' creado de manera correcta.</strong> Puede continuar con otra acción o presionar el botón "Limpiar" si desea tomar otro requerimiento!</div>');
                                    $("#divBotonRecargar").show();

                                    //evalua si el permiso para crear la cotización por parte del perfil esta activo
                                    if (permisos.indexOf("COT") !== -1) {
                                        //si el asesor asignado es el mismo que esta grabando el requerimiento entonces muestra el botón 
                                        //para iniciar la cotización                                        
                                        if (obj["usuario_asignd"] === $("#codusr").val()) {
                                            $("#iniciarCotizacion").show();
                                        }
                                    }

                                    //evalua si el permiso para enviar la solicitud a compras está activo
                                    if (permisos.indexOf("RQC") !== -1) {
                                        $("#solicitudACompras").show();
                                    }

                                    $("#tomarOtroRequerimiento").show();
                                    $("#id_requerim").val(obj["id_requerim"]);

                                } else {
                                    $("#divMensajesRequerimientos").html('<div class="callout callout-warning">Esto realmente es vergonsozo!Ha surgido un error durante la grabación del requerimiento. Es necesario volver a tomar toda la información. Podría por favor presionar la combinación de teclas "CTRL" + "SHIFT" + "R" e intentarlo nuevamente? En caso de volver a presentarse el fallo, por favor informe!</div>');
                                }
                            } catch (e) {
                                $("#divMensajesRequerimientos").html('<div class="callout callout-danger">Por favor informe. Ha surgido ERROR DESDE EL SERVIDOR. El texto indica: ' + respuesta + '</div>');
                                //$("#divMensajesRequerimientos").html('<div class="callout callout-danger">Al parecer el cliente no se encuentra zonificado de manera correcta. Por favor informe al responsable del área sobre esta novedad con este cliente</div>');
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
            }
        });
    });

});
