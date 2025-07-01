function retornarIPTipos(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_tipos.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_tipos',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_tipo',
                    'texto': 'descrip'
                };
                $("#divTipos1").html(crearSelect(datos, obj, datosDeLista, 0));

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPTipos(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        $.ajax({
            url: "../controladores/CT_ip_tipos.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_tipos',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_tipo',
                    'texto': 'descrip'
                };
                $("#divTipos").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPTipos(datos, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }
}