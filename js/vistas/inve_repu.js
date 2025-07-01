$(function(){

    $("#cod_item").focus();
    $("#actualizarFoto").hide();
    $("#divSubirFoto").hide();
    $("#divListado").hide();

    retornarIPUnidades(null, 1);

    //retorna los campos que no se deben mostrar según el id_rol
    retornarAPCamposx(null, 1);

    var data={
        'opcionSeleccionada':null,
        'nombreDiv':'divGrupos'
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

    data = {
        'nombreDiv': 'divTipoPersona'
    };
    retornarIPDTBasicos(data, 24);

    retornarIPModelos(null, 1);

    var data={
        'opcionSeleccionada':null
    }
    retornarIPLineas(data, 1);

    retornarIPDimen(null, 1);

    $("#cod_item").on("blur", function () {        
        retornarIMItems2(null, 2);
    });

    $("#actualizarFoto").on('click',function(){
        $("#divSubirFoto").show();
        $("#divFoto").hide();
    });

    $("#actualizarImItem").on('click',function(){
        cambiarIMItems(null,1);
    });

    //capturar el evento onclick de la lista tipoPersona
    $(document).on('change', '#tipoPersona', function(event) {
        // Do something when the <select> element is clicked
        //console.log("Select element clicked!");
    });

    $("#listarImItem").on("click",function(){
        retornarIMItems2(null, 3);
    });

    $("#mostrarFormulario").on("click",function(){
        $("#divFormulario").show();
        $("#divListado").hide();
    });

    if ($.urlParam('cod_item') !== null) {
        $("#cod_item").val($.urlParam('cod_item'));
        retornarIMItems2(null, 2);
    }

    $("#limpiar").on('click',function(){
        window.location.href='inve_repu.php?cod_item=null';        
    });

    $('#img_rep').elevateZoom({
        cursor: "crosshair",  // Para que se muestre una cruz al apoyar el cursor sobre la imagen
        zoomWindowFadeIn: 500, // El tiempo que tarda en mostrar el zoom al apoyar el cursor sobre la imagen
        zoomWindowFadeOut: 750 // El tiempo que tarda en desaparecer el zoom al sacar el cursor sobre la imagen
      });
});