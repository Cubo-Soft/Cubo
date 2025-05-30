function retornarIPDTBasicos(data, opcion) {

    if (opcion === 1) {

        var datosAEnviar = {
            'id_basico': $("#ip_basicos").val()
        };
        $.ajax({
            url: "../controladores/CT_ip_dtbasicos.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                
                var tabla = '<table class="table table-hover table-sm">';
                tabla += '<thead>';
                tabla += '<tr class="bg-primary" >';
                tabla += '<th>DT Básico</th>';
                tabla += '<th>Estado</th>';
                tabla += '</tr>';
                tabla += '</thead>';
                tabla += '<tbody>';
                for (var i = 0; i < obj.length; i++) {

                    tabla += '<tr>';

                    if (permisos.indexOf("A") !== -1) {
                        tabla += '<td><input type="text" id="b-' + obj[i]["sec_basico"] + '" name="b-' + obj[i]["sec_basico"] + '" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Texto del IP_DTBasico" onblur="cambiarIPDtbasicos(2,this.id)" class="form form-control" value="' + obj[i]["dt_basico"] + '" /></td>';

                        tabla += '<td>';
                        if (obj[i]["estado"] === 1) {
                            tabla += '<input type="checkbox" id="a-' + obj[i]["sec_basico"] + '" name="a-' + obj[i]["sec_basico"] + '" onclick="cambiarIPDtbasicos(1,this.id)" checked />';
                        } else {
                            tabla += '<input type="checkbox" id="a-' + obj[i]["sec_basico"] + '" name="a-' + obj[i]["sec_basico"] + '" onclick="cambiarIPDtbasicos(1,this.id)" />';
                        }
                        tabla += '</td>';

                    } else {
                        tabla += '<td>' + obj[i]["dt_basico"] + '</td>';

                        if (obj[i]["estado"] === 1) {
                            tabla += 'Activo';
                        } else {
                            tabla += 'Inactivo';
                        }
                    }

                    tabla += '</tr>';
                }
                tabla += '</tbody>';
                tabla += '</table>';
                //$("#" + data["nombreDiv"]).html(tabla);

                if(permisos.indexOf("C")!==-1){
                    $("#divNuevoDTBasico").show();
                }
                
                $("#divIPDtbasicos").html(tabla);
                $("#dt_basico").prop('placeholder', 'Nuevo valor a víncular para ' + $("#ip_basicos option:selected").html());
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPDTBasicos(opcion) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    } else {

        if (opcion === 2) {
            var datosAEnviar = {
                'id_basico': 13
            };
        }

        if (opcion === 3) {
            var datosAEnviar = {
                'id_basico': 15
            };
        }

        if (opcion === 4) {
            var datosAEnviar = {
                'id_basico': 21
            };
        }

        if (opcion === 5) {
            var datosAEnviar = {
                'id_basico': 9
            };
        }

        if (opcion === 6) {
            var datosAEnviar = {
                'id_basico': 1
            };
        }

        if (opcion === 7) {
            var datosAEnviar = {
                'id_basico': 2
            };
        }

        if (opcion === 8) {
            var datosAEnviar = {
                'id_basico': 3
            };
        }

        if (opcion === 9) {
            var datosAEnviar = {
                'id_basico': 13
            };
        }

        if (opcion === 10) {
            var datosAEnviar = {
                'id_basico': 22
            };
        }

        if (opcion === 11) {
            var datosAEnviar = {
                'id_basico': 23
            };
        }

        if (opcion === 12) {
            var datosAEnviar = {
                'id_basico': 24
            };
        }

        if (opcion === 13 || opcion === 14) {
            var datosAEnviar = {
                'id_basico': 25
            };
        }

        if (opcion === 15) {
            var datosAEnviar = {
                'id_basico': 31
            };
        }

        if (opcion === 16) {
            var datosAEnviar = {
                'id_basico': 11
            };
        }

        if (opcion === 17) {
            var datosAEnviar = {
                'id_basico': 27
            };
        }

        if (opcion === 18) {
            var datosAEnviar = {
                'id_basico': 28
            };
        }

        if (opcion === 19) {
            var datosAEnviar = {
                'id_basico': 29
            };
        }

        if (opcion === 20) {
            var datosAEnviar = {
                'id_basico': 30
            };
        }

        if (opcion === 21) {
            var datosAEnviar = {
                'id_basico': 34
            };
        }

        if (opcion === 22) {
            var datosAEnviar = {
                'id_basico': 4
            };
        }

        if (opcion === 23) {
            var datosAEnviar = {
                'id_basico': 8
            };
        }

        if (opcion === 24) {
            var datosAEnviar = {
                'id_basico': 5
            };
        }

        var datos = {};

        $.ajax({
            url: "../controladores/CT_ip_dtbasicos.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if(obj[0]['id_basico'] == '13'){
                    console.log("VIENE "+JSON.stringify(respuesta));
                }
                
                datos = {
                    'nombreSelect': 'ip_dtbasicos',
                    'nombreFuncion': 'retornarIMItems(null, 1)'
                };

                if (opcion === 5) {
                    datos = {
                        'nombreSelect': 'estado_entidad',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 6) {
                    datos = {
                        'nombreSelect': 'sexo_persona',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 7) {
                    datos = {
                        'nombreSelect': 'estado_civil_persona',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 8) {
                    datos = {
                        'nombreSelect': 'tipo_sangre',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 9) {
                    datos = {
                        'nombreSelect': 'fuentes',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 10) {
                    datos = {
                        'nombreSelect': 'estadoRegiones',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 11) {
                    datos = {
                        'nombreSelect': 'estadoZonas',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 12) {
                    datos = {
                        'nombreSelect': 'estadoSubZonas',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 13 || opcion === 14) {
                    datos = {
                        'nombreSelect': 'estadoRequerimiento',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 15) {
                    datos = {
                        'nombreSelect': 'estadoCotizacion',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 16) {
                    datos = {
                        'nombreSelect': 'moneda',
                        'nombreFuncion': null
                    };
                }

                var datosDeLista = {
                    'valor': 'sec_basico',
                    'texto': 'dt_basico'
                };

                var predeterminado = 0;

                if (opcion === 14) {
                    datos["todos"] = 1;
                }

                if (opcion === 15) {
                    predeterminado = 110;
                    datos["todos"] = 1;
                }

                if (opcion === 17) {
                    datos = {
                        'nombreSelect': 'tipo_contrato',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 18) {
                    datos = {
                        'nombreSelect': 'cesantias',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 19) {
                    datos = {
                        'nombreSelect': 'pensiones',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 20) {
                    datos = {
                        'nombreSelect': 'eps',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 21) {
                    datos = {
                        'nombreSelect': 'estadoREQProveedores',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 22) {
                    datos = {
                        'nombreSelect': 'areaItem',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 23) {
                    datos = {
                        'nombreSelect': 'estadoItem',
                        'nombreFuncion': null
                    };
                    predeterminado = 30;
                }

                if (opcion === 24) {
                    datos = {
                        'nombreSelect': 'tipoPersona',
                        'nombreFuncion': null
                    };
                }

                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, predeterminado));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPDTBasicos(opcion) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}

function cambiarIPDtbasicos(opcion, id) {

    if (opcion === 1) {
        var posGuion = id.indexOf("-"), estado = 0;
        if ($("#" + id).prop("checked") === true) {
            estado = 1;
        }
        var datosAEnviar = {
            'sec_basico': id.substr(posGuion + 1, id.length),
            'estado': estado
        };

        $.ajax({
            url: "../controladores/CT_ip_dtbasicos.php",
            data: { 'caso': '2', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                //retornarMensaje(obj, 1);
                $("#mensajes").html('<div class="alert alert-success">Estado ajustado!</div>');
                var data = {
                    'nombreDiv': 'divIPDtbasicos'
                };
                retornarIPDTBasicos(data, 1);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function cambiarIPDtbasicos(opcion, id) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2) {

        if ($("#" + id).val().length > 0) {
            var posGuion = id.indexOf("-"), estado = 0;

            var datosAEnviar = {
                'sec_basico': id.substr(posGuion + 1, id.length),
                'dt_basico': $("#" + id).val()
            };

            $.ajax({
                url: "../controladores/CT_ip_dtbasicos.php",
                data: { 'caso': '5', 'datosAEnviar': datosAEnviar },
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    //retornarMensaje(obj, 1);
                    $("#mensajes").html('<div class="alert alert-success">Cambio de texto realizado!</div>');
                    var data = {
                        'nombreDiv': 'divIPDtbasicos'
                    };
                    retornarIPDTBasicos(data, 1);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function cambiarIPDtbasicos(opcion, id) { opcion 1...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        } else {
            $("#mensajes").html('<div class="alert alert-danger">En serio? Por favor ingrese un valor válido</div>');
            $("#" + id).focus();
        }


    }

}