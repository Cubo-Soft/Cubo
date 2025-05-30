function retornarIPGrupos(data, opcion) {

    var datosAEnviar = [];
    var opcionSeleccionada = null;

    if (data["opcionSeleccionada"] !== null) {
        opcionSeleccionada = data["opcionSeleccionada"];
    }

    if (opcion === 1 || opcion === 2) {
        $.ajax({
            url: "../controladores/CT_ip_grupos.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (opcion === 1) {
                    var datos = {
                        'nombreSelect': 'ip_grupos',
                        'nombreFuncion': 'retornarIMItems(this.id, 1)'
                    };
                }

                if (opcion === 2) {
                    var datos = {
                        'nombreSelect': 'ip_grupos',
                        'nombreFuncion': 'retornarIMItems(this.id, 16)'
                    };
                }

                if (opcion === 3) {
                    var datos = {
                        'nombreSelect': 'ip_grupos',
                        'nombreFuncion': null
                    };
                }

                var datosDeLista = {
                    'valor': 'cod_grupo',
                    'texto': 'nom_grupo'
                };
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, opcionSeleccionada));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPGrupos(datos, opcion=1,2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 3) {
        $.ajax({
            url: "../controladores/CT_ip_grupos.php",
            data: { 'caso': '3' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                var datos = {
                    'nombreSelect': 'ip_grupos',
                    'nombreFuncion': null
                };

                var datosDeLista = {
                    'valor': 'cod_grupo',
                    'texto': 'nom_grupo'
                };
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, opcionSeleccionada));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPGrupos(datos, opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}