function retornarIPPresiones(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_presiones.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_presiones',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_presion',
                    'texto': 'vr_presion'
                };
                $("#divPresiones").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPPresiones(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}