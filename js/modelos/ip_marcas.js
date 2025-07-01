function retornarIPMarcas(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_marcas.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_marcas',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_marca',
                    'texto': 'nom_marca'
                };             
                $("#divMarcas1").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPMarcas(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
    
    if (opcion === 2) {
        $.ajax({
            url: "../controladores/CT_ip_marcas.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);
                var datos = {
                    'nombreSelect': 'ip_marcas',
                    'nombreFuncion': 'retornarIMItems(null, 4)'
                };

                var datosDeLista = {
                    'valor': 'id_marca',
                    'texto': 'nom_marca'
                };

                $("#divMarcas").html(crearSelectMultiple(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPMarcas(datos, opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}