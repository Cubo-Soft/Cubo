function retornarAPSubZonas(data, opcion) {
    if (opcion === 1) {
        var datosAEnviar = {

        };

        $.ajax({
            url: "../controladores/CT_ap_subzonas.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ap_subzonas',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_subzona',
                    'texto': 'nombreCompleto'
                };
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPSubzonas(data,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        if ($("#ap_zonas").val() !== '-1') {

            var datosAEnviar = {
                'id_zona': $("#ap_zonas").val()
            };

            $.ajax({
                url: "../controladores/CT_ap_subzonas.php",
                data: {'caso': '2', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    var datos = {
                        'nombreSelect': 'ap_subzonas',
                        'nombreFuncion': 'retornarAPSubZonas(this.id, 3)'
                    };
                    var datosDeLista = {
                        'valor': 'id_subzona',
                        'texto': 'nom_subzona'
                    };

                    $("#estadoZonas").val(obj[0]["estadoZona"]);

                    $("#divSubZonas").show();

                    $("#listaSubZonas").html(crearSelect(datos, obj, datosDeLista, 0));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPSubzonas(data,opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        } else {
            $("#divSubZonas").hide();
            $("#estadoZonas").val('-1');
        }
    }

    if (opcion === 3) {

        if ($("#ap_subzonas").val() !== '-1') {

            var datosAEnviar = {
                'id_subzona': $("#ap_subzonas").val()
            };

            $.ajax({
                url: "../controladores/CT_ap_subzonas.php",
                data: {'caso': '3', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    $("#estadoSubZonas").val(obj[0]["estado"]);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPSubzonas(data,opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        } else {
            $("#estadoSubZonas").val('-1');
        }
    }

    if (opcion === 4) {

        $.ajax({
            url: "../controladores/CT_ap_subzonas.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ap_subzonas2',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_subzona',
                    'texto': 'nom_subzona'
                };
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPSubzonas(data,opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }
}