var am_usuarios = 0, estadosRequerimiento = null;

$(document).ready(function () {

    //oculta los div con id requerimientos,cotizaciones,mantenimientos
    $("#requerimientos").hide();
    $("#cotizaciones").hide();
    $("#mantenimientos").hide();
    
    // Obtener el último día del mes actual
    var ultimoDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
    // Formatear la fecha al formato yyyy-mm-dd
    $("#dtRFinal").val(ultimoDiaMes.toISOString().slice(0, 10));
    //el inicio del año
    $("#dtRInicial").val(fechaActual.getFullYear() + '-01-01');

    $("#fecha_fin1").val(ultimoDiaMes.toISOString().slice(0, 10));
    //el inicio del año
    $("#fecha_ini1").val(fechaActual.getFullYear() + '-01-01');

    //inserta una lista desplegable en de los usuarios en el divUsuarios
    var data = {
        'nombreDiv': 'divUsuarios'
    };
    retornarAMUsuarios(data,2);
    
    //inserta una lista desplegable en de los usuarios en el divUsuarios2
    data = {
        'nombreDiv': 'divUsuarios2'
    };
    retornarAMUsuarios(data,3);    

    //inserta una lista desplegable en de los usuarios en el div estadosRequerimiento 
    data = {
        'nombreDiv': 'estadosRequerimiento'
    };
    retornarIPDTBasicos(data, 14);

    data = {
        'nombreDiv': 'estadosCotizacion'
    };
    retornarIPDTBasicos(data, 15);
    // Contar la cantidad de elementos <option> dentro del elemento <select> con ID "miSelect"       

    $("#btnBuscarRequerimiento").on('click',function () {
        retornarVRRequerim(null, 4);
    });

    $("#btnBuscarCotizacion").on('click',function () {
        retornarVRCotiza(null, 2);
    });

    //revisa el valor del parámetro id_alerta del metodo GET en la URL de la vista 
    switch ($.urlParam('id_alerta')) {
        case '1':
            retornarVRRequerim(null, 1);
            $("#requerimientos").show();
            $("#nombreReporte").html("Reporte requerimientos de clientes");
            break;
        case '2':
            retornarVRCotiza(null, 2);
            $("#cotizaciones").show();
            $("#nombreReporte").html("Reporte cotizaciones");
            break;
        case '3':
            $("#requerimientos").show();
            $("#nombreReporte").html("Reporte requerimientos internos");
            retornarVRRequerim(null, 4);
            break;
        case '4' :
            $("#mantenimientos").show();
            $("#nombreReporte").html("Reporte mantenimientos por revisar");
            retornarVRRequerim(null, 4);
            break;

    }

});