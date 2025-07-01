function retornarNPCiudades(id, opcion) {

    var datos = [], datosDeLista = [];

    if (opcion === 1) {
        var datosAEnviar = {
            'id_pais': $("#np_paises").val()
        };
        $.ajax({
            url: "../controladores/CT_np_ciudades.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                //opcion para permisosdeprogramas.php
                if (opcion === 1) {
                    datos = {
                        'nombreSelect': 'np_ciudades',
                        'nombreFuncion': 'retornarNPPaises(2, null)'
                    };
                    datosDeLista = {
                        'valor': 'id_ciudad',
                        'texto': 'nom_ciudad'
                    };
                }
                $("#divCiudades").html(crearSelect(datos, obj, datosDeLista, 0));

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        $.ajax({
            url: "../controladores/CT_np_ciudades.php",
            data: {'caso': '2'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                //opcion para permisosdeprogramas.php
                datos = {
                    'nombreSelect': 'np_ciudades',
                    'nombreFuncion': null
                };
                datosDeLista = {
                    'valor': 'id_ciudad',
                    'texto': 'nom_ciudad'
                };
                $("#divCiudades").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 3) {

        var datosAEnviar = {
            'id_ciudad': id
        };

        $.ajax({
            url: "../controladores/CT_np_ciudades.php",
            data: {'caso': '3','datosAEnviar':datosAEnviar},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);                                
                datos = {
                    'nombreSelect': 'np_ciudades',
                    'nombreFuncion': null
                };
                datosDeLista = {
                    'valor': 'id_ciudad',
                    'texto': 'nom_ciudad'
                };
                $("#divCiudades").html(crearSelect(datos, obj, datosDeLista, id));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

}