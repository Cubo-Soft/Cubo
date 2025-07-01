function retornarAPZonas(data, opcion) {

    var datosAEnviar = [];

    if (opcion === 1) {
        if ($("#ip_regiones").val() !== '-1') {
            datosAEnviar = {
                'region': $("#ip_regiones").val()
            };
            $.ajax({
                url: "../controladores/CT_ap_zonas.php",
                data: {'caso': '1', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    var datos = {
                        'nombreSelect': 'ap_zonas',
                        'nombreFuncion': 'retornarAPSubZonas(this.id,2)'
                    };

                    var datosDeLista = {
                        'valor': 'id_zona',
                        'texto': 'nom_zona'
                    };

                    $("#divZonas").show();

                    $("#estadoRegiones").val(obj[0]["estadoRegion"]);

                    var predeterminado = 0;

                    if (data !== null) {
                        predeterminado = data;
                        $("#estadoZonas").val('78');
                        retornarAPSubZonas(data, 2);
                    }

                    $("#divListadoZonas").html(crearSelect(datos, obj, datosDeLista, predeterminado));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPRegiones(data,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        } else {
            $("#divZonas").hide();
            $("#divSubZonas").hide();
            $("#estadoRegiones").val('-1');
        }
    }
}

function modificarAPZonas(data, opcion) {

    var datosAEnviar = [];

    if (opcion === 1) {
        datosAEnviar = {
            'id_zona': $("#ap_zonas").val(),
            'nom_zona': $("#nom_zona").val(),
            'estado': $("#estadoZonas").val(),
            'region': $("#ip_regiones").val()
        };
        $.ajax({
            url: "../controladores/CT_ap_zonas.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    retornarAPZonas(null, 1);
                    $("#estadoZonas").val('-1');
                    $("#nom_zona").val('');
                    $("#mensajesZonas").html("<div class='callout callout-success'>Zona modificada de manera correcta</div>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function modificarAPZonas(data, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {
        datosAEnviar = {
            'id_zona': $("#ap_zonas").val(),
            'estado': $("#estadoZonas").val()
        };
        $.ajax({
            url: "../controladores/CT_ap_zonas.php",
            data: {'caso': '3', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    retornarAPZonas(null, 1);
                    $("#estadoZonas").val('-1');
                    $("#nom_zona").val('');
                    $("#mensajesZonas").html("<div class='callout callout-success'>Zona modificada de manera correcta</div>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function modificarAPZonas(data, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}

function adicionarAPZonas(data, opcion) {

    var datosAEnviar = [];

    if (opcion === 1) {

        datosAEnviar = {
            'id_zona': $("#ap_zonas").val(),
            'region': $("#ip_regiones").val(),
            'nom_zona': $("#nom_zona").val()
        };
        $.ajax({
            url: "../controladores/CT_ap_zonas.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj > 1) {
                    retornarAPZonas(obj, 1);
                    $("#estadoZonas").val('-1');
                    $("#nom_zona").val('');
                    $("#mensajesZonas").html("<div class='callout callout-success'>Zona adicionada de manera correcta. <strong>Por favor recuerde crear la 'Sub-zona'</strong></div>");
                    $("#nom_subzona").focus();
                    $("#divSubZonas").show();
                } else {
                    $("#mensajesZonas").html("<div class='callout callout-danger'>Ha ocurrido un error al crear la 'Sub-zona', por favor presione la combinación de teclas 'CTRL' + 'SHIFT' + 'R' e intente nuevamente. Si el error persiste, por favor informe al equipo de desarrollo, gracias!</strong></div>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function adicionarAPZonas(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }
}