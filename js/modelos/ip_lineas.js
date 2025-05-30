function retornarIPLineas(datos, opcion) {

    var opcionSeleccionada = null;

    if (datos === null) {
        opcionSeleccionada=null;
    } else if (datos.opcionSeleccionada !== 'undefined') {
        opcionSeleccionada = datos.opcionSeleccionada;
    } else {
        opcionSeleccionada = null;
    }

    if (opcion === 1 || opcion === 2) {
        $.ajax({
            url: "../controladores/CT_ip_lineas.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (opcion === 2) {
                    var datos = {
                        'nombreSelect': 'ip_lineas',
                        'nombreFuncion': 'retornarIMItems(this.id, 16)'
                    };
                } else {
                    var datos = {
                        'nombreSelect': 'ip_lineas',
                        'nombreFuncion': 'retornarIMItems(this.id, 1)'
                    };
                }

                var datosDeLista = {
                    'valor': 'id_linea',
                    'texto': 'descrip'
                };

                $("#divLineas").html(crearSelectOutGroup(datos, obj, datosDeLista, opcionSeleccionada));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPLineas(datos, opcion) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}