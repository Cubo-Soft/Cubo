function retornarAPCamposx(data, opcion) {

    var datosAEnviar = [];
    var ap_camposx='';

    if (opcion === 1) {        
            datosAEnviar = {
                'id_rol': $("#id_rol").val(),
                'tabla':'im_items'
            };
            $.ajax({
                url: "../controladores/CT_ap_camposx.php",
                data: {'caso': '1', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);                   
                    var ap_camposx='';
                    for(var i=0;i<obj.length;i++){                        
                        ap_camposx+=obj[i]["campo_ocultar"]+"|";
                        $("#"+obj[i]["campo_ocultar"]).hide();
                        $("#lbl_"+obj[i]["campo_ocultar"]).hide();
                    }
                    $("#ap_camposx").val(ap_camposx);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPCamposx(data,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
}
}
