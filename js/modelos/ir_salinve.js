function retornarIRSalinve(datos, opcion) {

    var datosAEnviar = [];

    if (opcion === 1) {

        if(opcion===1){
            datosAEnviar = {
                'cod_item': $("#im_items").val()
            };
        }

        $.ajax({
            url: "../controladores/CT_ir_salinve.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                $("#cantidadSaldo").val(obj["ir_salinve"][0]["saldo"]);
                $("#precio_vta").val(obj["im_items"][0]["precio_vta"]);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIRSalinve(datos, opcion) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if(opcion===2 || opcion===3){        

        if(opcion===3){
            datosAEnviar = {
                'cod_item': datos.substr(3,datos.length)
            };
        }

        if(opcion===2){
            datosAEnviar = {
                'cod_item': respuestosCantidados.cod_item
            };
        }
        
        $.ajax({
            url: "../controladores/CT_ir_salinve.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {     
                var obj = JSON.parse(respuesta);
                $("#divTablaBodegasProductos").html(mostrarTablaRepuestosBodegas(obj, 1));
                $("#modalBodegasProductos").css("display", "block");              
                $("#modalBodegasProductos").addClass("in");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIRSalinve(datos, opcion) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if(opcion===4){

        datosAEnviar={
            'cod_item':$("#cod_item").val()
        }

        $.ajax({
            url: "../controladores/CT_ir_salinve.php",
            data: {'caso': '3', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["cod_item", "cod_item"];
                    var nombreDataList = 'Cod_Item';
                    $("#DivDataListRepuestos").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIRSalinve(datos, opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if(opcion===5){

        if($("#cod_item").val().length===0 || $("#im_bodeg").val()==='-1'){

            $("#divTablaBodegas").html('<div class="alert alert-danger">Por favor revise la bodega y/o el código del repuesto.</div>');
            $("#divTablaReservados").html('');
            $("#im_bodeg").val('-2');

        }else{
            datosAEnviar={
                'cod_item':$("#cod_item").val(),
                'codbodeg':$("#im_bodeg").val()
            }
                   
            $.ajax({
                url: "../controladores/CT_ir_salinve.php",
                data: {'caso': '4', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {                                                
                    var obj = JSON.parse(respuesta);                                
                    crearTablaBodegasReservados(obj,1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarIRSalinve(datos, opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }

        
    }
}

function borrarIRSalinve(data,opcion){

    var datosAEnviar = [];
    
    if(opcion ===1){

        Swal.fire({
            title: 'Confirmación',
            text: 'Por favor confirme borrar registro de este repuesto de los reservados!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {

                datosAEnviar={
                    'id':data
                }
                       
                $.ajax({
                    url: "../controladores/CT_ir_salinve.php",
                    data: {'caso': '5', 'datosAEnviar': datosAEnviar},
                    type: "POST",
                    success: function (respuesta) {                                                                        
                        var obj = JSON.parse(respuesta);                                
                        if(obj===1){
                            retornarIRSalinve(null, 5);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("Error en function retornarIRSalinve(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
                    }
                });                  
            }
        });  


        
    }
}



function crearTablaBodegasReservados(obj,opcion){

    var tabla=null;

if(opcion===1){

     tabla='<div class="col-lg-12"><center><strong>BODEGAS PRINCIPALES</strong></center></div>';

        tabla+='<div class="col-lg-12"><table class="table table-primary"><thead>';


    if (obj["ir_salinve"].length > 0) {

        tabla +='<tr class="table-primary" >';
        tabla +='<th></th><th>Código</th><th>Bodega</th><th>Persona</th><th>Saldo</th><th>Fecha arribo</th>';
        tabla +='</tr>';            
        tabla +='</thead>';            
        tabla +='<tbody>';            
        
        for(var i=0; i<obj["ir_salinve"].length; i++){
            tabla +='<tr>';

            tabla +='<td>'+(i+1)+'</td><td>'+obj["ir_salinve"][i]["cod_item"]+'</td><td>'+obj["ir_salinve"][i]["nom_bodega"]+'</td>';

            if(obj["ir_salinve"][i]["persona"]===null){
                tabla +='<td></td>';
            }else{
                tabla +='<td>'+obj["ir_salinve"][i]["persona"]+'</td>';
            }

            tabla +='<td><center>'+obj["ir_salinve"][i]["saldo"]+'</center></td>';
            
            if(obj["ir_salinve"][i]["fecha_arribo"]===null || obj["ir_salinve"][i]["fecha_arribo"]==='0000-00-00'){
                tabla +='<td></td>';
            }else{
                tabla +='<td>'+obj["ir_salinve"][i]["fecha_arribo"]+'</td>';
            }
            
            tabla +='</tr>';
        }

        tabla+='</tbody></table></div>';

        $("#divTablaBodegas").html(tabla);

    }else{
        $("#divTablaBodegas").html('<div class="alert alert-info">No se encuentra información con el repuesto consultado en las bodegas</div>');
    }


    if (obj["ir_resinve"].length > 0) {

        tabla ='<div class="col-lg-12"><center><strong>RESERVAS</strong></center></div>';
        tabla+='<table class="table table-sm table-info">';                   
        tabla +='<tr>';
        tabla +='<th scope="col"></th><th scope="col">Código</th><th scope="col">Bodega</th><th scope="col">Persona</th><th scope="col">Saldo</th><th scope="col">Fecha limite reserva</th><th scope="col"></th>';
        tabla +='</tr>';
        
        for(var i=0; i<obj["ir_resinve"].length; i++){
            tabla +='<tr>';

            tabla +='<th scope="row">'+(i+1)+'</th><td>'+obj["ir_resinve"][i]["cod_item"]+'</td><td>'+obj["ir_resinve"][i]["nom_bodega"]+'</td>';

            if(obj["ir_resinve"][i]["persona"]===null){
                tabla +='<td></td>';
            }else{
                tabla +='<td>'+obj["ir_resinve"][i]["persona"]+'</td>';
            }

            tabla +='<td><center>'+obj["ir_resinve"][i]["saldo"]+'</center></td>';
            
            if(obj["ir_resinve"][i]["fecha_arribo"]===null || obj["ir_resinve"][i]["fecha_arribo"]==='0000-00-00'){
                tabla +='<td></td>';
            }else{
                tabla +='<td>'+obj["ir_resinve"][i]["fecha_arribo"]+'</td>';
            }

            tabla +='<td><input type="button" class="btn btn-info" value="X" onclick="borrarIRSalinve(this.id,1);" id="'+obj["ir_resinve"][i]["codbodeg"]+'_'+obj["ir_resinve"][i]["cod_item"]+'_'+obj["ir_resinve"][i]["saldo"]+'_'+obj["ir_resinve"][i]["numid"]+'_'+obj["ir_resinve"][i]["fecha_arribo"]+'"/> </td>';
            
            tabla +='</tr>';
        }

        tabla+='</table>';

        $("#divTablaReservados").html(tabla);

    }else{
        $("#divTablaReservados").html('<div class="alert alert-info">No se encuentran reservados</div>');
    }

}
}