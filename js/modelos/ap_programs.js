function retornarAPPrograms(opcion, data) {

    var datos = [], datosDeLista = [];

    $.ajax({
        url: "../controladores/CT_ap_programs.php",
        data: {'caso': '1'},
        type: "POST",
        success: function (respuesta) {
            var obj = JSON.parse(respuesta);
            //opcion para permisosdeprogramas.php
            if (opcion === 1) {
                datos = {
                    'nombreSelect': 'ap_programs',
                    'nombreFuncion': 'retornarAPPermpro(1)'
                };
                datosDeLista = {
                    'valor': 'codprog',
                    'texto': 'nomprog'
                };
            }
            
            //opcion para permisosaroles.php
            if (opcion === 2) {
                datos = {
                    'nombreSelect': 'ap_programs',
                    'nombreFuncion': 'retornarAPOPCPermi(2, this.id)'
                };
                datosDeLista = {
                    'valor': 'codprog',
                    'texto': 'nomprog'
                };
            }

            $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista,0));


        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error en function retornarAPPrograms(opcion) {...\nError desde el servidor. Por favor informe a soporte");
        }
    });
}