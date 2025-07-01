$(document).ready(function () {

    //permisos    
    retornarARRoles(null, 1);

    $("#divNuevoDTBasico").hide();

    var data = {
        'nombreDiv': 'divListaBasicos'
    };
    retornarIPBasicos(1, data);

    $(document).on('mouseenter', '#ip_basicos', function (event) {
        $("#mensajes").html('');
    });
   
    /**
     * En el evento click del botón btnCrearDTBasico de la 
     * interfaz basicos_ipbasicos.php
     */
    $("#btnCrearDTBasico").click(function () {

        //si la longitud del input es mayor a cero entonces lo inserta en la tabla
        if ($("#dt_basico").val().length > 0) {
            $("#mensajes").html("");

            var datosAEnviar = {
                'id_basico': $("#ip_basicos").val(),
                'dt_basico': $("#dt_basico").val()
            };

            $.ajax({
                url: "../controladores/CT_ip_dtbasicos.php",
                data: {'caso': '3', 'datosAEnviar': datosAEnviar},
                type: "POST",
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (parseInt(obj) > 0) {
                        var data = {
                            'nombreDiv': 'divIPDtbasicos'
                        };
                        retornarIPDTBasicos(data, 1);
                        $("#dt_basico").val('');
                    } else {
                        alert("Error en function retornarIPDTBasicos(opcion) {...\nError desde el servidor. Por favor informe a soporte");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarIPDTBasicos(opcion) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });

        } else {
            $("#mensajes").html("<div class='callout callout-danger'>Por favor ingrese un valor válido para DT Básico</div>");
            $("#dt_basico").focus();
        }
    });


});
