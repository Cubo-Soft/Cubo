function retornarAPCamposx(data, opcion) {

    var datosAEnviar = [];

    if (opcion === 1) {        
            datosAEnviar = {
                'ir_rol': $("#id_rol").val()
            };
            $.ajax({
                url: "../controladores/CT_ap_camposx.php",
                data: {'caso': '1', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPCamposx(data,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
}
}
