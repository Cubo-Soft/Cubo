function retornarNMNits(data, opcion) {

    /*
     * se estaba usando en requerim.php pero esta interfaz fue reemplazada por 
     * tomar_requerimiento.php
     */

    if (opcion === 1) {
        var datosAEnviar = {
            'numid': $("#nit_cliente").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["nm_nits"].length > 0 && obj["nm_personas"].length > 0) {
                    $("#nombre").val(obj["nm_personas"][0]["nombres"] + ' ' + obj["nm_personas"][0]["apellidos"]);
                    $("#nit_cliente").prop("disabled", true);
                    $("#nombre").prop("disabled", true);
                    $("#np_tiponit").val();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    /*
     * para la busqueda de los datos en la interfaz tomarequerimiento.php
     * se llama desde nm_contactos.js opcion 3
     */
    if (opcion === 2) {
        var datosAEnviar = {
            'id_contacto': data["id_contacto"]
        };
        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    establecerValores(obj, 1);

                } else {
                    $("#mensajes").html('<div class="callout callout-danger">Error pendiente por controlar...</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }

    /*
     * para la busqueda de los nits en administracin_clientes.php 
     * a traves de administración_clientes.js 
     * en el evento onkeypress
     */

    if (opcion === 3) {
        var datosAEnviar = {
            'numid': $("#numid").val()
        };
        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["numid", "numid"];
                    var nombreDataList = 'nm_nits';
                    $("#DivDataListNMNits").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=3) {...\nError from server, please call support");
            }
        });
    }

    /*
     * para la busqueda de los nits en admon_clie.php 
     * a traves de admon_clie.js 
     * en el evento blur
     */
    if (opcion === 4 || opcion === 6) {
        $("#mensajes").html('');

        if (opcion === 4) {
            var datosAEnviar = {
                'numid': $("#numid").val()
            };
        }

        if (opcion === 6) {
            var datosAEnviar = {
                'numid': $("#numid").val()
            };
        }

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                $("#nuevaBusqueda").show();

                if (obj["nm_nits"].length > 0) {

                    $("#divComplementosNIT").show();
                    $("#listaComplementosNIT").show();

                    if (opcion === 4) {
                        retornarNMCompleme(null, 1);
                        estableceValoresJuridicaNatural(obj, 1);
                    }

                    if (opcion === 6) {
                        estableceValoresJuridicaNatural(obj, 2);
                    }

                    $("#dv").val(obj["nm_nits"][0]["dv"]);
                    $("#np_activeco").val(obj["nm_nits"][0]["actividad"]);
                    $("#np_tiponit").val(obj["nm_nits"][0]["idclase"]);
                    $("#ip_dtbasicos").val(obj["nm_nits"][0]["tipo_entidad"]);
                    $("#tipoPersona").val(obj["nm_nits"][0]["tipo_per"]);
                    $("#existe").val('1');
                    $("#estado_entidad").val(obj["nm_nits"][0]["stdnit"]);
                    $("#numid").prop('disabled', true);

                    if (permisos.indexOf("M") !== -1) {
                        $("#modificarClientes").show();
                    }
                    $("#crearClientes").hide();
                } else {
                    $("#divComplementosNIT").show();
                    $("#listaComplementosNIT").show();
                    retornarNMCompleme(null, 1);

                    consultarDV($("#numid").val(), 1);
                    $("#existe").val('0');
                    $("#tipoEntidad").val('0');
                    $("#np_activeco").val('-1');
                    $("#crearClientes").show();
                    $("#modificarSucursal").hide();
                    $("#listarSucursales").hide();
                    $("#listaSucursales").hide();
                    $("#divContactos").hide();
                    $("#nombre_empresa").val('');
                    $("#modificarClientes").hide();
                    if (permisos.indexOf("A") !== -1) {
                        $("#crearClientes").show();
                    }
                    //$("#ip_dtbasicos").val(74);
                    $("#estado_entidad").val(32);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=4) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 5) {

        var datosAEnviar = {
            'id_contacto': data
        };

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '7', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                estableceValoresJuridicaNatural(obj, 2);

                if (permisos.indexOf("M") !== -1) {
                    $("#modificarClientes").show();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=5) {...\nError from server, please call support");
            }
        });

    }

    if (opcion === 7) {
        var datosAEnviar = {
            'nombre_persona': $("#nombre_persona").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '8', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["numid", "nombre_persona"];
                    var nombreDataList = 'nombre_persona_1';
                    $("#DivDataListNombrePersona").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=5) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 8) {
        var datosAEnviar = {
            'nombre_persona': $("#nombre_persona").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '9', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["nm_juridicas"].length > 0) {
                    //persona juridica
                    $("#numid").val(obj["nm_juridicas"][0]["numid"]);
                    $("#mensajesUsuario").html('');
                    retornarNMJuridicas(null, 11);
                } else {
                    //persona natural
                    $("#numid").val(obj["nm_personas"][0]["numid"]);
                    $("#mensajesUsuario").html('');
                    retornarNMPersonas(null, 6);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNMNits(datos, opcion=5) {...\nError from server, please call support");
            }
        });
    }


}

function crearNMNits(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'numid': $("#numid").val(),
            'dv': $("#dv").val(),
            'idclase': $("#np_tiponit").val(),
            'tipo_per': $("#tipoPersona").val(),
            'actividad': $("#np_activeco").val(),
            'tipo_entidad': $("#ip_dtbasicos").val(),
            'stdnit': $("#estado_entidad").val(),
            'nombre_empresa': $("#nombre_empresa").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["nm_nits"].length > 0) {

                    $("#numid").prop('disabled', true);

                    //para las personas naturales
                    if ($("#ip_dtbasicos").val() === '74' && $("#np_tiponit").val() === '13') {
                        $("#divPersonasGeneral").show();
                        $("#mensajes").html('');
                        $("#mensajesPersonas").html('<div class="callout callout-info">Por favor ingrese los datos del cliente tipo persona. Con los apellidos y nombres sería suficiente mientras se obtienen otros datos.<br> Mejor si logra ubicar el sexo y la fecha de nacimiento! <br> Podría ALFRIO enviar un saludo de cumpleaños?</div>');
                        $("#crearClientes").hide();
                        $("#nuevaBusqueda").hide();
                        $("#modificarPersona").hide();
                        //para las personas juridicas en colombia
                    } else if ($("#ip_dtbasicos").val() === '74' && $("#np_tiponit").val() === '31') {
                        $("#divJuridicas").show();
                        $("#mensajes").html('');
                        $("#modificarJuridica").hide();
                        $("#adicionarJuridica").show();
                        $("#mensajesJuridicas").html('<div class="callout callout-info">Por favor ingrese el nombre de la entidad y presione el botón "Adicionar".</div>');
                        $("#razon_social").focus();
                    } else {
                        $("#mensajes").html('<div class="callout callout-success">Bien, se ha iniciado la creación del ' + $("#ip_dtbasicos option:selected").text() + '. Por favor ingrese los datos de la "SEDE PRINCIPAL" <br>Una vez se cree la sede, el sistema mostrará una tabla con las sedes creadas. <br>Para la creación del contacto, por favor presione en el icono <button class="btn bg-navy btn-flat" title="Ver contactos" ><span class="fa fa-users"></button>.<br> Será la última sección del proceso!</div>');
                        $("#divSucursalesGeneral").show();
                        $("#nom_sucur").val('SEDE PRINCIPAL');
                        $("#numid").prop('disabled', true);
                        $("#crearClientes").hide();
                        $("#nuevaBusqueda").hide();
                        var data = {
                            'numid': $("#numid").val()
                        };
                        retornarNMSucursal(data, 1);
                    }


                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function crearNMNits(data,opcion=1) {...\nError from server, please call support");
            }
        });
    }
}

function actualizarNMNits(data, opcion) {
    if (opcion === 1) {

        var datosAEnviar = {
            'numid': $("#numid").val(),
            'stdnit': $("#estado_entidad").val(),
            'actividad': $("#np_activeco").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_nits.php",
            data: { 'caso': '6', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    $("#mensajes").html('<div class="callout callout-success">Bien, registro actualizado!</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function actualizarNMNits(data,opcion) {...\nError from server, please call support");
            }
        });
    }
}

function estableceValoresJuridicaNatural(obj, opcion) {

    if (opcion === 1) {
        //if ((parseInt(obj["nm_nits"][0]["tipo_entidad"]) === 74 || parseInt(obj["nm_nits"][0]["tipo_entidad"]) === 73) && parseInt(obj["nm_nits"][0]["idclase"]) === 13) {
        if (parseInt(obj["nm_nits"][0]["tipo_per"]) === 23) {

            $("#divPersonasGeneral").show();
            retornarNMPersonas(null, 1);
        }
        //} else if ((parseInt(obj["nm_nits"][0]["tipo_entidad"]) === 74 || parseInt(obj["nm_nits"][0]["tipo_entidad"]) === 73) && parseInt(obj["nm_nits"][0]["idclase"]) === 31) {
        else if (parseInt(obj["nm_nits"][0]["tipo_per"]) === 24) {
            $("#divJuridicas").show();
            retornarNMJuridicas(null, 5);
        } else if (parseInt(obj["nm_nits"][0]["tipo_entidad"]) === 109) {

            $("#divComplementosNIT").hide();
            var data = {
                'numid': $("#numid").val()
            };
            retornarNMSucursal(data, 1);

            $("#divEmpleadosGeneral").show();
            $("#divUsuariosGeneral").show();

            retornarNMEmpleados(null, 1);

            retornarAMUsuarios(null, 5);

        } else {
            $("#divJuridicas").show();
            retornarNMJuridicas(null, 5);
            var data = {
                'numid': $("#numid").val()
            };
            retornarNMSucursal(data, 1);
        }
    }

    if (opcion === 2) {
        
        if (parseInt(obj[0]["tipo_entidad"]) === 74 && parseInt(obj[0]["idclase"]) === 13) {
            //     //$("#divPersonasGeneral").show();
            //     $("#divJuridicas").hide();
            //     //retornarNMPersonas(obj[0]["numid"], 2);
        } else if (parseInt(obj[0]["tipo_entidad"]) === 74 && parseInt(obj[0]["idclase"]) === 31) {
            //     $("#divJuridicas").show();
            //     $("#divPersonasGeneral").hide();
            //     retornarNMJuridicas(obj[0]["numid"], 6);

        } else if (parseInt(obj[0]["tipo_entidad"]) === 73 && parseInt(obj[0]["idclase"]) === 13) {

            //     //$("#divPersonasGeneral").show();
            //     $("#divJuridicas").hide();
            $("#divContactosGeneral").hide();
            retornarNMPersonas(obj[0]["numid"], 2);
            $("#personaNatural").val('1');

        } else {
            $("#divJuridicas").show();
            retornarNMJuridicas(obj[0]["numid"], 6);
            var data = {
                'numid': obj[0]["numid"]
            };
            retornarNMSucursal(data, 1);

            if(parseInt(obj[0]["tipo_entidad"]) === 109){
                $("#divJuridicas").hide();
            }
        }
    }
}