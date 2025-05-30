function retornarCMTrm(datos, opcion) {


    //esta parte de la función no se va a usar porque ya se logró dejar 
    //la parametrización de la politica de manejo de trm según 
    //lo establecido por Alfrio.
    // if (opcion === 1) {
    //     $.ajax({
    //         url: "../controladores/CT_cm_trm.php",
    //         data: {'caso': '1'},
    //         type: "POST",
    //         success: function (respuesta) {                
    //             var obj = JSON.parse(respuesta);
    //             $("#divValorTRM").html('TRM Establecida: <strong>'+obj[0]["trm"]+'</strong>');
    //         },
    //         error: function (jqXHR, textStatus, errorThrown) {
    //             alert("Error en function retornarCMTrm(datos,opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
    //         }
    //     });
    // }
    if (opcion === 2) {
        $.ajax({
            url: "../controladores/CT_cm_trm.php",
            data: {'caso': '2'},
            type: "POST",
            dataType:'json',
            success: function (respuesta) {                
                //var obj = JSON.parse(respuesta);
                var obj = JSON.stringify(respuesta);
                var tabla='<table class="table table-hover table-sm">';
                tabla +='<thead>';
                tabla +='<tr class="bg-primary"><th colspan="3"><center>Precio dolar últimos 8 días</center></th></tr>';
                tabla +='<tr><th></th><th>Fecha</th><th>Valor</th></tr>';
                tabla +='</thead>';
                tabla +='<tbody>';
                for (var i = 0; i < obj.length; i++) {
                    tabla +='<tr><td>'+(i+1)+'</td><td>'+obj[i]["fecha"]+'</td><td>'+obj[i]["trm"]+'</td></tr>';
                }

                tabla +='</tbody>';
                tabla +='</table>';
                $("#divPreciosDolar").html(tabla);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarCMTrm(datos,opcion=2) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}
