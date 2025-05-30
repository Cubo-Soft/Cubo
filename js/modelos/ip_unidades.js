function retornarIPUnidades(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_unidades.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_unidades',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'cod_unidad',
                    'texto': 'nom_unidad'
                };                               
                $("#divUnidadMedida1").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPUnidades(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}