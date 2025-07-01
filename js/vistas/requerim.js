$(document).ready(function () {

    retornarNPCiudades(11001, 3);

    var data = {
        'nombreDiv': 'divIPDtbasicos'
    };
    retornarIPDTBasicos(data, 2);

    /*
     * a medida que va digitando va consultando en la base de datos
     * las coincidencias y las va mostrando en un datalist
     */
    $("#nombre").on("keypress", function () {
        retornarVMClientesProv(null, 1);
    });

    /*
     * retornar el id_provis
     */
    $("#nombre").focusout(function () {
        if ($("#nit_cliente").val() === '0' || $("#nit_cliente").val().length === 0) {
            retornarVMClientesProv(null, 2);
        }
    });

    /*
     * verifica si al entrar en el foco la lista de fuentes había sido seleccionada
     */
    $("#nombre").focusin(function () {
        if ($("#nit_cliente").val() !== '0' || $("#nit_cliente").val().length < 0) {
            if ($("#ip_dtbasicos").val() === '-1') {
                $("#mensajes").html('<div class="callout callout-danger">Por favor seleccione la fuente del requerimiento</div>');
                $("#ip_dtbasicos").focus();
            } else {
                $("#mensajes").html('');
            }
        }
    });

    /*
     * verifica si al entrar en el foco la lista de fuentes había sido seleccionada
     */
    $("#nit_cliente").focusin(function () {
        if ($("#ip_dtbasicos").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-danger">Por favor seleccione la fuente del requerimiento</div>');
            $("#ip_dtbasicos").focus();
        } else {
            $("#mensajes").html('');
        }
    });

    /*
     * consulta si el nit existe en la tabla nm_nits
     */
    $("#nit_cliente").blur(function () {
        if (parseInt($("#nit_cliente").val()) !== 0 || $("#nit_cliente").val().length > 0) {
            retornarNMNits(null, 1);
        }

    });



});


//function showNameProduct(nameDiv, idName, type) {
//    $.ajax({
//        url: "../controllers/CT_product.php",
//        data: {'case': '1', 'name_product': $("#name_product").val(),'option':'1'},
//        type: "POST",
//        success: function (data) {
//            if (data.length > 0) {
//                var obj = JSON.parse(data);
//                if (obj.length > 0) {
//                    var names = ["id_product", "name_product"];
//                    if (type === 1) {
//                        $("#" + nameDiv).html(returnDataList(obj, names, idName));
//                    }
//                }
//            }
//        },
//        error: function (jqXHR, textStatus, errorThrown) {
//            alert("Error function showNameProduct(nameDiv, idName, type) {...\nError from server, please call support");
//        }
//    });
//}
//
//
//function returnIdProduct(value) {
//    var id = value.id;
//    if ($("#" + id).val() !== '') {
//        $.ajax({
//            url: "../controllers/CT_product.php",
//            data: {'case': '2', 'name_product': $("#" + id).val()},
//            type: "POST",
//            success: function (data) {
//                var obj = JSON.parse(data);
//                if (obj.length > 0) {
//                    $("#TrMessageProduct").hide();
//                    $("#id_product").val(obj[0]["id_product"]);
//                } else {
//                    $("#TrMessageProduct").show();
//                    $("#name_product").focus();
//                    $("#name_product").val('');
//                    $("#DivMessageProduct").html("<div class='alert alert-warning'>The entered product does not exist, please select a valid one </div>");
//                }
//            },
//            error: function (jqXHR, textStatus, errorThrown) {
//                alert("Error function returnIdProduct(value) {...\nError from server, please call support");
//            }
//        });
//    }
//
//
//}