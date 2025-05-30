function retornarIMItems(data, opcion) {

    $("#divFoto").html("");

    if (numid === null && id_sucursal === null && cc_contacto === null && $("#clienteProvisional").val() === '0') {

        $("#mensajesParametrosIniciales").html('<div class="callout callout-danger">No se registran datos del cliente. Por favor realice primero la búsqueda el cliente y podría continuar aquí. Recuerde por favor seleccionar la fuente del requerimiento!</div>');
        $("#ip_grupos").val('-1');
        $("#ip_lineas").val('-1');
        $("#fuentes").focus();

    }

    if ($("#ip_grupos").val() !== '-1' || $("#ip_lineas").val() === '-1') {

        var textoUnido = '<strong>' + $("#ip_grupos option:selected").html() + ' ' + $("#ip_lineas option:selected").html() + '</strong>';

        if (opcion === 1 || opcion === 15 || opcion === 16) {

            if (opcion === 1 || opcion === 16) {
                var datosAEnviar = {
                    'ip_lineas': $("#ip_lineas").val(),
                    'ip_grupos': $("#ip_grupos").val()
                };
            }

            if (opcion === 1) {
                var data = [];
                data["nombreDiv"] = "divSugerencia";
                retornarVPAsesorZona(data, 1);
            }

            if (opcion === 15) {
                var datosAEnviar = {
                    'ip_lineas': data["ip_lineas"],
                    'ip_grupos': data["ip_grupos"]
                };
            }

            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    $("#mensajesParametrosIniciales").html('');

                    //repuestos
                    if ($("#ip_grupos").val() === '02') {

                        $("#textoUnido").html(textoUnido);

                        var datos = {
                            'nombreSelect': 'grup_items',
                            'nombreFuncion': 'retornarIMItems(null, 2)'
                        };
                        var datosDeLista = {
                            'valor': 'cod_grupo',
                            'texto': 'nom_grupo'
                        };

                        $("#divServicioMantenimiento").hide();
                        $("#divEquipos").hide();
                        $("#divRepuestos").show();

                        $("#divProductosIniciales").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                    //equipos    
                    } else if ($("#ip_grupos").val() === '01') {

                        $("#textoUnido2").html(textoUnido);

                        $("#divRepuestos").hide();
                        $("#divServicioMantenimiento").hide();

                        if (opcion === 16) {
                            var datos = {
                                'nombreSelect': 'im_items2',
                                'nombreFuncion': 'retornarIRCaracte(this.id, 3)'
                            };
                        } else {
                            var datos = {
                                'nombreSelect': 'im_items2',
                                'nombreFuncion': 'retornarIRCaracte(this.id, 1)'
                            };
                        }

                        var datosDeLista = {
                            'valor': 'cod_grupo',
                            'texto': 'nom_grupo'
                        };

                        $("#divEquipos").show();
                        $("#divEquiposIniciales").html(crearSelect(datos, obj, datosDeLista, 0));

                        //servicios de mantenimiento
                    } else if ($("#ip_grupos").val() === '03') {

                        retornarSRProgMant(null, 1);

                        $("#divServicioMantenimiento").show();
                        $("#divEquipos").hide();
                        $("#divRepuestos").hide();

                        var datos = {
                            'nombreSelect': 'im_items3',
                            'nombreFuncion': null
                        };
                        var datosDeLista = {
                            'valor': 'id_articulo',
                            'texto': 'descrip'
                        };

                        $("#textoUnido3").html(textoUnido);

                        //proyectos
                    } else if ($("#ip_grupos").val() === '04') {

                        $("#textoUnido2").html(textoUnido);

                        $("#divRepuestos").hide();
                        $("#divServicioMantenimiento").hide();

                        var datos = {
                            'nombreSelect': 'im_items2',
                            'nombreFuncion': 'retornarIRCaracte(this.id, 1)'
                        };
                        var datosDeLista = {
                            'valor': 'cod_grupo',
                            'texto': 'nom_grupo'
                        };

                        $("#divEquipos").show();
                        $("#divEquiposIniciales").html(crearSelect(datos, obj, datosDeLista, 0));

                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=1) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 2) {

            $("#cantidadRepuestos").val('');
            $("#btnLlamarPUBodegas").hide();
            $("#modalBodegasProductos").hide();

            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj.length === 0) {
                        //para la opcion 'NO EXISTE'                        
                        retornarIPTipos(null, 2);
                        retornarIPMarcas(null, 2);
                        retornarIRCaracte($("#grup_items").val()[0], 2);
                        $("#divDimensiones").html('');
                        $("#divUnidadMedida").html('');
                        $("#divCodigosArticulos").html('');
                        $("#divProductosBorradores").html('');
                        $("#divCaracteristicasBorradores").html('');
                        $("#divCantidadRepuestos").show();
                        $("#divTextoRepuestos").removeClass('col-lg-12 disabled color-palette bg-gray');
                        $("#divTextoRepuestos").addClass('col-lg-12 disabled color-palette bg-danger');
                        $("#divFiltrosRepuestos1").removeClass('bg-gray');
                        $("#divFiltrosRepuestos1").addClass('bg-danger');
                        $("#divFiltrosRepuestos2").removeClass('bg-gray');
                        $("#divFiltrosRepuestos2").addClass('bg-danger');
                        $("#divTextoRepuestos").html('<center><label>Grupo no hay, adicione posibles tipo y/o marca. </label></center>');
                        $("#repuesto_existe").val('0');
                    } else {

                        $("#repuesto_existe").val('1');
                        var datos = {
                            'nombreSelect': 'id_tipos',
                            'nombreFuncion': 'retornarIMItems(null, 3)'
                        };

                        var datosDeLista = {
                            'valor': 'id_tipo',
                            'texto': 'descrip'
                        };

                        $("#divTipos").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                        $("#divMarcas").html('');
                        $("#divModelos").html('');
                        $("#divDimensiones").html('');
                        $("#divUnidadMedida").html('');
                        $("#divCodigosArticulos").html('');
                        $("#divProductosBorradores").html('');
                        $("#divCaracteristicasBorradores").html('');
                        $("#divCantidadRepuestos").hide();
                        $("#divTextoRepuestos").removeClass('rojo');
                        $("#divTextoRepuestos").addClass('bg-gray');

                        $("#divFiltrosRepuestos1").removeClass('bg-danger');
                        $("#divFiltrosRepuestos1").addClass('bg-gray');
                        $("#divFiltrosRepuestos2").removeClass('bg-danger');
                        $("#divFiltrosRepuestos2").addClass('bg-gray');

                        $("#divTextoRepuestos").html('<center><label>Filtros para búsqueda de repuestos</label></center>');

                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=2) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 3) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '3', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    var datos = {
                        'nombreSelect': 'ip_marcas',
                        'nombreFuncion': 'retornarIMItems(null, 4)'
                    };

                    var datosDeLista = {
                        'valor': 'id_marca',
                        'texto': 'nom_marca'
                    };

                    $("#divMarcas").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                    $("#divModelos").html('');
                    $("#divDimensiones").html('');
                    $("#divUnidadMedida").html('');
                    $("#divCodigosArticulos").html('');

                    retornarIMItems(null, 9);

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=3) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 4) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj.length > 0) {
                        var datos = {
                            'nombreSelect': 'ip_modelos',
                            'nombreFuncion': 'retornarIMItems(null, 5)'
                        };
                        var datosDeLista = {
                            'valor': 'id_modelo',
                            'texto': 'descrip_modelo'
                        };
                        retornarIMItems(null, 10);
                        $("#divDimensiones").html('');
                        $("#divUnidadMedida").html('');
                        $("#divCodigosArticulos").html('');
                        $("#divModelos").html(crearSelectMultiple(datos, obj, datosDeLista, 0));
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=4) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 5) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    var datos = {
                        'nombreSelect': 'ip_dimens',
                        'nombreFuncion': 'retornarIMItems(null, 6)'
                    };

                    var datosDeLista = {
                        'valor': 'id_dimen',
                        'texto': 'nom_dimen'
                    };

                    retornarIMItems(null, 11);

                    $("#divUnidadMedida").html('');
                    $("#divCodigosArticulos").html('');

                    $("#divDimensiones").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=5) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 6) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val(),
                'dimensiones': $("#ip_dimens").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '6', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    var datos = {
                        'nombreSelect': 'ip_unidades',
                        'nombreFuncion': 'retornarIMItems(null, 7)'
                    };

                    var datosDeLista = {
                        'valor': 'cod_unidad',
                        'texto': 'nom_unidad'
                    };

                    retornarIMItems(null, 12);

                    $("#divCodigosArticulos").html('');

                    $("#divUnidadMedida").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=6) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 7) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val(),
                'dimensiones': $("#ip_dimens").val(),
                'unidad': $("#ip_unidades").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '7', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    var datos = {
                        'nombreSelect': 'im_items',
                        'nombreFuncion': 'retornarIMItems(null, 14)'
                    };

                    var datosDeLista = {
                        'valor': 'cod_item',
                        'texto': 'codigoItem'
                    };

                    $("#divCodigosArticulos").html(crearSelectMultiple(datos, obj, datosDeLista, 0));

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=7) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 9) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '9', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=9) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 10) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val()
            };

            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '10', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 11) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '11', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 12) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val(),
                'ip_dimens': $("#ip_dimens").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '12', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

        if (opcion === 13) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val(),
                'ip_dimens': $("#ip_dimens").val(),
                'ip_unidades': $("#ip_unidades").val()
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '13', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

        //filtro 1 es para decirle al controlador como obtener los datos. 
        //aqui es cuando tiene todos los filtros trabajando 
        if (opcion === 14) {
            var datosAEnviar = {
                'grup_item': $("#grup_items").val(),
                'ip_lineas': $("#ip_lineas").val(),
                'id_tipos': $("#id_tipos").val(),
                'ip_marcas': $("#ip_marcas").val(),
                'ip_modelos': $("#ip_modelos").val(),
                'ip_dimens': $("#ip_dimens").val(),
                'ip_unidades': $("#ip_unidades").val(),
                'cod_item': $("#im_items").val(),
                'filtro': '1'
            };
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '14', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);

                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));

                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

        //aqui es cuando buscan por cod_item desde la consulta de los filtros de repuestos
        if (opcion === 17) {
            var datosAEnviar = {
                'grup_item': data[0]["grup_item"],
                'ip_lineas': data[0]["linea"],
                'id_tipos': data[0]["tipo_item"],
                'ip_marcas': data[0]["id_marca"],
                'ip_modelos': data[0]["modelo"],
                'ip_dimens': data[0]["dimensiones"],
                'ip_unidades': data[0]["unidad"],
                'cod_item': data[0]["cod_item"],
                'filtro': '0'
            };

            $("#grup_items2").val(data[0]["grup_item"]);
            $("#tipos2").val(data[0]["tipo_item"]);
            $("#marcas2").val(data[0]["id_marca"]);

            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '14', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj["datosRepuesto"].length > 0) {
                        var data = {
                            'id_tabla': 'tablaProductosBorradores'
                        };
                        $("#divProductosBorradores").html(armarTablaProductosBorradores(obj, data, 1));
                    } else {
                        $("#divProductosBorradores").html('');
                    }

                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error function retornarIMItems(datos, opcion=10) {...\nError from server, please call support");
                }
            });
        }

    } else {

        $("#mensajesParametrosIniciales").html('<div class="callout callout-warning">Por favor seleccione al menos un valor para la lista "Misionales"</div>');
        $("#divRepuestos").hide();
        $("#divEquipos").hide();
        $("#divServicioMantenimiento").hide();
    }
}


function retornarIMItems2(data, opcion) {

    if (opcion === 1) {
        var datosAEnviar = {
            'cod_item': $("#cod_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '15', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["cod_item", "cod_item"];
                    var nombreDataList = 'cod_item_1';
                    $("#DivDataListItems").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=1) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 2) {
        var datosAEnviar = {
            'cod_item': $("#cod_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '16', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["im_items"].length > 0) {
                    establecerValores(obj, 4);
                } else {
                    retornarMensajeDeCreacion(2);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=2) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 3) {
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '19' },
            type: "POST",
            beforeSend: function () {
                $("#divFormulario").hide();
                $("#divListado").show();
                $("#divListadoRepuestos").html('<div class="m-0 row justify-content-center"><div class="col-auto p-5 text-center"><img width="400" src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" /><p>Un momento, cargando elementos...</p></div></div>');
            },
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                $("#divFormulario").hide();
                $("#divListado").show();

                var tabla = "<table class='table table-striped' id='tablaProductos'>";
                tabla += "<thead>";
                tabla += "<tr>";
                tabla += "<th>Referencia</th>";
                tabla += "<th>Referencia alterna</th>";
                //tabla += "<th>IVA</th>";
                tabla += "<th>Descripcion</th>";
                tabla += "<th>Marca</th>";
                tabla += "<th>Modelo</th>";
                tabla += "<th>Dimensiones</th>";
                tabla += "<th>Unidad</th>";
                //tabla += "<th>Minimo</th>";
                tabla += "<th>Estado</th>";
                tabla += "<th>Foto</th>";
                tabla += "<th></th>";
                tabla += "</tr>";
                tabla += "</thead>";
                tabla += "<tbody>";
                for (var i = 0; i < obj.length; i++) {
                    tabla += "<tr>";
                    //tabla+="<td>"+(i+1)+"</td>";                                      
                    tabla += "<td>" + obj[i]["cod_item"] + "</td>";
                    tabla += "<td>" + obj[i]["alter_item"] + "</td>";
                    tabla += "<td>" + obj[i]["nom_item"] + "</td>";
                    //tabla += "<td>" + obj[i]["precio_vta"] + "</td>";
                    tabla += "<td>" + obj[i]["nom_marca"] + "</td>";
                    tabla += "<td>" + obj[i]["descrip_modelo"] + "</td>";
                    tabla += "<td>" + obj[i]["nom_dimen"] + "</td>";
                    tabla += "<td>" + obj[i]["nom_unidad"] + "</td>";
                    tabla += "<td>" + obj[i]["estado"] + "</td>";
                    //tabla += "<td>" + obj[i]["maximo"] + "</td>";

                    if (obj[i]["foto"] === '../img_inve/sin_imagen.jpg') {
                        tabla += "<td>No</td>";
                    } else {
                        tabla += "<td>Si</td>";
                    }
                    tabla += '<td><button class="btn btn-success" id="' + obj[i]["cod_item"] + '" onclick="redirigir(this.id,5)" title="Ver producto" ><span class="fa fa-eye"></span></button></td>';
                    tabla += "</tr>";
                }
                tabla += "</tbody>";
                tabla += "<table>";
                $("#divListadoRepuestos").html(tabla);

                $("#mensajeListado").html('');

                $("#tablaProductos").DataTable({
                    "order": [[1, "asc"]]
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=3) {...\nError from server, please call support");
            }
        });

    }

    if (opcion === 4) {
        var datosAEnviar = {
            'alter_item': $("#alter_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '20', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["alter_item", "alter_item"];
                    var nombreDataList = 'alter_item_1';
                    $("#DivDataListItemsDos").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=4) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 5) {
        var datosAEnviar = {
            'alter_item': $("#alter_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '21', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj["im_items"].length > 0) {
                    establecerValores(obj, 4);
                } else {
                    retornarMensajeDeCreacion(2);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=5) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 6) {
        var datosAEnviar = {
            'cod_item': $("#cod_item").val(),
            'grup_item': $("#ip_grupos").val(),
            'linea': $("#ip_lineas").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '23', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["cod_item", "cod_item"];
                    var nombreDataList = 'cod_item_1';
                    $("#DivDataListItems").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=6) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 7) {
        var datosAEnviar = {
            'cod_item': $("#cod_item").val(),
            'grup_item': $("#ip_grupos").val(),
            'linea': $("#ip_lineas").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '24', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    retornarIMItems(obj, 17);
                    $("#alter_item").val(obj[0]["alter_item"]);
                    $("#nom_item").val(obj[0]["nom_item"]);
                    
                    $("#divTextoRepuestos").removeClass('col-lg-12 disabled color-palette bg-danger');
                    $("#divFiltrosRepuestos2").removeClass('bg-danger');
                    $("#divFiltrosRepuestos1").removeClass('bg-danger');
                    $("#divTextoRepuestos").addClass('col-lg-12 disabled color-palette bg-gray');
                    $("#divFiltrosRepuestos1").addClass('bg-gray');
                    $("#divFiltrosRepuestos2").addClass('bg-gray');
                    $("#divTextoRepuestos").html('');
                    $("#repuesto_existe").val('1');

                } else {
                    $("#divProductosBorradores").html('');
                    $("#divCantidadRepuestos").hide();
                    $("#alter_item").val('');
                    $("#nom_item").val('');
                    //$("#divProductosIniciales").html('');
                    $("#divFoto").html('');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=7) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 8) {
        var datosAEnviar = {
            'alter_item': $("#alter_item").val(),
            'grup_item': $("#ip_grupos").val(),
            'linea': $("#ip_lineas").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '25', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["alter_item", "alter_item"];
                    var nombreDataList = 'alter_item_1';
                    $("#DivDataListItemsDos").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=8) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 9) {
        var datosAEnviar = {
            'alter_item': $("#alter_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '26', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    $("#cod_item").val(obj[0]["cod_item"]);
                    retornarIMItems2(null, 7);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=9) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 10) {
        var datosAEnviar = {
            'nom_item': $("#nom_item").val(),
            'grup_item': $("#ip_grupos").val(),
            'linea': $("#ip_lineas").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '27', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 0) {
                    var nombres = ["nom_item", "nom_item"];
                    var nombreDataList = 'nom_item_1';
                    $("#DivDataListItemsTres").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=10) {...\nError from server, please call support");
            }
        });
    }

    if (opcion === 11) {
        var datosAEnviar = {
            'nom_item': $("#nom_item").val()
        };
        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '28', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length > 1) {
                    var tabla = '<div class="alert alert-info">Se han encontrado varias referencias con el nombre digitado.</div>';
                    tabla += '<table class="table table-info">';
                    tabla += '<tr>';
                    tabla += '<th><th>Articulo</th><th>Tipo</th><th>Marca</th><th>Modelo</th><th>Dimensiones</th><th>Unidad de medida</th></th><th>Referencia interna</th><th>Referencia alterna</th><th>Nombre</th><th></th>';
                    tabla += '</tr>';

                    for (let index = 0; index < obj.length; index++) {
                        tabla += '<tr>';
                        tabla += '<td>' + (index + 1) + '</td>';
                        tabla += '<td>' + obj[index]["nom_grupo"] + '</td>';
                        tabla += '<td>' + obj[index]["descrip"] + '</td>';
                        tabla += '<td>' + obj[index]["nom_marca"] + '</td>';
                        tabla += '<td>' + obj[index]["descrip_modelo"] + '</td>';
                        tabla += '<td>' + obj[index]["nom_dimen"] + '</td>';
                        tabla += '<td>' + obj[index]["nom_unidad"] + '</td>';
                        tabla += '<td>' + obj[index]["cod_item"] + '</td>';
                        tabla += '<td>' + obj[index]["alter_item"] + '</td>';
                        tabla += '<td>' + obj[index]["nom_item"] + '</td>';
                        tabla += '<td><button class="btn btn-primary" id="' + obj[index]["cod_item"] + '" title="Seleccionar" onclick="establecerCodItem(this.id,1)" ><span class="fa fa-question"></span></button></td>';
                        tabla += '</tr>';
                    }

                    tabla += '</table>';

                    tabla += '<div class="alert alert-info">Por favor presione el botón con el signo de interrogación correspondiente a una de ellas para continuar con la toma del requerimiento</div>';

                    $("#divRepuestosRepetidos").html(tabla);
                } else {
                    $("#divRepuestosRepetidos").html("");
                    $("#cod_item").val(obj[0]["cod_item"]);
                    retornarIMItems2(null, 7);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMItems2(datos, opcion=11) {...\nError from server, please call support");
            }
        });
    }


}

function cambiarIMItems(data, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        if ($("#ip_grupos").val() === 'null' || $("#ip_grupos").val() === null || $("#ip_grupos").val() === '-1') {
            $("#mensajesUsuario").html('<div class="alert alert-danger">Por favor seleccione un grupo válido</div>');
            $("#ip_grupos").focus();

        } else if ($("#ip_unidades").val() === 'null' || $("#ip_unidades").val() === null || $("#ip_unidades").val() === '-1') {

            $("#mensajesUsuario").html('<div class="alert alert-danger">Por favor seleccione una unidad válido</div>');
            $("#ip_unidades").focus();

        } else {

            datosAEnviar.cod_item = $("#cod_item").val();
            datosAEnviar.alter_item = $("#alter_item").val();
            datosAEnviar.nom_item = $("#nom_item").val();
            datosAEnviar.unidad = $("#ip_unidades").val();
            datosAEnviar.grup_item = $("#ip_grupos").val();
            datosAEnviar.numid = $("#numid").val();
            datosAEnviar.id_marca = $("#ip_marcas").val();
            datosAEnviar.unid_desgaste = $("#unid_desgaste").val();
            datosAEnviar.cant_desgaste = $("#cant_desgaste").val();
            datosAEnviar.facturable = $("#facturable").val();
            datosAEnviar.area_item = $("#areaItem").val();
            datosAEnviar.articulo = $("#ip_articulos").val();
            datosAEnviar.tipo_item = $("#ip_tipos").val();
            datosAEnviar.num_parte = $("#num_parte").val();
            datosAEnviar.estado_item = $("#estadoItem").val();
            datosAEnviar.iva = $("#iva").val();
            datosAEnviar.precio_vta = $("#precio_vta").val();
            datosAEnviar.modelo = $("#ip_modelos").val();
            datosAEnviar.linea = $("#ip_lineas").val();
            datosAEnviar.peso = $("#peso").val();
            datosAEnviar.volumen = $("#volumen").val();
            datosAEnviar.dimensiones = $("#ip_dimen").val();
            datosAEnviar.precio_vta_usd = $("#precio_vta_usd").val();
            datosAEnviar.minimo = $("#minimo").val();
            datosAEnviar.maximo = $("#maximo").val();
            datosAEnviar.id_proveedor = $("#id_proveedor").val();
            datosAEnviar.ap_camposx = $("#ap_camposx").val();

            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: { 'caso': '18', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj === 1) {
                        retornarIMItems2(null, 2);
                        $("#mensajesUsuario").html('<div class="alert alert-info">Actualización correcta</div>');
                    } else {
                        $("#mensajesUsuario").html('<div class="alert alert-danger">Actualización fallida. Por favor presione el botón "Limpiar" para iniciar nuevamente. Si la falla persiste por favor informe</div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function cambiarIMItems(data,opcion){ opcion 1...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }
    }
}

function crearIMItems(data, opcion) {

    if (opcion === 1) {

        var datosAEnviar = {};

        datosAEnviar.cod_item = $("#cod_item").val();
        datosAEnviar.alter_item = $("#alter_item").val();
        datosAEnviar.nom_item = $("#nom_item").val();
        datosAEnviar.unidad = $("#ip_unidades").val();
        datosAEnviar.grup_item = $("#ip_grupos").val();
        datosAEnviar.numid = $("#numid").val();
        datosAEnviar.numid = $("#id_proveedor").val();
        datosAEnviar.id_marca = $("#ip_marcas").val();
        datosAEnviar.unid_desgaste = $("#unid_desgaste").val();
        datosAEnviar.cant_desgaste = $("#cant_desgaste").val();
        datosAEnviar.facturable = $("#facturable").val();
        datosAEnviar.area_item = $("#areaItem").val();
        datosAEnviar.articulo = $("#ip_articulos").val();
        datosAEnviar.tipo_item = $("#ip_tipos").val();
        datosAEnviar.num_parte = $("#num_parte").val();
        datosAEnviar.estado_item = $("#estadoItem").val();
        datosAEnviar.iva = $("#iva").val();
        datosAEnviar.precio_vta = $("#precio_vta").val();
        datosAEnviar.precio_vta_usd = $("#precio_vta_usd").val();
        datosAEnviar.modelo = $("#ip_modelos").val();
        datosAEnviar.linea = $("#ip_lineas").val();
        datosAEnviar.peso = $("#peso").val();
        datosAEnviar.volumen = $("#volumen").val();
        datosAEnviar.dimensiones = $("#ip_dimen").val();
        datosAEnviar.minimo = $("#minimo").val();
        datosAEnviar.maximo = $("#maximo").val();
        datosAEnviar.id_proveedor = $("#id_proveedor").val();
        datosAEnviar.ap_camposx = $("#ap_camposx").val();

        $.ajax({
            url: "../controladores/CT_im_items.php",
            data: { 'caso': '22', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === "0") {
                    $("#mensajesUsuario").html('<div class="alert alert-success">Creación correcta. Por favor ingrese la fotografía del elemento</div>');
                    $("#divSubirFoto").show();
                } else {
                    $("#mensajesUsuario").html('<div class="alert alert-danger">Creación fallida. Por favor presione el botón "Limpiar" para iniciar nuevamente. Seleccione y digite todos los campos del formulario. Si la falla persiste por favor informe</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function crearIMItems(data,opcion){ opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}