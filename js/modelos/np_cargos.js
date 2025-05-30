function retornarNPCargos(data,opcion){
    if(opcion===1){        
        $.ajax({
            url: "../controladores/CT_np_cargos.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);

                var datos = {
                    'nombreSelect': 'np_cargos',
                    'nombreFuncion': null
                };
                var datosDeLista = {
                    'valor': 'id_cargo',
                    'texto': 'nom_cargo'
                };

                $("#"+data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error function retornarNPCargos(data,opcion=1) {...\nError from server, please call support");
            }
        });
    }
}