function retornarIPDimen(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_dimen.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_dimen',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_dimen',
                    'texto': 'nom_dimen'
                };
                $("#divDimensiones").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPMarcas(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}