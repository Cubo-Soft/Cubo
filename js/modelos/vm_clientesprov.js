function retornarVMClientesProv(datos, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'nombre': $("#nombre").val()
        };
        $.ajax({
            url: "../controladores/CT_vm_clientesprov.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                if (respuesta.length > 0) {
                    var obj = JSON.parse(respuesta);
                    if (obj.length > 0) {
                        var nombres = ["id_provis", "nombre"];
                        var nombreDataList = 'vm_clientesprov';
                        $("#DivDataListClientesProv").html(retornarDataList(obj, nombres, nombreDataList));
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarVMClientesProv(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2) {

        if (opcion === 2) {
            var datosAEnviar = {
                'nombre': $("#nom_contacto").val()
            };
        }

        $("#clienteProvisional").val('1');

        $.ajax({
            url: "../controladores/CT_vm_clientesprov.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                $("#divClientesProvisionales").show();

                if (obj.length > 0) {
                    $("#mensajes").html('');
                    $("#id_provis").val(parseInt(obj[0]["id_provis"]));

                    if (obj[0]["nit_cliente"].length > 0) {
                        $("#nit_cliente_cp").val(obj[0]["nit_cliente"]);
                    }

                    $("#nit_cliente_cp").prop('disabled', true);

                    if (obj[0]["nombre"].length > 0) {
                        $("#nombre_cp").val(obj[0]["nombre"]);
                    }

                    if (obj[0]["direccion"].length > 0) {
                        $("#direccion_cp").val(obj[0]["direccion"]);
                    }

                    if (obj[0]["telefono"].length > 0) {
                        $("#telefono_cp").val(obj[0]["telefono"]);
                    }

                    if (obj[0]["email"].length > 0) {
                        $("#email_cp").val(obj[0]["email"]);
                    }

                    if (obj[0]["contacto"].length > 0) {
                        $("#contacto_cp").val(obj[0]["contacto"]);//corregido para evitar traer de nuevo el correo daniel 2025
                    }

                    $("#ap_subzonas2").val(obj[0]["cod_zona"]);

                    $("#clienteProvisionalExiste").val('1');

                    $("#mensajesClientesProvisionales").html('<div class="callout callout-info">Se encontró información en clientes provisionales.</div>');
                    $("#adicionarClienteProvisional").hide();

                    if (permisos.indexOf("M") !== -1) {
                        $("#modificarClienteProvisional").show();
                    }

                    $("#divContactosGeneral").hide();

                } else {

                    $("#nombre_cp").val($("#nom_contacto").val());
                    $("#telefono_cp").val($("#tel_contacto").val());
                    $("#nit_cliente_cp").val($("#cc_contacto").val());
                    $("#email_cp").val($("#email").val());
                    $("#contacto_cp").val();
                    $("#nit_cliente_cp").val('');
                    $("#nit_cliente_cp").focus();
                    $("#modificarClienteProvisional").hide();
                    $("#divContactosGeneral").hide();
                    $("#mensajes").html('');
                    $("#mensajesClientesProvisionales").show();
                    $("#mensajesClientesProvisionales").html('<div class="callout callout-warning">Al parecer es un cliente nuevo, ingrese como mínimo <strong>Nombres </strong>, el número de <strong>NIT</strong> y el <strong>correo electrónico.</strong> Es necesario seleccionar también <strong>la región</strong> por favor!</div>');

                    $("#id_provis").val('0');

                    $("#adicionarClienteProvisional").show();  // {RMG} dic 09/2024
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarVMClientesProv(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }
}

/* Función Nueva Daniel20025*/
function crearVMClientesProv(data, opcion) {
    if (opcion === 1) {
        // Verificar si los campos están vacíos
        if ($("#nombre_cp").val() === "" || $("#nit_cliente_cp").val() === "" || $("#telefono_cp").val() === "" || $("#email_cp").val() === "") {
            // Si algún campo obligatorio está vacío, mostrar un mensaje de advertencia
            $("#mensajesClientesProvisionales").html('<div class="callout callout-warning">Por favor, complete todos los campos obligatorios (Nombre, NIT, Teléfono, Correo Electrónico).</div>');
            return; // No continuar con el envío de los datos
        }

        var datosAEnviar = {
            'nombre': $("#nombre_cp").val(),
            'direccion': $("#direccion_cp").val(),
            'telefono': $("#telefono_cp").val(),
            'email': $("#email_cp").val(),
            'contacto': $("#contacto_cp").val(),
            'nit_cliente': $("#nit_cliente_cp").val()
        };

        $.ajax({
            url: "../controladores/CT_vm_clientesprov.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj.error) {
                    // Si el NIT ya está registrado, mostrar un mensaje de error
                    $("#mensajesClientesProvisionales").html('<div class="callout callout-danger">' + obj.error + '</div>');
                } else if (obj.success) {
                    // Si el cliente fue creado o editado correctamente, mostrar un mensaje de éxito
                    $("#mensajesClientesProvisionales").html('<div class="callout callout-success">' + obj.success + '</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearVMClientesProv(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }


}

// evento para editar cliente en nuevo llamado Daniel2025
$(document).on("click", "#modificarClienteProvisional", function () {
    if ($("#nombre_cp").val() === "" || $("#nit_cliente_cp").val() === "" || $("#telefono_cp").val() === "" || $("#email_cp").val() === "") {
        $("#mensajesClientesProvisionales").html('<div class="callout callout-warning">Por favor, complete todos los campos obligatorios (Nombre, NIT, Teléfono, Correo Electrónico).</div>');
        return;
    }

    var datosAEnviar = {
        'id_provis': $("#id_provis").val(),
        'nombre': $("#nombre_cp").val(),
        'direccion': $("#direccion_cp").val(),
        'telefono': $("#telefono_cp").val(),
        'email': $("#email_cp").val(),
        'contacto': $("#contacto_cp").val(),
        'nit_cliente': $("#nit_cliente_cp").val()
    };

    $.ajax({
        url: "../controladores/CT_vm_clientesprov.php",
        data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
        type: "POST",
        success: function (respuesta) {
            var obj = JSON.parse(respuesta);
            if (obj.success) {
                $("#mensajesClientesProvisionales").html('<div class="callout callout-success">' + obj.success + '</div>');
            } else {
                $("#mensajesClientesProvisionales").html('<div class="callout callout-danger">Error al actualizar cliente provisional.</div>');
            }
        },
        error: function () {
            alert("Error al modificar el cliente provisional.");
        }
    });
});