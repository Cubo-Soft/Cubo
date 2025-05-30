function retornarVPAsesorZona(data, opcion) {

    var datosAEnviar = {};
    
    if (opcion === 1) {

        if ($("#ip_grupos").val() !== '-1' && $("#ip_lineas").val() !== '-1') {

            datosAEnviar.grupo = $("#ip_grupos").val();
            datosAEnviar.linea = $("#ip_lineas").val();
            datosAEnviar.id_sucursal = $("#id_sucursal").val();

            $.ajax({
                url: "../controladores/CT_vp_asesor_zona.php",
                data: { 'caso': '1','datosAEnviar':datosAEnviar},
                type: "POST",
                success: function (respuesta) {                             
                    var obj = JSON.parse(respuesta);                    
                        var datos = {
                            'nombreSelect': 'vp_asesor_zona',
                            'nombreFuncion': null
                        };
                        var datosDeLista = {
                            'valor': 'asesor',
                            'texto': 'nombre'
                        };                    

                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarVPAsesorZona(opcion=1, data) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        }else{
            $("#" + data["nombreDiv"]).html('');
        }
    }    

    if (opcion === 2) {

            datosAEnviar.linea = data.ip_lineas;

            $.ajax({
                url: "../controladores/CT_vp_asesor_zona.php",
                data: { 'caso': '2','datosAEnviar':datosAEnviar},
                type: "POST",
                success: function (respuesta) {        
                    var obj = JSON.parse(respuesta);
                        var datos = {
                            'nombreSelect': 'asesores',
                            'nombreFuncion': 'cambiarVRRequerim(null, 1);'
                        };
                        var datosDeLista = {
                            'valor': 'codusr',
                            'texto': 'nombre'
                        };
                    $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista, 0));
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error en function retornarVPAsesorZona(opcion=1, data) {...\nError desde el servidor. Por favor informe a soporte");
                }
            });
        
    }    

}
