$(document).ready(function () {

    retornarCMTrm(null, 2);

    $("#seccionTrabajo").hide();
    $("#divGraficas").show();

    
    if($.urlParam('mostrarValorTRM')==='1'){
        var ruta="alertas.php";                 
        insertarPagina(ruta, null);
    }

});
function grabarClaveNueva() {

    if ($("#paswd").val() === '' || $("#paswd").val().length > 10 || $("#paswd").val().length <= 4) {
        //Swal.fire('Advertencia','Por favor ingrese una clave válida. Mínimo cuatro carácteres!','danger');
        Swal.fire({
            icon: 'warning',
            title: 'Advertencia',
            text: 'Una clave válida debe tener mínimo cuatro carácteres y máximo diez!'
        });
        $("#pasw").focus();
    } else {

        var arregloEnvio = {
            'paswd': $("#paswd").val(),
            'codusr': $("#codusr").val()
        };

        $.ajax({
            url: "../controladores/CT_am_usuarios.php",
            data: {'caso': '2', 'arregloEnvio': arregloEnvio},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                if (obj === 1) {
                    $(location).prop("href", "../index.php")
                } else {
                    alert("Error en function grabarClaveNueva() {...\nError desde el servidor. Por favor informe a soporte");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function grabarClaveNueva() {...\nError desde el servidor. Por favor informe a soporte");
            }
        });

    }
}