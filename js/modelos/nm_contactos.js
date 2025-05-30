function retornarNMContactos(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'nom_contacto': $("#nom_contacto").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["cc_contacto", "nom_contacto"];
                    var nombreDataList = 'nom_contactos';
                    $("#DivDataListContactos").html(retornarDataList(obj, nombres, nombreDataList));
                } else {
                    $("#cc_contacto").val('0');
                    retornarMensajeDeCreacion(1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2) {
        var datosAEnviar = {
            'cc_contacto': $("#cc_contacto").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["cc_contacto", "cc_contacto"];
                    var nombreDataList = 'cc_contactos';
                    $("#DivDataListIdentificaciones").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 3) {
        var datosAEnviar = {
            'cc_contacto': $("#cc_contacto").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    establecerDatosUnSoloContacto(obj, 1);
                } else {

                    if ($("#num_id").val() === '0') {
                        retornarVMClientesProv(null, 2);
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=3) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 4) {
        var datosAEnviar = {
            'nom_contacto': $("#nom_contacto").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '3', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                $("#divJuridicas").hide();
                $("#divSucursalesGeneral").hide();
                $("#nuevaBusqueda").show();

                $("#divBotonesBusqueda").html('');
                $("#divBotonesBusqueda").html('<div class="callout callout-info" >Búsqueda por contacto</div>');

                //para el caso de que exista un nombre igual en los contactos
                if (obj.length >= 2) {

                    var tabla = '<table class="table table-hover table-sm">'

                    tabla += '<thead>';
                    tabla += '<tr class="bg-primary">';
                    tabla += '<th>No.</th><th>Empresa</th><th>N.Identificación</th><th>Nombre</th><th>Cargo</th><th>Teléfono</th><th>Dirección sede</th><th>Ciudad</th><th>Estado</th><th></th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        var estado = 'Activo';

                        if (obj[i]["estado"] === 0) {
                            var estado = 'Inactivo';
                        }

                        tabla += '<tr>';
                        tabla += '<td>' + (i + 1) + '</td>';

                        if (obj[i]["personas"] !== null) {
                            tabla += '<td>' + obj[i]["personas"] + '</td>';
                        } else if (obj[i]["juridicas"] !== null) {
                            tabla += '<td>' + obj[i]["juridicas"] + '</td>';
                        } else {
                            tabla += '<td></td>';
                        }

                    //    tabla += '<td>' + obj[i]["cc_contacto"] + '</td><td>' + obj[i]["nom_contacto"] + '</td><td>' + obj[i]["cargo"] + '</td><td>' + obj[i]["tel_contacto"] + '</td><td>' + obj[i]["direccion"] + '</td><td>' + obj[i]["nom_ciudad"] + ' , ' + obj[i]["nom_dpto"].toUpperCase() + ' , ' + obj[i]["nom_ciudad"] + '</td><td>' + estado + '</td><td><button class="btn bg-info btn-flat" id="nmc_' + obj[i]["id_contacto"] + '" onclick="retornarNMContactos(this.id,8)" title="Seleccionar" ><span class="fa fa-hand-o-left"></span></button></td>';
                        tabla += '<td>' + obj[i]["numid"] + '</td><td>' + obj[i]["nom_contacto"] + '</td><td>' + obj[i]["cargo"] + '</td><td>' + obj[i]["tel_contacto"] + '</td><td>' + obj[i]["direccion"] + '</td><td>' + obj[i]["nom_ciudad"] + ' , ' + obj[i]["nom_dpto"].toUpperCase() + ' , ' + obj[i]["nom_ciudad"] + '</td><td>' + estado + '</td><td><button class="btn bg-info btn-flat" id="nmc_' + obj[i]["id_contacto"] + '" onclick="retornarNMContactos(this.id,8)" title="Seleccionar" ><span class="fa fa-hand-o-left"></span></button></td>';
                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';

                    $("#divContactos").show();
                    $("#mensajesContacto").show();
                    $("#editarCrearContacto").hide();
                    $("#mensajesContacto").html('<div class="callout callout-warning">El sistema ha encontrado coincidencias en el nombre del contacto. Por favor seleccione uno para continuar el proceso de la toma del requerimiento</div>');
                    $("#divContactos").html(tabla);
                    
                } else if (obj.length === 1) {                    
                    //para cuando se encuentra un solo contacto                    
                    retornarNMNits(obj[0]["id_contacto"], 5);
                } else {
                    //buscar en vm_clientesprov
                    retornarVMClientesProv(null, 2);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=4) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 5 || opcion === 7) {

        var nmc = null, datosAEnviar = [];

        if (opcion === 5) {
            nmc = data.substring(4, data.length);

            datosAEnviar = {
                'id_sucursal': nmc
            };
            $("#id_sucursal").val(nmc);
        }

        if (opcion === 7) {
            datosAEnviar = {
                'id_sucursal': data
            };
            $("#id_sucursal").val(data);
        }

        $("#navNombreSucursal").html($("#" + data).attr('name'));

        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '5', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                $("#divContactosGeneral").show();
                var tabla = '<table class="table table-hover table-sm">';

                //cuando los contactos tienen nombre igual
                if (obj.length > 0) {
                    tabla += '<thead>';
                    tabla += '<tr class="bg-primary">';
                    tabla += '<th>No.</th><th>Nro. identificación</th><th>Nombre</th><th>Cargo</th><th>Teléfono</th><th>Correo</th><th>Estado</th><th></th><th></th>';
                    tabla += '</tr>';
                    tabla += '</thead>';
                    tabla += '<tbody>';

                    for (var i = 0; i < obj.length; i++) {
                        tabla += '<tr>';
                        tabla += '<td>' + (i + 1) + '</td>';
                        tabla += '<td>' + obj[i]["cc_contacto"] + '</td>';
                        tabla += '<td>' + obj[i]["nom_contacto"] + '</td>';
                        tabla += '<td>' + obj[i]["cargo"] + '</td>';
                        tabla += '<td>' + obj[i]["tel_contacto"] + '</td>';
                        tabla += '<td>' + obj[i]["email"] + '</td>';

                        if (obj[i]["estadoContacto"] === 1) {
                            tabla += '<td>Activo</td>';
                        } else {
                            tabla += '<td>Inactivo</td>';
                        }

                        if (permisos.indexOf("M") !== -1) {
                            tabla += '<td><button class="btn bg-purple btn-flat" id="nmc_' + obj[i]["id_contacto"] + '" onclick="retornarNMContactos(this.id,6)" title="Seleccionar / Modificar" ><span class="fa fa-edit"></span></button></td>';
                        } else {
                            tabla += '<td></td>';
                        }
                        tabla += '</tr>';
                    }


                    if (permisos.indexOf("A") !== -1) {
                        tabla += '<tr>';
                        tabla += '<td><input type="button" class="btn btn-success" value="Adicionar" onclick="mostrarFormulario(1);"/></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
                        tabla += '</tr>';
                    }

                    tabla += '</tbody>';

                    $("#editarCrearContacto").hide();
                    $("#divContactos").html(tabla);
                    $("#divContactos").show();

                } else {
                    $("#divContactos").hide();
                    $("#editarCrearContacto").show();
                    $("#modificarContacto").hide();
                    $("#listarContactos").hide();
                    $("#mensajesContactos").html('<div class="callout callout-warning">No se registran contactos para este sede.</div>');
                    $("#id_sucursal").val(nmc);
                    $("#adicionarContacto").show();
                    $("#estadoContacto").prop('checked', true);
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=5,opcion=7) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 6 || opcion === 8) {
        
        var nms = null;

        if (typeof data === 'number' && !isNaN(data)) {
            nms = data;
        } else {
            nms = data.substring(4, data.length);
        }

        var datosAEnviar = {
            'id_contacto': nms
        };

        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '6', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                $("#divContactos").hide();
                $("#editarCrearContacto").show();

                if (opcion === 6) {
                    $("#adicionarContacto").hide();
                    $("#modificarContacto").show();
                    $("#listarContactos").show();
                }

                if (opcion === 8) {
                    $("#listarContactos").hide();
                    $("#mensajesContacto").html('');
                    $("#divContactos").hide();
                    retornarNMNits(nms, 5);
                }

                $("#id_contacto").val(obj[0]["id_contacto"]);
                $("#cc_contacto").val(obj[0]["cc_contacto"]);

                 //permiso para "M"odificar
                if (permisos.indexOf("M") !== -1) {                    
                    $("#cc_contacto").prop('disabled', false);
                    $("#modificarContacto").show();
                }else{
                    $("#cc_contacto").prop('disabled', true);
                    $("#modificarContacto").hide();                     
                }

                id_contacto=obj[0]["id_contacto"];
                cc_contacto = obj[0]["cc_contacto"];
                
                $("#nom_contacto").val(obj[0]["nom_contacto"]);
                $("#cargo").val(obj[0]["cargo"]);
                $("#tel_contacto").val(obj[0]["tel_contacto"]);
                $("#email").val(obj[0]["email"]);

                if (obj[0]["estado"] === 1) {
                    $("#estadoContacto").prop('checked', true);
                    $("#lblEstadoContacto").text('Estado: ACTIVO');
                } else {
                    $("#estadoContacto").prop('checked', false);
                    $("#lblEstadoContacto").text('Estado: INACTIVO');
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMContactos(datos, opcion=6,opcion=8) {...\nError from server, please call support");
            }
        });
    }
}

function actualizarNMContactos(datos, opcion) {


    if (opcion === 1) {

        var estado = 0;

        if ($("#estadoContacto").prop("checked")) {
            estado = 1;
        }

        var datosAEnviar = {
            'cc_contacto': $("#cc_contacto").val(),
            'tel_contacto': $("#tel_contacto").val(),
            'nom_contacto': $("#nom_contacto").val(),
            'email': $("#email").val(),
            'estado': estado,
            'id_contacto':$("#id_contacto").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    $("#mensajes").html('<div class="callout callout-success">Datos actualizados</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function actualizarNMContactos(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2 || opcion === 3) {

        var estado = 0;

        if ($("#estadoContacto").prop("checked")) {
            estado = 1;
        } else {
            estado = 0;
        }

        var datosAEnviar = {
            'cc_contacto': $("#cc_contacto").val(),
            'tel_contacto': $("#tel_contacto").val(),
            'nom_contacto': $("#nom_contacto").val(),
            'email': $("#email").val(),
            'cargo': $("#cargo").val(),
            'id_contacto': $("#id_contacto").val(),
            'estado': estado
        };

        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '7', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    if (opcion === 2) {
                        $("#divContactos").html('');
                        var data = $("#id_sucursal").val();
                        retornarNMContactos(data, 7);
                        $("#editarCrearContacto").hide();
                        $("#modificarContacto").hide();
                    }

                    if (opcion === 3) {
                        $("#mensajesContacto").html('<div class="callout callout-success">Contacto actualizado de manera correcta</div>');
                        $("#modificarContacto").show();
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function actualizarNMContactos(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }

}

function crearNMContactos(data, opcion) {
    if (opcion === 1) {

        var datosAEnviar = {
            'cc_contacto': $("#cc_contacto").val(),
            'tel_contacto': $("#tel_contacto").val(),
            'nom_contacto': $("#nom_contacto").val(),
            'email': $("#email").val(),
            'cargo': $("#cargo").val(),
            'id_sucursal': $("#id_sucursal").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_contactos.php",
            data: {'caso': '8', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (opcion === 1) {
                    if (obj > 0) {
                        var data = $("#id_sucursal").val();
                        retornarNMContactos(data, 7);
                        $("#cc_contacto").val('');
                        $("#nom_contacto").val('');
                        $("#cargo").val('');
                        $("#tel_contacto").val('');
                        $("#email").val('');
                        $("#editarCrearContacto").hide();
                        $("#adicionarContacto").hide();
                        $("#mensajesContacto").html('');
                    } else {
                        $("#mensajesContacto").html('<div class="callout callout-warning">En verdad esto es una verguenza. Excusas. Algo fallo en el proceso de la creación del contacto. Podría por favor presionar la combinación de teclas CTRL + R?</div>');
                    }
                }


            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearNMContactos(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }
}

function establecerDatosUnSoloContacto(obj, opcion) {
    if (opcion === 1) {
        $("#cc_contacto").val(obj[0]["cc_contacto"]);
        if (obj[0]["tel_contacto"].length === 0) {
            $("#mensajes").html('<div class="callout callout-info">No se registra teléfono</div>');
            $("#tel_contacto").val('');
        }

        if (obj[0]["email"].length === 0) {
            $("#mensajes").append('<div class="callout callout-warning">No se registra correo</div>');
            $("#email").val('');
        }

        $("#nom_contacto").val(obj[0]["nom_contacto"]);
        $("#id_contacto").val(obj[0]["id_contacto"]);
        $("#cargo").val(obj[0]["cargo"]);
        $("#cc_contacto").prop('disabled', true);
        cc_contacto = obj[0]["cc_contacto"];
        $("#tel_contacto").val(obj[0]["tel_contacto"]);
        $("#email").val(obj[0]["email"]);
        $("#crearVMClientesProv").hide();

        if (permisos.indexOf("M") !== -1) {
            $("#modificarContacto").show();
        }

        retornarNMNits(obj[0]["id_contacto"], 5);
    }
}