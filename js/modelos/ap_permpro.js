function retornarAPPermpro(opcion) {

    if (opcion === 1) {
        $("#mensajes").html("");
        $("#divGrupoPermisos").empty();
        $("#divGrupoPermisos").html(tablaPermisos);

        var listaCheckbox = [];

        var i = 0;
        //recorre la lista de checkbox que existen en la interfaz
        $("input[type=checkbox]").each(function () {
            listaCheckbox[i] = $(this);
            i += 1;
        });


        if ($("#ap_programs").val() !== '-1') {
            $.ajax({
                url: "../controladores/CT_ap_permpro.php",
                data: {'caso': '1', 'codprog': $("#ap_programs").val()},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    for (var i = 0; i < obj.length; i++) {
                        for (var j = 0; j < listaCheckbox.length; j++) {
                            if (obj[i]["permpro"] === listaCheckbox[j][0].id) {
                                if (parseInt(obj[i]["estado"]) === 1) {
                                    $("#" + obj[i]["permpro"]).prop("checked", true);
                                } else {
                                    $("#" + obj[i]["permpro"]).prop("checked", false);
                                }
                                //cambia el atributo id
                                $("#" + obj[i]["permpro"]).attr("id", obj[i]["permpro"] + "-" + obj[i]["id_permpro"]);
                                //cambia el atributo name
                                $("#nombre").attr("name", obj[i]["permpro"] + "-" + obj[i]["id_permpro"]);

                                j = listaCheckbox.length;
                            }
                        }
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarAPPrograms(opcion) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        } else {
            //deja desabilitados la lista de checkbox de la interfaz
            for (var j = 0; j < listaCheckbox.length; j++) {
                $("#" + listaCheckbox[j][0].id).prop("checked", false);
            }
        }
    }
}


function actualizarAPPermpro(id, opcion) {

    if (opcion === 1) {
        if ($("#ap_programs").val() === '-1') {
            $("#mensajes").html("<div class='callout callout-danger'>Por favor seleccione un programa de la lista</div>");
            $("#ap_programs").focus();
            $("#" + id).prop("checked", false);
        } else {
            $("#mensajes").html("");
            $("#mensajes2").html("");
            var posGuion = id.indexOf("-");

            var datosAEnviar = [];

            if (posGuion === -1) {
                datosAEnviar = {
                    'id_permpro': id.substr(posGuion + 1, id.length),
                    'permpro': id,
                    'estado': $("#" + id).prop("checked"),
                    'codprog': $("#ap_programs").val()
                };
            } else {
                datosAEnviar = {
                    'id_permpro': id.substr(posGuion + 1, id.length),
                    'permpro': id.substr(0, posGuion),
                    'estado': $("#" + id).prop("checked"),
                    'codprog': $("#ap_programs").val()
                };
            }

            $.ajax({
                url: "../controladores/CT_ap_permpro.php",
                data: {'caso': '2', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    retornarMensaje(obj,1);
                    retornarAPPermpro(1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function cambiarAPOPCPermi(id, opcion) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }
    }
}

