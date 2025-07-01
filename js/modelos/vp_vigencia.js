function retornarVPVigencia(data, opcion) {

    var datos = [], datosDeLista = [];

    if (opcion === 1) {
        $.ajax({
            url: "../controladores/CT_vp_vigencia.php",
            data: {'caso': '1'},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);                
                if (opcion === 1) {

                    if(opcion===1){
                        datos = {
                            'nombreSelect': 'vp_vigencia',
                            'nombreFuncion': 'calcularFechaVencimiento(this.id,1)'
                        };
                    }
                    
                    datosDeLista = {
                        'valor': 'dias',
                        'texto': 'descrip'
                    };
                }
                
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarVPVigencia(opcion=1, data) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}
