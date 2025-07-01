function actualizarIRDetalleOper(data,opcion){

    var datosAEnviar={};

    if (opcion === 1) {

        $("#divMensajes").html('');

        // Obtiene la posición del carácter "_"
        var posicion = data.indexOf('_'); 

        datosAEnviar.cantidad=$("#"+data).val();
        datosAEnviar.id_detalle=data.substring(posicion + 1); 
        
        $.ajax({
            url: "../controladores/CT_ir_detalle_oper.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if(obj){
                    $("#divMensajes").html('<div class="alert alert-success">Cantidad actualizada de manera correcta</div>');
                }else{
                    $("#divMensajes").html('<div class="alert alert-danger">Ha surgido un error al actualizar la cantidad, por favor presione la combinación de teclas CTRL + SHIFT + R en el teclado. Si la falla persiste por favor informe</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function actualizarIRDetalleOper(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });


    }

}