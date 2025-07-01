var map=null;

$(document).ready(function () {
    
    $("#ubicacionGeograficaSucursales").hide();
    $("#datosSucursales").hide();
    $("#divContactos").hide();
    $("#listaSucursales").hide();
    
    retornarNPCiudades(null, 2);
    
    var data={
        'nombreDiv':'divActividades'
    };    
    retornarNPActiveco(data, 1);

    $("#numid").keypress(function () {
        retornarNMNits(null, 3);
    });

    $("#numid").focusin(function () {
        $(this).val('');
    });

    $("#numid").on('blur',function () {
        if ($("#numid").val().length <= 6 || $("#numid").val() === '0') {
            $("#mensajes").html('<div class="callout callout-danger">Por favor ingrese un valor válido para iniciar la búsqueda. Mientras va digitando en este campo, el sistema le va mostrando sugerencias!</div>');
            $("#numid").focus();
        } else {
            retornarNMNits(null, 4);
        }
    });

});
