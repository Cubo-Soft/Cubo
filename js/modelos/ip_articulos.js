function retornarIPArticulos(datos, opcion) {

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_ip_articulos.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {                
                var obj = JSON.parse(respuesta);                
                var datos = {
                    'nombreSelect': 'ip_articulos',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_articulo',
                    'texto': 'descrip'
                };             
                $("#divArticulos1").html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIPArticulos(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
    
}