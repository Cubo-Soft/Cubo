function retornarIPModelos(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_modelos.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                       
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_modelos',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_modelo',
                    'texto': 'descrip_modelo'
                };
                $("#divModelos").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPModelos(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}