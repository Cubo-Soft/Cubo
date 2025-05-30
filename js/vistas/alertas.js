$(document).ready(function () {

    var data = [];

    $("#divReqComercial").hide();
    $("#divCotComercial").hide();
    $("#divReqCompras").hide();
    $("#divReqProveedor").hide();
    $("#divMantenimientos").hide();

    //superadministrador
    if($("#id_rol").val() === '1' || $("#id_rol").val() === '2' || $("#id_rol").val() === '3'){

        $("#divReqComercial").show();
        $("#divCotComercial").show();
        $("#divReqCompras").show();
        $("#divReqProveedor").show();
        $("#divMantenimientos").show();

        data["id_tipoalerta"] = 1;
        retornarAPAlertas(data, 1);

        data["id_tipoalerta"] = 2;
        retornarAPAlertas(data, 2);

        //data["id_tipoalerta"] = 3;
        //retornarAPAlertas(data, 2);


        retornarVRCotiza(null, 3);

        
    }

    //director comercial 
    //Ingeniero lider de refrigeraci
    if($("#id_rol").val() === '4' || $("#id_rol").val()==='5' ||  $("#id_rol").val()==='10'){
        $("#divReqComercial").show();
        $("#divCotComercial").show();        
        data["id_tipoalerta"] = 1;
        retornarAPAlertas(data, 1);
        data["id_tipoalerta"] = 2;
        retornarAPAlertas(data, 2);
        retornarVRCotiza(null, 3);
    }
    
    //director compras
    if ($("#id_rol").val() === '7') {
        $("#divReqCompras").show();
        data["id_tipoalerta"] = 2;
        retornarAPAlertas(data, 2);
        $("#divReqProveedor").show();    
    }

    //especialista técnico
    if($("#id_rol").val()==='9'){
        $("#divMantenimientos").show();
    }
 
});