function crearNMPersonas(data, opcion) {
    if (opcion === 1) {

        var datosAEnviar = {
            'apellidos': $("#apellidos").val(),
            'nombres': $("#nombres").val(),
            'sexo': $("#sexo_persona").val(),
            'est_civil': $("#estado_civil_persona").val(),
            'fecha_naci': $("#fecha_naci").val(),
            'tipo_sangre': $("#tipo_sangre").val(),
            'numid': $("#numid").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === '0') {
                    $("#mensajesPersonas").html('<div class="callout callout-success">Persona creada de manera correcta</div>');
                    $("#adicionarPersona").hide();
                    $("#modificarPersona").show();
                    $("#nuevaBusqueda").show();
                    retornarNMSucursal(datosAEnviar, 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function crearNMPersonas(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}

function retornarNMPersonas(data, opcion) {
    if (opcion === 1 || opcion === 2) {

        if (opcion === 1) {
            var datosAEnviar = {
                'numid': $("#numid").val()
            };
        }

        if (opcion === 2) {
            var datosAEnviar = {
                'numid': data
            };
        }

        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '2', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj.length === 0) {
                    $("#modificarPersona").hide();
                    $("#adicionarPersona").show();
                    $("#mensajesPersonas").html('<div class="callout callout-info">Por favor ingrese los datos del cliente tipo persona. Con los apellidos y nombres sería suficiente mientras se obtienen otros datos.<br> Mejor si logra ubicar el sexo y la fecha de nacimiento! <br> Podría ALFRIO enviar un saludo de cumpleaños?</div>');
                    $("#divSucursalesGeneral").hide();
                } else {                    
                    $("#modificarPersona").show();
                    $("#adicionarPersona").hide();
                    $("#divSucursalesGeneral").show();                    
                    retornarNMSucursal(datosAEnviar, 1);
                    establecerDatosNMPersonas(obj, 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNMPersonas(data, opcion=1 || opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
    
    //retorna una lista de nombres de comerciales
    if (opcion === 3) {
        var datosAEnviar={
            'nombre_comercial':$("#nombre_comercial").val()
        };        
        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                    
                if (obj.length > 0) {
                        var nombres = ["numid", "apelli_nom"];
                        var nombreDataList = 'nombre_comercial_1';
                        $("#DivDataListComercial").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNMPersonas(data, opcion=3) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    //retorna el numid del comercial seleccionado en la lista del caso 3
    if (opcion === 4) {
        var datosAEnviar={
            'nombre_comercial':$("#nombre_comercial").val()
        };        
        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '4', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                    
                if (obj.length > 0) {
                    $("#numid_c").val(obj[0]["numid"]);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNMPersonas(data, opcion=4) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    //retorna una lista de personas para la vista de la administración de los items
    if (opcion === 5) {
        var datosAEnviar={
            'apelli_nom':$("#nombre_persona").val()
        };        
        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '6', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                    
                if (obj.length > 0) {
                    var nombres = ["numid", "apelli_nom"];
                    var nombreDataList = 'nombre_persona_1';
                    $("#DivDataListNombrePersona").html(retornarDataList(obj, nombres, nombreDataList));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarNMPersonas(data, opcion=5) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

        //retorna el numid y la lista de sedes 
        if (opcion === 6) {
            var datosAEnviar={
                'apelli_nom':$("#nombre_persona").val()
            };        
            $.ajax({
                url: "../controladores/CT_nm_personas.php",
                data: {'caso': '7', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);                    
                    if (obj["nm_personas"].length > 0) {
                        
                        $("#numid").val(obj["nm_personas"][0]["numid"]);
                        $("#divSucursales").show();
                        $("#divSucursales").html(crearTablaSucursales(obj["nm_sucursal"], 2));

                    }else{

                        $("#divSucursales").html('');
                        $("#divSucursales").hide();                        
                        $("#mensajesUsuario").html('<div class="alert alert-warning">No se encuentran datos con la información ingresada. Desea buscar por "Persona Juridica"? Podría no existir la entidad que está buscando o estar mal configurada</div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarNMPersonas(data, opcion=6) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }
}

function actualizarNMPersonas(data, opcion) {
    if (opcion === 1) {

        var numid = null;

        if ($("#numid").val() === '0') {
            numid = $("#cc_contacto").val();
        } else {
            numid = $("#numid").val();
        }

        var datosAEnviar = {
            'numid': numid,
            'apellidos': $("#apellidos").val(),
            'nombres': $("#nombres").val(),
            'sexo': $("#sexo_persona").val(),
            'est_civil': $("#estado_civil_persona").val(),
            'fecha_naci': $("#fecha_naci").val(),
            'tipo_sangre': $("#tipo_sangre").val()
        };

        $.ajax({
            url: "../controladores/CT_nm_personas.php",
            data: {'caso': '3', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    $("#modificarPersona").show();
                    $("#adicionarPersona").hide();
                    $("#mensajesPersonas").html('<div class="callout callout-success">Datos actualizados de manera correcta</div>');
                } else {
                    $("#mensajesPersonas").html('<div class="callout callout-warning">Oops! Esto es vergonzoso! Ha surgido un error. Podría por favor presionar la combinación de teclas "CTRL" + "R" y reiniciar la operación de actualización? Si la falla persiste por favor informe!</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function actualizarNMPersonas(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}

function establecerDatosNMPersonas(obj, opcion) {
    if (opcion === 1) {
        
        $("#nombres").val(obj[0]["nombres"]);
        $("#apellidos").val(obj[0]["apellidos"]);
        if (obj[0]["sexo"] !== 0) {
            $("#sexo_persona").val(obj[0]["sexo"]);
        }
        if (obj[0]["est_civil"] !== 0) {
            $("#estado_civil_persona").val(obj[0]["est_civil"]);
        }
        if (obj[0]["fecha_naci"] !== '0000-00-00') {
            $("#fecha_naci").val(obj[0]["fecha_naci"]);
        }
        if (obj[0]["tipo_sangre"] !== 0) {
            $("#tipo_sangre").val(obj[0]["tipo_sangre"]);
        }
    }
}