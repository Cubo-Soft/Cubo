function retornarAPAlertas(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        datosAEnviar = {
            'id_tipoalerta': data["id_tipoalerta"],
            'usuario_asignd': $("#usuario_asignd").val()
        };

        $.ajax({
            url: "../controladores/CT_am_alertas.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            dataType: 'json',
            success: function (respuesta) {
                //var obj = JSON.parse(respuesta);
                var obj = JSON.stringify(respuesta);
                $("#totalReqComercial").text(obj.length);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //alert("Error en function retornarAPAlertas(data,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                alert("Error en function retornarAPAlertas(data,opcion=1) {...\nError "+errorThrown);
            }
        });
    }

    if (opcion === 2) {
        datosAEnviar = {
            'id_tipoalerta': data["id_tipoalerta"],
            'usuario_asignd': $("#usuario_asignd").val()
        };

        $.ajax({
            url: "../controladores/CT_am_alertas.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            dataType: 'json',
            type: "POST",
            beforeSend:function(){  //adicionado RMG 20250117
                //console.log("li:40 Envio ap_alertas data: "+data);
            },  // fin adicion RMG
            success: function (respuesta) {     
                //var obj = JSON.parse(respuesta);
                var obj = JSON.stringify(respuesta);
                $("#totalReqProveedor").text(obj.length);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPAlertas(data,opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

}

