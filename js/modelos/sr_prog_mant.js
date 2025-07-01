function retornarSRProgMant(data,opcion){

    var datosAEnviar={};

    if(opcion===1){
        datosAEnviar.suc_cliente=$("#id_sucursal").val()

        $.ajax({
            url: "../controladores/CT_sr_prog_mant.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if(obj["sr_prog_mant"].length>0){
                    
                    $("#divServicioMantenimiento").html(armarTablaMantenimientos(obj,1));
                    //guarda los id de los mantenimientos solicitados y una vez se graba el requerimiento, los datos van a las tablas correspondientes                    
                    $("#id_mantenimientos").val(id_mantenimientos);

                }else{

                    $("#divServicioMantenimiento").html("<div class='alert alert-warning'>No se encontraron equipos asociados a la sucursal del cliente.</div>");

                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarSRProgMant(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

}