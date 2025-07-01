function retornarIMBodeg(data, opcion) {

    if(opcion===1){
        
        $.ajax({
            url: "../controladores/CT_im_bodeg.php",
            data: { 'caso': '1' },
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                if (obj.length > 0) {

                    var datos = {
                        'nombreSelect': 'im_bodeg',
                        'nombreFuncion': 'retornarIRSalinve(null, 5);',
                        'todos':1
                    };

                    var datosDeLista = {
                        'valor': 'cod_bodega',
                        'texto': 'nom_bodega_ciudad'
                    };

                    $("#divBodegas").html(crearSelect(datos, obj, datosDeLista, 0));
                    $("#im_bodeg").val('-2');
                }

            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarIMBodeg(datos, opcion=1) {...\nError from server, please call support");
            }
        });



    }
}
