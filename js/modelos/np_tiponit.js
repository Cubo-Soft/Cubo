function retornarNPTiponit(data, opcion) {

    var datos = [], datosDeLista = [];

    $.ajax({
        url: "../controladores/CT_np_tiponit.php",
        data: {'caso': '1'},
        type: "POST",
        success: function (respuesta) {            
            var obj = JSON.parse(respuesta);
            //opcion para permisosdeprogramas.php
            if (opcion === 1) {
                datos = {
                    'nombreSelect': 'np_tiponit',
                    'nombreFuncion': null
                };
                datosDeLista = {
                    'valor': 'idclase',
                    'texto': 'nomclase'
                };
            }

            $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error en function retornarNPTiponit(data, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
        }
    });

}