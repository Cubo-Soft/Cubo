function retornarNMSucursal(data, opcion) {

    if (opcion === 1 || opcion === 4) {
        var datosAEnviar = {
            'numid': data["numid"]
        };
        $.ajax({
            url: "../controladores/CT_nm_sucursal.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (opcion === 1) {
                    if (obj.length === 1) {
                        id_sucursal = obj[0]["id_sucursal"];
                        $("#id_sucursal").val(obj[0]["id_sucursal"]);
                    } else {
                        id_sucursal = 0;
                    }

                    if (obj.length > 0) {
                        $("#divSucursalesGeneral").show();
                        $("#listaSucursales").html(crearTablaSucursales(obj, 1));
                        $("#listaSucursales").show();
                        

                        //si la lista de sucursales es igual a 1 entonces
                        //trae los contactos asociados a dicha sucursal
                        if (obj.length === 1) {
                            //la función retira los primeros 4 caracteres del parámetro 
                            //se ve mejor su funcionamiento en la función crearTablaSucursales(obj,1) linea 2552
                            retornarNMContactos('nmc_' + obj[0]["id_sucursal"], 5);
                        }

                    } else {
                        $("#divSucursalesGeneral").show();
                        $("#datosSucursales").show();
                    }
                }

                if (opcion === 4) {
                    $("#divSucursales").html(crearTablaSucursales(obj, 2));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMSucursal(data, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2 || opcion === 3) {

        $("#ubicacionGeograficaSucursales").show();
        $("#datosSucursales").show();
        $("#listaSucursales").hide();
        $("#divContactos").hide();
        $("#editarCrearContacto").hide();
        $("#adicionarSucursal1").hide();
        $("#mensajesUbicacion").html('');
        $("#modificarSucursal").show();

        if (opcion === 2) {
            var datosAEnviar = {
                'id_sucursal': data.substring(4, data.length)
            };
        }

        if (opcion === 3) {
            var datosAEnviar = {
                'id_sucursal': data["id_sucursal"]
            };
        }

        $.ajax({
            url: "../controladores/CT_nm_sucursal.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                $("#direccion").val(obj[0]["direccion"]);
                $("#np_ciudades").val(obj[0]["ciudad"]);
                $("#telefono").val(obj[0]["telefono"]);
                $("#nom_sucur").val(obj[0]["nom_sucur"]);
                $("#suc_lat_gps").val(obj[0]["suc_lat_gps"]);
                $("#suc_lng_gps").val(obj[0]["suc_lng_gps"]);
                $("#id_sucursal").val(obj[0]["id_sucursal"]);
                $("#codigo_helisa").val(obj[0]["cod_clie_helisa"]);
                $("#ap_regiones").val(obj[0]["id_region"]);

                if (obj[0]["estado"] === 1) {
                    $("#estadoSede").prop("checked", true);
                } else {
                    $("#estadoSede").prop("checked", false);
                }

                var suc_lat_gps = parseFloat(obj[0]["suc_lat_gps"]);
                var suc_lng_gps = parseFloat(obj[0]["suc_lng_gps"]);

                map.setView([suc_lat_gps, suc_lng_gps], 18);

                var marker = L.marker([suc_lat_gps, suc_lng_gps]).addTo(map);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMSucursal(data, opcion=2) {...\nError from server, please call support");
            }
        });
    }
}

function modificarNMSucursal(data, opcion) {
    if (opcion === 1) {

        var estado = 0;

        if ($("#estadoSede").prop("checked")) {
            estado = 1;
        }

        var datosAEnviar = {
            'id_sucursal': $("#id_sucursal").val(),
            'nom_sucur': $("#nom_sucur").val(),
            'np_ciudades': $("#np_ciudades").val(),
            'direccion': $("#direccion").val(),
            'telefono': $("#telefono").val(),
            'suc_lng_gps': $("#suc_lng_gps").val(),
            'suc_lat_gps': $("#suc_lat_gps").val(),
            'estado': estado,
            'codigo_helisa': $("#codigo_helisa").val(),
            'id_region': $("#ap_regiones").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_sucursal.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj) {
                    var data = {
                        'numid': $("#numid").val()
                    };
                    retornarNMSucursal(data, 1);
                    $("#datosSucursales").hide();
                } else {
                    $("#mensajesUbicacion").html('<div class="callout callout-success">Esto es verdaderamente incomodo. Podría por favor presionar la combinación de teclas "CTRL + R"? Fallo la modificación de la sede!</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function modificarNMSucursal(data, opcion=1) {...\nError from server, please call support");
            }
        });

    }
}

function crearNMSucursal(data, opcion) {
    if (opcion === 1) {

        if (validarCampos(1) === 6) {

            var datosAEnviar = {
                'id_sucursal': -1,
                'numid': $("#numid").val(),
                'nom_sucur': $("#nom_sucur").val(),
                'np_ciudades': $("#np_ciudades").val(),
                'direccion': $("#direccion").val(),
                'telefono': $("#telefono").val(),
                'telefono2': $("#telefono2").val(),
                'fax': $("#fax").val(),
                'suc_lng_gps': $("#suc_lng_gps").val(),
                'suc_lat_gps': $("#suc_lat_gps").val(),
                'codigo_helisa': $("#codigo_helisa").val(),
                'tipo_entidad': $("#ip_dtbasicos").val(),
                'id_region': $("#ap_regiones").val()
            };


            $.ajax({
                url: "../controladores/CT_nm_sucursal.php",
                data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj > 0) {
                        $("#datosSucursales").hide();
                        $("#listarSucursales").show();
                        retornarNMNits(null, 4);
                    } else {
                        $("#mensajesUbicacion").html('<div class="callout callout-success">Esto es verdaderamente incomodo. Podría por favor presionar la combinación de teclas "CTRL + R"? Fallo la modificación de la sede!</div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function crearNMSucursal(data, opcion=1) {...\nError from server, please call support");
                }
            });
        }
    }
}