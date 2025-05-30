function retornarAMUsuarios(data,opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_am_usuarios.php",
            data: { 'caso': '3' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (opcion === 1) {
                    var datos = {
                        'nombreSelect': 'am_usuarios',
                        'nombreFuncion': null
                    };
                    var datosDeLista = {
                        'valor': 'codusr',
                        'texto': 'nombre'
                    };

                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAMUsuarios(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 2 || opcion === 3) {

        datosAEnviar = {
            'id_rol': $("#id_rol").val(),
            'codusr': $("#codusr").val()
        };

        $.ajax({
            url: "../controladores/CT_am_usuarios.php",
            data: { 'caso': '4', 'datosAEnviar': datosAEnviar },
            type: "POST",
            dataType: 'json',
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                var datos = {};

                if (opcion === 2) {
                    datos = {
                        'nombreSelect': 'am_usuarios',
                        'nombreFuncion': null,
                        'todos': 1
                    };
                }

                if (opcion === 3) {
                    datos = {
                        'nombreSelect': 'am_usuarios1',
                        'nombreFuncion': null,
                        'todos': 1
                    };
                }
                var datosDeLista = {
                    'valor': 'codusr',
                    'texto': 'nombre'
                };

                if (obj.length === 1) {
                    var codusr = $("#codusr").val();
                    am_usuarios = codusr;
                    datos.todos=0;
                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, codusr));
                } else {
                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAMUsuarios(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 4) {

        $.ajax({
            url: "../controladores/CT_am_usuarios.php",
            data: { 'caso': '5' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'asesores',
                    'nombreFuncion': 'cambiarVRRequerim(null, 1);'
                };
                var datosDeLista = {
                    'valor': 'codusr',
                    'texto': 'nombre'
                };
                
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, data["asesor"]));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAMUsuarios(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }

    if (opcion === 5) {

        datosAEnviar = {
            'numid': $("#numid").val()
        };

        $.ajax({
            url: "../controladores/CT_am_usuarios.php",
            data: { 'caso': '6','datosAEnviar':datosAEnviar },
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);                
                if(obj.length>0){           
                    
                    $("#adicionarUsuario").hide();
                    $("#modificarUsuario").show();                       
                    
                    $("#divFotoEmpleado").html('<div><img width="200" height="200" src="'+obj[0]["foto"]+'" /></div>');
                    $("#mensajesEmpleado").html('');
                }else{

                    $("#adicionarUsuario").show();
                    $("#modificarUsuario").hide();

                    $("#divFotoEmpleado").html('<div></div>');
                    $("#mensajesEmpleado").html('<div class="alert alert-danger">No se encuentran fotos de este usuario</div>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAMUsuarios(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}