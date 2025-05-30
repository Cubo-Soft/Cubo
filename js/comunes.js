const permisos = [];
var tablaPermisos = '', map = null;
var numid = null, cc_contacto = null, id_sucursal = null, id_contacto = null;
var valorDescuento = 0, dtoAplicar = 0, precioCotizar = 0, precioVenta = 0, vlrConDescuento = 0, valorBruto = 0, descuento = 0, subTotal = 0, valorIva = 0, valorTotal = 0, totalValorSinIva = 0, totalValorIva = 0, totalDescuentos = 0;
var cod_items = [];
var repuestosSinExistencia = [];
var suc_cliente = null;
var activarReqCompras = 0;
//cantidad de repuestos en requerimiento
var cantRepReq = 0;
var rojo = '#F97A73';
var amarillo = '#FFEE41';
var verde = '#66FF41';
var crearRequerimientoACompras = 1;
var fechaActual = new Date();
var tipos_mantenimiento = null;
var id_mantenimientos = '';

$(document).ready(function () {

    $("body").addClass('sidebar-collapse');

    $("#btnRevisarEquipos").click(function () {
        location.href = "../vistas/cot_equipos.php?id_consecot=" + $("#id_consecot").val();
    });

    $("#btnRevisarRepuestos").click(function () {
        location.href = "../vistas/cotiza.php?id_consecot=" + $("#id_consecot").val();
    });

    $("#iniciarCotizacion").click(function () {
        location.href = "../controladores/CT_grabar_cotizacion.php?id_requerim=" + $("#id_requerim").val();
    });

    $("#adicionarSucursal1").on('mouseenter', function () {
        if (validarCampos(1) !== 6) {
            $("#mensajesUbicacion").html('<div class="callout callout-warning">Realmente quiere "Adicionar" una sede nueva sin datos?</div>');
        }
    });

    $("#adicionarSucursal1").on('mouseout', function () {
        $("#mensajesUbicacion").html('<div class="callout callout-default">Preparado para adicionar una sede a ' + $("#nombre_empresa").val() + '. Son necesarios todos los datos de este formulario!</div>');
    });

    $("#adicionarSucursal1").click(function () {
        if (validarCampos(1) === 6) {
            crearNMSucursal(null, 1);
        }
    });

    $("#modificarSucursal").click(function () {
        if (validarCampos(1) === 6) {
            modificarNMSucursal(null, 1);
        }
    });

    $("#cancelarModificarSucursal").click(function () {
        $("#datosSucursales").hide();
        retornarNMNits(null, 4);
    });

    $("#cod_item").on("keypress", function () {
        retornarIMItems2(null, 1);
    });

    $("#alter_item").on("keypress", function () {
        retornarIMItems2(null, 4);
    });

    $("#cambiarFoto").on('click', function (e) {

        //detiene el envío del formulario por php
        e.preventDefault();

        const fotoInput = $("#foto");
        const file = fotoInput[0].files[0];

        // Verificar si se seleccionó un archivo
        if (!file) {
            $("#mensajesUsuario").html('<div class="alert alert-danger">Por favor selecciona una imagen</div>');
            return;
        }

        // Obtener la extensión del archivo
        const extension = file.name.split('.').pop().toLowerCase();

        // Obtener el tipo MIME del archivo
        const fileType = file.type;

        // Validar la extensión
        if (!['image/png', 'image/jpg', 'image/jpeg'].includes(fileType)) {
            $("#mensajesUsuario").html('<div class="alert alert-danger">Solo se admiten archivos JPG.</div>');
            return;
        }

        var formData = new FormData($("#formularioFoto")[0]);

        if ($("#codprog").val() === 'admon_clie') {
            formData.append('caso', 7);
            formData.append('numid', $("#numid").val());
            $.ajax({
                url: "../controladores/CT_am_usuarios.php",
                data: formData,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj === 1) {

                        $("#mensajesUsuario").html('<div class="alert alert-success">Imagen cambiada de manera exitosa</div>');
                        $("#divSubirFoto").hide();
                        $("#divFotoEmpleado2").show();
                        retornarAMUsuarios(null, 5);

                    } else {
                        $("#mensajesUsuario").html('<div class="alert alert-danger">Error al cambiar la imagen. Por favor intentelo nuevamente</div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error $('#cambiarFoto').on('click',function(e) { if $('#codprog').val()==='admon_clie'...\nError from server, please call support");
                }
            });
        }

        if ($("#codprog").val() === 'refe_inve') {
            formData.append('caso', 17);
            formData.append('cod_item', $("#cod_item").val());
            $.ajax({
                url: "../controladores/CT_im_items.php",
                data: formData,
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                success: function (respuesta) {
                    var obj = JSON.parse(respuesta);
                    if (obj === 1) {
                        $("#divFoto").html('');
                        retornarIMItems2(null, 2);
                        $("#mensajesUsuario").html('<div class="alert alert-success">Imagen cambiada de manera exitosa</div>');
                    } else {
                        $("#mensajesUsuario").html('<div class="alert alert-danger">Error al cambiar la imagen. Por favor intentelo nuevamente</div>');
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("Error $('#cambiarFoto').on('click',function(e) { if $('#codprog').val()==='inve_repu' ...\nError from server, please call support");
                }
            });
        }
    });

});
function starMap() {

    map = L.map('map').setView([4.6449260960446, -74.07018363475801], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;
        document.getElementById("suc_lat_gps").value = lat;
        document.getElementById("suc_lng_gps").value = lng;
    });
}



function codeAddress() {
    var direccion = document.getElementById("direccion").value;
    var ciudad = document.getElementById('np_ciudades').options[document.getElementById('np_ciudades').selectedIndex].text;
    var address = direccion + ',' + ciudad;
    if (address.search("BOGOTA") === -1) {
        address = direccion + ',' + 'BOGOTA';
    }
    myForwardGeocode(ciudad, 1);

}

function myForwardGeocode(addr, opcion) {

    if (opcion === 1) {
        $.ajax({
            type: "GET",
            //url: "https://api.opencagedata.com/geocode/v1/json?q=" + encodeURIComponent(addr) + "&key=a08ab980938843789855fc7e05f161d3&no_annotations=1&language=" + trans.Locale,
            url: "https://api.opencagedata.com/geocode/v1/json?q=" + encodeURIComponent(addr) + "&key=50beeb116cef4c2ab91323142ee7b4ad&no_annotations=1",
            //url: "https://api.openstreetmap.org/api/0.6/geocode?address=" + addr,
            dataType: "json",
            success: function (data) {
                if (data.status.code == 200) {
                    if (data.total_results >= 1) {
                        var latres = data.results[0].geometry.lat;
                        var lngres = data.results[0].geometry.lng;
                        map.setView([latres, lngres], 18);
                        document.getElementById('suc_lng_gps').value = '';
                        document.getElementById('suc_lat_gps').value = '';
                        L.map('map').setView([latres, lngres], 5);
                    } else {
                        alert(trans.GeolocationError)
                    }
                } else {
                    alert(trans.GeolocationError)
                }
            },
            error: function (xhr, err) {
                alert(trans.GeolocationError)
            }
        }).always(function () { });
        return false
    }
}

function insertarPagina(ruta, opcion) {
    $("#divGraficas").hide();
    $("#divSeccionTrabajo").html('');
    $("#iframeContenedor").remove();
    var iframe = null;
    // Crear el elemento iframe
    iframe = document.createElement('iframe');
    iframe.frameBorder = '0';
    iframe.src = ruta;
    iframe.id = "iframeContenedor";
    var width = parseFloat($(window).width()) - (($(window).width() * 5) / 100);
    //var height = parseFloat($(window).width()) - (($(window).width() * 50) / 100);
    var height = parseFloat($(window).width()) - (($(window).width() * 5) / 100);
    iframe.width = width + 'px';
    iframe.height = height + 'px';
    document.getElementById('divSeccionTrabajo').appendChild(iframe);
    $("#iframeContenedor").css('border','solid 1px');
}

/*
 * retorna una lista de tipo <select> con los datos incluidos en data
 * @param {type} datos = nombreSelect el nombre y/o id del select
 *                     = nombreFuncion el nombre de la función a ejecutar para el método onchange. Debe venir por ejemplo nombreFuncion(1) donde nombreFuncion es el "nombre de la función" y el parámetro el valor que recibe
 *@param {type} lista  = es el objeto a ser recorrido por el ciclo for interno
 *@param {type} datosDeLista = trae dos valores uno valor que es para el value y otro texto que es lo que se muestra al usuario         
 *@returns {String} = retorna el elemento <select> de html 
 */
function crearSelect(datos, lista, datosDeLista, opcionSeleccionada) {

    var retornar = "<select class='form form-control' ";
    if (datos["nombreSelect"] !== null) {
        retornar += " name='" + datos["nombreSelect"] + "' id='" + datos["nombreSelect"] + "'";
    }
    if (datos["nombreFuncion"] !== null) {
        retornar += " onchange='" + datos["nombreFuncion"] + "' ";
    }
    retornar += ">";
    retornar += "<option value='-1'>...</option>";

    if (datos["todos"] === 1) {
        retornar += "<option value='-2'>TODOS</option>";
    }

    for (var i = 0; i < lista.length; i++) {

        if (opcionSeleccionada === lista[i][datosDeLista["valor"]]) {
            retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "' selected>" + lista[i][datosDeLista["texto"]] + "</option>";
        } else {
            retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "'>" + lista[i][datosDeLista["texto"]] + "</option>";
        }

    }
    retornar += "</select>";
    return retornar;
}

function crearSelectOutGroup(datos, lista, datosDeLista, opcionSeleccionada) {

    var select = '<select id="' + datos["nombreSelect"] + '" name="' + datos["nombreSelect"] + '"  ';
    if (datos["nombreFuncion"] !== null) {
        select += "onchange='" + datos["nombreFuncion"] + "' ";
    }

    select += 'class="form form-control" >';
    select += '<option value="-1">...<option/>';
    for (var i = 0; i < lista.length; i++) {

        if (lista[i]["id_linea"].length === 2) {
            select += '<optgroup label="' + lista[i][datosDeLista["texto"]] + '">';
        } else {

            if (opcionSeleccionada === 'null' || opcionSeleccionada === null) {
                select += '<option value="' + lista[i][datosDeLista["valor"]] + '">' + lista[i][datosDeLista["texto"]] + '</option>';
            } else if (lista[i][datosDeLista["valor"]] === opcionSeleccionada) {
                select += '<option value="' + lista[i][datosDeLista["valor"]] + '" selected>' + lista[i][datosDeLista["texto"]] + '</option>';
            } else {
                select += '<option value="' + lista[i][datosDeLista["valor"]] + '" >' + lista[i][datosDeLista["texto"]] + '</option>';
            }


        }
    }

    // Convertir la cadena HTML en un elemento del DOM
    var tempDiv = document.createElement('div');
    tempDiv.innerHTML = select;
    var selectElement = tempDiv.firstChild;
    // Obtener todas las opciones del select
    var options = selectElement.getElementsByTagName('option');
    // Recorrer las opciones y eliminar aquellas que no tienen texto
    for (var i = 0; i < options.length; i++) {
        if (!options[i].textContent.trim()) {
            options[i].parentNode.removeChild(options[i]);
        }
    }

    // Obtener el HTML modificado
    var modifiedSelect = tempDiv.innerHTML;
    return modifiedSelect;
}

/*
 * retorna una lista de tipo <select> con los datos incluidos en data
 * @param {type} datos = nombreSelect el nombre y/o id del select
 *                     = nombreFuncion el nombre de la función a ejecutar para el método onchange. Debe venir por ejemplo nombreFuncion(1) donde nombreFuncion es el "nombre de la función" y el parámetro el valor que recibe
 *@param {type} lista  = es el objeto a ser recorrido por el ciclo for interno
 *@param {type} datosDeLista = trae dos valores uno valor que es para el value y otro texto que es lo que se muestra al usuario         
 *@returns {String} = retorna el elemento <select> de html 
 */
function crearSelectMultiple(datos, lista, datosDeLista, opcionSeleccionada) {

    var retornar = "<select class='form form-control lista-multiple' multiple ";
    if (datos["nombreSelect"] !== null) {
        retornar += " name='" + datos["nombreSelect"] + "' id='" + datos["nombreSelect"] + "'";
    }
    if (datos["nombreFuncion"] !== null) {
        retornar += " onchange='" + datos["nombreFuncion"] + "' ";
    }
    retornar += ">";
    retornar += "<option value='-1'>...</option>";
    for (var i = 0; i < lista.length; i++) {

        if (opcionSeleccionada === lista[i][datosDeLista["valor"]]) {
            //retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "' selected>" + (i + 1) + ". " + lista[i][datosDeLista["texto"]] + "</option>";
            retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "' selected>" + lista[i][datosDeLista["texto"]] + "</option>";
        } else {
            //retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "'>" + (i + 1) + ". " + lista[i][datosDeLista["texto"]] + "</option>";
            retornar += "<option value='" + lista[i][datosDeLista["valor"]] + "'>" + lista[i][datosDeLista["texto"]] + "</option>";
        }

    }
    retornar += "</select>";
    return retornar;
}


/**
 * 
 * @param {type} lista = el objeto a ser recorridos por el for interno
 * @param {type} datos = un arreglo indicando los valores a ser tenidos en cuenta al recorrer lista
 * @param {type} opcion = si es 1 entrega una tabla con el número de checkbox que se ingrese en el arreglo datos
 * @returns {String} = retornar en función de la opción
 */

function crearCheckbox(datos, lista, opcion) {

    var retornar = null;
    if (opcion === 1) {
        retornar = "<table class='table'>";
        for (var i = 0; i < lista.length; i++) {
            retornar += '<tr>';
            retornar += '<td>';
            retornar += '<input type="checkbox" name="' + lista[i][datos["valor"]] + '" id="' + lista[i][datos["valor"]] + '" ';
            if (datos["funcion"] !== null) {
                retornar += 'onclick="' + datos["funcion"] + '" />';
            } else {
                retonar += ' />';
            }

            retornar += ' ' + lista[i][datos["texto"]] + '</td>';
            retornar += '</tr>';
        }

        retornar += '</table>';
    }
    tablaPermisos = retornar;
    return retornar;
}

function retornarMensaje(obj, opcion) {

    if (opcion) {
        if (parseInt(obj[0]) === 1) {
            Swal.fire({
                title: 'Correcto',
                text: 'Registro actualizado',
                icon: 'success',
                position: 'top'
            });
        }
        if (obj[0] === 0) {
            Swal.fire({
                title: 'Correcto',
                text: 'Registro creado',
                icon: 'success',
                position: 'top'
            });
        }
    }
}

/**
 * 
 * @param {type} obj = el objeto obtenido por el AJAX * 
 * @param {type} names = es un arreglo donde la primer posicion es el id de la tabla y el segundo el nombre del campo
 * @param {type} idName nombreDataList = es el nombre del dataList para desocuparlo
 * @returns {String}
 */
function retornarDataList(obj, nombres, nombreDataList) {
    $("#" + nombreDataList).empty();
    var datalist = "<datalist id='" + nombreDataList + "'>";
    for (var i = 0, max = obj.length; i < max; i++) {
        datalist += "<option value='" + obj[i][nombres[1]] + "'>";
    }
    datalist += "</datalist>";
    return datalist;
}

/**
 * 
 * @param {*} numero cualquier número con formato decimal como punto 
 * @returns si decimal < 5 se queda en ese de lo contrario sube al siguiente 
 */
function redondear(numero) {
    if (Number.isFinite(parseFloat(numero))) {
        const decimales = numero.toString().split(".");
        const tieneDecimales = decimales.length > 1;
        const cifraDecimal = tieneDecimales ? decimales[1][0] : undefined;
        return tieneDecimales ? (cifraDecimal < 5 ? numero : numero + 1) : numero;
    } else {
        return 0;
    }
}

function establecerValores(obj, opcion) {
    if (opcion === 1) {
        $("#numid").val(obj[0]["numid"]);
        $("#direccion").val(obj[0]["direccion"]);
        $("#razon_social").val(obj[0]["razon_social"]);
        $("#telefono").val(obj[0]["telefono"]);
        $("#np_ciudades").val(obj[0]["ciudad"]);
        $("#np_paises").val(obj[0]["pais"]);
        $("#ap_subzonas").val(obj[0]["id_sub_zona"]);
        $("#numid").prop('disabled', true);
        $("#razon_social").prop('disabled', true);
        //$("#direccion").prop('disabled', true);
    }

    if (opcion === 2) {
        $("#direccion").val('');
        $("#razon_social").val('');
        $("#telefono").val('');
        $("#np_ciudades").val('11001');
        $("#np_paises").val('7');
        $("#mensajes").html('<div class="callout callout-success">Por favor recuerde solicitar la <strong>razón social</strong> completa y el número de <strong>teléfono</strong>. La ciudad y el país son importantes tambíen</div>');
    }

    if (opcion === 3) {
        $("#direccion").val('');
        $("#telefono").val('');
        $("#np_ciudades").val('11001');
        $("#np_paises").val('7');
        $("#mensajes").html('<div class="callout callout-success">Por favor recuerde solicitar la <strong>razón social</strong> completa y el número de <strong>teléfono</strong>. La ciudad y el país son importantes tambíen</div>');
    }

    if (opcion === 4) {

        var permisos = $("#permisos").val().split("|");

        if (permisos.indexOf("M") !== -1) {
            $("#actualizar").show();
        }

        $("#crear").hide();
        $("#actualizarFoto").show();
        $("#cod_item").prop("disabled", true);
        $("#cod_item").val(obj["im_items"][0]["cod_item"]);
        $("#alter_item").val(obj["im_items"][0]["alter_item"]);
        $("#nom_item").val(obj["im_items"][0]["nom_item"]);
        $("#ip_unidades").val(obj["im_items"][0]["unidad"]);
        $("#ip_grupos").val(obj["im_items"][0]["grup_item"]);
        $("#ip_marcas").val(obj["im_items"][0]["id_marca"]);
        $("#unid_desgaste").val(obj["im_items"][0]["unid_desgaste"]);
        $("#cant_desgaste").val(obj["im_items"][0]["cant_desgaste"]);
        $("#facturable").val(obj["im_items"][0]["facturable"]);
        $("#areaItem").val(obj["im_items"][0]["area_item"]);
        $("#ip_articulos").val(obj["im_items"][0]["articulo"]);
        $("#ip_tipos").val(obj["im_items"][0]["tipo_item"]);
        $("#num_parte").val(obj["im_items"][0]["num_parte"]);
        $("#estadoItem").val(obj["im_items"][0]["estado_item"]);
        $("#iva").val(obj["im_items"][0]["iva"]);
        $("#precio_vta").val(obj["im_items"][0]["precio_vta"]);
        $("#ip_modelos").val(obj["im_items"][0]["modelo"]);
        $("#ip_lineas").val(obj["im_items"][0]["linea"]);
        $("#peso").val(obj["im_items"][0]["peso"]);
        $("#volumen").val(obj["im_items"][0]["volumen"]);
        $("#ip_dimen").val(obj["im_items"][0]["dimensiones"]);
        $("#precio_vta_usd").val(obj["im_items"][0]["precio_vta_usd"]);
        $("#minimo").val(obj["im_items"][0]["minimo"]);
        $("#maximo").val(obj["im_items"][0]["maximo"]);
        $("#id_proveedor").val(obj["im_items"][0]["id_proveedor"]);

        if (permisos.indexOf("MOF") !== -1) {
            if (obj["im_items"][0]["foto"] === '../img_inve/sin_imagen.jpg') {
                $("#divSubirFoto").show();
                $("#divFoto").hide();
                $("#actualizarFoto").hide();
            } else {
                $("#divFoto").show();
                $("#actualizarFoto").show();
                $("#divFoto").html("<img src='" + obj["im_items"][0]["foto"] + "' data-zoom-image='" + obj["im_items"][0]["foto"] + "' id='img_rep'  alt='Imagen repuesto' height='280px' width='360px' />");
                $("#divSubirFoto").hide();
            }
        } else {

            $("#actualizarFoto").hide();
            $("#divSubirFoto").hide();
        }

        $("#numid").val(obj["nm_nits"][0]["numid"]);
        $("#tipoPersona").val(obj["nm_nits"][0]["tipo_per"]);

        if (obj["nm_juridicas"].length > 0) {
            $("#nombre_persona").val(obj["nm_juridicas"][0]["razon_social"]);
        }

        if (obj["nm_personas"].length > 0) {
            var nombres = null;
            if (obj["nm_personas"][0]["apelli_nom"] === '') {
                nombres = obj["nm_personas"][0]["apellidos"] + ' ' + obj["nm_personas"][0]["nombres"];
            } else {
                nombres = obj["nm_personas"][0]["apelli_nom"];
            }
            $("#nombre_persona").val(nombres);
        }

    }

}

function ocultarBotones(opcion) {
    if (opcion === 1) {
        $("#actualizarNMContactos").hide();
        $("#crearVMClientesProv").hide();
        $("#nuevaBusqueda").hide();
    }
}

function consultarDV(numero, opcion) {

    var datosAEnviar = {
        'numero': numero,
        'np_tiponit': $("#np_tiponit").val(),
        'ip_dtbasicos': $("#ip_dtbasicos").val()
    };
    $.ajax({
        url: "../adicionales/comunes.php",
        data: { 'caso': '1', 'datosAEnviar': datosAEnviar },
        type: "POST",
        success: function (respuesta) {
            var obj = JSON.parse(respuesta);
            if (opcion === 1) {

                if ($("#ip_dtbasicos").val() === '-1') {
                    $("#mensajes").html('<div class="callout callout-warning">Por favor, si va a crear una nueva entidad seleccione un valor de la lista "Tipo de identificación". Esto ayuda al sistema a calcular el "Digito de verificación" de ser necesario</div>');
                    $("#ip_dtbasicos").focus();
                } else {
                    if (parseFloat(obj) > 0) {
                        $("#dv").val(obj);
                    }
                    $("#mensajes").html('<div class="callout callout-info">Se inicia proceso de adición de un ' + $("#ip_dtbasicos option:selected").text() + '!<br> Una vez presione el botón "Adicionar" el sistema mostrará un formulario para captura del nombre de la entidad para luego mostrar <br>  botones de acción para activar las secciones de ingreso de sedes y contactos ...</div>');
                }
            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error function consultarDV(numero) {...\nError from server, please call support");
        }
    });
}

function validarCampos(opcion) {

    var retorno = 0;
    if (opcion === 1) {
        if ($("#nom_sucur").val().length === 0) {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Por favor ingrese un nombre válido para la sede'));
            $("#nom_sucur").focus();
        } else {
            retorno += 1;
        }

        if ($("#np_ciudades").val() === '-1') {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Seleccione una "Ciudad-País" válida'));
            $("#np_ciudades").focus();
        } else {
            retorno += 1;
        }

        if ($("#direccion").val().length === 0) {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Podría revisar la dirección?'));
            $("#direccion").focus();
        } else {
            retorno += 1;
        }

        if ($("#telefono").val().length === 0 && $("#telefono").val().length <= 4) {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Es el número de teléfono de la sede?'));
            $("#telefono").focus();
        } else {
            retorno += 1;
        }

        if ($("#codigo_helisa").val().length === 0) {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Por favor ingrese el "Código Helisa", si no hay un "Código Helisa" válido por favor digite cero'));
            $("#codigo_helisa").focus();
        } else {
            retorno += 1;
        }

        if ($("#suc_lat_gps").val().length === 0 || $("#suc_lng_gps").val().length === 0) {
            $("#mensajesUbicacion").html(retornarAlertaWarning('Es necesario que por favor ubique la dirección en el mapa lo más aproximado posible a la realidad'));
            $("#suc_lat_gps").focus();
        } else {
            retorno += 1;
        }

    }

    if (opcion === 2) {
        if ($("#cc_contacto").val().length === 0) {
            $("#mensajesContacto").html(retornarAlertaWarning('Si no conocer el número de identificación del contacto, por favor digite un cero'));
            $("#cc_contacto").focus();
        } else {
            retorno += 1;
        }

        if ($("#nom_contacto").val().length <= 4 || $("#nom_contacto").val().length === 0) {
            $("#mensajesContacto").html(retornarAlertaWarning('Debe revisar el nombre del contacto, por favor'));
            $("#nom_contacto").focus();
        } else {
            retorno += 1;
        }

        if ($("#cargo").val().length <= 0 || $("#cargo").val().length >= 21) {
            $("#mensajesContacto").html(retornarAlertaWarning('El cargo del contacto. Por favor ingrese un texto inferior a 20 carácteres. Podría usar abreviaturas!'));
            $("#cargo").focus();
        } else {
            retorno += 1;
        }

        if ($("#tel_contacto").val().length === 0 && $("#tel_contacto").val().length <= 4) {
            $("#mensajesContacto").html(retornarAlertaWarning('Es el número de teléfono del contacto?'));
            $("#tel_contacto").focus();
        } else {
            retorno += 1;
        }

        if ($("#email").val().length === 0 && $("#email").val().length <= 4) {
            $("#mensajesContacto").html(retornarAlertaWarning('El correo es necesario, por favor!'));
            $("#email").focus();
        } else {
            retorno += 1;
        }
    }

    if (opcion === 3) {
        if ($("#np_tiponit").val() === '-1') {
            $("#mensajes").html(retornarAlertaWarning('No se registra el "Tipo NIT" seleccionado!'));
            $("#np_tiponit").focus();
        } else {
            retorno += 1;
        }

        if ($("#numid").val().length <= 4) {
            $("#mensajes").html(retornarAlertaWarning('El "Nro. de identificación" es igual o inferior a cuatro digitos'));
            $("#numid").focus();
        } else {
            retorno += 1;
        }

        if ($("#np_activeco").val() === '-1') {
            $("#mensajes").html(retornarAlertaWarning('Por favor seleccione una "Actividad" de la lista'));
            $("#np_activeco").focus();
        } else {
            retorno += 1;
        }
    }

    if (opcion === 4) {
        if ($("#nombres").val().length === 0) {
            $("#mensajesPersonas").html(retornarAlertaWarning('Por favor ingrese un nombre válido'));
            $("#nombres").focus();
        } else {
            retorno += 1;
        }

        if ($("#apellidos").val().length <= 4) {
            $("#mensajesPersonas").html(retornarAlertaWarning('Podría revisar los apellidos? No se detectan valores válidos'));
            $("#apellidos").focus();
        } else {
            retorno += 1;
        }
    }

    if (opcion === 5) {
        if ($("#credito").val().length === 0 && $("#factu_despacho").val().length === 0 && $("#docs_pra_facturar").val().length === 0 && $("#cierre_factu").val().length === 0 && $("#area_contacto").val().length === 0) {
            $("#mensajesComplementosNIT").html(retornarAlertaWarning('Por favor ingrese al menos un valor válido para crear un complemento'));
        } else {
            retorno = 1;
        }
    }

    if (opcion === 6) {
        if ($("#nombre_cp").val().length <= 4) {
            $("#mensajesClientesProvisionales").html(retornarAlertaWarning('Es necesario el nombre del cliente provisional'));
            $("#nombre_cp").focus();
        } else {
            retorno += 1;
        }

        if ($("#email_cp").val().length <= 4) {
            $("#mensajesClientesProvisionales").html(retornarAlertaWarning('Si nos ayuda con el correo, sería fantastico!'));
            $("#email_cp").focus();
        } else {
            retorno += 1;
        }

        if ($("#telefono_cp").val().length <= 4) {
            $("#mensajesClientesProvisionales").html(retornarAlertaWarning('El número de teléfono de contacto se hace absolutamente necesario!'));
            $("#telefono_cp").focus();
        } else {
            retorno += 1;
        }
    }

    if (opcion === 7) {

        if ($("#nit_cliente_cp").val().length === 0 || $("#nit_cliente_cp").val() === '0' || $("#nit_cliente_cp").val() === '') {
            $("#nit_cliente_cp").focus();
            $("#mensajesClientesProvisionales").html('<div class="callout callout-warning">Por favor digite el NIT del cliente</div>');
        } else {
            retorno += 1;
        }

        if ($("#nombre_cp").val().length === 0) {
            $("#nombre_cp").focus();
            $("#mensajesClientesProvisionales").html('<div class="callout callout-danger">Por favor digite el nombre del cliente</div>');
        } else {
            retorno += 1;
        }

        if ($("#email_cp").val().length === 0) {
            $("#email_cp").focus();
            $("#mensajesClientesProvisionales").html('<div class="callout callout-warning">Por favor digite el email del cliente</div>');
        } else {
            retorno += 1;
        }

        if ($("#ap_regiones2").val() === '-1') {
            $("#ap_regiones2").focus();
            $("#mensajesClientesProvisionales").html('<div class="callout callout-danger">Por favor seleccione la región</div>');
        } else {
            retorno += 1;
        }
    }

    if (opcion === 8) {

        if ($("#cod_item").val().length === 0) {
            $("#cod_item").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor ingrese una referencia interna válida</div>');
        } else {
            retorno += 1;
        }

        if ($("#alter_item").val().length === 0) {
            $("#alter_item").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Es necesaria una referencia alterna</div>');
        } else {
            retorno += 1;
        }

        if ($("#nom_item").val().length === 0) {
            $("#nom_item").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor el nombre del elemento</div>');
        } else {
            retorno += 1;
        }

        if ($("#ip_unidades").val() === '-1') {
            $("#ip_unidades").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">En que unidades?</div>');
        } else {
            retorno += 1;
        }

        if ($("#id_proveedor").val() === '0') {
            $("#id_proveedor").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">No se encuentra un proveedor válido. Por favor realice la búsqueda del proveedor. Inicialmente seleccione el tipo de proveedor si es persona natural o persona jurídica para luego escribir el nombre y seleccionar la sede. Gracias!</div>');
        } else {
            retorno += 1;
        }

        if ($("#ip_marcas").val() === '-1') {
            $("#ip_marcas").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor seleccione la marca</div>');
        } else {
            retorno += 1;
        }

        if ($("#unid_desgaste").val().length === 0) {
            $("#unid_desgaste").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Una unidad de desgaste por favor</div>');
        } else {
            retorno += 1;
        }

        if ($("#cant_desgaste").val().length === 0) {
            $("#cant_desgaste").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">La cantidad de desgaste por favor</div>');
        } else {
            retorno += 1;
        }

        if ($("#areaItem").val() === '-1') {
            $("#areaItem").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">El área donde pertenece el elemento, por favor</div>');
        } else {
            retorno += 1;
        }

        if ($("#ip_articulos").val() === '-1') {
            $("#ip_articulos").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">El artículo podría por favor seleccionarlo?</div>');
        } else {
            retorno += 1;
        }

        if ($("#ip_tipos").val() === '-1') {
            $("#ip_tipos").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">El tipo podría por favor seleccionarlo?</div>');
        } else {
            retorno += 1;
        }

        if ($("#iva").val().length === 0) {
            $("#iva").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor ingrese un valor de IVA válido para este elemento</div>');
        } else {
            retorno += 1;
        }

        if ($("#precio_vta").val().length === 0) {
            $("#precio_vta").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">El precio de venta, por favor</div>');
        } else {
            retorno += 1;
        }

        if ($("#precio_vta_usd").val().length === 0) {
            $("#precio_vta_usd").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">El precio de venta en Dolares es importante!</div>');
        } else {
            retorno += 1;
        }

        if ($("#maximo").val() === '0') {
            $("#maximo").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor ingrese un valor máximo</div>');
        } else {
            retorno += 1;
        }

        if ($("#minimo").val() === '0') {
            $("#minimo").focus();
            $("#mensajesUsuario").html('<div class="callout callout-danger">Por favor ingrese un valor minimo</div>');
        } else {
            retorno += 1;
        }

    }

    return retorno;
}

function retornarAlertaWarning(mensaje) {
    return '<div class="callout callout-danger">' + mensaje + '</div>';
}

function mostrarFormularioSucursal(opcion) {
    if (opcion === 1) {
        $("#listaSucursales").hide();
        $("#divContactos").hide();
        $("#editarCrearContacto").hide();
        $("#modificarSucursal").hide();
        $("#datosSucursales").show();
        $("#adicionarSucursal1").show();
        $("#mensajesUbicacion").html('<div class="callout callout-warning">Vamos a adicionar una sede. Al ubicar el punto en el mapa, las coordenadas se mostrarán en "Latitud" y "Longitud"!</div>');
        $("#direccion").val('');
        $("#np_ciudades").val(11001);
        $("#telefono").val('');
        $("#ap_subzonas").val('-1');
        if ($("#tablaSucursales").length > 0) {
            $("#nom_sucur").val('');
        } else {
            $("#nom_sucur").val('SEDE PRINCIPAL');
        }

        $("#suc_lat_gps").val('');
        $("#suc_lng_gps").val('');
        $("#id_sucursal").val('');
        $("#codigo_helisa").val('');
        $("#estadoSede").prop('checked', true);
        map.setView([4.6449260960446, -74.07018363475801], 6);
    }
}

function mostrarFormulario(opcion) {
    if (opcion === 1) {
        $("#listarContactos").show();
        $("#cc_contacto").val('');
        $("#cc_contacto").prop('disabled', false);
        $("#nom_contacto").val('');
        $("#cargo").val('');
        $("#tel_contacto").val('');
        $("#email").val('');
        $("#estadoContacto").prop('checked', false);
        $("#editarCrearContacto").show();
        $("#divContactos").hide();
        $("#adicionarContacto").show();
    }
}

function divOcultos(opcion) {

    if (opcion === 1) {
        $("#datosSucursales").hide();
        $("#divContactos").hide();
        $("#modificarContacto").hide();
        $("#adicionarContacto").hide();
        $("#listarContactos").hide();
        $("#editarCrearContacto").hide();
        $("#divContactosGeneral").hide();
        $("#listaSucursales").hide();
        $("#crearClientes").hide();
        $("#modificarClientes").hide();
        $("#nuevaBusqueda").hide();
        $("#divSucursalesGeneral").hide();
        $("#divPersonasGeneral").hide();
        $("#divJuridicas").hide();
        $("#divComplementosNIT").hide();
    }

    if (opcion === 2) {
        $("#divContactosGeneral").hide();
        $("#datosSucursales").hide();
        $("#listaSucursales").hide();
        $("#crearClientes").hide();
        $("#modificarClientes").hide();
        $("#nuevaBusqueda").hide();
        $("#divSucursalesGeneral").hide();
        $("#divPersonasGeneral").hide();
        $("#divJuridicas").hide();
        $("#divComplementosNIT").hide();
        $("#modificarContacto").hide();
        $("#adicionarContacto").hide();
        $("#listarContactos").hide();
    }

}

function pintarRetornarNMContactos() {
    var data = 'nmc_' + $("#id_sucursal").val();
    $("#editarCrearContacto").hide();
    $("#listarContactos").hide();
    $("#adicionarContacto").hide();
    $("#modificarContacto").hide();
    retornarNMContactos(data, 5);
}

function retornarParametricas(opcion) {
    if (opcion === 1) {
        retornarIPTipos(null, 1);
        retornarIPMarcas(null, 1);
        retornarIPUnidades(null, 1);
        retornarIPDimen(null, 1);
        retornarIPPresiones(null, 1);
        retornarIPModelos(null, 1);
        retornarIPVoltajes(null, 1);
    }

    if (opcion === 2) {
        retornarIPTipos(null, 1);
        retornarIPMarcas(null, 1);
    }
}

function armarTablaProductosBorradores(data, data2, opcion) {

    var saldoVenta = 0;
    var saldoReserva = 0;
    var saldoBDPrincipal = 0;

    $("#divRepuestosRepetidos").html("");
    $("#divFoto").html("");

    var tabla = "<table class='table table-hover table-sm' id='" + data2["id_tabla"] + "'>";
    if (opcion === 1) {

        tabla += '<thead>';
        tabla += '<tr class="bg-info">';
        tabla += '<th colspan="13" ><center>Repuestos candidatos</center></th>';
        tabla += '</tr>';
        tabla += '<tr class="bg-info" >';
        tabla += '<th>No.</th>';
        tabla += '<th>Articulo</th>';
        tabla += '<th>Tipo</th>';
        tabla += '<th>Marca</th>';
        tabla += '<th>Modelo</th>';
        tabla += '<th>Dimensiones</th>';
        tabla += '<th>Unidad de medida</th>';
        tabla += '<th>Código del producto</th>';

        tabla += '<th>Reservados</th>';

        //permiso para ver el saldo
        if (permisos.indexOf("S") !== -1) {
            tabla += '<th>Saldo</th>';
        }

        //permiso de precio de venta
        if (permisos.indexOf("P") !== -1) {
            tabla += '<th>Precio venta</th>';
        }

        tabla += '<th>RQ</th>';
        tabla += '<th></th>';
        tabla += '</tr>';
        tabla += '</thead>';
        tabla += '<tbody>';
        for (var i = 0; i < data["datosRepuesto"].length; i++) {

            tabla += '<tr class="bg-info" >';
            tabla += '<td>' + (i + 1) + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["nom_grupo"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["descrip"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["nom_marca"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["descrip_modelo"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["nom_dimen"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["nom_unidad"] + '</td>';
            tabla += '<td>' + data["datosRepuesto"][i]["cod_item"] + '</td>';


            if (data["ir_resinve"].length > 0) {

                tabla += '<td>';

                for (var j = 0; j < data["ir_resinve"].length; j++) {
                    tabla += data["ir_resinve"][j]["saldo_nombre"] + '<br>';
                    saldoReserva += parseInt(data["ir_resinve"][j]["saldo"]);
                }

                tabla += '</td>';

            } else {
                tabla += '<td></td>';
            }

            saldoBDPrincipal = parseInt(data["datosRepuesto"][i]["saldo"]);

            //buscar en salinve el item que saldo tiene y restarle el valor de la tabla resinve para saber el valor real que puede vender 
            saldoVenta = saldoBDPrincipal - saldoReserva;

            //permiso de saldo
            if (permisos.indexOf("S") !== -1) {
                if (saldoVenta <= 0) {
                    tabla += '<td></td>';
                } else {
                    tabla += '<td>' + saldoVenta + '</td>';
                }
            }

            //permiso de precio de venta
            if (permisos.indexOf("P") !== -1) {
                tabla += '<td>' + data["datosRepuesto"][i]["precio_vta"] + '</td>';
            }

            tabla += '<td><input type="checkbox" id="chkACompras" name="chkACompras" title="Crear requerimiento para compras" /></td>';

            if (data["datosRepuesto"].length === 1) {

                $("#divFoto").html("<center><img src='" + data["datosRepuesto"][0]["foto"] + "' width='150px' height='90px' alt='Imagen repuesto' /></center>");

                tabla += '<td><button class="btn btn-success" id="' + data["datosRepuesto"][i]["cod_item"] + '" title="Producto seleccionado" ><span class="fa fa-check"></span></button></td>';

                $("#cod_item").val(data["datosRepuesto"][i]["cod_item"]);                
                $("#alter_item").val(data["datosRepuesto"][i]["alter_item"]);
                $("#nom_item").val(data["datosRepuesto"][i]["nom_item"]);
                
                if (parseInt(data["datosRepuesto"][i]["saldo"]) === 0) {
                    repuestosSinExistencia[i] = data["datosRepuesto"][i]["cod_item"];
                } else {
                    repuestosSinExistencia[i] = 0;
                }
            } else {

                $("#cod_item").val('');
                $("#alter_item").val('');
                $("#nom_item").val('');

                $("#divFoto").html("");

                tabla += '<td><button class="btn btn-primary" id="' + data["datosRepuesto"][i]["cod_item"] + '" title="Producto seleccionado" ><span class="fa fa-question"></span></button></td>';
            }
            tabla += '</tr>';
        }

        if (data["datosRepuesto"].length === 1) {
            respuestosCantidados = data["datosRepuesto"][0];
            $("#divCantidadRepuestos").show();
            retornarIRCaracte(data["datosRepuesto"][0]["cod_grupo"], 2);
        } else {
            respuestosCantidados = [];
            $("#divCaracteristicasBorradores").html('');
        }

        tabla += '</tbody>';
        tabla += '</table>';
        return tabla;
    }
}

function obtenerTamañoMasGrande(arreglo) {
    let tamañoMasGrande = 0;
    for (let i = 0; i < arreglo.length; i++) {
        const subarreglo = arreglo[i];
        if (subarreglo.length > tamañoMasGrande) {
            tamañoMasGrande = subarreglo.length;
        }
    }

    return tamañoMasGrande;
}

function redirigir(data, opcion) {

    switch (opcion) {
        case 1:
            window.location.href = "edit_requer.php?id_requerim=" + data;
            break;
        case 2:
            window.location.href = "cotiza.php?id_consecot=" + data;
            break;
        case 3:

            var partes = data.split("_");
            var nro_cot = partes[0];
            var version = partes[1];

            Swal.fire({
                title: 'Confirmación',
                text: 'Esta acción iniciará una nueva versión a partir de la ultima cotización guardada en el sistema.Este proceso es irreversible!\nEsta seguro?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = "../controladores/CT_grabar_cotizacion_version.php?nro_cot=" + nro_cot + "&version=" + version;
                }
            });

            break;
        case 4:
            window.location.href = "cot_equipos.php?id_consecot=" + data;
            break;
        case 5:
            window.location.href = "refe_inve.php?cod_item=" + data;
            break;
        case 6:
            window.location.href = "refe_inve.php";
            break;
    }
}

$.urlParam = function (name) {
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results === null) {
        return null;
    }
    return decodeURI(results[1]) || 0;
};

function agregarCaracteristicasEquipos(opcion) {

    if (opcion === 1) {

        var prueba = 1;
        for (var i = 0; i < arregloCaracteristicas.length; i++) {
            if ($("#" + arregloCaracteristicas[i]).val().length === 0) {
                prueba = 0;
            } else {
                prueba = 1;
                i = arregloCaracteristicas.length;
            }
        }

        if (prueba === 0) {
            $("#divMensajesEquipos").html('<div class="callout callout-warning">Por favor ingrese mímino un valor del formulario "Caracteristicas a solicitar"</div>');
            $("#divCaracteristicasEquipos").addClass('bg-info');
        } else {

            $("#divCaracteristicasEquipos").removeClass('bg-info');
            for (var i = 0; i < arregloCaracteristicas.length; i++) {
                textosCaracteristicas2[i] = $("#" + arregloCaracteristicas[i]).val();
            }

            clavesEquipos.push(arregloCaracteristicas);
            textosEquipos.push(textosCaracteristicas2);
            etiquetasEquipos.push(textosCaracteristicas);
            aCompras.push(0);
            if ($("#ip_grupos").val() === '01') {
                lineasEquipos.push($("#ip_grupos").val());
            }

            if ($("#ip_grupos").val() === '04') {
                lineasProyectos.push($("#ip_grupos").val());
            }

            textosGeneralesEquipos["equipo"] = $("#im_items2 option:selected").html();
            textosGeneralesEquipos["tipo"] = $("#ip_tipos option:selected").html();
            textosGeneralesEquipos["marca"] = $("#ip_marcas option:selected").html();
            clavesGeneralesEquipos["im_items"] = $("#im_items2").val();
            clavesGeneralesEquipos["ip_tipos"] = $("#ip_tipos").val();
            clavesGeneralesEquipos["ip_marcas"] = $("#ip_marcas").val();
            clavesGeneralesEquipos["de_linea"] = $("#ip_grupos").val();
            textosCaracteristicasEquipos.push(textosGeneralesEquipos);
            clavesCaracteristicasEquipos.push(clavesGeneralesEquipos);
            cantidadesEquiposEnviar.push($("#cantidadEquipos").val());
            observacionesEquiposEnviar.push($("#observacionesEquipos").val());
            textosCaracteristicas = [];
            arregloCaracteristicas = [];
            textosCaracteristicas2 = [];
            textosGeneralesEquipos = [];
            clavesGeneralesEquipos = [];
            $("#im_items2").val('-1');
            $("#ip_tipos").val('0');
            $("#ip_marcas").val('0');
            $("#ip_unidades").val('-1');
            $("#divCaracteristicasEquipos").html('');
            $("#divEquiposFinales").html(armarTablaEquipos(null, 1));
        }
    }

    if (opcion === 2) {

        if ($("#ip_grupos").val() === '-1' || $("#ip_lineas").val() === '-1') {
            $("#mensajesParametrosIniciales").html('<div class="callout callout-warning">La <strong>Línea</strong> o la <strong>Sub línea</strong> no están seleccionadas. Por favor verifique!</div>');
        } else if ($("#cantidadEquipos").val().length === 0) {
            $("#divMensajesEquipos").html('<div class="callout callout-warning">Cuantos equipos?</div>');
            $("#cantidadEquipos").focus();
        } else {

            $("#mensajesParametrosIniciales").html('');
            $("#divMensajesEquipos").html('');

            if ($("#codprog").val() === 'edit_requer') {
                crearVRRequerimDet(null, 2);
            }

            if ($("#codprog").val() === 'cotiza') {
                crearVRCotizaDet(null, 2);
            }
        }
    }

}

function retornarMensajeDeCreacion(opcion) {
    if (opcion === 1) {
        $("#mensajes").html('<div class="callout callout-warning">Al parecer es un cliente nuevo, ingrese como mínimo <strong>Nombres </strong>, el número de <strong>NIT</strong> y el <strong>correo electrónico.</strong> Es necesario seleccionar también <strong>la región</strong> por favor!</div>');
        $("#crearVMClientesProv").show();
        $("#actualizarNMContactos").hide();
        $("#direccion").val('');
        $("#razon_social").val('');
        $("#telefono").val('');
        $("#np_ciudades").val('');
        $("#np_paises").val('');
    }

    if (opcion === 2) {
        $("#actualizar").hide();
        $("#actualizarFoto").hide();
        $("#cod_item").prop("disabled", false);
    }
}

function eliminarPosicion(posicion, opcion) {

    if (opcion === 1) {

        textosIniciales.splice(posicion, 1);
        valoresIniciales.splice(posicion, 1);
        cantidadesIniciales.splice(posicion, 1);
        notasIniciales.splice(posicion, 1);
        //preciosVenta.splice(posicion, 1);
        lineasRepuestos.splice(posicion, 1);
        repuestosSinExistencia.splice(posicion, 1);
        aCompras.splice(posicion, 1);
        caracteristicasRepuestosEnviar.push(posicion, 1);
        textosCaracteristicasRepuestosEnviar.push(posicion, 1);
        clavesCaracteristicasRepuestosEnviar.push(posicion, 1);
        repNoExiste.splice(posicion, 1);
        textosMostrarRepuestosNoExiste.splice(posicion, 1);
        armarTablaProductos(null, 1);
    }

    if (opcion === 2) {

        var pos = posicion.slice(2);
        if ($("#ip_grupos").val() === '01') {
            lineasEquipos.splice(pos, 1);
        }

        if ($("#ip_grupos").val() === '04') {
            lineasProyectos.splice(pos, 1);
        }

        clavesEquipos.splice(pos, 1);
        textosEquipos.splice(pos, 1);
        etiquetasEquipos.splice(pos, 1);
        textosCaracteristicasEquipos.splice(pos, 1);
        clavesCaracteristicasEquipos.splice(pos, 1);
        cantidadesEquiposEnviar.splice(pos, 1);
        observacionesEquiposEnviar.splice(pos, 1);
        $("#divEquiposFinales").html(armarTablaEquipos(null, 1));
    }
}

function armarTablaProductos(data, opcion) {

    var datos = [];

    tabla = "<table class='table table-hover'>";
    tabla += '<thead>';
    tabla += '<tr class="bg-primary">';
    tabla += '<th><center>REPUESTOS</center></th>';
    tabla += '</tr>';
    tabla += '<tr class="bg-primary" >';

    if ($("#codprog").val() === 'cotiza') {

        tabla += '<th>No.</th>';
        tabla += '<th>Marca</th>';
        tabla += '<th>Articulo</th>';
        tabla += '<th>Modelo</th>';
        tabla += '<th>Código del producto</th>';
        tabla += '<th>Disp. en semanas</th>';
        tabla += '<th>Cantidad</th>';

        if (data["vr_cotiza"][0]["id_moneda"] === 34) {
            if (opcion === 3) {
                tabla += '<th>Valor unitario COP</th>';
            } else {
                tabla += '<th>Precio venta</th>';
            }
        }

        if (data["vr_cotiza"][0]["id_moneda"] === 35) {
            if (opcion === 3) {
                tabla += '<th>Valor unitario USD</th>';
            }
        }

        tabla += '<th>Dscto. %</th>';

        //tabla += '<th style="text-align:right;" >Con dscto.</th>';

        tabla += '<th>IVA %</th>';

        tabla += '<th style="text-align:right;">Sub total</th>';

    } else {

        tabla += '<th>No.</th>';
        tabla += '<th>Articulo</th>';
        tabla += '<th>Tipo</th>';
        tabla += '<th>Marca</th>';
        tabla += '<th>Modelo</th>';
        tabla += '<th>Dimensiones</th>';
        tabla += '<th>Unidad de medida</th>';
        tabla += '<th>Código del producto</th>';
        tabla += '<th>Cantidad</th>';
        tabla += '<th>Reservados</th>';

        if ($("#codprog").val() === 'edit_requer') {
            tabla += '<th>Saldo</th>';
            //tabla += '<th>Mínimo</th>';
        }

        //permiso de precio de venta        
        if (permisos.indexOf("P") !== -1) {
            if ($("#codprog").val() === 'toma_requer' || $("#codprog").val() === 'edit_requer') {
                tabla += '<th>Precio venta</th>';
            }
        }

        if ($("#codprog").val() === 'cotiza' || $("#codprog").val() === 'cot_equipos') {
            if (data["vr_cotiza"][0]["id_moneda"] === 34) {
                tabla += '<th>Precio COP</th>';
            }

            if (data["vr_cotiza"][0]["id_moneda"] === 35) {
                tabla += '<th>Precio USD</th>';
            }
        }

    }

    tabla += '<th>Notas</th>';

    //solamente en la edición del requerimiento aparece esta opción
    if ($("#codprog").val() === 'edit_requer') {
        tabla += '<th>Modo importación</th>';
        tabla += '<th>a Compras</th>';
    }

    if($("#codprog").val() === 'toma_requer'){
        tabla += '<th>a Compras</th>';
    }

    tabla += '<th></th>';
    tabla += '<th></th>';
    tabla += '</tr>';
    tabla += '</thead>';
    tabla += '<tbody>';

    //para la creación del requerimiento
    if (opcion === 1) {

        if (textosIniciales.length === 0) {

            $("#divProductosFinales").html('');
        } else {

            for (var i = 0; i < textosIniciales.length; i++) {
                tabla += '<tr>';
                tabla += '<td>' + (i + 1) + '</td>';

                //cuando existe el producto
                if (textosIniciales[i] !== null && textosIniciales[i]["cod_item"] !== undefined) {
                    tabla += '<td>' + textosIniciales[i]["nom_grupo"] + '</td>';
                    tabla += evaluarNA(textosIniciales[i]["descrip"], 1);
                    tabla += evaluarNA(textosIniciales[i]["nom_marca"], 1);
                    tabla += evaluarNA(textosIniciales[i]["descrip_modelo"], 1);
                    tabla += evaluarNA(textosIniciales[i]["nom_dimen"], 1);
                    tabla += evaluarNA(textosIniciales[i]["nom_unidad"], 1);
                    tabla += evaluarNA(textosIniciales[i]["cod_item"], 1);
                    //cuando no existe
                } else {

                    tabla += '<td>' + textosMostrarRepuestosNoExiste[i]["articulo"] + '</td>';
                    tabla += '<td>' + textosMostrarRepuestosNoExiste[i]["tipo"] + '</td>';
                    tabla += '<td>' + textosMostrarRepuestosNoExiste[i]["marca"] + '</td>';
                    tabla += '<td></td>';
                    tabla += '<td></td>';
                    tabla += '<td></td>';
                    tabla += '<td></td>';
                }

                tabla += '<td>' + cantidadesIniciales[i] + '</td>';

                //permiso de precio de venta
                if (permisos.indexOf("P") !== -1) {
                    if (textosIniciales[i] !== null) {
                        tabla += '<td></td>';
                        tabla += '<td>' + redondear(textosIniciales[i]["precio_vta"]) + '</td>';
                    } else {
                        tabla += '<td></td>';
                        tabla += '<td></td>';
                    }
                }
                tabla += '<td>' + notasIniciales[i] + '</td>';

                //para la creación del requerimiento para compras
                if (aCompras[i] === 0) {
                    tabla += '<td><input type="checkbox" id="cr_' + i + '" name="cr_' + i + '" title="Crear requerimiento para compras" onclick="cambiarCR(this.id,1);" /></td>';
                } else {
                    tabla += '<td><input type="checkbox" id="cr_' + i + '" name="cr_' + i + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarCR(this.id,1);" /></td>';
                }

                tabla += '<td><button class="btn btn-primary" id="' + i + '" onclick="eliminarPosicion(this.id,1)" title="Eliminar" ><span class="fa fa-remove"></span></button></td>';
                tabla += '</tr>';
                if (textosCaracteristicasRepuestosEnviar[i].length > 0) {

                    //cuando existe el repuesto
                    if (textosIniciales[i] !== null) {
                        tabla += '<tr><td colspan="12"><div class="col-lg-13 bg-info"> Caracteristicas de ' + textosIniciales[i]["nom_grupo"] + ' ';
                        for (var j = 0; j < textosCaracteristicasRepuestosEnviar[i].length; j++) {
                            tabla += '<strong>' + textosCaracteristicasRepuestosEnviar[i][j] + ' :</strong> ' + caracteristicasRepuestosEnviar[i][j] + '  ';
                        }
                        // cuando el repuesto no existe
                    } else {
                        tabla += '<tr><td colspan="12"><div class="col-lg-13 bg-info"> ';
                        for (var j = 0; j < textosCaracteristicasRepuestosEnviar[i].length; j++) {
                            tabla += '<strong>' + textosCaracteristicasRepuestosEnviar[i][j] + ' :</strong> ' + caracteristicasRepuestosEnviar[i][j] + '  ';
                        }
                    }
                    tabla += '</div></td></tr>';
                }

            }

            tabla += '</tbody>';
            tabla += '</table>';
            $("#divProductosFinales").html(tabla);
        }
    }

    //para la edición del requerimiento
    if (opcion === 2) {

        var datos = {};
        //con saldo
        var cs = 0;
        //sin saldo
        var ss = 0;
        //no existe
        var ne = 0;
        var colspan = 20;

        var saldoReserva = 0;

        var color = null;

        for (var i = 0; i < data["vr_requerimdet"].length; i++) {

            if (data["repuestosConSaldo"][i] !== undefined) {

                if (data["repuestosConSaldo"][i].length > 0) {

                    if (cs === 0) {
                        tabla += '<tr>';
                        tabla += '<th colspan="' + colspan + '" style="background-color:#FFE1DF"><center>CON EXISTENCIAS</center></th>';
                        tabla += '</tr>';
                        cs = 1;
                    }

                    tabla += '<tr>';
                    tabla += '<td>' + (i + 1) + '</td>';
                    tabla += '<td>' + data["repuestosConSaldo"][i][0]["nom_grupo"] + '</td>';
                    tabla += evaluarNA(data["repuestosConSaldo"][i][0]["descrip"], 1);
                    tabla += evaluarNA(data["repuestosConSaldo"][i][0]["nom_marca"], 1);
                    tabla += evaluarNA(data["repuestosConSaldo"][i][0]["descrip_modelo"], 1);
                    tabla += evaluarNA(data["repuestosConSaldo"][i][0]["nom_dimen"], 1);
                    tabla += evaluarNA(data["repuestosConSaldo"][i][0]["nom_unidad"], 1);
                    tabla += evaluarNA(data["vr_requerimdet"][i]["cod_item"], 1);

                    if (data["ir_resinve"][i].length > 0) {
                        for (var j = 0; j < data["ir_resinve"][i].length; j++) {
                            saldoReserva += parseInt(data["ir_resinve"][i][j]["saldo"]);
                        }
                    }

                    tabla += '<td style="background-color:' + asignarColor(data, saldoReserva, i, 1) + '"><center><strong>' + data["vr_requerimdet"][i]["cantidad"] + '</strong></center></td>';
                    //tabla += '<td>' + data["vr_requerimdet"][i]["minimo"] + '</td>';

                    if (data["ir_resinve"][i].length > 0) {
                        tabla += '<td>';
                        for (var j = 0; j < data["ir_resinve"][i].length; j++) {
                            tabla += data["ir_resinve"][i][j]["saldo_nombre"] + '<br>';
                        }
                        tabla += '</td>';
                    } else {
                        tabla += '<td></td>';
                    }

                    tabla += '<td><center>' + data["vr_requerimdet"][i]["saldo"] + '</center></td>';

                    //permiso de precio de venta
                    if (permisos.indexOf("P") !== -1) {
                        tabla += '<td>' + redondear(data["repuestosConSaldo"][i][0]["precio_vta"]) + '</td>';
                    }

                   tabla += '<td>' + data["vr_requerimdet"][i]["observs"] + '</td>';

                    //determinar el tipo de importacion
                    tabla += '<td id="td_' + data["vr_requerimdet"][i]["id_reqdet"] + '">' + retornarCPTipoImportacion(data["vr_requerimdet"][i], 1) + '</td>';
                    
                    //para compras                
                    if (data["vr_requerimdet"][i]["a_compras"] === 0) {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1)" /></td>';
                    } else {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1);" /></td>';
                    }

                    //impedir que se retire el repuesto del requerimiento
                    //estado 83 = cerrado

                    tabla += '<td><input type="button" class="btn btn-success" value="Bodegas" id="bd_' + data["vr_requerimdet"][i]["cod_item"] + '" name="bd_' + data["vr_requerimdet"][i]["cod_item"] + '" onclick="retornarIRSalinve(this.id, 3);" title="Revisar bodegas" /></td>';

                    if (data["vr_requerim"][0]["estado"] === 83) {
                        tabla += '<td></td>';
                    } else {
                        tabla += '<td><button class="btn btn-primary" id="' + data["vr_requerimdet"][i]["id_reqdet"] + '" onclick="borrarVRRequerimDet(this.id,1)" title="Eliminar" ><span class="fa fa-remove"></span></button></td>';
                    }

                    tabla += '</tr>';
                    if (data["vr_requerimcar"][i].length > 0) {
                        tabla += '<tr><td colspan="20"><div class="col-lg-12 bg-info"> Caracteristicas ';
                        for (var j = 0; j < data["textosCaracteristicas"][i].length; j++) {
                            tabla += '<strong>' + data["textosCaracteristicas"][i][j][0]["desccarac"] + ' :</strong> ' + data["vr_requerimcar"][i][j]["vr_caract"] + '  ';
                        }
                        tabla += '</div></td></tr>';
                    }
                }

            }

            if (data["repuestosSinSaldo"][i] !== undefined) {

                if (data["repuestosSinSaldo"][i].length > 0) {

                    if (ss === 0) {
                        tabla += '<tr>';
                        tabla += '<th colspan="' + colspan + '" style="background-color:#FFE1DF" ><center>SIN EXISTENCIAS</center></th>';
                        tabla += '</tr>';
                        ss = 0;
                    }

                    tabla += '<tr>';
                    tabla += '<td>' + (i + 1) + '</td>';
                    tabla += '<td>' + data["repuestosSinSaldo"][i][0]["nom_grupo"] + '</td>';
                    tabla += evaluarNA(data["repuestosSinSaldo"][i][0]["descrip"], 1);
                    tabla += evaluarNA(data["repuestosSinSaldo"][i][0]["nom_marca"], 1);
                    tabla += evaluarNA(data["repuestosSinSaldo"][i][0]["descrip_modelo"], 1);
                    tabla += evaluarNA(data["repuestosSinSaldo"][i][0]["nom_dimen"], 1);
                    tabla += evaluarNA(data["repuestosSinSaldo"][i][0]["nom_unidad"], 1);
                    tabla += evaluarNA(data["vr_requerimdet"][i]["cod_item"], 1);
                    tabla += '<td style="background-color:' + rojo + '"><center><strong>' + data["vr_requerimdet"][i]["cantidad"] + '</strong></center></td>';

                    if (data["ir_resinve"][i].length > 0) {
                        tabla += '<td>';
                        for (var j = 0; j < data["ir_resinve"].length; j++) {
                            tabla += data["ir_resinve"][i][j]["saldo_nombre"] + '<br>';
                            saldoReserva += parseInt(data["ir_resinve"][i][j]["saldo"]);
                        }
                        tabla += '</td>';
                    } else {
                        tabla += '<td></td>';
                    }

                    tabla += '<td><center><strong>' + data["vr_requerimdet"][i]["saldo"] + '</strong></center></td>';
                    //tabla += '<td>' + data["vr_requerimdet"][i]["minimo"] + '</td>';                    

                    //permiso de precio de venta
                    if (permisos.indexOf("P") !== -1) {
                        tabla += '<td>' + redondear(data["repuestosSinSaldo"][i][0]["precio_vta"]) + '</td>';
                    }

                    tabla += '<td>' + data["vr_requerimdet"][i]["observs"] + '</td>';

                    //determinar el tipo de importacion
                    tabla += '<td id="td_' + data["vr_requerimdet"][i]["id_reqdet"] + '">' + retornarCPTipoImportacion(data["vr_requerimdet"][i], 1) + '</td>';

                    //para compras                
                    if (data["vr_requerimdet"][i]["a_compras"] === 0) {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1)" /></td>';
                    } else {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1);" /></td>';
                    }

                    //impedir que se retire el repuesto del requerimiento
                    //estado 83 = cerrado
                    if (data["vr_requerim"][0]["estado"] === 83) {
                        tabla += '<td></td>';
                    } else {
                        tabla += '<td><button class="btn btn-primary" id="' + data["vr_requerimdet"][i]["id_reqdet"] + '" onclick="borrarVRRequerimDet(this.id,1)" title="Eliminar" ><span class="fa fa-remove"></span></button></td>';
                    }

                    tabla += '</tr>';

                    if (data["vr_requerimcar"][i].length > 0) {
                        //tabla += '<tr><td colspan="12"><div class="col-lg-12 bg-info"> Caracteristicas de ' + data["caracteristicasRepuestos"][i][0]["nom_grupo"] + ' ';
                        tabla += '<tr><td colspan="20"><div class="col-lg-12 bg-info"> Caracteristicas ';
                        for (var j = 0; j < data["textosCaracteristicas"][i].length; j++) {
                            tabla += '<strong>' + data["textosCaracteristicas"][i][j][0]["desccarac"] + ' :</strong> ' + data["vr_requerimcar"][i][j]["vr_caract"] + '  ';
                        }
                        tabla += '</div></td></tr>';
                    }
                }
            }

            if (data["repuestosNoExiste"][i] !== null) {

                if (ne === 0) {
                    tabla += '<tr>';
                    tabla += '<th colspan="' + colspan + '" style="background-color:#FFE1DF" ><center>NO EXISTE</center></th>';
                    tabla += '</tr>';
                    ne = 1;
                }

                tabla += '<tr>';
                tabla += '<td>' + (i + 1) + '</td>';
                tabla += '<td>' + data["repuestosNoExiste"][i]["nom_grupo"] + '</td>';
                tabla += evaluarNA(data["repuestosNoExiste"][i]["descrip"], 1);
                tabla += evaluarNA(data["repuestosNoExiste"][i]["nom_marca"], 1);

                tabla += '<td></td>';
                tabla += '<td></td>';
                tabla += '<td></td>';
                tabla += '<td></td>';
                tabla += '<td style="background-color:' + rojo + '">' + data["vr_requerimdet"][i]["cantidad"] + '</td>';
                //precio venta no hay
                tabla += '<td></td>';
                tabla += '<td></td>';

                tabla += '<td>' + data["vr_requerimdet"][i]["observs"] + '</td>';

                //determinar el tipo de importacion
                tabla += '<td id="' + datos["nombreTD"] + '">' + retornarCPTipoImportacion(data["vr_requerimdet"][i], 1) + '</td>';
                
                // //para compras                
                if (data["vr_requerimdet"][i]["a_compras"] === 0) {
                    tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1)" /></td>';
                } else {
                    tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1);" /></td>';
                }

                //impedir que se retire el repuesto del requerimiento
                //estado 83 = cerrado
                if (data["vr_requerim"][0]["estado"] === 83) {
                    tabla += '<td></td>';
                } else {
                    tabla += '<td><button class="btn btn-primary" id="' + data["vr_requerimdet"][i]["id_reqdet"] + '" onclick="borrarVRRequerimDet(this.id,1)" title="Eliminar" ><span class="fa fa-remove"></span></button></td>';
                }


                tabla += '</tr>';

                if (data["vr_requerimcar"][i].length > 0) {

                    tabla += '<tr><td colspan="20"><div class="col-lg-12 bg-info"> Caracteristicas ';
                    for (var j = 0; j < data["textosCaracteristicas"][i].length; j++) {
                        tabla += '<strong>' + data["textosCaracteristicas"][i][j][0]["desccarac"] + ' :</strong> ' + data["vr_requerimcar"][i][j]["vr_caract"] + '  ';
                    }
                    tabla += '</div></td></tr>';
                }

            }

            $("#equipos").val(1);
            $("#divProductosFinales").html(tabla);
        }
    }

    //para la visualización en el módulo de cotización
    if (opcion === 3) {

        var datos = {}, colspan = 9, arregloIVA = [[], []];

        texto = 'INMEDIATA';
        trm = $("#trm").val();

        // si el cliente tiene un descuento aplica sobre la cotización
        if (data["vm_dsctos_especiales"].length > 0) {
            dtoAplicar = data["vm_dsctos_especiales"][0]["dscto_%"];
            $("#divMensajesRequerimientos").html('<div class="callout callout-warning" >El cliente tiene un descuento de ' + dtoAplicar + '% </div>');
        } else {
            //si el perfil tiene descuento aplica sobre la cotización
            if (data["vp_limites"].length > 0) {
                dtoAplicar = data["vp_limites"][0]["maximo"];
                $("#divMensajesRequerimientos").html('<div class="callout callout-success" >El perfil puede aplicar hasta ' + dtoAplicar + '% de descuento</div>');
            } else {
                $("#divMensajesRequerimientos").html('<div class="callout callout-warning" >El perfil no puede aplicar descuentos. Podría solicitar ésta carácteristica a su lider de área!</div>');
            }
        }

        for (var i = 0; i < data["vr_cotizadet"].length; i++) {

            if (data["caracteristicasRepuestos"][i].length > 0) {

                tabla += '<tr>';
                tabla += '<td>' + (i + 1) + '</td>';
                tabla += evaluarNA(data["caracteristicasRepuestos"][i][0]["nom_marca"], 1);
                tabla += '<td>' + data["caracteristicasRepuestos"][i][0]["nom_grupo"] + '</td>';
                tabla += evaluarNA(data["caracteristicasRepuestos"][i][0]["descrip_modelo"], 1);
                tabla += evaluarNA(data["vr_cotizadet"][i]["cod_item"], 1);

                if (data["vr_cotizadet"][i]["sem_dispo"] === 0) {
                    texto = 'INMEDIATA';
                } else {
                    texto = 'SEMANA(S)';
                }

                //disponibilidad de semanas
                if (data["vr_cotiza"][0]["estado"] === 111) {
                    tabla += '<td><input type="number" value="0" style="width: 50px; border:none" min="1" id="s_' + data["vr_cotizadet"][i]["sem_dispo"] + '" disabled /> ' + texto + '</td>';
                } else {
                    tabla += '<td><input type="number" value="' + data["vr_cotizadet"][i]["sem_dispo"] + '" style="width: 50px; min="1" id="s_' + data["vr_cotizadet"][i]["id_orden"] + '" onchange="cambiarVRCotizadet(this.id,7)" /> ' + texto + '</td>';
                }

                tabla += '<td><input type="number" value="' + data["vr_cotizadet"][i]["cantidad"] + '" style="width: 50px; border:none" min="1" id="c_' + data["vr_cotizadet"][i]["id_orden"] + '" disabled /></td>';

                if (data["vr_cotiza"][0]["id_moneda"] === 34) {
                    tabla += '<td><input type="number" value="' + redondear(data["vr_cotizadet"][i]["valor_unit"]) + '" style="border:none; text-align:left;" disabled /></td>';
                }

                if (data["vr_cotiza"][0]["id_moneda"] === 35) {

                    /*
                    //este código no se necesita ya que un PA entró a trabajar en este caso
                    //la función retornarPrecioDolares(datos,2) se deja 
                    datos.precioProducto = redondear(data["vr_cotizadet"][i]["valor_unit"]);
                    datos.iva = data["vr_cotizadet"][i]["iva_referencia"];
                    datos.trm = $("#trm").val();
                    datos.cantidad = data["vr_cotizadet"][i]["cantidad"];

                    tabla += '<td><input type="number" value="' + retornarPrecioDolares(datos, 2) + '" style="border:none; text-align:left;" disabled /></td>';
                    */                   

                    tabla += '<td><input type="number" value="' + data["precioDolares"][i] + '" style="border:none; text-align:left;" disabled /></td>';
                }

                if (data["vr_cotiza"][0]["estado"] === 111) {
                    tabla += '<td><input type="number" value="' + data["vr_cotizadet"][i]["dscto_item"] + '" style="width: 50px;" min="0" step="1" max="' + dtoAplicar + '" disabled /></td>';
                } else {
                    if (dtoAplicar === 0) {
                        tabla += '<td><input type="number" value="' + data["vr_cotizadet"][i]["dscto_item"] + '" style="width: 50px;" min="0" step="1" max="' + dtoAplicar + '" disabled /></td>';
                    } else {
                        tabla += '<td><input type="number" value="' + data["vr_cotizadet"][i]["dscto_item"] + '" style="width: 50px;" min="0" step="1" max="' + dtoAplicar + '" id="d_' + data["vr_cotizadet"][i]["id_orden"] + '" onchange="cambiarVRCotizadet(this.id, 6);" oninput="validarNumero(this,1)" /></td>';
                    }
                }

                //evitar suma de los mismos valores durante el ciclo                
                if (cod_items.indexOf(data["vr_cotizadet"][i]["id_orden"]) === -1) {

                    cod_items[i] = data["vr_cotizadet"][i]["id_orden"];

                    datos.precioProducto = redondear(data["vr_cotizadet"][i]["valor_unit"]);

                    datos.iva = data["vr_cotizadet"][i]["iva_referencia"];
                    datos.trm = $("#trm").val();
                    datos.cantidad = data["vr_cotizadet"][i]["cantidad"];

                    $("#iva").val(data["vr_cotizadet"][i]["iva_referencia"]);

                    //para el peso colombiano
                    if (data["vr_cotiza"][0]["id_moneda"] === 34) {
                        precioVenta = redondear(parseFloat(data["vr_cotizadet"][i]["valor_unit"]) * parseFloat(data["vr_cotizadet"][i]["cantidad"]));                        
                    }

                    //para el dolar
                    if (data["vr_cotiza"][0]["id_moneda"] === 35) {
                        precioVenta = parseFloat(data["precioDolares"][i]);
                    }

                    if (parseFloat(data["vr_cotizadet"][i]["dscto_item"]) !== 0) {
                        valorDescuento = redondear((parseFloat(data["vr_cotizadet"][i]["dscto_item"]) * precioVenta) / 100);
                    } else {
                        valorDescuento = 0;
                    }                    

                    valorConDescuento = redondear(precioVenta) - redondear(valorDescuento);
                    valorIva = (valorConDescuento * parseFloat(data["vr_cotizadet"][i]["iva_referencia"])) / 100;
                    valorConIva = redondear(valorConDescuento) + redondear(valorIva);
                    
                    subTotal += precioVenta;
                    totalDescuentos += valorDescuento;
                    valorBruto += valorConDescuento;
                    totalesIva += valorIva;

                    

                }
                //para el peso colombiano
                if (data["vr_cotiza"][0]["id_moneda"] === 34) {
                    precioVenta = redondear(parseFloat(data["vr_cotizadet"][i]["valor_unit"]) * parseFloat(data["vr_cotizadet"][i]["cantidad"]));
                    precioVenta=precioVenta.toFixed(2);
                }

                //para el dolar
                if (data["vr_cotiza"][0]["id_moneda"] === 35) {
                    precioVenta = data["precioDolares"][i];
                }

                tabla += '<td style="text-align: right;"><input type="number" value="' + data["vr_cotizadet"][i]["iva_referencia"] + '" style="width:60px; border:none" disabled /></td>';

                tabla += '<td style="text-align: right;"><input type="number" value="' + precioVenta + '" style="border:none; text-align:right;" disabled /></td>';

                if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {
                    tabla += '<td><input type="text" value="' + data["vr_cotizadet"][i]["observs"] + '" onblur="cambiarVRCotizadet(this.id,2)" onkeyup="javascript:this.value=this.value.toUpperCase();" id="n_' + data["vr_cotizadet"][i]["id_orden"] + '" /></td>';
                } else {
                    tabla += '<td>' + data["vr_cotizadet"][i]["observs"] + '</td>';
                }

                //este es en caso de que se necesite crear la opción de "a Compras" en la cotización
                //tabla +='<td></td>';                
                tabla += '<td><input type="button" class="btn btn-success" value="Bodegas" id="bd_' + data["vr_cotizadet"][i]["cod_item"] + '" name="bd_' + data["vr_cotizadet"][i]["cod_item"] + '" onclick="retornarIRSalinve(this.id, 3);" title="Revisar bodegas" /></td>';

                if (data["vr_cotiza"][0]["estado"] === 111) {
                    tabla += '<td></td>';
                } else {
                    tabla += '<td><button class="btn btn-primary" id="' + data["vr_cotizadet"][i]["id_orden"] + '" onclick="borrarVRCotizadet(this.id,1)" title="Eliminar" ><span class="fa fa-remove"></span></button></td>';
                }

                tabla += '</tr>';

                if (data["vr_cotizcar"][i].length > 0) {

                    tabla += '<tr><td colspan="11"><div class="col-lg-12 bg-info"> Caracteristicas de ' + data["caracteristicasRepuestos"][i][0]["nom_grupo"] + ' ';

                    for (var k = 0; k < data["textosCaracteristicas"][i].length; k++) {
                        tabla += '<strong>' + data["textosCaracteristicas"][i][k][0]["desccarac"] + ' :</strong> ';
                        tabla += data["vr_cotizcar"][i][k]["vr_caract"];
                    }
                    tabla += '</div></td></tr>';

                }
            }

        }

        $("#maximo").val(dtoAplicar);

        tabla += '<tr><td colspan="' + colspan + '" ></td><td style="text-align:right;" ><strong>Valor bruto</strong></td><td><input type="number" value="' + subTotal.toFixed(2) + '" id="valorBruto" style="border:none; text-align:right;" disabled /></td><td colspan="3"></td></tr>';
        tabla += '<tr><td colspan="' + colspan + '" ></td><td style="text-align:right;" ><strong>Descuentos</strong></td><td><input type="number" value="' + totalDescuentos.toFixed(2) + '" id="valorBruto" style="border:none; text-align:right;" disabled /></td><td colspan="3"></td></tr>';
        tabla += '<tr><td colspan="' + colspan + '"></td><td style="text-align:right;" ><strong>Sub total</strong></td><td><input type="number" value="' + valorBruto.toFixed(2) + '" id="subTotal" style="border:none; text-align:right;" disabled /></td><td colspan="3"></td></tr>';
        tabla += '<tr><td colspan="' + colspan + '"></td><td style="text-align:right;" ><strong>Total IVA</strong></td><td><input type="number" value="' + totalesIva.toFixed(2) + '" id="valorIva" style="border:none; text-align:right;" disabled /></td><td colspan="3"></td></tr>';

        valorTotal = totalesIva + valorBruto;

        tabla += '<tr><td colspan="' + colspan + '"></td><td style="text-align:right;" ><strong>Valor total</strong></td><td><input type="number" value="' + valorTotal.toFixed(2) + '" id="valorTotal" style="border:none; text-align:right;" disabled /></td><td colspan="3"></td></tr>';
        $("#equipos").val(1);
        $("#divProductosFinales").html(tabla);

    }

    var data = ['divTipos', 'divMarcas', 'divModelos', 'divDimensiones', 'divUnidadMedida', 'divCodigosArticulos'];
    borrarContenidoDivs(data, 1);
    $("#cantidadRepuestos").val('0');
    $("#notasRepuestos").val('');
    $("#divMensajesRepuestos").html('');
    $("#divProductosBorradores").html('');
    $("#divCaracteristicasBorradores").html('');
    $("#divCantidadRepuestos").hide();
}


function asignarColor(data, saldoReserva, i, opcion) {

    var saldoTemporal = 0;
    var cantidadRequerida = 0;
    var minimo = 0;
    var inventario = 0;
    var saldoReal = 0;

    if (opcion === 1) {

        cantidadRequerida = parseInt(data["vr_requerimdet"][i]["cantidad"]);
        minimo = parseInt(data["vr_requerimdet"][i]["minimo"]);
        inventario = parseInt(data["vr_requerimdet"][i]["saldo"]);

        saldoReal = inventario - saldoReserva - minimo;

        if (cantidadRequerida < saldoReal) {
            color = verde;
            crearRequerimientoACompras = 0;
        } else if (cantidadRequerida > saldoReal && (cantidadRequerida > (inventario - saldoReserva))) {
            color = amarillo;
            //}else if(cantidadRequerida<saldoReal && (saldo-saldoReserva) < minimo ){
            //color=rojo;
        } else {
            color = rojo;
        }

        return color;
    }
}

function validarNumero(input, opcion) {

    if (opcion === 1) {
        input.value = Math.min(parseFloat(input.value).toFixed(2), 3);
    }
}

function armarTablaEquipos(data, opcion) {

    if (opcion === 1) {

        var colspan = (obtenerTamañoMasGrande(textosEquipos)) + 1;
        tabla = '';
        if (textosEquipos.length > 0) {

            tabla = "<table class='table table-sm' id='tablaEquipos'>";
            tabla += '<tr class="bg-primary">';
            tabla += '<th>' + $("#ip_grupos option:selected").html() + '</th>';
            tabla += '</tr>';
            for (var i = 0; i < textosEquipos.length; i++) {

                tabla += '<tr class="bg-primary" >';
                tabla += '<th></th>';
                tabla += '<th>Equipo</th>';
                tabla += '<th>Tipo</th>';
                tabla += '<th>Marca</th>';
                tabla += '<th></th>';
                tabla += '<th colspan="' + colspan + '" ></th>';
                tabla += '</tr>';
                tabla += '<tr>';
                tabla += '<td>' + (i + 1) + '</td>';
                tabla += '<td><strong>' + textosCaracteristicasEquipos[i]["equipo"] + '</strong></td>';
                tabla += evaluarNA(textosCaracteristicasEquipos[i]["tipo"], 1);
                tabla += evaluarNA(textosCaracteristicasEquipos[i]["marca"], 1);
                tabla += "<td></td>";
                tabla += "<td><button class='btn btn-primary' id='e_" + i + "' onclick='eliminarPosicion(this.id,2)' title='Eliminar'><span class='fa fa-remove'></span></button></td>";
                tabla += '<td colspan="' + colspan + '" ></td>';
                tabla += '</tr>';
                tabla += '<tr class="bg-info" >';
                for (var j = 0; j < etiquetasEquipos[i].length; j++) {
                    tabla += '<th>' + etiquetasEquipos[i][j] + '</th>';
                }

                tabla += '<th>Cantidad</th>';
                tabla += '<th>a Compras</th>';
                tabla += '<th colspan="' + colspan + '"></th>';
                tabla += '</tr>';
                tabla += '<tr>';
                for (var k = 0; k < textosEquipos[i].length; k++) {
                    tabla += '<td>' + textosEquipos[i][k] + '</td>';
                }

                tabla += '<td>' + cantidadesEquiposEnviar[i] + '</td>';

                //para la creación del requerimiento para compras
                if (aCompras[i] === 0) {
                    tabla += '<td><input type="checkbox" id="cr_' + i + '" name="eq_' + i + '" title="Crear requerimiento para compras" onclick="cambiarCR(this.id,2);" /></td>';
                } else {
                    tabla += '<td><input type="checkbox" id="cr_' + i + '" name="eq_' + i + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarCR(this.id,2);" /></td>';
                }

                tabla += '<tr>';
                tabla += '<tr class="bg-info" >';
                tabla += '<th>Observaciones</th>';
                tabla += '<td colspan="' + colspan + '">' + observacionesEquiposEnviar[i] + '</td>';
                tabla += '</tr>';
            }
        }
    }

    if (opcion === 2) {

        tabla = "<table class='table table-sm' id='tablaEquipos'>";
        tabla += '<tr class="bg-primary">';
        tabla += '<th><center>EQUIPOS</center></th>';
        //    tabla += '<th><center>PROYECTOS</center></th>';

        tabla += '</tr>';
        var numero = 0;
        for (var i = 0; i < data["vr_requerimdet"].length; i++) {

            if (data["vr_requerimdet"][i]["misional"] === '01' || data["vr_requerimdet"][i]["misional"] === '04') {

                if (data["vr_requerimcar"][i].length > 0) {

                    tabla += '<tr class="bg-primary" >';
                    tabla += '<th></th>';
                    tabla += '<th>Equipo</th>';
                    tabla += '<th>Tipo</th>';
                    tabla += '<th>Marca</th>';
                    tabla += '<th></th>';
                    tabla += '<th colspan="' + (data["textosCaracteristicas"][i].length * 2) + '" ></th>';
                    tabla += '</tr>';
                    tabla += '<tr>';
                    tabla += '<td>' + (numero + 1) + '</td>';
                    tabla += '<td><strong>' + data["ip_grupos"][i][0]["nom_grupo"] + '</strong></td>';
                    tabla += evaluarNA(data["ip_tipos"][i][0]["descrip"], 1);
                    tabla += evaluarNA(data["ip_marcas"][i][0]["nom_marca"], 1);
                    tabla += "<td></td>";
                    tabla += "<td><button class='btn btn-primary' id='e_" + data["vr_requerimdet"][i]["id_reqdet"] + "' onclick='borrarVRRequerimDet(this.id,2)' title='Eliminar'><span class='fa fa-remove'></span></button></td>";
                    tabla += '<td colspan="' + colspan + '" ></td>';
                    tabla += '</tr>';
                    tabla += '<tr class="bg-info" >';
                    for (var j = 0; j < data["textosCaracteristicas"][i].length; j++) {
                        tabla += '<th>' + data["textosCaracteristicas"][i][j][0]["desccarac"] + '</th>';
                    }

                    tabla += '<th>Cantidad</th>';
                    tabla += '<th>a Compras</th>';
                    tabla += '<th colspan="' + colspan + '"></th>';
                    tabla += '</tr>';
                    tabla += '<tr>';
                    for (var k = 0; k < data["vr_requerimcar"][i].length; k++) {
                        tabla += '<td>' + data["vr_requerimcar"][i][k]["vr_caract"] + '</td>';
                    }

                    tabla += '<td>' + data["vr_requerimdet"][i]["cantidad"] + '</td>';

                    //para compras                
                    if (data["vr_requerimdet"][i]["a_compras"] === 0) {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1)" /></td>';
                    } else {
                        tabla += '<td><input type="checkbox" id="cr_' + data["vr_requerimdet"][i]["id_reqdet"] + '" name="re_' + data["vr_requerimdet"][i]["id_reqdet"] + '" checked="true" title="Crear requerimiento para compras" onclick="cambiarVRRequerimDet(this.id, 1);" /></td>';
                    }

                    tabla += '<tr>';
                    tabla += '<tr class="bg-info" >';
                    tabla += '<th>Observaciones</th>';
                    tabla += '<td colspan="' + colspan + '">' + data["vr_requerimdet"][i]["observs"] + '</td>';
                    tabla += '</tr>';
                }
            }
        }
    }

    if (opcion === 3) {

        tabla = "<table class='table table-sm' id='tablaEquipos'>";
        tabla += '<tr class="bg-primary">';
        tabla += '<th><center>EQUIPOS</center></th>';
        //    tabla += '<th><center>PROYECTOS</center></th>';

        tabla += '</tr>';
        var numero = 0, valor = null, iva = null, trm = null, equipos = [], datos = {};

        valorBruto = 0, valorIva = 0;

        trm = $("#trm").val();

        for (var i = 0; i < data["vr_cotizadet"].length; i++) {

            if (data["vr_cotizadet"][i]["misional"] === '01' || data["vr_cotizadet"][i]["misional"] === '04') {

                if (equipos.indexOf(data["vr_cotizadet"][i]["id_orden"]) === -1) {

                    equipos[i] = data["vr_cotizadet"][i]["id_orden"];

                    tabla += '<tr class="bg-primary" >';
                    tabla += '<th>No.</th>';
                    tabla += '<th>Equipo</th>';
                    tabla += '<th>Tipo</th>';
                    tabla += '<th>Marca</th>';
                    tabla += '<th></th>';
                    tabla += '<th colspan="8"></th>';
                    tabla += '</tr>';
                    tabla += '<tr class="bg-info">';
                    tabla += '<td><strong>' + (i + 1) + '</strong></td>';
                    tabla += '<td>' + data["ip_grupos"][i][0]["nom_grupo"] + '</td>';
                    tabla += evaluarNA(data["ip_tipos"][i][0]["descrip"], 1);
                    tabla += evaluarNA(data["ip_marcas"][i][0]["nom_marca"], 1);
                    tabla += "<td></td>";

                    if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {
                        tabla += "<td><button class='btn btn-primary' id='s_" + data["vr_cotizadet"][i]["id_orden"] + "' onclick='incluirSeccion(this.id,1)' title='Cambiar caracteristicas'><span class='fa fa-arrows-h'></span></button></td>";
                        tabla += "<td><button class='btn btn-primary' id='e_" + data["vr_cotizadet"][i]["id_orden"] + "' onclick='borrarVRCotizadet(this.id,2)' title='Eliminar'><span class='fa fa-remove'></span></button></td>";
                    } else {
                        tabla += '<td></td>';
                        tabla += '<td></td>';
                    }

                    tabla += '<td colspan="8" ></td>';
                    tabla += '</tr>';

                    for (var j = 0; j < data["textosCaracteristicas"][i].length; j++) {

                        tabla += '<tr>';

                        tabla += '<th class="bg-info">' + data["textosCaracteristicas"][i][j][0]["desccarac"] + '</th>';

                        if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {
                            tabla += '<td colspan="8" ><input type="text" id="r_' + data["vr_cotizcar"][i][j]["id_cotcar"] + '" value="' + data["vr_cotizcar"][i][j]["vr_caract"] + '" onkeyup="javascript:this.value = this.value.toUpperCase();" class="form form-control" onchange="cambiarVRCotizcar(this.id,1)"  style="width:100%" /></td>';
                        } else {
                            tabla += '<td colspan="8" >' + data["vr_cotizcar"][i][j]["vr_caract"] + '</td>';
                        }

                        tabla += '</tr>';

                    }

                    tabla += '<tr>';
                    tabla += '<th class="bg-info">Observaciones del equipo</th>';
                    if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {
                        tabla += '<td colspan="8"><textarea rows="4" cols="200" id="o_' + data["vr_cotizadet"][i]["id_orden"] + '"  style="width:100%" onchange="cambiarVRCotizadet(this.id, 2);" class="form form-control" >' + data["vr_cotizadet"][i]["observs"] + ' </textarea></td>';
                    } else {
                        tabla += '<td>' + data["vr_cotizadet"][i]["observs"] + '</td>';
                    }
                    tabla += '</tr>';

                    tabla += '<tr>';
                    tabla += '<th class="bg-info">Cantidad</th>';

                    if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {
                        tabla += '<td><input type="number" id="a_' + data["vr_cotizadet"][i]["id_orden"] + '" min="0" value="' + data["vr_cotizadet"][i]["cantidad"] + '" class="form form-control" onchange="cambiarVRCotizadet(this.id, 1);" /></td>';
                    } else {
                        tabla += '<td>' + data["vr_cotizadet"][i]["cantidad"] + '</td>';
                    }

                    tabla += '<td colspan="4"></td>';

                    tabla += '<th class="bg-info">Valor unidad</th>';

                    if (data["vr_cotiza"][0]["estado"] === 110 || data["vr_cotiza"][0]["estado"] === 113) {

                        datos.precioProducto = redondear(data["vr_cotizadet"][i]["valor_unit"]);
                        datos.iva = data["vr_cotizadet"][i]["iva_referencia"];
                        datos.trm = $("#trm").val();
                        datos.cantidad = data["vr_cotizadet"][i]["cantidad"];

                        precioVenta = redondear(parseFloat(data["vr_cotizadet"][i]["valor_unit"]) * parseFloat(data["vr_cotizadet"][i]["cantidad"]));
                        valorIva = redondear((precioVenta * parseFloat(data["vr_cotizadet"][i]["iva_referencia"])) / 100);
                        valorTotal = redondear(precioVenta + valorIva);
                        valorIva = redondear(precioVenta - valorIva);
                        valorBruto += redondear(precioVenta);
                        totalValorSinIva += redondear(valorIva);

                        tabla += '<td><input type="number" id="v_' + data["vr_cotizadet"][i]["id_orden"] + '" min="0" value="' + precioVenta + '"  class="form form-control" onchange="cambiarVRCotizadet(this.id, 4);" /></td>';
                    } else {
                        tabla += '<td>' + data["vr_cotizadet"][i]["valor_unit"] + '</td>';
                    }

                    tabla += '</tr>';

                }
            }
        }

        tabla += '<tr>';
        tabla += '<td colspan="6"></td>';
        tabla += '<th class="bg-info">IVA</th>';
        tabla += '<td><input type="number" id="i_' + data["vr_cotiza"][0]["id_consecot"] + '" min="0" value="' + datos.iva + '" class="form form-control" disabled /></td>';
        tabla += '</tr>';

        tabla += '<tr>';
        tabla += '<td colspan="6"></td>';
        valorIva = redondear(((valorBruto * datos.iva) / 100) + valorBruto);
        tabla += '<th class="bg-info">Total</th>';
        tabla += '<td><input type="number" id="t_' + data["vr_cotiza"][0]["id_consecot"] + '" min="0" value="' + valorIva.toFixed(2) + '" class="form form-control" disabled /></td>';

        tabla += '</tr>';

    }

    return tabla;
}

function formatearNumero(valor, opcion) {

    var numero = null;

    if (opcion === 1) {
        // Obtener el valor del input
        var numero = $("#" + valor).val();

        // Remover cualquier carácter no numérico
        numero = numero.replace(/[^0-9]/g, '');

        // Formatear el número con separadores de miles
        var numeroFormateado = new Intl.NumberFormat('es-ES').format(numero);

        $("#" + valor).val(numeroFormateado);
    }

    if (opcion === 2) {
        //numero = valor.replace(/[^0-9]/g, '');
        return new Intl.NumberFormat('es-ES').format(valor);
    }


}

function borrarContenidoDivs(data, opcion) {
    if (opcion === 1) {
        for (var i = 0; i < data.length; i++) {
            $("#" + data[i]).html('');
        }
    }
}

function evaluarNA(dato, opcion) {

    if (opcion === 1) {
        if (dato === 'N/A' || dato === 'undefined' || dato === '...') {
            return '<td></td>';
        } else {
            return '<td>' + dato + '</td>';
        }
    }

    if (opcion === 2) {
        if (dato.toString() === 'N/A') {
            return ' ';
        } else {
            return ' - ' + dato + ' ';
        }
    }

}

function verificarArregloCaracteristicas() {

    var retorno = 1;
    if (arregloCaracteristicas.length > 0) {
        for (var i = 0; i < arregloCaracteristicas.length; i++) {

            if ($("#" + arregloCaracteristicas[i]).val().length === 0) {
                retorno = 0;
            }
            caracteristicasRepuestos[i] = $("#" + arregloCaracteristicas[i]).val();
        }
    }

    return retorno;
}

/***
 * 
 * @param {type} datos precioProducto y valor del porcentaje del IVA
 * @param {type} opcion si es para obtener el valor completo 2, si es solo para obtener el valor del IVA 1
 * @returns {Number} 
 */
function retornarPrecioIva(datos, opcion) {

    var valorIva = 0, valorMasIva = 0, retorno = 0;

    if (datos["iva"].length === 1) {
        valorIva = '1.0' + datos["iva"];
    } else {
        valorIva = '1.' + datos["iva"];
    }

    if (opcion === 1) {

        valorMasIva = parseFloat(datos["valor_unit"]) * parseFloat(valorIva);
        retorno = parseFloat(valorMasIva) - parseFloat(datos["precioProducto"]);
    }

    if (opcion === 2) {
        retorno = parseFloat(datos["valor_unit"]) * parseFloat(valorIva);
    }

    return retorno.toFixed(2);
}


//esta funcion retorna el precio en dolares de un producto
//se va a dejar de usar ya que un PA entró a funcionar
//y al parecer no se necesita
function retornarPrecioDolares(datos, opcion) {

    var retorno = 0;

    if (opcion === 1) {
        retorno = (parseFloat(datos["valor_unit"]) * parseFloat(datos["cantidad"])) / parseFloat(datos["trm"]);
    }

    if (opcion === 2) {
        retorno = parseFloat(datos["valor_unit"]) / parseFloat(datos["trm"]);
    }

    return retorno.toFixed(2);
}

function calcularFechaVencimiento(datos, opcion) {
    if (opcion === 1) {

        if ($("#vp_vigencia").val() === '-1') {
            $("#mensajes").html('<div class="callout callout-warning">Por favor seleccione días de vigencia válidos para realizar la operación</div>');
            $("#vp_vigencia").focus();
        } else {
            $("#mensajes").html('');
            var fecha_ini = new Date($("#fecha_ini").val());
            var vigencia = parseInt($("#vp_vigencia").val());
            //sumar los días de vígencia a la fecha_ini
            fecha_ini.setDate(fecha_ini.getDate() + vigencia);
            //establecer la fecha_vence con la fecha obtenida
            $("#fecha_vence").val(fecha_ini.toISOString().split('T')[0]);
        }


    }
}

function incluirSeccion(datos, opcion) {
    if (opcion === 1) {
        $("#divEquipos").show();
        $("#divSuperiorEquiposIniciales").hide();
        var divAnidado = '<div id="divCambiarTipoMarca" class="col-lg-4">';
        divAnidado += '<div class="col-lg-6">';
        divAnidado += '<label></label>';
        divAnidado += '<div><input type="button" value="Aplicar cambio" class="btn btn-primary" onclick="cambiarVRCotizadet(' + datos + ',5)"  /></div>';
        divAnidado += '</div>';
        divAnidado += '<div class="col-lg-6">';
        divAnidado += '<label></label>';
        divAnidado += '<div><input type="button" value="Cancelar" class="btn btn-primary" onclick="location.reload();"  /></div>';
        divAnidado += '</div>';
        divAnidado += '</div>';
        $("#divSuperiorEquipos").append(divAnidado);
    }
}

function cambiarCR(valor, opcion) {

    if (opcion === 1) {

        Swal.fire({
            title: "Confirmar",
            text: "El cambio de este valor podría implicar hacer o no la solicitud DEL REPUESTO al departamento de compras. Esta absolutamente seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                var posicion = parseInt(valor.substr(3, valor.length));

                //el valor que entra en la variable "valor" es "cr_#" donde # es un número de un ciclo
                if ($("#" + valor).prop("checked")) {
                    aCompras[posicion] = 1;
                } else {
                    aCompras[posicion] = 0;
                }
            } else {
                armarTablaProductos(null, 1);
            }
        });
    }

    if (opcion === 2) {

        Swal.fire({
            title: "Confirmar",
            text: "El cambio de este valor podría implicar hacer o no la solicitud DEL EQUIPO al departamento de compras. Esta absolutamente seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                var posicion = parseInt(valor.substr(3, valor.length));

                //el valor que entra en la variable "valor" es "cr_#" donde # es un número de un ciclo
                if ($("#" + valor).prop("checked")) {
                    aCompras[posicion] = 1;
                } else {
                    aCompras[posicion] = 0;
                }
            } else {
                armarTablaEquipos(null, 1);
            }
        });
    }
}

function mostrarTablaRepuestosBodegas(data, opcion) {

    if (opcion === 1) {
        var tabla = '<table class="table">';
        tabla += '<tr>';
        tabla += '<th></th>';
        tabla += '<th>Cod item</th>';
        tabla += '<th>Saldo</th>';
        tabla += '<th>Bodega</th>';

        tabla += '<th>Fecha arribo</th>';
        //tabla += '<th>Semanas arribo</th>';
        tabla += '<th>Usuario</th>';

        tabla += '<th>Ciudad</th>';
        tabla += '</tr>';

        for (var i = 0; i < data.length; i++) {
            tabla += '<tr>';
            tabla += '<td>' + (i + 1) + '</td>';
            tabla += '<td>' + data[i]["cod_item"] + '</td>';
            tabla += '<td align="center">' + data[i]["saldo"] + '</td>';
            tabla += '<td>' + data[i]["nom_bodega"] + '</td>';

            if (data[i]["codbodeg"] === 99) {
                tabla += '<td>' + data[i]["fecha_arribo"] + '</td>';
                //tabla += '<td align="center" >'+data[i]["semanas_arribo"]+'</td>';
            } else {
                tabla += '<td></td>';
                //tabla += '<td></td>';
            }

            if (data[i]["nombreEmpleado"] === null) {
                tabla += '<td></td>';
            } else {
                tabla += '<td>' + data[i]["nombreEmpleado"] + '</td>';
            }

            tabla += '<td>' + data[i]["nom_ciudad"] + '</td>';
            tabla += '</tr>';
        }

        tabla += '</table>';
        return tabla;

    }
}

function cerrarModal(opcion) {
    if (opcion === 1) {
        $("#modalBodegasProductos").removeClass("in");
        $("#modalBodegasProductos").css("display", "none");
    }
}

function crearTablaSucursales(data, opcion) {

    var tabla = '<table class="table table-hover table-sm" id="tablaSucursales">';
    tabla += '<thead>';
    tabla += '<tr class="bg-primary">';
    tabla += '<th>No.</th><th>Nombre</th><th>Dirección</th><th>Teléfono</th><th>Ciudad</th><th>País</th><th>Región</th><th>Estado</th><th></th><th></th>';
    tabla += '</tr>';
    tabla += '</thead>';
    tabla += '<tbody>';

    for (var i = 0; i < data.length; i++) {

        if (suc_cliente === data[i]["id_sucursal"]) {
            tabla += '<tr id="tr_' + data[i]["id_sucursal"] + '" class="callout callout-success">';
        } else {
            tabla += '<tr id="tr_' + data[i]["id_sucursal"] + '">';
        }

        tabla += '<td>' + (i + 1) + '</td>';
        tabla += '<td>' + data[i]["nom_sucur"] + '</td>';
        tabla += '<td>' + data[i]["direccion"] + '</td>';
        tabla += '<td>' + data[i]["telefono"] + '</td>';
        tabla += '<td>' + data[i]["nom_ciudad"] + '</td>';
        tabla += '<td>' + data[i]["nom_pais"] + '</td>';
        tabla += '<td>' + data[i]["nom_region"] + '</td>';

        if (parseInt(data[i]["estado"]) === 1) {
            tabla += '<td>Activo</td>';
        } else {
            tabla += '<td>Inactivo</td>';
        }

        if (opcion === 1) {
            if (permisos.indexOf("M") !== -1) {
                tabla += '<td><button class="btn bg-purple btn-flat" id="nms_' + data[i]["id_sucursal"] + '" onclick="retornarNMSucursal(this.id,2)" title="Modificar" ><span class="fa fa-edit"></span></button></td>';
            } else {
                tabla += '<td></td>';
            }
            tabla += '<td><button class="btn bg-navy btn-flat" id="nmc_' + data[i]["id_sucursal"] + '" name="' + data[i]["nom_sucur"] + '" onclick="retornarNMContactos(this.id,5)" title="Ver contactos" ><span class="fa fa-users"></button></td>';
        }

        if (opcion === 2) {
            tabla += '<td></td>';
            tabla += '<td><button class="btn bg-navy btn-flat" id="nmc_' + data[i]["id_sucursal"] + '" name="' + data[i]["nom_sucur"] + '" onclick="establecerSucursal(this.id,1)" title="Ver contactos" ><span class="fa fa-hand-o-left"></button></td>';
        }


        tabla += '</tr>';
    }

    if (opcion === 1) {
        if (permisos.indexOf("A") !== -1) {
            tabla += '<tr>';
            tabla += '<td><input type="button" class="btn btn-success" value="Adicionar" id="adicionarSucursal" onclick="mostrarFormularioSucursal(1)" /></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>';
            tabla += '</tr>';
        }
    }

    tabla += '</tbody>';



    return tabla;

}

function establecerSucursal(data, opcion) {

    if (opcion === 1) {
        $("#" + data + " span").removeClass("fa fa-hand-o-left").addClass("fa fa-check-square-o");
        $("#id_proveedor").val(data.substr(4, data.length));
    }
}


function establecerCodItem(data, opcion) {
    $("#cod_item").val(data);
    if (opcion === 1) {
        $("#divRepuestosRepetidos").html('');
        retornarIMItems2(null, 7);
    }
}

function armarTablaMantenimientos(data, opcion) {

    var tabla = '<div class="box">';
    tabla += '<div class="box-header with-border">';
    tabla += '<p style="text-align: center;"><strong>Equipos relacionados con la sucursal del cliente</strong></p>';
    tabla += '</div>';
    tabla += '<div class="box-body">';
    tabla += '<table class="table table-bordered" >';
    tabla += '<thead>';
    tabla += '<tr>';
    tabla += '<th></th><th>Código</th><th>Equipo</th><th>Tipo</th><th>Marca</th><th>Nro. parte</th><th>Nro. Serie</th><th>Fecha ultimo mant.</th><th>Tipo mantenimiento a realizar</th>';
    tabla += '</tr>';
    tabla += '</thead>';
    tabla += '<tbody>';

    if (opcion === 1) {
        for (let index = 0; index < data["sr_prog_mant"].length; index++) {

            id_mantenimientos += data["sr_prog_mant"][index]["id_prog"] + '|';

            //tm = tipo_mantenimiento
            tipos_mantenimiento = '<select class="form form-control" id="tm_' + data["sr_prog_mant"][index]["id_prog"] + '">';
            for (let b = 0; b < data["tipos_mantenimiento"].length; b++) {
                if (b === 0) {
                    tipos_mantenimiento += '<option value="-1">...</option>';
                }
                tipos_mantenimiento += '<option value="' + data["tipos_mantenimiento"][b]["cod_grupo"] + '">' + data["tipos_mantenimiento"][b]["nom_grupo"] + '</option>';
            }
            tipos_mantenimiento += '</select>';

            tabla += '<tr>';
            tabla += '<td>' + (index + 1) + '</td><td>' + data["sr_prog_mant"][index]["cod_item"] + '</td><td>' + data["sr_prog_mant"][index]["tipoEquipo"] + '</td><td>' + data["sr_prog_mant"][index]["nom_grupo"] + '</td><td>' + data["sr_prog_mant"][index]["nom_marca"] + '</td><td>' + data["sr_prog_mant"][index]["nro_parte"] + '</td><td>' + data["sr_prog_mant"][index]["nro_serie"] + '</td><td>' + data["sr_prog_mant"][index]["fec_ult_mant"] + '</td><td>' + tipos_mantenimiento + '</td>';
            tabla += '</tr>';

            tipos_mantenimiento = null;
        }
    }

    if (opcion === 2) {
        
        for (let index = 0; index < data["equipos"].length; index++) {

            //tm = tipo_mantenimiento
            tipos_mantenimiento = '<select class="form form-control" id="tm_' + data["vr_requerimdet"][index]["id_reqdet"] + '" onchange="">';
            for (let b = 0; b < data["tipos_mantenimiento"].length; b++) {
                if (b === 0) {
                    tipos_mantenimiento += '<option value="-1">...</option>';
                }

                if (data["vr_requerimdet"][index]["observs"] === data["tipos_mantenimiento"][b]["cod_grupo"]) {
                    tipos_mantenimiento += '<option value="' + data["tipos_mantenimiento"][b]["cod_grupo"] + '" selected >' + data["tipos_mantenimiento"][b]["nom_grupo"] + '</option>';
                } else {
                    tipos_mantenimiento += '<option value="' + data["tipos_mantenimiento"][b]["cod_grupo"] + '">' + data["tipos_mantenimiento"][b]["nom_grupo"] + '</option>';
                }
            }
            tipos_mantenimiento += '</select>';

            tabla += '<tr>';
            tabla += '<td>' + (index + 1) + '</td><td>' + data["vr_requerimdet"][index]["cod_item"] + '</td><td>' + data["equipos"][index][0]["tipoEquipo"] + '</td><td>' + data["equipos"][index][0]["nom_grupo"] + '</td><td>' + data["equipos"][index][0]["nom_marca"] + '</td><td>' + data["equipos"][index]["nro_parte"] + '</td><td>' + data["equipos"][index]["nro_serie"] + '</td><td>' + data["equipos"][index]["fec_ult_mant"] + '</td><td>' + tipos_mantenimiento + '</td>';
            tabla += '</tr>';

            tipos_mantenimiento = null;
        }
    }

    tabla += '</tbody>';
    tabla += '</table>';
    tabla += '</div>';
    tabla += '</div>';

    return tabla;

}