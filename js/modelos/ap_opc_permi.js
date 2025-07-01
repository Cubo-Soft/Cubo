function retornarAPOPCPermi(opcion, data) {

//proviene de permisosdeprograma.js
//carga la lista a mostrar de permisos de la tabla ap_opc_permi
    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ap_opc_permi.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (opcion === 1) {
                    var datos = {
                        'valor': 'cod_opcion',
                        'texto': 'descrip',
                        'funcion': 'actualizarAPPermpro(this.id,1)'
                    };
                    $("#" + data["nombreDiv"]).html('');
                    $("#" + data["nombreDiv"]).html(crearCheckbox(datos, obj, 1));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPOPCPermi(opcion=1, data) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {
        if ($("#ap_roles").val() === '-1') {
            $("#mensajes").html("<div class='callout callout-danger'>Por favor seleccione un rol válido</div>");
            $("#ap_programs").val('-1');
            $("#ap_roles").val('-1');
            $("#ap_roles").focus();
            $("#divGrupoPermisos").empty();
        } else if ($("#ap_programs").val() === '-1') {
            $("#mensajes").html("<div class='callout callout-info'>Para continuar con la consulta, por favor recuerde seleccionar un programa y un rol.</div>");
            $("#divGrupoPermisos").empty();
        } else {
            $("#mensajes").empty();
            var datosAEnviar = {
                'id_rol': $("#ap_roles").val(),
                'codprog': $("#ap_programs").val()
            };
            $.ajax({
                url: "../controladores/CT_ap_opc_permi.php",
                data: {'caso': '2', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    var rol = $("#ap_roles option:selected").text();
                    var tabla = "<table class='table table-hover table-sm'>";
                    tabla += '<thead>';
                    tabla += '<tr class="bg-primary" >';
                    tabla += '<th>Código</th>';
                    tabla += '<th>Nombre</th>';
                    tabla += '<th>Estado</th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        tabla += '<tr>';
                        tabla += '<td>' + obj[i]["permpro"] + '</td>';
                        tabla += '<td>' + obj[i]["descrip"] + '</td>';
                        tabla += '<td>';
                        //a-id = actualizar id
                        //c-id = crear id
                        if (parseInt(obj[i]["estado_perm_rol"]) === 1) {
                            tabla += '<input type="checkbox" id="a-' + obj[i]["id_permpro"] + '" name="a-' + obj[i]["id_permpro"] + '" onclick="cambiarARRoles(1,this.id)" checked />';
                        } else if (parseInt(obj[i]["estado_perm_rol"]) === 0) {
                            tabla += '<input type="checkbox" id="a-' + obj[i]["id_permpro"] + '" name="a-' + obj[i]["id_permpro"] + '" onclick="cambiarARRoles(1,this.id)" />';
                        } else {
                            tabla += '<input type="checkbox" id="c-' + obj[i]["id_permpro"] + '" name="c-' + obj[i]["id_permpro"] + '" onclick="cambiarARRoles(1,this.id)" /> <label>Pendiente por crear</label>';
                        }
                        tabla += '</td>';

                        tabla += '</tr>';
                    }
                    tabla += '</tbody>';
                    tabla += '</table>';

                    $("#divGrupoPermisos").html(tabla);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPOPCPermi(opcion=2, data) { opcion 2...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }
    }

}

