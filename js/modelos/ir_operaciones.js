function retornarIROperaciones(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ir_operaciones.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    var datos = {
                        'nombreSelect': 'suc_cliente',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'id_suc_cliente',
                        'texto': 'nombre_persona'
                    };
                    $("#divRazonSocial").html(crearSelect(datos, obj, datosDeLista, 0));

                } else {
                    //aqui el código para cuando no hay resultado
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function  retornarIROperaciones(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {
        $.ajax({
            url: "../controladores/CT_ir_operaciones.php",
            data: { 'caso': '2' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    var datos = {
                        'nombreSelect': 'nm_empleados',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'codemple',
                        'texto': 'apelli_nom'
                    };
                    $("#divComercial").html(crearSelect(datos, obj, datosDeLista, 0));

                } else {
                    //aqui el código para cuando no hay resultado
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function  retornarIROperaciones(datos, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion == 3) {
        $.ajax({
            url: "../controladores/CT_ir_operaciones.php",
            data: { 'caso': '3' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    var datos = {
                        'nombreSelect': 'im_items',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'cod_item',
                        'texto': 'cod_item_concat'
                    };
                    $("#divProducto").html(crearSelect(datos, obj, datosDeLista, 0));

                } else {
                    //aqui el código para cuando no hay resultado
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function  retornarIROperaciones(datos, opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion == 4) {
        $.ajax({
            url: "../controladores/CT_ir_operaciones.php",
            data: { 'caso': '4' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    var datos = {
                        'nombreSelect': 'ir_operaciones',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'id_operacion',
                        'texto': 'id_operacion'
                    };
                    $("#divSOC_REQ").html(crearSelect(datos, obj, datosDeLista, 0));

                } else {
                    //aqui el código para cuando no hay resultado
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function  retornarIROperaciones(datos, opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 5) {

        datosAEnviar.id_suc_cliente = 0;
        datosAEnviar.codemple = 0;
        datosAEnviar.cod_item = 0;
        datosAEnviar.id_operacion = 0;

        switch ($("#criterioBusqueda1").val()) {
            case '0':
                datosAEnviar.id_suc_cliente = $("#suc_cliente").val();
                break;

            case '1':
                datosAEnviar.codemple = $("#nm_empleados").val();
                break;

            case '2':
                datosAEnviar.cod_item = $("#im_items").val();
                break;

            case '3':
                datosAEnviar.id_operacion = $("#ir_operaciones").val();
                break;

            default:
                break;
        }

        datosAEnviar.estado = $("#estadoREQProveedores").val();
        datosAEnviar.fechaInicial = $("#fechaInicial").val();
        datosAEnviar.fechaFinal = $("#fechaFinal").val();

        $.ajax({
            url: "../controladores/CT_ir_operaciones.php",
            data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["ir_operaciones"].length > 0) {

                    $("#divMensajes").html('');

                    $("#guardar").show();
                    $("#generarPDF").show();
                    $("#enviarSolicitud").show();

                    var tabla = '<br/><table class="table table-striped" >';

                    tabla += '<thead>';
                    tabla += '<tr>';
                    tabla += '<th>No.</th><th>Fecha sol</th><th>SIPV</th><th>QTY</th><th>Producto</th><th>Voltaje</th><th>Parte</th><th>Marca</th><th>Modo IMP.</th><th>Modelo</th><th>Cliente</th><th>Ciudad</th><th>Anexos a solicitar</th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj["ir_operaciones"].length; i++) {

                        tabla += '<tr>';
                        tabla += '<td><input type="hidden" id="' + obj["ir_operaciones"][i]["id_operacion"] + '" />' + obj["ir_operaciones"][i]["id_operacion"] + '</td><td>' + obj["ir_operaciones"][i]["fecha_registro"] + '</td>';
                        tabla += '<td>' + obj["ir_operaciones"][i]["SIPV"] + '</td>';
                        tabla += '<td><input type="number" value="' + obj["ir_operaciones"][i]["cantidad"] + '" id="qty_' + obj["ir_operaciones"][i]["id_detalle"] + '" style="width: 50px;border: none;" min="0" onchange="actualizarIRDetalleOper(this.id,1)" /></td>';
                        tabla += '<td>' + obj["ir_operaciones"][i]["nom_item"] + '</td><td></td><td>' + obj["ir_operaciones"][i]["num_parte"] + '</td><td>' + obj["ir_operaciones"][i]["nom_marca"] + '</td><td>' + obj["ir_operaciones"][i]["nom_tipo"] + '</td><td>' + obj["ir_operaciones"][i]["descrip_modelo"] + '</td><td>' + obj["ir_operaciones"][i]["nm_juridicas"] + '</td><td>' + obj["ir_operaciones"][i]["ciudad"] + '</td><td>Documento 1 <br/> Documento 2 <br/> Documento 3</td>';
                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';
                    tabla += '</table>';

                    $("#divResultado").html(tabla);

                } else {
                    $("#consultar").show();

                    $("#guardar").hide();
                    $("#generarPDF").hide();
                    $("#enviarSolicitud").hide();
                    $("#divResultado").html('');
                    $("#divMensajes").html('<div class="alert alert-info">No se registran datos con la información seleccionada</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function  retornarIROperaciones(datos, opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }
}


/*function actualizarIROperaciones(data, opcion) {

}
*/