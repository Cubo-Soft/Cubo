$(document).ready(function () {

    //permisos    
    retornarARRoles(null, 1);

    $("#divSubZonas").hide();
    $("#divZonas").hide();

    var data = [];

    data = {
        'nombreDiv': 'divRegiones'
    };
    retornarAPRegiones(data, 1);

    data = {
        'nombreDiv': 'divEstadoRegiones'
    };
    retornarIPDTBasicos(data, 10);

    data = {
        'nombreDiv': 'divEstadoZonas'
    };
    retornarIPDTBasicos(data, 11);

    data = {
        'nombreDiv': 'divEstadoSubZonas'
    };
    retornarIPDTBasicos(data, 12);

    $("#crearRegion").click(function () {
        if ($("#nom_region").val().length === 0 || $("#cubrimiento").val().length === 0) {
            $("#mensajesRegiones").html("<div class='callout callout-danger'>Por favor revise el nombre de la región y/o el cubrimiento!</div>");
        } else {
            crearAPRegiones(null, 1);
        }
    });

    $("#modificarRegion").click(function () {
        if ($("#nom_region").val().length === 0 && $("#cubrimiento").val().length === 0) {
            $("#mensajesRegiones").html("<div class='callout callout-danger'>Por favor revise el nombre de la región y/o el cubrimiento!</div>");
        } else if ($("#nom_region").val().match(/^\s*$/) && $("#cubrimiento").val().match(/^\s*$/)) {
            $("#mensajesRegiones").html("<div class='callout callout-danger'>Por favor revise el nombre de la región y/o el cubrimiento! Solo va a ingresar espacios en blanco?</div>");
        } else {
            modificarAPRegiones(null, 1);
        }

        if ($("#estadoRegiones").val() !== '-1') {
            modificarAPRegiones(null, 2);
        }
    });

    $("#modificarZona").on("mouseenter", function () {
        $("#mensajesZonas").html("<div class='callout callout-info'>La 'Región' se ajustará a la 'Zona' " + $("#ip_regiones option:selected").html() + " esto podría perjudicar la lógica de las subzonas</div>");
    });

    $("#modificarZona").click(function () {
        if ($("#nom_zona").val().length === 0) {
            $("#mensajesZonas").html("<div class='callout callout-danger'>Por favor digite un nombre válido para modificar la zona</div>");
            $("#nom_zona").focus();
        } else if ($("#nom_zona").val().match(/^\s*$/)) {
            $("#mensajesZonas").html("<div class='callout callout-danger'>Solo espacios en blanco? Por favor digite un nombre válido para modificar la zona</div>");
            $("#nom_zona").focus();
        } else {
            modificarAPZonas(null, 1);
        }

        if ($("#estadoZonas").val() !== '-1') {
            modificarAPZonas(null, 2);
        }
    });
    
    $("#crearZona").click(function () {
        if ($("#nom_zona").val().length === 0) {
            $("#mensajesZonas").html("<div class='callout callout-danger'>Por favor digite un nombre válido para crear la zona</div>");
            $("#nom_zona").focus();
        } else if ($("#nom_zona").val().match(/^\s*$/)) {
            $("#mensajesZonas").html("<div class='callout callout-danger'>Solo espacios en blanco? Por favor digite un nombre válido para crear la zona</div>");
            $("#nom_zona").focus();
        } else {
            adicionarAPZonas(null, 1);
        }
    });

});

