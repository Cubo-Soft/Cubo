function retornarNPPaises(opcion, data) {

    var datos = [], datosDeLista = [];

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_np_paises.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                //opcion para permisosdeprogramas.php
                if (opcion === 1) {
                    datos = {
                        'nombreSelect': 'np_paises',
                        'nombreFuncion': 'retornarNPCiudades(null,1)'
                    };
                    datosDeLista = {
                        'valor': 'id_pais',
                        'texto': 'nom_pais'
                    };
                }

                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion=1, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        var datosAEnviar = {
            'id_ciudad': $("#np_ciudades").val()
        };
        $.ajax({
            url: "../controladores/CT_np_paises.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                //opcion para permisosdeprogramas.php
                if (opcion === 1) {
                    datos = {
                        'nombreSelect': 'np_paises',
                        'nombreFuncion': null
                    };
                    datosDeLista = {
                        'valor': 'id_pais',
                        'texto': 'nom_pais'
                    };
                }

                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion=2, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
    
    /**
     * opcion para tomarequerimiento.php
     */
    if (opcion === 3) {        
        $.ajax({
            url: "../controladores/CT_np_paises.php",
            data: {'caso': '3'},
            type: "POST",
            success: function (respuesta) {        
                var obj = JSON.parse(respuesta);
                if (opcion === 3) {
                    datos = {
                        'nombreSelect': 'np_paises',
                        'nombreFuncion': null
                    };
                    datosDeLista = {
                        'valor': 'id_pais',
                        'texto': 'nom_pais'
                    };
                }                

                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista,7));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPPaises(opcion=3, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

}

