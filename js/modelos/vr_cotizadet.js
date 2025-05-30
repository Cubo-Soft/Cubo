function retornarVRCotizadet(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        datosAEnviar["id_consecot"] = datos;

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function retornarVRCotizadet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }

}

function cambiarVRCotizadet(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        var division = datos.split("_");

        datosAEnviar.id_orden = division[1];
        datosAEnviar.cantidad = $("#" + datos).val();

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        var division = datos.split("_");

        datosAEnviar.id_orden = division[1];
        datosAEnviar.observs = $("#" + datos).val();

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 3) {

        var division = datos.split("_");

        datosAEnviar.id_orden = division[1];
        datosAEnviar.observs = $("#" + datos).val();

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 4) {

        var division = datos.split("_");

        datosAEnviar.id_orden = division[1];
        datosAEnviar.valor_unit = $("#" + datos).val();

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=5) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 5) {

        if ($("#ip_tipos").val() === '-1' && $("#ip_marcas").val() === '-1') {

            $("#divMensajesEquipos").html('<div class="callout callout-warning">Por favor verifique el <strong>Tipo</strong> y/o la <strong>Marca</strong></div>');

        } else {

            var id = datos.id;
            var division = id.split("_");

            datosAEnviar.id_orden = division[1];

            if ($("#ip_tipos").val() === '-1') {
                datosAEnviar.tipo = 0;
            } else {
                datosAEnviar.tipo = $("#ip_tipos").val();
            }

            if ($("#ip_marcas").val() === '-1') {
                datosAEnviar.marca = 0;
            } else {
                datosAEnviar.marca = $("#ip_marcas").val();
            }


            $.ajax({
                url: "../controladores/CT_vr_cotizadet.php",
                data: { 'caso': '6', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj) {
                        id_consecot = $.urlParam('id_consecot');
                        retornarVRCotiza($.urlParam('id_consecot'), 1);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error en la solicitud AJAX:");
                    console.log("Texto de error: " + textStatus);
                    console.log("Error lanzado: " + errorThrown);
                    console.log("Respuesta del servidor:");
                    console.log(jqXHR.responseText);
                    alert("Error en function cambiarVRCotizadet(data, opcion=6) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }
    }

    if (opcion === 6) {

        datosAEnviar.id_orden = datos.slice(2);
        datosAEnviar.dscto_item = parseFloat($("#" + datos).val());

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '8', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=5) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }

    if (opcion === 7) {

        datosAEnviar.id_orden = datos.slice(2);
        datosAEnviar.sem_dispo = parseFloat($("#" + datos).val());

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '9', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizadet(data, opcion=5) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }

}

function borrarVRCotizadet(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1 || opcion === 2) {

        Swal.fire({
            title: 'Confirmación',
            text: 'Por favor confirme. Borrar este producto de la cotización?\nEsta seguro?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {

            if (result.isConfirmed) {

                if (opcion === 1) {
                    datosAEnviar.id_orden = datos;
                }

                if (opcion === 2) {

                    var division = datos.split("_");
                    datosAEnviar.id_orden = division[1];
                }

                $.ajax({
                    url: "../controladores/CT_vr_cotizadet.php",
                    data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
                    type: "POST",
                    success: function (respuesta) {
                        var obj = JSON.parse(respuesta);
                        if (opcion === 1) {
                            if (obj) {
                                location.reload();
                            }
                        }

                        if (opcion === 2) {
                            if (obj.vr_cotizadet === 1 && obj.vr_cotizcar === 1) {
                                id_consecot = $.urlParam('id_consecot');
                                retornarVRCotiza($.urlParam('id_consecot'), 1);
                            }
                        }

                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error en la solicitud AJAX:");
                        console.log("Texto de error: " + textStatus);
                        console.log("Error lanzado: " + errorThrown);
                        console.log("Respuesta del servidor:");
                        console.log(jqXHR.responseText);
                        alert("Error en function borrarVRCotizadet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                    }
                });


            }
        });

    }
}

function crearVRCotizaDet(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {
        var marca = $("#ip_marcas").val();

        if ($("#ip_marcas").val().length === 0) {
            marca = respuestosCantidados["id_marca"];
        }

        if(caracteristicasRepuestos.length===0){
            caracteristicasRepuestos[0]=null;
        }

        if(arregloCaracteristicas.length===0){
            arregloCaracteristicas[0]=null;
        }

        datosAEnviar = {
            'id_consecot': $("#id_consecot").val(),
            'linea': $("#ip_lineas").val(),
            'misional': $("#ip_grupos").val(),
            'articulo': $("#grup_items").val(),
            'tipo': $("#id_tipos").val(),
            'marca': marca,
            'cod_item': respuestosCantidados.cod_item,
            'nom_item': respuestosCantidados.nom_item,
            'cantidad': $("#cantidadRepuestos").val(),
            'observs': $("#notasRepuestos").val(),
            'version': $("#version").val(),
            'descrip': respuestosCantidados.descrip,
            'iva': respuestosCantidados.iva,
            'precio_vta': respuestosCantidados.precio_vta,
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
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (parseInt(obj["vr_cotizadet"]) > 0) {
                    location.reload();
                    respuestosCantidados = null;
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function crearVRCotizaDet(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        if (caracteristicasRepuestos.length === 0) {
            for (var i = 0; i < arregloCaracteristicas.length; i++) {
                caracteristicasRepuestos[i] = $("#" + arregloCaracteristicas[i]).val();
            }
        }

        datosAEnviar = {
            'id_consecot': $("#id_consecot").val(),
            'version': $("#version").val(),
            'linea': $("#ip_lineas").val(),
            'misional': $("#ip_grupos").val(),
            'articulo': $("#im_items2").val(),
            'tipo': $("#ip_tipos").val(),
            'marca': $("#ip_marcas").val(),
            'cod_item': '0',
            'cantidad': $("#cantidadEquipos").val(),
            'observs': $("#observacionesEquipos").val(),
            'caracteristicasRepuestos': caracteristicasRepuestos,
            'arregloCaracteristicas': arregloCaracteristicas
        };

        $.ajax({
            url: "../controladores/CT_vr_cotizadet.php",
            data: { 'caso': '7', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (parseInt(obj["vr_cotizadet"]) > 0) {
                    location.reload();
                    caracteristicasRepuestos = [];
                    arregloCaracteristicas = [];
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function crearVRCotizaDet(data, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}