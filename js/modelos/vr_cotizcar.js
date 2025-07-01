function cambiarVRCotizcar(datos, opcion) {

    var datosAEnviar = {};

    if (opcion === 1) {

        var division = datos.split("_");

        datosAEnviar.id_cotcar = division[1];
        datosAEnviar.vr_caract = $("#" + datos).val();

        $.ajax({
            url: "../controladores/CT_vr_cotizcar.php",
            data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj) {
                    id_consecot = $.urlParam('id_consecot');
                    retornarVRCotiza($.urlParam('id_consecot'), 1);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error en la solicitud AJAX:");
                console.log("Texto de error: " + textStatus);
                console.log("Error lanzado: " + errorThrown);
                console.log("Respuesta del servidor:");
                console.log(jqXHR.responseText);
                alert("Error en function cambiarVRCotizcar(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });



    }
}