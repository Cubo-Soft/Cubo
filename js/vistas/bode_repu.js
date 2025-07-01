$(document).ready(function () {
   
    retornarParametricas(2);

    /*
     * retornar permisos
     */
    //retornarARRoles(null, 1);

    retornarIMBodeg(null, 1);

    $("#cod_item").on("keypress", function () {
        retornarIRSalinve(null, 4);
    });

    $("#cod_item").on("focusin", function () {
        $("#divTablaBodegas").html('');
        $("#divTablaReservados").html('');
        $("#cod_item").val('');
    });

    $("#cod_item").blur(function () {        
            retornarIRSalinve(null, 5);        
    });

   
});
