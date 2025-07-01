function retornarNMCompleme(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_compleme.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                
                $("#adicionarComplementosNIT").show();

                var tabla = '<table class="table table-hover table-sm" id="tablaSucursales">';
                if (obj.length > 0) {
                    tabla += '<thead>';
                    tabla += '<tr class="bg-primary">';
                    tabla += '<th>No.</th><th>Credito</th><th>Factura despacho</th><th>Documentos para facturar</th><th>Cierre factura</th><th>Area contacto</th><th></th><th></th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        tabla += '<tr>';
                        tabla += '<td>' + (i + 1) + '</td>';
                        tabla += '<td>' + obj[i]["credito"] + '</td>';
                        tabla += '<td>' + obj[i]["factu_despacho"] + '</td>';
                        tabla += '<td>' + obj[i]["docs_pra_facturar"] + '</td>';
                        tabla += '<td>' + obj[i]["cierre_factu"] + '</td>';
                        tabla += '<td>' + obj[i]["area_contacto"] + '</td>';

                        if (permisos.indexOf("M") !== -1) {
                            tabla += '<td><button class="btn bg-purple btn-flat" id="nmx_' + obj[i]["id_comple"] + '" onclick="retornarNMCompleme(this.id,2)" title="Modificar" ><span class="fa fa-edit"></span></button></td>';
                        } else {
                            tabla += '<td></td>';
                        }

                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';

                    $("#listaComplementosNIT").html(tabla);
                    $("#listaComplementosNIT").show();
                    $("#datosComplementosNIT").hide();                    
                    $("#modificarComplementosNIT").hide();

                } else {
                    $("#datosComplementosNIT").show();                    
                    $("#modificarComplementosNIT").hide();
                    $("#listarComplementosNIT").hide();
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMCompleme(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2) {

        var datosAEnviar = {
            'id_comple': data.substring(4, data.length)
        };
                
        $.ajax({
            url: "../controladores/CT_nm_compleme.php",
            data: {'caso': '3', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                
                $("#id_comple").val(obj[0]["id_comple"]);
                $("#credito").val(obj[0]["credito"]);
                $("#factu_despacho").val(obj[0]["factu_despacho"]);
                $("#docs_pra_facturar").val(obj[0]["docs_pra_facturar"]);
                $("#cierre_factu").val(obj[0]["cierre_factu"]);
                $("#area_contacto").val(obj[0]["area_contacto"]);
                
                $("#listaComplementosNIT").hide();
                $("#datosComplementosNIT").show();
                $("#adicionarComplementosNIT").hide();
                $("#modificarComplementosNIT").show();

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMCompleme(datos, opcion=2) {...\nError from server, please call support");
            }
        });

    }

}

function crearNMCompleme(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'numid': $("#numid").val(),
            'credito': $("#credito").val(),
            'factu_despacho': $("#factu_despacho").val(),
            'docs_pra_facturar': $("#docs_pra_facturar").val(),
            'cierre_factu': $("#cierre_factu").val(),
            'area_contacto': $("#area_contacto").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_compleme.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                
                if (parseInt(obj) > 0) {
                    retornarNMCompleme(null, 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearNMCompleme(data,opcion=1) {...\nError from server, please call support");
            }
        });
    }
}

function actualizarNMCompleme(data, opcion) {
    if (opcion === 1) {

        var datosAEnviar = {
            'id_comple': $("#id_comple").val(),
            'credito': $("#credito").val(),
            'factu_despacho': $("#factu_despacho").val(),
            'docs_pra_facturar': $("#docs_pra_facturar").val(),
            'cierre_factu': $("#cierre_factu").val(),
            'area_contacto': $("#area_contacto").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_compleme.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                
                if (obj === 1) {
                    retornarNMCompleme(null, 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function actualizarNMCompleme(data,opcion) {...\nError from server, please call support");
            }
        });
    }
}