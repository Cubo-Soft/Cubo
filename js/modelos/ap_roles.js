function retornarAPRoles(opcion, data) {
    $.ajax({
        url: "../controladores/CT_ap_roles.php",
        data: {'caso': '1'},
        type: "POST",
        success: function (respuesta) {
            var obj = JSON.parse(respuesta);
            if (opcion === 1) {
                var datos = {
                    'nombreSelect': 'ap_roles',
                    'nombreFuncion': 'retornarAPOPCPermi(2, null);'
                };
                var datosDeLista = {
                    'valor': 'id_rol',
                    'texto': 'descrip_rol'
                };
                $("#" + data["nombreDiv"]).html(crearSelect(datos, obj, datosDeLista,0));
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error en function function retornarAPRoles(opcion, data) {...\nError desde el servidor. Por favor informe a soporte");
        }
    });
}
