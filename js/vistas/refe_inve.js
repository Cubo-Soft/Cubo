$(function () {

    //permisos    
    console.log(retornarARRoles(null, 1));

    var perm = $("#permisos").val();

    $("#cod_item").focus();
    $("#divSubirFoto").hide();
    $("#divListado").hide();
    $("#divSucursalesGeneral").hide();
    $("#crear").hide();
    $("#listar").hide();
    $("#actualizar").hide();
    $("#actualizarFoto").hide();

    retornarIPUnidades(null, 1);

    //retorna los campos que no se deben mostrar según el id_rol
    retornarAPCamposx(null, 1);

    var data = {
        'opcionSeleccionada': null,
        'nombreDiv': 'divGrupos'
    }
    retornarIPGrupos(data, 3);

    retornarIPMarcas(null, 1);

    retornarIPArticulos(null, 1);

    var data = {
        'nombreDiv': 'divAreaItem'
    };
    retornarIPDTBasicos(data, 22);

    retornarIPTipos(null, 1);

    data = {
        'nombreDiv': 'divEstado'
    };
    retornarIPDTBasicos(data, 23);

    retornarIPModelos(null, 1);

    var data = {
        'opcionSeleccionada': null
    }
    retornarIPLineas(data, 1);

    retornarIPDimen(null, 1);

    $("#cod_item").on("blur", function () {
        retornarIMItems2(null, 2);
    });

    $("#alter_item").on("blur", function () {
        if($("#cod_item").val().length===0){
            retornarIMItems2(null, 5);
        }        
    });

    $("#actualizarFoto").on('click', function () {
        $("#divSubirFoto").show();
        $("#divFoto").hide();
    });

    $("#actualizar").on('click', function () {
        cambiarIMItems(null, 1);
    });

    $("#nombre_persona").on("keypress", function () {
        /*if ($("#tipoPersona").val() === '-1') {
            $("#mensajesUsuario").html('<div class="alert alert-warning">Para realizar la consulta por el nombre de la entidad, por favor seleccione si es una persona natural o jurídica.</div>');
            $("#tipoPersona").focus();
        } else if ($("#tipoPersona").val() === '23') {
            //persona natural
            $("#mensajesUsuario").html('');
            retornarNMPersonas(null, 5);
        } else {
            //persona juridica
            $("#mensajesUsuario").html('');
            retornarNMJuridicas(null, 10);
        }*/
        retornarNMNits(null,7);
    });

    $("#nombre_persona").on("blur", function () {
        /*if ($("#tipoPersona").val() === '-1') {
            $("#mensajesUsuario").html('<div class="alert alert-warning">Para realizar la consulta por el nombre de la entidad, por favor seleccione si es una persona natural o jurídica.</div>');
            $("#tipoPersona").focus();
        } else if ($("#tipoPersona").val() === '23') {
            //persona natural
            $("#mensajesUsuario").html('');
            retornarNMPersonas(null, 6);
        } else {
            //persona juridica
            $("#mensajesUsuario").html('');
            retornarNMJuridicas(null, 11);
        }*/

        retornarNMNits(null,8);

    });

    //elimina la función que viene con el select de manera que 
    //al cambiar no la ejecute 
    $(document).on('change', '#ip_lineas', function (event) {
        event.preventDefault();
    });

    $(document).on('change', '#tipoPersona', function (event) {
        $("#divSucursales").html('');
        $("#nombre_persona").val('');
    });

    $("#listar").on("click", function () {
        retornarIMItems2(null, 3);
    });

    $("#mostrarFormulario").on("click", function () {
        redirigir(null, 6);
    });

    if ($.urlParam('cod_item') !== null) {
        $("#cod_item").val($.urlParam('cod_item'));
        retornarIMItems2(null, 2);
    }

    $("#crear").on("click", function () {        
        if(validarCampos(8)===16){
            crearIMItems(null,1);
        }
    });
   
    /*    $('#img_rep').elevateZoom({
            cursor: "crosshair",  // Para que se muestre una cruz al apoyar el cursor sobre la imagen
            zoomWindowFadeIn: 500, // El tiempo que tarda en mostrar el zoom al apoyar el cursor sobre la imagen
            zoomWindowFadeOut: 750 // El tiempo que tarda en desaparecer el zoom al sacar el cursor sobre la imagen
          });*/
});