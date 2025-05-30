function retornarCPTipoImportacion(data,opcion){

    if(opcion===1){
        $.ajax({
            url: "../controladores/CT_cp_tipo_importacion.php",
            data: { 'caso': '1',},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ti_'+data["id_reqdet"],
                    'nombreFuncion': 'cambiarVRRequerimDet(this.id,3)'
                };
                var datosDeLista = {
                    'valor': 'id_tipotrans',
                    'texto': 'nom_tipo'
                };                
                $("#td_"+data["id_reqdet"]).html(crearSelect(datos, obj, datosDeLista, data["modo_import"]));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarCPTipoImportacion(data,opcion=1) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });

   }

}