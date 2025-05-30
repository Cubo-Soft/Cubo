function retornarIRCaracte(data, opcion) {

    $("#mensajesContacto").html('');

    var datosAEnviar = [];

    if (opcion === 1 || opcion === 2 || opcion === 3) {

        if (opcion === 1 || opcion === 3) {
            datosAEnviar = {
                'codgrup': $("#" + data).val()
            };
        }

        if (opcion === 2) {
            datosAEnviar = {
                'codgrup': data
            };
        }

        $.ajax({
            url: "../controladores/CT_ir_caracte.php",
            data: {'caso': '1', 'datosAEnviar': datosAEnviar},
            type: "POST",
            success: function (respuesta) {
                var obj = JSON.parse(respuesta);
                var listaCaracteristicas = '';

                if (obj.length > 0) {

                    if (opcion === 1 || opcion === 3) {
                        listaCaracteristicas = '<div class="col-lg-12 bg-gray disabled color-palette" id="divCaracteristicasEquipos">';
                    }

                    if (opcion === 2) {
                        listaCaracteristicas = '<div class="col-lg-12 bg-info disabled color-palette">';
                    }

                    listaCaracteristicas += '<center><label>Caracteristicas a solicitar</label></center>';
                    listaCaracteristicas += '<div>';

                    arregloCaracteristicas = [];
                    textosCaracteristicas = [];

                    for (var i = 0; i < obj.length; i++) {

                        listaCaracteristicas += '<div class="col-lg-12">';
                        listaCaracteristicas += '<div class="col-lg-3"><label>' + obj[i]["desccarac"] + '</label></div>';
                        listaCaracteristicas += '<div class="col-lg-9" id="div' + obj[i]["desccarac"] + '">';
                        listaCaracteristicas += '<input type="text" class="form form-control" id="' + obj[i]["codcarac"] + '" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="' + obj[i]["desccarac"] + '"  />';
                        listaCaracteristicas += '</div>';
                        listaCaracteristicas += '</div>';
                        arregloCaracteristicas.push(obj[i]["codcarac"]);
                        textosCaracteristicas.push(obj[i]["desccarac"]);
                    }

                    if ($("#ip_grupos").val() === '01' || $("#ip_grupos").val() === '04') {

                        listaCaracteristicas += '<div class="col-lg-12">';
                        listaCaracteristicas += '<div class="col-lg-3"><label>Observaciones</label></div>';
                        listaCaracteristicas += '<div class="col-lg-9" id="divObservacionesEquipo">';
                        listaCaracteristicas += '<input type="text" class="form form-control" id="observacionesEquipos" placeholder="Observaciones" onkeyup="javascript:this.value = this.value.toUpperCase();" />';
                        listaCaracteristicas += '</div>';
                        listaCaracteristicas += '</div>';

                        listaCaracteristicas += '<div class="col-lg-12">';
                        listaCaracteristicas += '<div class="col-lg-3"><label>Cantidad</label></div>';
                        listaCaracteristicas += '<div class="col-lg-9" id="divCantidad">';
                        listaCaracteristicas += '<input type="number" class="form form-control" id="cantidadEquipos" placeholder="Cantidad"  />';
                        listaCaracteristicas += '</div>';
                        listaCaracteristicas += '</div>';                        
                    }

                    listaCaracteristicas += '<div class="col-lg-12">';

                    if (opcion === 1) {
                        listaCaracteristicas += '<input type="button" id="btnAgregarCaracteristicasEquipos" name="btnAgregarCaracteristicasEquipos" class="btn btn-success" value="Agregar" onclick="agregarCaracteristicasEquipos(1)" />';
                    }

                    if (opcion === 3) {
                        listaCaracteristicas += '<input type="button" id="btnAgregarCaracteristicasEquipos" name="btnAgregarCaracteristicasEquipos" class="btn btn-success" value="Agregar" onclick="agregarCaracteristicasEquipos(2)" />';
                    }

                    listaCaracteristicas += '<div>';

                } else {

                    if (opcion === 1 || opcion === 3) {
                        listaCaracteristicas = '<div class="callout callout-warning">Pendiente por establecer caracteristicas de este equipo</div>';
                    }

                    if (opcion === 2) {
                        listaCaracteristicas = '';
                    }

                    arregloCaracteristicas = [];
                    textosCaracteristicas = [];

                }

                if (opcion === 1 || opcion === 3) {
                    $("#divCaracteristicasEquipos").html('');
                    $("#divCaracteristicasEquipos").html(listaCaracteristicas);
                }

                if (opcion === 2) {
                    $("#divCaracteristicasBorradores").html('');
                    $("#divCaracteristicasBorradores").html(listaCaracteristicas);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("Error en function retornarIRCaracte(datos, opcion=1) {...\nError desde el servidor. Por favor informe a soporte");
            }
        });
    }
}