function retornarIPVoltajes(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_voltajes.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                       
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_voltajes',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_voltaje',
                    'texto': 'vr_voltaje'
                };
                $("#divVoltajes").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPVoltajes(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}