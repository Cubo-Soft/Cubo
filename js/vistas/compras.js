$(function () {

    var data = {
        'nombreDiv': 'divEstadoRequerimiento'
    };
    retornarIPDTBasicos(data, 21);

    //    
    const anio = fechaActual.getFullYear();
    const mes = String(fechaActual.getMonth() + 1).padStart(2, '0');
    const dia = new Date(anio, mes, 0).getDate();
    $("#fechaFinal").val(anio + '-' + mes + '-' + dia);

    //establece el primer del mes en curso para la fecha inicial
    fechaActual.setDate(1);
    $("#fechaInicial").val(fechaActual.toISOString().split('T')[0]);

    $("#divRazonSocial").hide();
    $("#divComercial").hide();
    $("#divProducto").hide();
    $("#divCliente").hide();
    $("#divSOC_REQ").hide();

    $("#guardar").hide();
    $("#generarPDF").hide();
    $("#enviarSolicitud").hide();

    $("#criterioBusqueda1").on('change', function () {
        switch (parseInt($(this).val())) {
            case 0:
                $("#divRazonSocial").show();
                $("#razon_social").val('');
                $("#numid_r").val('0');
                $("#divComercial").hide();
                $("#divProducto").hide();
                $("#divSOC_REQ").hide();
                $("#divMsjCriterio").html("");
                $("#lblCriterio").text('Razon social');
                retornarIROperaciones(null, 1);
                break;
            case 1:
                $("#divRazonSocial").hide();
                $("#divComercial").show();
                $("#nombre_comercial").val('');
                $("#numid_c").val('0');
                $("#divProducto").hide();
                $("#divSOC_REQ").hide();
                $("#divMsjCriterio").html("");
                $("#lblCriterio").text('Persona');
                retornarIROperaciones(null, 2);
                break;
            case 2:
                $("#divRazonSocial").hide();
                $("#divComercial").hide();
                $("#divProducto").show();
                $("#divSOC_REQ").hide();
                $("#divMsjCriterio").html("");
                $("#lblCriterio").text('Código producto');
                retornarIROperaciones(null, 3);
                break;
            case 3:
                //para compras existe el SOC para Cubo el REQ. Son los mismos 
                $("#divRazonSocial").hide();
                $("#divComercial").hide();
                $("#divProducto").hide();
                $("#divSOC_REQ").show();                
                $("#divMsjCriterio").html("");
                $("#lblCriterio").text('SOC');
                retornarIROperaciones(null, 4);
                break;
            default:
                $("#divRazonSocial").hide();
                $("#divComercial").hide();
                $("#divProducto").hide();
                $("#divMsjCriterio").html("");
                $("#lblCriterio").text('...');
                $(this).trigger('focus');
                break;
        }
    });

    $("#razon_social").on("keypress", function () {
        retornarNMJuridicas(null, 7);
    });

    $("#razon_social").on("blur", function () {
        retornarNMJuridicas(null, 8);
    });

    $("#nombre_comercial").on("keypress", function () {
        retornarNMPersonas(null, 3);
    });

    $("#nombre_comercial").on("blur", function () {
        retornarNMPersonas(null, 4);
    });

    $("#consultar").on("click",function(){

        if($("#criterioBusqueda1").val()==='-1'){
            $("#divMensajes").html("<div class='alert alert-warning'>Por favor seleccione que opción para buscar</div>");
            $("#criterioBusqueda1").trigger("focus");
        }else if($("#estadoREQProveedores").val()==='-1'){
            $("#divMensajes").html("<div class='alert alert-warning'>No se registra selección del 'Estado del requerimiento' </div>");
            $("#criterioBusqueda1").trigger("focus");
        }else{
            retornarIROperaciones(null,5);
        }
    });


});