function retornarVRCotiza(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        datosAEnviar["id_consecot"] = datos;

        $.ajax({
            url: "../controladores/CT_vr_cotiza.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                suc_cliente = obj["vr_cotiza"][0]["suc_cliente"];

                    if ($("#codprog").val() === 'cotiza') {                        
                        $("#btnGenerarPDFRepuestos").show();
                        $("#btnEnviarPDFRepuestos").show();
                        $("#btnGenerarPDFEquipos").hide();
                        $("#btnEnviarPDFEquipos").hide();
                    }

                    if ($("#codprog").val() === 'cot_equipos') {
                        $("#btnGenerarPDFEquipos").show();
                        $("#btnEnviarPDFEquipos").show();
                        $("#btnGenerarPDFRepuestos").hide();
                        $("#btnEnviarPDFRepuestos").hide();
                    }

                if (obj["vr_cotiza"][0]["estado"] === 111) {
                    $("#btnGuardarCotizacion").hide();
                    $("#divParametrosIniciales").hide();
                    $("#btnGenerarPDFEquipos").hide();
                    $("#btnEnviarPDFEquipos").hide();
                    //$("#btnGenerarPDFRepuestos").hide();
                    //$("#btnEnviarPDFRepuestos").show();
                    $("#btnGenerarPDFRepuestos").show();
                    $("#btnEnviarPDFRepuestos").hide();
                }

                $("#divValorTRMCotizacion").html("Cotizacion: <strong>" + obj["vr_cotiza"][0]["trm"] + "</strong>");

                $("#divNumeroCotizacion").html(obj["vr_cotiza"][0]["nro_cot"]);
                $("#version").val(obj["vr_cotiza"][0]["version"]);
                $("#trans_base").val(obj["vr_cotiza"][0]["trans_base"]);
                $("#fecha_ini").val(obj["vr_cotiza"][0]["fecha_ini"]);
                $("#fecha_vence").val(obj["vr_cotiza"][0]["fecha_vence"]);
                $("#vp_vigencia").val(obj["vr_cotiza"][0]["vigencia"]);

                $("#divFechaVenceCotizacion").html();

                $("#estadoCotizacion").val(obj["vr_cotiza"][0]["estado"]);

                $("#estadoCotizacion option[value='-2']").remove();
                if (obj["vr_cotiza"][0]["estado"] === 111) {
                    $("#estadoCotizacion option[value='110']").remove();
                    $("#estadoCotizacion option[value='113']").remove();
                } else if (obj["vr_cotiza"][0]["estado"] === 113) {
                    $("#estadoCotizacion option[value='110']").remove();
                }

                $("#vp_terminospago").val(obj["vr_cotiza"][0]["termn_pago"]);
                $("#moneda").val(obj["vr_cotiza"][0]["id_moneda"]);

                $("#divEquipos").hide();

                numid = obj["nm_nits"][0]["numid"];
                id_consecot = datos;

                //para las empresas
                if (obj["nm_nits"][0]["idclase"] === 31) {
                    retornarNMJuridicas(obj["nm_nits"][0]["numid"], 6);
                    $("#divContactosGeneral").show();
                    retornarNMContactos(obj["vr_cotiza"][0]["id_contacto"], 6);
                }

                //para las personas
                if (obj["nm_nits"][0]["idclase"] === 13) {
                    $("#divPersonasGeneral").show();
                    retornarNMPersonas(obj["nm_nits"][0]["numid"], 2);
                    $("#divContactosGeneral").show();
                    retornarNMContactos(obj["vr_cotiza"][0]["id_contacto"], 6);
                }

                //en la tabla vr_cotiza no esta el campo de las observaciones
                //$("#textAreaObservaciones").val(obj["vr_cotiza"][0]["observs"]);

                for (var i = 0; i < obj["vr_cotizadet"].length; i++) {

                    //para los equipos
                    if (obj["vr_cotizadet"][i]["misional"] === '01' || obj["vr_cotizadet"][i]["misional"] === '04') {
                        $("#btnRevisarEquipos").show();
                    }

                    if (obj["vr_cotizadet"][i]["misional"] === '02') {
                        $("#btnRevisarRepuestos").show();
                    }

                    //para los repuestos
                    if ($("#codprog").val() === 'cotiza') {
                        if (obj["vr_cotizadet"][i]["misional"] === '02') {
                            var data = {
                                'ip_lineas': obj["vr_cotizadet"][i]["linea"],
                                'ip_grupos': obj["vr_cotizadet"][i]["misional"]
                            };
                            retornarIMItems(data, 15);
                            armarTablaProductos(obj, 3);
                        }
                    }

                    //para los equipos
                    if ($("#codprog").val() === 'cot_equipos') {
                        if (obj["vr_cotizadet"][i]["misional"] === '01' || obj["vr_cotizadet"][i]["misional"] === '04') {
                            $("#divEquiposFinales").show();
                            $("#divEquiposFinales").html(armarTablaEquipos(obj, 3));
                        }
                    }
                }

                var datos = {};
                datos.opcionSeleccionada = obj["vr_cotizadet"][0]["linea"];
                retornarIPLineas(datos, 2);

                var data = [];
                data = {
                    'nombreDiv': 'divLineasMisionales',
                    'opcionSeleccionada':obj["vr_cotizadet"][0]["misional"]
                };
                retornarIPGrupos(data, 2);   
                

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function retornarVRCotiza(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }

    if (opcion === 2) {

        datosAEnviar.estado = $("#estadoCotizacion").val();
        datosAEnviar.fechaInicial = $("#fecha_ini1").val();
        datosAEnviar.fechaFinal = $("#fecha_fin1").val();
        datosAEnviar.usuario = $("#am_usuarios1").val();

        if(datosAEnviar.estado===undefined){            
            datosAEnviar.estado = 110;
        }

        if(datosAEnviar.usuario===undefined){            
            datosAEnviar.usuario = $("#codusr").val();
        }
        
        $("#divTituloCotizaciones").hide();

        $.ajax({
            url: "../controladores/CT_vr_cotiza.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    var tabla = '<table class="table table-hover table-sm" id="tablaCotizaciones" >';
                    tabla += '<thead>';
                    tabla += '<tr>';
                    tabla += '<th>Cot. Nro.</th>';
                    tabla += '<th>Fecha</th>';
                    tabla += '<th>Usuario asig.</th>';
                    tabla += '<th>Cliente</th>';
                    tabla += '<th>Ciudad</th>';
                    tabla += '<th>Sucursal</th>';
                    tabla += '<th>Contacto</th>';
                    tabla += '<th>Estado</th>';
                    tabla += '<th></th>';
                    tabla += '<th></th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        tabla += '<tr>';
                        tabla += '<td>' + obj[i]["nro_cot"] + '_' + obj[i]["version"] + '</td>';
                        tabla += '<td>' + obj[i]["fecha_ini"] + '</td>';
                        tabla += '<td>' + obj[i]["usuario"] + '</td>';
                        tabla += '<td>' + obj[i]["razon_social_empresa"] + '</td>';
                        tabla += '<td>' + obj[i]["ciudad"] + '</td>';
                        tabla += '<td>' + obj[i]["sucursal"] + '</td>';

                        if(obj[i]["nombre_persona"]===null){
                            tabla += '<td>' + obj[i]["razon_social_empresa"] + '</td>';
                        }else{
                            tabla += '<td>' + obj[i]["nombre_persona"] + '</td>';
                        }
                                                
                        tabla += '<td>' + obj[i]["nombreEstado"] + '</td>';

                        switch (obj[i]["misional"]) {
                            case '01':
                                tabla += '<td><button class="btn btn-danger" id="' + obj[i]["id_consecot"] + '" name="' + obj[i]["id_consecot"] + '" title="Ver" onclick="redirigir(this.id,4)"><span class="fa fa-eye"></span></button></a></td>';
                                break;
                            case '02':
                                tabla += '<td><button class="btn btn-primary" id="' + obj[i]["id_consecot"] + '" name="' + obj[i]["id_consecot"] + '" title="Ver" onclick="redirigir(this.id,2)"><span class="fa fa-eye"></span></button></a></td>';
                                break;

                        }

                        if (obj[i]["estado"] === 110) {
                            tabla += '<td></td>';
                        } else {
                            tabla += '<td><button class="btn btn-primary" id="' + obj[i]["id_consecot"] + '" name="' + obj[i]["nro_cot"] + '_' + obj[i]["version"] + '" title="Nueva versión" onclick="redirigir(this.name,3)"><span class="fa fa-star"></span></button></a></td>';
                        }

                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';
                    tabla += '</table>';

                    $("#divTituloCotizaciones").show();
                    $("#divListadoCotizaciones").html(tabla);

                    $("#tablaCotizaciones").DataTable({
                        "order": [[1, "asc"]]
                    });

                } else {
                    $("#divListadoCotizaciones").html('<div class="callout callout-info">No se registran cotizaciones con los parámetros ingresados</div>');
                }



            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function retornarVRCotiza(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 3) {
        
        var datosAEnviar={};

        datosAEnviar.usuario=$("#codusr").val();

        $.ajax({
            url: "../controladores/CT_vr_cotiza.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                $("#totalCotComercial").html(obj.length);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function retornarVRCotiza(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }     
        });
    }
}

function cambiarVRCotiza(datos, opcion) {

    var datosAEnviar = {};

    datosAEnviar.id_consecot = $("#id_consecot").val();

    if (opcion === 1) {

        if ($("#estadoCotizacion").val() === 'null' || $("#estadoCotizacion").val() === null) {
            $("#divMensajesRequerimientos").html('<div class="callout callout-warning">Por favor seleccione un estado válido para la cotización</div>');
            $("#estadoCotizacion").focus();
        } else {

            $("#divMensajesRequerimientos").html('');

            datosAEnviar.vp_termn_pago = $("#vp_terminospago").val();
            datosAEnviar.estado = $("#estadoCotizacion").val();
            datosAEnviar.id_moneda = $("#moneda").val();
            datosAEnviar.vigencia = $("#vp_vigencia").val();
            datosAEnviar.fecha_vence = $("#fecha_vence").val();
            datosAEnviar.sem_entrega = $("#sem_entrega").val();
            datosAEnviar.id_contacto = $("#id_contacto").val();

            $.ajax({
                url: "../controladores/CT_vr_cotiza.php",
                data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj) {
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("Error en la solicitud AJAX:");
                    console.log("Texto de error: " + textStatus);
                    console.log("Error lanzado: " + errorThrown);
                    console.log("Respuesta del servidor:");
                    console.log(jqXHR.responseText);
                    alert("Error en function retornarVRCotiza(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });

        }

    }

}
