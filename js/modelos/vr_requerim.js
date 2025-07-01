function retornarVRRequerim(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1 || opcion === 3) {

        if (opcion === 1) {
            datosAEnviar = {
                'dtRInicial': $("#dtRInicial").val(),
                'dtRFinal': $("#dtRFinal").val(),
                'am_usuarios': $("#codusr").val(),
                'estadoRequerimiento': '82'
            };
        }

        if (opcion === 3) {
            datosAEnviar = {
                'dtRInicial': $("#dtRInicial").val(),
                'dtRFinal': $("#dtRFinal").val(),
                'am_usuarios': $("#am_usuarios").val(),
                'estadoRequerimiento': $("#estadoRequerimiento").val()
            };
        }

        $.ajax({
            url: "../controladores/CT_vr_requerim.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var tabla = '<table class="table table-hover table-sm" id="tablaRequerimientos" >';
                    tabla += '<thead>';
                    tabla += '<tr>';
                    tabla += '<th>#</th>';
                    tabla += '<th>Req. Nro.</th>';
                    tabla += '<th>Fecha</th>';
                    tabla += '<th>Fuente</th>';
                    tabla += '<th>Usuario asig.</th>';
                    tabla += '<th>Cliente</th>';
                    tabla += '<th>Ciudad</th>';
                    tabla += '<th>Sucursal</th>';
                    tabla += '<th>Contacto</th>';
                    tabla += '<th>Linea</th>';
                    tabla += '<th>Estado</th>';
                    tabla += '<th></th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        tabla += '<tr>';
                        tabla += '<td>' + (i + 1) + '</td>';
                        tabla += '<td>' + obj[i]["id_requerim"] + '</td>';
                        tabla += '<td>' + obj[i]["fechora"] + '</td>';
                        tabla += '<td>' + obj[i]["textoFuente"] + '</td>';
                        tabla += '<td>' + obj[i]["nombre"] + '</td>';
                        tabla += '<td>' + obj[i]["nom_cliente"] + '</td>';
                        tabla += '<td>' + obj[i]["nom_ciudad"] + '</td>';
                        tabla += '<td>' + obj[i]["nom_sucur"] + '</td>';
                        tabla += '<td>' + obj[i]["nom_contacto"] + '</td>';
                        tabla += '<td>' + obj[i]["descrip"] + '</td>';
                        tabla += '<td>' + obj[i]["textoEstado"] + '</td>';
                        tabla += "<td><button class='btn btn-primary' id='" + obj[i]["id_requerim"] + "' name='" + obj[i]["id_requerim"] + "' title='Ver' onclick='redirigir(this.id,1)' ><span class='fa fa-eye's></span></button></td>";
                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';
                    tabla += '</table>';

                    $("#divTituloRequerimientos").show();
                    $("#divListadoRequerimientos").html(tabla);

                    $("#tablaRequerimientos").DataTable({
                        "order": [[1, "asc"]]
                    });

                } else {
                    $("#divTituloRequerimientos").hide();
                    $("#divListadoRequerimientos").html('<div class="callout callout-info">No se registran requerimientos asignados</div>');
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarVRRequerim(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    //para la edicion del requerimiento
    if (opcion === 2) {

        datosAEnviar["id_requerim"] = data;

        $.ajax({
            url: "../controladores/CT_vr_requerim.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {

                console.log('Datos recibidos:', respuesta);

                var obj = JSON.parse(respuesta);
                $("#divEquipos").hide();

                $("#fuentes").val(obj["vr_requerim"][0]["id_fuente"]);

                numid = obj["nm_nits"][0]["numid"];
                id_requerim = data;

                if (obj["nm_nits"] && obj["nm_nits"].length > 0) {
                    const cliente = obj["nm_nits"][0];

                    //para las empresas
                    if (cliente["idclase"] === 31) {
                        retornarNMJuridicas(cliente["numid"], 6);
                        $("#divContactosGeneral").show();
                        retornarNMContactos(obj["vr_requerim"][0]["id_contacto"], 6);
                    }
                
                    //para las personas
                    if (cliente["idclase"] === 13) {
                        $("#divPersonasGeneral").show();
                        retornarNMPersonas(cliente["numid"], 2);
                        $("#divContactosGeneral").show();
                        retornarNMContactos(obj["vr_requerim"][0]["id_contacto"], 6);
                    }
                
                } else if (obj["vr_requerim"].length > 0) {
                    // Mostrar datos de cliente provisional
                    $("#divClientesProvisionales").show();
                    const clienteProv = obj["vr_requerim"][0];
                    
                    $("#nit_cliente_cp").val(clienteProv["nit_cliente"]);
                    $("#nombre_cp").val(clienteProv["nom_cliente"]);
                    $("#direccion_cp").val(clienteProv["dir_cliente"]);
                    $("#telefono_cp").val(clienteProv["tel_cliente"]);
                    $("#email_cp").val(clienteProv["correo_cliente"]);
                    $("#contacto_cp").val(clienteProv["nom_contacto"]);
                }
                


                $("#textAreaObservaciones").val(obj["vr_requerim"][0]["observs"]);

                if (obj["vr_requerimdet"].length === 0) {
                    $("#ip_grupos").val('-1');

                    $("#divEquiposFinales").html('');

                    var datos = {};
                    datos.opcionSeleccionada = null;
                    retornarIPLineas(datos, 2);
                    var data = [];
                    data = {
                        'nombreDiv': 'divLineasMisionales',
                        'opcionSeleccionada': null,
                    };
                    retornarIPGrupos(data, 2);
                } else {
                    var cantRep = 0;

                    var data = {
                        ip_lineas: obj["vr_requerim"][0]["de_linea"],
                        ip_grupos: obj["vr_requerimdet"][0]["misional"],
                        nombreDiv: "divSugerencia",
                    };
                    //retornarVPAsesorZona(data, 2);

                    for (var i = 0; i < obj["vr_requerimdet"].length; i++) {
                        //para los repuestos
                        if (obj["vr_requerimdet"][i]["misional"] === "02") {
                            cantRep += 1;
                            retornarIMItems(data, 15);
                            armarTablaProductos(obj, 2);

                            if (obj["vr_requerimdet"][i]["a_compras"] === 1) {
                                activarReqCompras += 1;
                            }

                            if (obj["vr_requerimdet"][i]["saldo"] !== null) {
                                if (parseInt(obj["vr_requerimdet"][i]["saldo"]) > 0) {
                                    cantRepReq += 1;
                                }
                            }
                        }

                        //para los equipos
                        if (
                            obj["vr_requerimdet"][i]["misional"] === "01" ||
                            obj["vr_requerimdet"][i]["misional"] === "04"
                        ) {
                            $("#divEquiposFinales").show();
                            $("#divEquiposFinales").html(armarTablaEquipos(obj, 2));
                        }

                        //para los mantenimientos
                        if (obj["vr_requerimdet"][i]["misional"] === "03") {
                            $("#divServicioMantenimiento").show();
                            $("#divServicioMantenimiento").html(
                                armarTablaMantenimientos(obj, 2)
                            );
                        }
                    }

                    //para los equipos
                    if (
                        obj["vr_requerimdet"][0]["misional"] === "01" ||
                        obj["vr_requerimdet"][0]["misional"] === "04"
                    ) {
                        $("#iniciarCotizacion").show();
                        $("#solicitudACompras").show();
                    }

                    //evalua si el permiso para enviar la solicitud a compras está activo
                    if (permisos.indexOf("RQC") !== -1) {
                        //si alguno de los registros de los repuestos necesita ser enviado a compras
                        if (activarReqCompras > 0) {
                            $("#solicitudACompras").show();
                        }
                    }

                    //evalua si el permiso para crear la cotización por parte del perfil esta activo
                    if (permisos.indexOf("COT") !== -1) {
                        //si el asesor asignado es el mismo que esta grabando el requerimiento entonces muestra el botón
                        //para iniciar la cotización
                        if (obj["vr_requerim"][0]["asesor_asignd"] === $("#codusr").val()) {
                            //si hay existencias de repuestos suficientes
                            //if (cantRepReq === cantRep) {
                            //    $("#iniciarCotizacion").show();
                            //}
                        }
                    }

                    $("#numeroRequerimiento").html(obj["vr_requerim"][0]["id_requerim"]);

                    $("#estadoRequerimiento").val(obj["vr_requerim"][0]["estado"]);

                    if (
                        obj["vr_requerim"][0]["estado"] === 83 ||
                        obj["vr_requerim"][0]["estado"] === 84
                    ) {
                        $("#adicionarSucursal").hide();
                    } else {
                        $("#iniciarCotizacion").attr(
                            "name",
                            obj["vr_requerim"][0]["id_requerim"]
                        );
                        $("#divBotonRecargar").show();
                        $("#botonLimpiarAbajo").hide();
                    }

                    if (
                        obj["vr_requerim"][0]["estado"] === 82 ||
                        obj["vr_requerim"][0]["estado"] === 84
                    ) {
                        if (parseInt($("#id_rol").val()) <= 4) {
                            var data = {
                                ip_lineas: obj["vr_requerim"][0]["de_linea"],
                                ip_grupos: obj["vr_requerimdet"][0]["misional"],
                                nombreDiv: "divSugerencia",
                            };
                            retornarVPAsesorZona(data, 2);
                        }
                    }

                    //se retiran la capacidad de los select de linea y repuestos de llamar la función asociada al evento onchange
                    if (obj["vr_requerim"][0]["estado"] === 83) {
                        $("#divLineasMisionales").html(
                            obj["vr_requerimdet"][0]["nom_grupo"]
                        );
                        $("#divLineas").html(obj["vr_requerim"][0]["descrip"]);
                    } else {
                        var datos = {};
                        datos.opcionSeleccionada = obj["vr_requerim"][0]["de_linea"];
                        retornarIPLineas(datos, 2);

                        var data = [];
                        data = {
                            nombreDiv: "divLineasMisionales",
                            opcionSeleccionada: obj["vr_requerimdet"][0]["misional"],
                        };
                        retornarIPGrupos(data, 2);
                    }

                    //si crearRequerimientosACompras=0 quiere decir que no es necesario crear el requerimiento y puede pasar de una vez a la cotización
                    if (crearRequerimientoACompras === 0) {
                        $("#iniciarCotizacion").show();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert(
                    "Error en function retornarVRRequerim(data, opcion=4) {...\nError desde el servidor. Por favor informe a soporte"
                );
            },
        });
    }

    if (opcion === 4) {
        datosAEnviar = {
            dtRInicial: $("#dtRInicial").val(),
            dtRFinal: $("#dtRFinal").val(),
            am_usuarios: $("#am_usuarios").val(),
            estadoRequerimiento: $("#estadoRequerimiento").val(),
        };

        $.ajax({
            url: "../controladores/CT_vr_requerim.php",
            data: { caso: "7", datosAEnviar: datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                //console.log(respuesta);
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var tabla =
                        '<table class="table table-hover table-sm" id="tablaRequerimientos" >';
                    tabla += "<thead>";
                    tabla += "<tr>";
                    tabla += "<th>#</th>";
                    tabla += "<th>Req. Nro.</th>";
                    tabla += "<th>Fecha</th>";
                    tabla += "<th>Fuente</th>";
                    tabla += "<th>Usuario asig.</th>";
                    tabla += "<th>Cliente</th>";
                    tabla += "<th>Ciudad</th>";
                    tabla += "<th>Sucursal</th>";
                    tabla += "<th>Contacto</th>";
                    tabla += "<th>Linea</th>";
                    tabla += "<th>Estado</th>";
                    tabla += "<th></th>";
                    tabla += "</tr>";
                    tabla += "</thead>";
                    tabla += "<tbody>";

                    for (var i = 0; i < obj.length; i++) {
                        tabla += "<tr>";
                        tabla += "<td>" + (i + 1) + "</td>";
                        tabla += "<td>" + obj[i]["id_requerim"] + "</td>";
                        tabla += "<td>" + obj[i]["fechora"] + "</td>";
                        tabla += "<td>" + obj[i]["textoFuente"] + "</td>";
                        tabla += "<td>" + obj[i]["nombre"] + "</td>";
                        tabla += "<td>" + obj[i]["nom_cliente"] + "</td>";
                        tabla += "<td>" + obj[i]["nom_ciudad"] + "</td>";
                        tabla += "<td>" + obj[i]["nom_sucur"] + "</td>";
                        tabla += "<td>" + obj[i]["nom_contacto"] + "</td>";
                        tabla += "<td>" + obj[i]["descrip"] + "</td>";
                        tabla += "<td>" + obj[i]["textoEstado"] + "</td>";
                        tabla +=
                            "<td><button class='btn btn-primary' id='" +
                            obj[i]["id_requerim"] +
                            "' name='" +
                            obj[i]["id_requerim"] +
                            "' title='Ver' onclick='redirigir(this.id,1)' ><span class='fa fa-eye's></span></button></td>";
                        tabla += "</tr>";
                    }

                    tabla += "</tbody>";
                    tabla += "</table>";

                    $("#divTituloRequerimientos").show();
                    $("#divListadoRequerimientos").html(tabla);

                    $("#tablaRequerimientos").DataTable({
                        order: [[1, "asc"]],
                    });
                } else {
                    $("#divTituloRequerimientos").hide();
                    $("#divListadoRequerimientos").html(
                        '<div class="callout callout-info">No se registran requerimientos asignados</div>'
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert(
                    "Error en function retornarVRRequerim(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte"
                );
            },
        });
    }
}

function cambiarVRRequerim(data, opcion) {
    if (opcion === 1) {
        Swal.fire({
            title: "Confirmación",
            text: "¿Cambiar el asesor asignado?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {
                var datosAEnviar = {
                    id_requerim: $("#id_requerim").val(),
                    asesor_asignd: $("#asesores").val(),
                };
                $.ajax({
                    url: "../controladores/CT_vr_requerim.php",
                    data: { caso: "6", datosAEnviar: datosAEnviar },
                    type: "POST",
                    success: function (respuesta) {
                        var obj = JSON.parse(respuesta);
                        if (obj) {
                            $("#divMensajesRequerimientos").html(
                                '<div class="callout callout-success">Asesor asignado de manera correcta</div>'
                            );
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("Error en la solicitud AJAX:");
                        console.log("Texto de error: " + textStatus);
                        console.log("Error lanzado: " + errorThrown);
                        console.log("Respuesta del servidor:");
                        console.log(jqXHR.responseText);
                        alert(
                            "Error $('#btnCrearRequerimiento').click(function () {...\nError from server, please call support"
                        );
                    },
                });
            }
        });
    }

    if (opcion === 2) {
        var datosAEnviar = {
            id_requerim: $("#id_requerim").val(),
            asesor_asignd: $("#asesores").val(),
        };
        $.ajax({
            url: "../controladores/CT_vr_requerim.php",
            data: { caso: "6", datosAEnviar: datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj) {
                    $("#divMensajesRequerimientos").html(
                        '<div class="callout callout-success">Asesor asignado de manera correcta</div>'
                    );
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert(
                    "Error $('#btnCrearRequerimiento').click(function () {...\nError from server, please call support"
                );
            },
        });
    }
}
