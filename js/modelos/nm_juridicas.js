function retornarNMJuridicas(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["razon_social", "numid"];
                    var nombreDataList = 'nm_juridicas_1';
                    $("#DivDataListJuridicas").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2) {
        var datosAEnviar = {
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    establecerValores(obj, 1);
                    retornarNMSucursal(datosAEnviar, 1);
                } else {
                    establecerValores(null, 2);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 3 || opcion === 10) {

        if (opcion === 3) {
            var datosAEnviar = {
                'razon_social': $("#razon_social").val()
            };
        }

        if (opcion === 10) {
            var datosAEnviar = {
                'razon_social': $("#nombre_persona").val()
            };
        }

        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    if (opcion === 3) {
                        var nombres = ["numid", "razon_social"];
                        var nombreDataList = 'razon_social_1';
                        $("#DivDataListRazonSocial").html(retornarDataList(obj, nombres, nombreDataList));
                    }

                    if (opcion === 10) {                        
                        var nombres = ["numid", "razon_social"];
                        var nombreDataList = 'nombre_persona_1';
                        $("#DivDataListNombrePersona").html(retornarDataList(obj, nombres, nombreDataList));
                    }
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=3) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 4) {
        var datosAEnviar = {
            'razon_social': $("#razon_social").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    $("#divBotonesBusqueda").html('');
                    $("#divBotonesBusqueda").html('<div class="callout callout-info" >Búsqueda por empresa</div>');

                    establecerValores(obj, 1);
                    var datosAEnviar = {
                        'numid': obj[0]["numid"]
                    };
                    retornarNMSucursal(datosAEnviar, 1);
                } else {
                    //buscar en vm_clientesprov
                    retornarVMClientesProv(null, 2);
                    $("#datosInicialesEmpresa").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=4) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 5 || opcion === 6 || opcion===11) {

        if (opcion === 5 || opcion===11) {
            var datosAEnviar = {
                'numid': $("#numid").val()
            };
        }

        if (opcion === 6) {
            var datosAEnviar = {
                'numid': data
            };
        }

        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '6', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {

                    if (opcion === 5) {
                        $("#razon_social").val(obj[0]["razon_social"]);
                    }

                    if (opcion === 6) {
                        $("#razon_social").val(obj[0]["razon_social"]);
                        $("#numid").val(obj[0]["numid"]);
                        numid = obj[0]["numid"];
                        $("#numid").prop('disabled', true);
                        $("#adicionarJuridica").hide();
                        $("#modificarJuridica").hide();
                        $("#divSucursalesGeneral").show();
                        $("#datosInicialesEmpresa").show();
                        $("#divJuridicas").hide();
                    }

                    if(opcion===5 || opcion===6){
                        retornarNMSucursal(datosAEnviar, 1);
                    }
                    
                    if(opcion===11){
                        $("#numid").val(obj[0]["numid"]);   
                        retornarNMSucursal(datosAEnviar, 4);                     
                    }
                    

                } else {
                    $("#divSucursalesGeneral").hide();
                    $("#razon_social").focus();
                    $("#mensajesJuridicas").html('<div class="callout callout-warning">No se registra un nombre válido para esta empresa. Podría crearla por favor?</div>');
                    $("#adicionarJuridica").show();
                    $("#modificarJuridica").hide();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=5) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 7) {
        var datosAEnviar = {
            'razon_social': $("#razon_social").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '8', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["numid", "razon_social"];
                    var nombreDataList = 'razon_social_1';
                    $("#DivDataListRazonSocial").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=3) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 8) {
        var datosAEnviar = {
            'razon_social': $("#razon_social").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    $("#numid_r").val(obj[0]["numid"]);
                    $("#divMsjCriterio").html('');
                } else {
                    $("#divMsjCriterio").html('<div class="alert alert-danger">Los valores de búsqueda no son coincidentes con los registrados. Por favor verifique</div>');
                    $("#razon_social").val('');
                    $("#razon_social").focus();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=4) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 9) {
        var datosAEnviar = {
            'razon_social': $("#razon_social_3").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '9', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["numid", "razon_social_3"];
                    var nombreDataList = 'razon_social_3';
                    $("#DivDataListClientes").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMJuridicas(datos, opcion=3) {...\nError from server, please call support");
            }
        });
    }

}

function crearNMJuridicas(data, opcion) {
    if (opcion === 1) {
        var datosAEnviar = {
            'razon_social': $("#razon_social").val(),
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === '0') {
                    $("#mensajesJuridicas").html('<div class="callout callout-success">Empresa creada de manera correcta</div>');
                    $("#adicionarJuridica").hide();
                    $("#modificarJuridica").show();
                    retornarNMSucursal(datosAEnviar, 1);
                } else {
                    $("#mensajesJuridicas").html('<div class="callout callout-warning">Esto es vergonzoso. Algunas veces no se logra comunicación con el servidor. Podría por favor presionar "CTRL" + "R" e intenarlo nuevamente?</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearNMJuridicas(data,opcion=1){...\nError from server, please call support");
            }
        });
    }
}

function actualizarNMJuridicas(data, opcion) {
    if (opcion === 1) {
        var datosAEnviar = {
            'razon_social': $("#razon_social").val(),
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_juridicas.php",
            data: { 'caso': '7', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    $("#mensajesJuridicas").html('<div class="callout callout-success">Empresa actualizada de manera correcta</div>');
                    $("#adicionarJuridica").hide();
                    $("#modificarJuridica").show();
                } else {
                    $("#mensajesJuridicas").html('<div class="callout callout-warning">Esto es vergonzoso. Algunas veces no se logra comunicación con el servidor. Podría por favor presionar "CTRL" + "R" e intenarlo nuevamente?</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearNMJuridicas(data,opcion=1){...\nError from server, please call support");
            }
        });
    }
}