function retornarAPRegiones(data, opcion) {

    var datosAEnviar = [];

    if (opcion === 1 || opcion === 2) {

        datosAEnviar = null;

        $.ajax({
            url: "../controladores/CT_ap_regiones.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            dataType: 'json',
            type: "POST",
            beforeSend:function(){
                console.log('li 15 ap_regiones.js data:'+data);
            },
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (opcion === 1) {

                    var datos = {
                        'nombreSelect': 'ap_regiones',
                        'nombreFuncion': null
                    };
                }

                if (opcion === 2) {
                    var datos = {
                        'nombreSelect': 'ap_regiones2',
                        'nombreFuncion': null
                    };
                }

                var datosDeLista = {
                    'valor': 'id_region',
                    'texto': 'nom_region'
                };



                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarAPRegiones(data,opcion=1,2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}

