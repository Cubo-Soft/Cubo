function retornarNPActiveco(data, opcion) {
    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_np_activeco.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                if (opcion === 1) {
                    var datos = {
                        'nombreSelect': 'np_activeco',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'codigo',
                        'texto': 'descrip'
                    };
                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNPActiveco(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}