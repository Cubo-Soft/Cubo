function retornarNMEmpleados(data,opcion){

    if(opcion===1){

        var datosAEnviar = {
            'numid': $("#numid").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_empleados.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if(obj.length>0){
                    $("#adicionarEmpleado").hide();
                    $("#codemple").val(obj[0]["codemple"]);
                    $("#fecha_ingreso").val(obj[0]["fecha_ingreso"]);
                    $("#fecha_retiro").val(obj[0]["fecha_retiro"]);
                    $("#np_cargos").val(obj[0]["id_cargo"]);
                    $("#tipo_contrato").val(obj[0]["contrato"]);
                    $("#cesantias").val(obj[0]["cesantias"]);
                    $("#pensiones").val(obj[0]["pension"]);                    
                    $("#eps").val(obj[0]["eps"]);     
                    $("#usuario").val(obj[0]["usuario"]);                    
                }else{
                    $("#adicionarEmpleado").show();
                    $("#modificarEmpleado").hide();
                    $("#mensajesEmpleado").html("<div class='alert alert-danger'>No encuentran datos con el número de identificación ingresado</div>");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMEmpleados(data,opcion=1) {...\nError from server, please call support");
            }
        });

    }


}