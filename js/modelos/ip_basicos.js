function retornarIPBasicos(opcion, data) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_basicos.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (opcion === 1) {
                    var datos = {
                        'nombreSelect': 'ip_basicos',
                        'nombreFuncion': 'retornarIPDTBasicos(["divIPDtbasicos"],1);'
                    };
                    var datosDeLista = {
                        'valor': 'id_basico',
                        'texto': 'descrip'
                    };
                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista,0));                    
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPBasicos(opcion, data) { {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}
