//function retornarVRRequerimDet(data, opcion) {
//    
//}

function crearVRRequerimDet(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {
        var marca = $("#ip_marcas").val();
        var cod_item = null, tipo = null;

        if ($("#ip_marcas").val().length === 0) {
            marca = respuestosCantidados["id_marca"];
        }

        if (respuestosCantidados !== null) {
            cod_item = respuestosCantidados["cod_item"];
            tipo = $("#id_tipos").val();
        } else {
            cod_item = '0';
            tipo = '0';
        }

        datosAEnviar = {
            'id_requerim': $("#id_requerim").val(),
            'linea': $("#ip_lineas").val(),
            'misional': $("#ip_grupos").val(),
            'articulo': $("#grup_items").val(),
            'tipo': tipo,
            'marca': marca,
            'cod_item': cod_item,
            'cantidad': $("#cantidadRepuestos").val(),
            'observs': $("#notasRepuestos").val(),
            'caracteristicasRepuestos': caracteristicasRepuestos,
            'arregloCaracteristicas': arregloCaracteristicas
        };

        //esto es para cuando digitan el código del artículo/repuesto/item en cod_item en edit_requer.php 
        //los datos enviados a CT_vr_requerimdet son de tipo arreglo
        //por eso el [$("#id").val()] al tomar el dato
        if (datosAEnviar.articulo.length === 0 && datosAEnviar.tipo === undefined && datosAEnviar.marca === "0") {
            datosAEnviar.articulo = [$("#grup_items2").val()];
            datosAEnviar.tipo = [$("#tipos2").val()];
            datosAEnviar.marca = [$("#marcas2").val()];
        }

        $.ajax({
            url: "../controladores/CT_vr_requerimdet.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (parseInt(obj["vr_requerimdet"]) > 0) {
                    location.reload();
                    respuestosCantidados = null;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarVRRequerimDet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        var caracteristicasAEnviar = {};

        for (var i = 0; i < arregloCaracteristicas.length; i++) {
            caracteristicasAEnviar[i] = $("#" + arregloCaracteristicas[i]).val();
        }

        datosAEnviar = {
            'caracteristicas': arregloCaracteristicas,
            'valoresCaracteristicas': caracteristicasAEnviar,
            'observs': $("#observacionesEquipos").val(),
            'cantidad': $("#cantidadEquipos").val(),
            'id_requerim': $("#id_requerim").val(),
            'misional': $("#ip_grupos").val(),
            'linea': $("#ip_lineas").val(),
            'articulo': $("#im_items2").val(),
            'tipo': $("#ip_tipos").val(),
            'marca': $("#ip_marcas").val()
        };

        $.ajax({
            url: "../controladores/CT_vr_requerimdet.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (parseInt(obj["vr_requerimdet"]) > 0) {
                    location.reload();
                    arregloCaracteristicas = [];
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarVRRequerimDet(data, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }

}

function borrarVRRequerimDet(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1 || opcion === 2) {

        Swal.fire({
            title: 'Pregunta',
            text: 'Esta completamente seguro?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {

            if (result.isConfirmed) {

                if (opcion === 1) {
                    datosAEnviar = {
                        'id_reqdet': data
                    };
                }

                if (opcion === 2) {
                    datosAEnviar = {
                        'id_reqdet': data.substring(2),
                        'id_requerim': $("#id_requerim").val()
                    };
                }

                $.ajax({
                    url: "../controladores/CT_vr_requerimdet.php",
                    data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
                    type: "POST",
                    success: function (respuesta) {
                        var obj = JSON.parse(respuesta);
                        if (obj.vr_requerimdet === 1 && obj.vr_requerimcar === 1) {
                            location.reload();
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error en la solicitud AJAX:");
                        console.log("Texto de error: " + textStatus);
                        console.log("Error lanzado: " + errorThrown);
                        console.log("Respuesta del servidor:");
                        console.log(jqXHR.responseText);
                        alert("Error en function borrarVRRequerimDet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                    }
                });

            }
        });
    }
}

function cambiarVRRequerimDet(data, opcion) {
    if (opcion === 1) {

        Swal.fire({
            title: 'Confirmación',
            text: '¿Cambiar el estado de envío a compras?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {

                var a_compras = 0;
                if ($("#" + data).prop('checked')) {
                    a_compras = 1;
                } else {
                    a_compras = 0;
                }
                var datosAEnviar = {
                    'id_reqdet': data.slice(3),
                    'a_compras': a_compras
                };
                $.ajax({
                    url: "../controladores/CT_vr_requerimdet.php",
                    data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
                    type: "POST",
                    success: function (respuesta) {
                        var obj = JSON.parse(respuesta);
                        if (obj) {
                            id_requerim = $.urlParam('id_requerim');
                            retornarVRRequerim($.urlParam('id_requerim'), 2);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error en la solicitud AJAX:");
                        console.log("Texto de error: " + textStatus);
                        console.log("Error lanzado: " + errorThrown);
                        console.log("Respuesta del servidor:");
                        console.log(jqXHR.responseText);
                        alert("Error function cambiarVRRequerimDet(data, opcion) {...\nError from server, please call support");
                    }
                });
            }
        });
    }

    if (opcion === 2) {
        var datosAEnviar = {
            'id_requerim': $("#id_requerim").val()
        };
        $.ajax({
            url: "../controladores/CT_vr_requerimdet.php",
            data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                try {
                    var obj = JSON.parse(respuesta);
                    if (obj) {
                        $("#divMensajesRequerimientos").html('<div class="callout callout-info"><strong>Se han enviado las solicitudes de los repuestos no existentes en este requerimiento al área de compras</div>');
                    }
                } catch (e) {
                    $("#divMensajesRequerimientos").html('<div class="callout callout-danger"><strong>Ha surgido un error al iniciar el llamado a ' + respuesta + '. Por favor informe</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error function cambiarVRRequerimDet(data, opcion) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 3) {

        var partes=data.split("_");

        var datosAEnviar = {
            'id_reqdet': partes[1],
            'modo_import':$("#"+data).val()
        };
        $.ajax({
            url: "../controladores/CT_vr_requerimdet.php",
            data: { 'caso': '6', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                try {
                    var obj = JSON.parse(respuesta);
                    if (obj) {
                        $("#divMensajesRequerimientos").html('<div class="callout callout-info"><strong>Se cambiado la solicitud de modo de importación para el artículo</div>');
                    }
                } catch (e) {
                    $("#divMensajesRequerimientos").html('<div class="callout callout-danger"><strong>Ha surgido un error al iniciar el llamado a ' + respuesta + '. Por favor informe</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error function cambiarVRRequerimDet(data, opcion) {...\nError from server, please call support");
            }
        });
    }
}