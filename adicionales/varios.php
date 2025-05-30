<?php

//session_start();

//var_dump($_SESSION);

function retornarCabeceraInicial($titulo)
{

    echo '
    <meta charset="utf-8">
            <link rel="shortcut icon" href="../imagenes/app/favicon.png">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>' . $titulo . '</title>
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <script src="../js/modelos/ar_roles.js?ramdom=' . time() . '" type="text/javascript"></script>
            <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css"/>
            <link href="../dist/css/adminLTE.min.css" rel="stylesheet" type="text/css"/>
            <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/morris.js/morris.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/jvectormap/jquery-jvectormap.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css"/>
            <link href="../bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
            <link href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css"/>
            <script src="../bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
            <script src="../bower_components/sweetalert2.all.min.js.js" type="text/javascript"></script>

            <link href="../css/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
            <link href="../css/general.css" rel="stylesheet" type="text/css"/>

            <meta http-equiv="Access-Control-Allow-Origin" content="*">
            <meta http-equiv="Access-Control-Allow-Methods" content="GET, POST, PUT, DELETE, OPTIONS">
            <meta http-equiv="Access-Control-Allow-Headers" content="X-Requested-With, content-type">
            <meta http-equiv="Access-Control-Allow-Credentials" content="true">
            
';
}

function retornarOpcionesIniciales($datos)
{
}

/**
 *
 * @param type $nit = el nit de la empresa que se esta ingresando
 * @return el número digito de verificación
 */
function calcularDigitoVerificacion($nit)
{  // Digito Verificacion Nit-Colombia. Junio 05-2014
    // suministrado por  http://www.forosdelweb.com/f18/digito-verificacion-colombia-938744/
    if (!is_numeric($nit)) {
        return false;
    }

    $arr = array(
        1 => 3,
        4 => 17,
        7 => 29,
        10 => 43,
        13 => 59,
        2 => 7,
        5 => 19,
        8 => 37,
        11 => 47,
        14 => 67,
        3 => 13,
        6 => 23,
        9 => 41,
        12 => 53,
        15 => 71
    );
    $x = 0;
    $y = 0;
    $z = strlen($nit);
    $dv = '';

    for (
        $i = 0;
        $i < $z;
        $i++
    ) {
        $y = substr($nit, $i, 1);
        $x += ($y * $arr[$z - $i]);
    }

    $y = $x % 11;

    if ($y > 1) {
        $dv = 11 - $y;
        return $dv;
    } else {
        $dv = $y;
        return $dv;
    }
}

function retorarCodigoParaListaPHP($datos)
{
    echo '<input type="text" name="' . $datos["idDelCampo"] . '" id="' . $datos["idDelCampo"] . '" class="form-control" list="' . $datos["nombreLista"] . '" placeholder="' . $datos["textoPlaceHolder"] . '" onkeyup="javascript:this.value=this.value.toUpperCase();" value="' . $datos["valorPorDefecto"] . '" />
          <input type="hidden" name="' . $datos["idResultado"] . '" id="' . $datos["idResultado"] . '" value="0"/>
          <div id="DivDataList' . $datos["nombreDataList"] . '"></div>';
}

function precioDolarHoy()
{
    // URL del servicio web del Banco de la República de Colombia
    $url = "https://www.datos.gov.co/resource/32sa-8pi3.json";
    // Realizar la solicitud GET a la API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    // Decodificar la respuesta JSON
    $data = json_decode($response);
    // Verificar si la solicitud fue exitosa y obtener el precio del dólar
    if ($data !== null && !empty($data)) {
        $trm = $data[0]->valor;
        //echo "El precio del dólar hoy en Colombia es: $dolar COP";
    } else {

        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        // Realizar la solicitud GET a la API
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificar la respuesta JSON
        $data = json_decode($response, true);

        // Verificar si la solicitud fue exitosa y obtener el precio del dólar
        if ($data && isset($data['rates']) && isset($data['rates']['COP'])) {
            $trm = $data['rates']['COP'];
        } else {
            $trm = '0000';
        }
    }
    return $trm;
}

function retornarDiv($datos)
{
    echo '<div class="col-lg-' . $datos["tamañoColumna"] . ' form-group">'
        . '<label>' . $datos["etiquetaLabel"] . '</label>'
        . '<div id="' . $datos["nombreDiv"] . '">'
        . '</div>'
        . '</div>';
}

function retornarDivJuridicas($opcion)
{
    echo '<div class="box-body" id="divJuridicas">
            <div class="box box-default">
                <div class="box header with-border">
                    <strong>Jurídicas</strong>
                </div>
                <div class="box-body">
                    <div class="col-lg-12" id="listaJuridicas">

                    </div>
                    <div class="col-lg-12" id="datosJuridicas">
                        <div class="col-lg-12">
                            <div class="col-lg-12 form-group">
                                <label>Razón social</label>
                                <div id="divRazonSocial">';

    if ($opcion === 1 || $opcion === 3) {
        echo '<input type="text" id="razon_social" name="razon_social" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Razón social" />';
    }

    if ($opcion === 2) {
        echo '<input type="text" id="razon_social2" name="razon_social2" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Razón social" />';
    }

    echo '</div>
                            </div>
                        </div>';

    if ($opcion === 1 || $opcion === 2) {
        echo '<div class="col-lg-12" id="mensajesJuridicas">

        </div>
        <div class="col-lg-12">
            <input type="button" value="Modificar" id="modificarJuridica" class="btn btn-primary" />
            <input type="button" value="Adicionar" id="adicionarJuridica" class="btn btn-success" />
            <!--<input type="button" value="Listar sedes" id="listarSucursales" class="btn btn-info" />                             -->
        </div>';
    }

    echo '</div>
                </div>
            </div>
        </div>';
}

function retornarDivPersonasGeneral()
{
    echo '<div class="box-body" id="divPersonasGeneral">
            <div class="box box-default">
                <div class="box-header with-border">
                    <strong>Personas</strong>
                </div>
                <div class="box-body">
                    <div class="col-lg-12" id="listaPersonas">

                    </div>
                    <div class="col-lg-12" id="datosPersonas">
                        <div class="col-lg-12">
                            <div class="col-lg-4 form-group">
                                <label>Nombres</label>
                                <div id="divNombresPersona">
                                    <input type="text" id="nombres" name="nombres" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Nombres" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Apellidos</label>
                                <div id="divApellidosPersona">
                                    <input type="text" id="apellidos" name="apellidos" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Apellidos" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Sexo</label>
                                <div id="divSexoPersona">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-4 form-group">
                                <label>Estado civíl</label>
                                <div id="divEstadoCivilPersona">
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Fecha de nacimiento</label>
                                <div id="divFechaNacimientoPersona">
                                    <input type="date" id="fecha_naci" name="fecha_naci" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Tipo de sangre</label>
                                <div id="divTipoSangrePersona">

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="mensajesPersonas">

                        </div>
                        <div class="col-lg-12">
                            <input type="button" value="Modificar" id="modificarPersona" class="btn btn-primary" />
                            <input type="button" value="Adicionar" id="adicionarPersona" class="btn btn-success" />
                            <input type="button" value="Limpiar" id="limpiarPersona" class="btn btn-info" onclick="location.reload();" />
                            <!--<input type="button" value="Listar sedes" id="listarSucursales" class="btn btn-info" />                             -->
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}

function retornarDivSucursalesGeneral()
{
    echo '<div class="box-body" id="divSucursalesGeneral">
            <div class="box box-default">
                <div class="box-header with-border">
                    <strong>Sedes</strong>
                </div>
                <div class="box-body">
                    <input type="hidden" id="id_sucursal" name="id_sucursal" value="0" />
                    <div class="col-lg-12" id="listaSucursales">

                    </div>
                    <div class="col-lg-12" id="datosSucursales">
                        <div class="col-lg-12">
                            <div class="col-lg-4 form-group">
                                <label>Ciudad - País</label>
                                <div id="divCiudades">
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Nombre de la sede</label>
                                <div id="divNombreSucursal">
                                    <input type="text" id="nom_sucur" name="nombre_sucur" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Nombre de la sucursal" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Teléfono</label>
                                <div id="divTelefono">
                                    <input type="number" id="telefono" name="telefono" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" value="0" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-3 form-group">
                                <label>Dirección</label>
                                <div id="divDireccion">
                                    <input type="text" id="direccion" name="direccion" class="form form-control" onblur="codeAddress()" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Dirección" />
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label>Latitud</label>
                                <input type="text" id="suc_lat_gps" name="suc_lat_gps" class="form form-control" value="0" disabled="disabled" />
                            </div>
                            <div class="col-lg-3 form-group">
                                <label>Longitud</label>
                                <input type="text" id="suc_lng_gps" name="suc_lng_gps" class="form form-control" value="0" disabled="disabled" />
                            </div>';

    $datos["tamañoColumna"] = 3;
    $datos["etiquetaLabel"] = 'Región';
    $datos["nombreDiv"] = 'divSubZonas';
    retornarDiv($datos);

    echo '</div>
                        <div class="col-lg-12">
                            <div class="col-lg-3 form-group">
                                <label>Teléfono 2</label>
                                <div id="divTelefono">
                                    <input type="text" id="telefono2" name="telefono2" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" value="0"/>
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label>FAX</label>
                                <div id="divFax">
                                    <input type="text" id="fax" name="fax" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" value="0" />
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label>Código Helisa</label>
                                <div id="divCodigoHelisa">
                                    <input type="text" id="codigo_helisa" name="codigo_helisa" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" value="0"/>
                                </div>
                            </div>
                            <div class="col-lg-3 form-group">
                                <label>Estado</label>
                                <div id="divEstadoSede">
                                    <input type="checkbox" id="estadoSede" name="estadoSede" class="form-check-input" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12" id="ubicacionGeograficaSucursales">
                            <div id="map" style="width: 100%; height: 300px;" >
                                <canvas id="map"></canvas>
                            </div>
                        </div>
                        <div id="mensajesUbicacion" class="col-lg-12">

                        </div>
                        <div class="col-lg-12">
                            <input type="button" value="Modificar" id="modificarSucursal" class="btn btn-primary" />
                            <input type="button" value="Adicionar" id="adicionarSucursal1" class="btn btn-success" />
                            <input type="button" value="Listar sedes" id="listarSucursales" class="btn btn-info" />                            
                        </div>
                    </div>
                </div>
            </div>
        </div>';
}

function retornarDivContactosGeneral($opcion)
{
    echo '<div class="box-body" id="divContactosGeneral">
            <div class="box box-default">
                <div class="box-header with-border">
                    <strong>Contactos <span id="navNombreSucursal"></span></strong>
                </div>
                <div class="box-body" >
                    <div class="col-lg-12" id="divContactos">

                    </div>
                    <div class="col-lg-12" id="editarCrearContacto">
                        <div class="col-lg-12">
                            <input type="hidden" id="id_contacto" name="id_contacto" />
                            <div class="col-lg-4 form-group">
                                <label>Nro. de identificación</label>
                                <div id="divNroIdentificacionContacto">';

    if ($opcion === 1) {
        echo '<input type="number" id="cc_contacto" name="cc_contacto" class="form form-control" placeholder="Nro. de identificación" />';
    }

    if ($opcion === 2) {

        $datos['idDelCampo'] = 'cc_contacto';
        $datos['nombreLista'] = 'cc_contactos';
        $datos['idResultado'] = 'id_contacto_1';
        $datos['nombreDataList'] = 'Identificaciones';
        $datos['textoPlaceHolder'] = 'Nro. de identificación';
        $datos['valorPorDefecto'] = '0';
        echo retorarCodigoParaListaPHP($datos);
    }
    echo '

                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Nombre</label>
                                <div id="divNombreContacto">
                                ';
    if ($opcion === 1) {
        echo '<input type="text" id="nom_contacto" name="nom_contacto" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Nombre" />';
    }

    if ($opcion === 2) {
        $datos['idDelCampo'] = 'nom_contacto';
        $datos['nombreLista'] = 'nom_contactos';
        $datos['idResultado'] = 'id_contacto_2';
        $datos['nombreDataList'] = 'Contactos';
        $datos['textoPlaceHolder'] = 'Apellidos y nombres del contacto';
        $datos['valorPorDefecto'] = '';
        echo retorarCodigoParaListaPHP($datos);
    }


    echo '</div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Cargo</label>
                                <div id="divCargoContacto">
                                    <input type="text" id="cargo" name="cargo" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Cargo" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="col-lg-4 form-group">
                                <label>Teléfono</label>
                                <div id="divNroTelefonoContacto">
                                    <input type="text" id="tel_contacto" name="tel_contacto" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Teléfono" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label>Correo electrónico</label>
                                <div id="divCorreoContacto">
                                    <input type="email" id="email" name="email" class="form form-control" placeholder="Correo electrónico" />
                                </div>
                            </div>
                            <div class="col-lg-4 form-group">
                                <label id="lblEstadoContacto">Estado</label>
                                <div id="divEstadoContacto">
                                    <input type="checkbox" id="estadoContacto" name="estadoContacto" class="form-check-input" />
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="mensajesContacto" class="col-lg-12">

                    </div>
                    <div class="col-lg-12">
                        <input type="button" value="Modificar" id="modificarContacto" class="btn btn-primary" />
                        <input type="button" value="Adicionar" id="adicionarContacto" class="btn btn-success" />
                        <input type="button" value="Listar contactos" id="listarContactos" class="btn btn-info" />';

    if ($opcion === 2) {
        echo '<input type="button" value="Limpiar" id="nuevaBusqueda" class="btn btn-info" onclick="location.reload();"/>';
    }
    echo '
                    </div>
                </div>
            </div>
        </div>';
}

function retornarDivClientesProvisionales($opcion)
{
    echo '<!-- CP ClienteProvisional -->
                <div class="box-body" id="divClientesProvisionales">
                    <input type="hidden" id="clienteProvisional" value="0" />
                    <input type="hidden" id="clienteProvisionalExiste" value="0" />
                    <input type="hidden" id="id_provis" value="0" />
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Clientes provisionales</strong>
                        </div>
                        <div class="box-body" id="divBodyClientesProvisionales">
                            <div class="col-lg-12">
                                <div class="col-lg-4 form-group">
                                    <label>NIT</label>
                                    <div id="divNITClienteCP">
                                        <input type="text" id="nit_cliente_cp" name="nit_cliente_cp" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" value="0" placeholder="NIT" />
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Nombre</label>
                                    <div id="divNombreCP">
                                        <input type="text" id="nombre_cp" name="nombre_cp" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Nombres y apellidos" />
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Dirección</label>
                                    <div id="divDireccionCP">
                                        <input type="text" id="direccion_cp" name="direccion_cp" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Dirección" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-4 form-group">
                                    <label>Teléfono</label>
                                    <div id="divTelefonoCP">
                                        <input type="text" id="telefono_cp" name="telefono_cp" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Teléfono" />
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Correo Electrónico</label>
                                    <div id="divEMailCP">
                                        <input type="email" id="email_cp" name="email_cp" class="form form-control" placeholder="Correo electrónico" />
                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label>Contacto</label>
                                    <div id="divContactoCP">
                                        <input type="text" id="contacto_cp" name="contacto_cp" class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" placeholder="Contacto" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-4 form-group">
                                    <label>Región</label>
                                    <div id="divRegionCP">

                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label></label>
                                    <div id="">

                                    </div>
                                </div>
                                <div class="col-lg-4 form-group">
                                    <label></label>
                                    <div id="">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="mensajesClientesProvisionales">

                            </div>
                            <div class="col-lg-12">
                                <input type="button" value="Modificar" id="modificarClienteProvisional" class="btn btn-primary" />
                                <input type="button" value="Adicionar" id="adicionarClienteProvisional" class="btn btn-success" />
                                <input type="button" value="Limpiar" id="nuevaClientesProvisionales" class="btn btn-info" onclick="location.reload();"/>
                            </div>
                        </div>
                    </div>
                </div>';
}

function retornarDivDatosInicialesEmpresa($opcion)
{
    echo '<div class="box-body" id="datosInicialesEmpresa">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Datos de la empresa</strong>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-lg-6 form-group">
                                    <label>Nro. de identificación</label>
                                    <div id="divIdentificacion">';

    $datos['idDelCampo'] = 'numid';
    $datos['nombreLista'] = 'nm_juridicas_1';
    $datos['idResultado'] = 'numid_2';
    $datos['nombreDataList'] = 'Juridicas';
    $datos['textoPlaceHolder'] = 'Nro. de identificación';
    $datos['valorPorDefecto'] = '0';
    echo retorarCodigoParaListaPHP($datos);

    echo '</div>
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>Razón social</label>
                                    <div id="divRazonSocial">';

    $datos['idDelCampo'] = 'razon_social';
    $datos['nombreLista'] = 'razon_social_1';
    $datos['idResultado'] = 'num_id3';
    $datos['nombreDataList'] = 'RazonSocial';
    $datos['textoPlaceHolder'] = 'Razón social';
    $datos['valorPorDefecto'] = '';
    echo retorarCodigoParaListaPHP($datos);

    echo '</div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <input type="button" value="Limpiar" id="nuevaClientesProvisionales" class="btn btn-info" onclick="location.reload();"/>
                            </div>
                        </div>
                    </div>
                </div>';
}

function retornarDivInicialRequerimiento($datos, $opcion)
{
    echo '<section class="content-header">
                    <h3>' . $datos["texto"] . '</h3>
                </section>
                <div class="box-body">
                    <div class="box box-primary">

                    </div>
                    <div class="box-body">
                        <div class="col-lg-12">';

    if ($opcion === 1) {
        echo '<div class="col-lg-6">
                                    <label>Fuente</label>
                                    <div id="divFuentes"></div>
                                </div>
                                <div class="col-lg-6" id="divBotonesBusqueda">
                                    <label>Buscar por</label>
                                    <div>
                                        <input type="button" class="btn btn-info" id="btnBuscarPorContacto" name="btnBuscarPorContacto" value="Contacto" />
                                        <input type="button" class="btn btn-info" id="btnBuscarPorEmpresa" name="btnBuscarPorEmpresa" value="Empresa" />
                                    </div>
                                </div>';
    }

    if ($opcion === 2) {
        echo '<div class="col-lg-6">
                <label>Fuente</label>
                <div id="divFuentes"></div>
              </div>
              <div class="col-lg-6">
                <label>Requerimiento número: </label>
                <div id="numeroRequerimiento"></div>
              </div>';
    }

    if ($opcion === 3) {
        echo '                  <div class="col-lg-2">
                                    <label>Cotización número</label>
                                    <div id="divNumeroCotizacion"></div>
                                </div>
                                <div class="col-lg-2">
                                        <label>Versión</label>
                                        <div id="divVersionCotizacion">
                                            <input type="number" value="0" class="form form-control" id="version" disabled style="border:none;"/>
                                        </div>
                                </div>
                                <div class="col-lg-2">
                                        <label>Fecha cotización</label>
                                        <div id="divFechaCotizacion">
                                        <input type="date" class="form form-control" id="fecha_ini" name="fecha_ini" disabled style="border:none;"/>
                                        </div>
                                </div>                
                                <div class="col-lg-2">
                                        <label>Días de vigencia</label>
                                        <div id="divDiasVigencia"></div>
                                </div>                
                                <div class="col-lg-2">
                                        <label>Fecha vencimiento</label>
                                        <div id="divFechaVenceCotizacion">
                                            <input type="date" class="form form-control" id="fecha_vence" name="fecha_vence" readonly="readonly" />
                                        </div>
                                </div>                                                                    
                                <div class="col-lg-2" id="divTRM">
                                        <label>TRM</label>
                                        <div class="col-lg-12" id="divValorTRM">
                                        ' . $datos["trm"] . '
                                        </div>                                        
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="col-lg-2" >
                                    <label>Transacción base</label>
                                    <div class="col-lg-12" id="divTransaccionBase">
                                    <input type="text" class="form form-control" id="trans_base" value="1" disabled />    
                                    </div>
                                </div>
                                <div class="col-lg-2" >
                                    <label>Semanas entrega</label>
                                    <div class="col-lg-12" id="semanasEntrega">
                                        <input type="number" class="form form-control" id="sem_entrega" value="1" />
                                    </div>
                                </div>
                            </div>';
    }


    echo '
                        </div>
                        <div class="col-lg-12">
                            <div id="mensajes" class="col-lg-12"></div>
                        </div>
                    </div>
                </div>';
}

function retornarDivParametrosIniciales($opcion)
{
    echo '<div class="box-body" id="divParametrosIniciales">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <strong>Parametros iniciales</strong>
                        </div>
                        <div class="box-body">
                        <div class="col-lg-12">';

    $label = "Sugerencia asignación del requerimiento";

    if (intval($_SESSION["id_rol"]) <= 4) {
        $label = "Asesor asignado";
    }

    if ($opcion === 1) {
        echo '<div class="col-lg-4">
                            <label>Línea</label>
                            <div id="divLineasMisionales"></div>
                        </div>
                        <div class="col-lg-4">
                            <label>Sub linea</label>
                            <div id="divLineas"></div>
                        </div>
                        <div class="col-lg-4">
                            <label>' . $label . '</label>
                            <div id="divSugerencia"></div>
                        </div>';
    }

    if ($opcion === 2) {
        echo '<div class="col-lg-6">
                            <label>Línea</label>
                            <div id="divLineasMisionales"></div>
                        </div>
                        <div class="col-lg-6">
                            <label>Sub linea</label>
                            <div id="divLineas"></div>
                        </div>';
    }

    echo '</div>
                            <div class="col-lg-12" id="mensajesParametrosIniciales"></div>
                        </div>
                    </div>
                </div>';
}

function retornarDivRepuestos($opcion)
{

    if ($opcion === 1) {

        echo '<div class="box-body" id="divRepuestos">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div id="textoUnido">

                            </div>
                        </div>
                        <div class="box-body">

                        <div class="col-lg-12 bg-info disabled color-palette">
                                <center><label>Primer filtro por referencias</label></center>
                            </div>

                            <div class="col-lg-12 bg-gray disabled color-palette">
                                <label id="divTextoFiltrosIniciales"></label>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <label>Referencia interna</label>';
        $datos['idDelCampo'] = 'cod_item';
        $datos['nombreLista'] = 'cod_item_1';
        $datos['idResultado'] = 'cod_item_2';
        $datos['nombreDataList'] = 'Items';
        $datos['textoPlaceHolder'] = 'Referencia interna';
        $datos['valorPorDefecto'] = '';
        echo retorarCodigoParaListaPHP($datos);

        echo '</div>
                                    <div class="col-lg-4">
                                        <label>Referencia alterna</label>';
        $datos['idDelCampo'] = 'alter_item';
        $datos['nombreLista'] = 'alter_item_1';
        $datos['idResultado'] = 'alter_item_2';
        $datos['nombreDataList'] = 'ItemsDos';
        $datos['textoPlaceHolder'] = 'Referencia alterna';
        $datos['valorPorDefecto'] = '';
        echo retorarCodigoParaListaPHP($datos);
        echo '</div>
                                    <div class="col-lg-4">                                    
                                        <label>Nombre artículo</label>';
        $datos['idDelCampo'] = 'nom_item';
        $datos['nombreLista'] = 'nom_item_1';
        $datos['idResultado'] = 'nom_item_2';
        $datos['nombreDataList'] = 'ItemsTres';
        $datos['textoPlaceHolder'] = 'Nombre artículo';
        $datos['valorPorDefecto'] = '';
        echo retorarCodigoParaListaPHP($datos);
        echo '</div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divRepuestosRepetidos">

                            </div>
                            <div class="col-lg-12 bg-info disabled color-palette">
                                <center><label id="divTextoRepuestos">Segundo filtro por grupos, tipos, marcas y demás</label></center>
                            </div>
                            <div class="col-lg-12 bg-gray disabled color-palette" id="divFiltrosRepuestos1">                            
                                <div class="col-lg-3">
                                    <center><label>Grupos</label></center>
                                    <div id="divProductosIniciales">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <center><label>Tipo</label></center>
                                    <div id="divTipos">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <center><label>Marca</label></center>
                                    <div id="divMarcas">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                <center><label>Foto</label></center>
                                <div id="divFoto">

                                </div>
                            </div>                                
                            </div>
                            <div class="col-lg-12 bg-gray disabled color-palette" id="divFiltrosRepuestos2" >
                            <div class="col-lg-3">
                                    <center><label>Modelo</label></center>
                                    <div id="divModelos">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <center><label>Dimensiones</label></center>
                                    <div id="divDimensiones">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <center><label>Unidad de medida</label></center>
                                    <div id="divUnidadMedida">

                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <center><label>Código del producto</label></center>
                                    <div id="divCodigosArticulos">

                                    </div>
                                </div>
                               
                            </div>
                            <div class="col-lg-12 bg-gray disabled color-palette " id="divProductosBorradores">

                            </div>
                            <div class="col-lg-12 bg-gray disabled color-palette " id="divCaracteristicasBorradores">

                            </div>
                            <div class="col-lg-12 bg-gray disabled color-palette" id="divCantidadRepuestos">
                                <div class="col-lg-2">
                                    <label>Cantidad</label>
                                    <div id="divCantidad">
                                        <input type="number" id="cantidadRepuestos" name="cantidadRepuestos"  value="0" class="form form-control" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label>Notas del producto</label>
                                    <div id="divNotasProducto">
                                        <input type="text" id="notasRepuestos" name="notasRepuestos" placeholder="Notas del producto"  class="form form-control" onkeyup="javascript:this.value = this.value.toUpperCase();" />
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label></label>
                                        <div>
                                            <input type="button" id="btnAgregarRepuestos" name="btnAgregarRepuestos" class="btn btn-success" value="Agregar" />                                    
                                            <input type="button" id="btnLlamarPUBodegas" name="btnLlamarPUBodegas" class="btn btn-success" value="Otras bodegas" data-toggle="modal" data-target="#modalBodegasProductos" />                                    
                                        </div>                                    
                                </div>
                            </div>
                            <div class="col-lg-12" class="bg-gray disabled color-palette">
                                <div id="divMensajesRepuestos">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
}

function retornarDivModales($datos, $opcion)
{

    if ($opcion === 1) {

        echo '<div class="modal fade" id="modalBodegasProductos" style="display: none;">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="cerrarModal(1)">
                <span aria-hidden="true">×</span></button>
              <h4 class="modal-title">' . $datos["titulo"] . '</h4>
            </div>
            <div class="modal-body">
              <div id="divTablaBodegasProductos" class="col-lg-12">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline pull-left" data-dismiss="modal" onclick="cerrarModal(1)" >Cerrar</button>              
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>';
    }
}

function retornarDivExistenciaMinima($datos, $opcion)
{
    if ($opcion === 1) {
        echo '<div id="divExistenciaMinima"></div>';
    }
}

function retornarDivEmpleados($opcion)
{
    echo '<div class="box-body" id="divEmpleadosGeneral">
    <div class="box box-default">
        <div class="box-header with-border">
            <strong>Empleados <span id="navNombreSucursal"></span></strong>
        </div>
        <div class="box-body" >
            <div class="col-lg-12" id="divEmpleados">

            </div>
            <div class="col-lg-12" id="editarCrearEmpleados">
                <div class="col-lg-12">                    
                    <div class="col-lg-3 form-group">
                        <label>Código empleado</label>
                        <div id="divCodEmpleado">
                            <input type="text" id="codemple" name="codemple" class="form form-control" placeholder="Código empleado" />
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label>Fecha ingreso</label>
                        <div id="divFechaIngresoEmpleado">
                            <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="form form-control" placeholder="Fecha ingreso" />
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label>Fecha retiro</label>
                        <div id="divFechaRetiroEmpleado">
                            <input type="date" id="fecha_retiro" name="fecha_retiro" class="form form-control" placeholder="Fecha retiro" />
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label>Estado</label>
                        <div id="divEstadoEmpleado">
                        <input type="checkbox" id="estadoEmpleado" name="estadoEmpleado" class="form-check-input" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-3 form-group">
                        <label>Cargo</label>
                        <div id="divCargoEmpleado">
                            
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label>Nivel</label>
                        <div id="divNivelEmpleado">
                            
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label id="lblContratoEmpleado">Contrato</label>
                        <div id="divContratoEmpleado">                            
                        </div>
                    </div>
                    <div class="col-lg-3 form-group">
                        <label id="lblCesantiasEmpleado">Cesantias</label>
                        <div id="divCesantiasEmpleado">                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-4 form-group">
                        <label>Pensión</label>
                        <div id="divPensionEmpleado">
                            
                        </div>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label>EPS</label>
                        <div id="divEPSEmpleado">
                            
                        </div>
                    </div>
                    <div class="col-lg-4 form-group">
                        <label id="lblUsuarioEmpleado">Usuario</label>
                        <div id="divUsuarioEmpleado">     
                            <input type="text" id="usuario" name="usuario" class="form form-control" placeholder="Usuario" />
                        </div>
                    </div>                    
                </div>
            </div>
            <div id="mensajesEmpleado" class="col-lg-12">

            </div>
            <div class="col-lg-12">
                <input type="button" value="Modificar" id="modificarEmpleado" class="btn btn-primary" />
                <input type="button" value="Adicionar" id="adicionarEmpleado" class="btn btn-success" />                
            </div>
        </div>
    </div>
</div>';
}

function retornarDivUsuarios($opcion)
{
    echo '<div class="box-body" id="divUsuariosGeneral">
    <div class="box box-default">
        <div class="box-header with-border">
            <strong>Usuarios <span id="navNombreUsuarios"></span></strong>
        </div>
        <div class="box-body" >
            <div class="col-lg-12" id="divUsuario">

            </div>
            <div class="col-lg-12" id="editarCrearUsuario">
                <div class="col-lg-12">                    
                    <div class="col-lg-3 form-group" id="divFotoEmpleado2">
                        <label>Foto</label>
                        <div id="divFotoEmpleado">                            
                        </div>
                    </div>';
    $datos["tamanio"] = 3;
    $datos["nombreDivInterno"] = "CrearFotoEmpleado";
    $datos["nombreDivExterno"] = "SubirFoto";
    echo retornarSeccionFoto($datos, 1);
    echo '</div>                
            </div>
            <div id="mensajesUsuario" class="col-lg-12">

            </div>
            <div class="col-lg-12">
                <input type="button" value="Modificar" id="modificarUsuario" class="btn btn-primary" />
                <input type="button" value="Adicionar" id="adicionarUsuario" class="btn btn-success" />                
            </div>
        </div>
    </div>
</div>';
}


function retornarSeccionFoto($datos, $opcion)
{

    if ($opcion === 1) {
        echo '<div class="col-lg-' . $datos["tamanio"] . '" form-group" id="div' . $datos["nombreDivExterno"] . '">
    <label>Foto</label>
    <div id="div' . $datos["nombreDivInterno"] . '">                                                                                
        <form action="#" method="POST" id="formularioFoto" name="formularioFoto" enctype="multipart/form-data">
            <input type="file" id="foto" name="foto" class="form form-control" accept=".jpg,.png">                                
            <input type="submit" id="cambiarFoto" name="cambiarFoto" class="btn btn-primary" value="Subir imagen" >
            <label class="alert alert-warning">Por favor solo imagenes png o jpg. Gracias</label>                                                                                        
        </form>                            
    </div>
</div>';
    }
}


function retornarDivEquipos($opcion)
{
    echo '                <div id="divEquipos">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div id="textoUnido2">

                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12" id="divSuperiorEquipos" >
                                <div class="col-lg-4" id="divSuperiorEquiposIniciales">
                                    <label>Equipos</label>
                                    <div id="divEquiposIniciales">

                                    </div>
                                </div>
                                <div class="col-lg-4" id="divSuperiorTipos">
                                    <label>Tipo</label>
                                    <div id="divTipos1">

                                    </div>
                                </div>
                                <div class="col-lg-4" id="divSuperiorMarcas">
                                    <label>Marca</label>
                                    <div id="divMarcas1">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" id="divCaracteristicasEquipos">

                            </div>

                            <div class="col-lg-12" id="divMensajesEquipos">

                            </div>
                        </div>
                    </div>
                </div>';
}

function retornarDivServiciosMantenimiento($opcion)
{
    echo '<div id="divServicioMantenimiento">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div id="textoUnido3">

                            </div>
                        </div>
                        <div class="box-body">
                            <div class="col-lg-12">
                                <div class="col-lg-3">
                                    <label>Servicios</label>
                                    <div id="divServiciosMantenimientoIniciales">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
}

function retornarDivFinalRequerimientos($datos, $opcion)
{
    echo '<div class="box-body">
                    <div class="box-header with-border">
                        <!--<strong>Productos finales</strong>-->
                    </div>
                    <div class="box-body">
                        <div class="col-lg-12">
                            <div id="divProductosFinales" class="scrollable-div" ></div>
                            <div id="divEquiposFinales" class="scrollable-div" ></div>
                            <div id="divMantenimientosFinales" class="scrollable-div" ></div>
                            <div id="divProyectosFinales" class="scrollable-div" ></div>
                        </div>
                        <div class="col-lg-12">';
    if ($opcion === 1) {
        echo '<div class="col-lg-12 form-group" id="divObservacionesSuperior">
                                <label>Observaciones</label>
                                <div id="divObservaciones">
                                    <textarea rows="3" cols="70" class="form form-control" id="textAreaObservaciones" onkeyup="javascript:this.value = this.value.toUpperCase();" ></textarea>
                                </div>
                            </div>';
    }

    if ($opcion === 2 || $opcion === 3) {
        echo '<div class="col-lg-12 form-group" id="divObservacionesSuperior">
                                <label>Observaciones</label>
                                <div id="divObservaciones">
                                    <textarea rows="3" cols="70" class="form form-control" id="textAreaObservaciones" onkeyup="javascript:this.value = this.value.toUpperCase();" ></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 form-group">
                            <input type="button" class="btn btn-success" id="btnActualizarObservaciones" name="btnActualizarObservaciones" value="Actualizar observaciones" />
                            </div>';
    }

    if ($opcion === 1 || $opcion === 2) {
        echo '</div>
                    </div>
                    <div class="form-group" id="divNuevoDTBasico">
                        <div class="col-lg-12">
                            <div class="col-lg-4" id="divEstadosRequerimiento">
                                <label>Estado del requerimiento</label>
                                <div id="estadosRequerimiento">

                                </div>
                            </div>
                            <div class="col-lg-4" id="divBotonRecargar">';
    }

    if ($opcion === 3) {
        echo '</div>
                    </div>
                    <div class="form-group" id="divNuevoDTBasico">
                        <div class="col-lg-12">
                            <div class="col-lg-4" id="divEstadosCotizacion">
                                <label>Estado de la cotizacion</label>
                                <div id="estadosCotizacion">

                                </div>
                            </div>
                            <div class="col-lg-4" id="divBotonRecargar">
        <br/>';
    }

    if ($opcion === 2) {
        echo '<input type="button" class="btn btn-success" id="btnEditarRequerimiento" name="btnEditarRequerimiento" value="Actualizar estado" title="Actualizar estado" />';
        echo '<input type="button" value="Limpiar" class="btn btn-info" id="botonLimpiarAbajo" onclick="location.reload();"/>
              <!--<input type="button" value="Ver Requerimientos" title="Ver requerimientos" class="btn btn-info" id="verRequerimientos" onclick="window.location.href = \'listados.php\'"/>-->
              <input type="button" value="Crear solicitudes a compras" title="Enviar solicitudes a compras" id="solicitudACompras" name="0" class="btn btn-success" />';
    }

    if ($opcion === 3) {
        echo '<button class="btn btn-success" id="btnGuardarCotizacion" name="btnGuardarCotizacion" title="Guardar cambios"  ><span class="fa fa-save"></span></button>
        <button class="btn btn-success" id="btnGenerarPDFRepuestos" name="btnGenerarPDFRepuestos" title="Ver PDF"  ><span class="fa fa-file-pdf-o"></span></button>        
        <button class="btn btn-info" id="btnEnviarPDFRepuestos" name="btnEnviarPDFRepuestos" title="Enviar cotización de repuestos"  ><span class="fa fa-send-o"></span></button>
        <!--<button class="btn btn-danger" id="btnRevisarEquipos" name="btnRevisarEquipos" title="Revisar equipos"  ><span class="fa fa-tasks"></span></button>
        <button class="btn btn-info" id="btnRevisarRepuestos" name="btnRevisarRepuestos" title="Revisar repuestos"  ><span class="fa fa-cog"></span></button>-->
        <button class="btn btn-success" id="btnGenerarPDFEquipos" name="btnGenerarPDFEquipos" title="Ver PDF"  ><span class="fa fa-file-pdf-o"></span></button>        
        <button class="btn btn-info" id="btnEnviarPDFEquipos" name="btnEnviarPDFEquipos" title="Enviar cotización de equipos"  ><span class="fa fa-send-o"></span></button>';
    }



    if ($opcion === 1 || $opcion === 2) {
        echo ' <input type="button" value="Iniciar cotización" title="Iniciar cotización" id="iniciarCotizacion" name="0" class="btn btn-success" />
            <!--<input type="button" value="Crear solicitudes a compras" title="Enviar solicitudes a compras" id="solicitudACompras" name="0" class="btn btn-info" /> -->
            <input type="button" value="Tomar otro requerimiento" title="Tomar otro requerimiento" id="tomarOtroRequerimiento" name="0" class="btn btn-success" />
            </div>
                            <div class="col-lg-4" id="divBotonGrabarRequerimiento">
                                <label></label>
                                <div>';
    }

    if ($opcion === 1) {
        echo '<input type="button" class="btn btn-success" id="btnCrearRequerimiento" name="btnCrearRequerimiento" value="Crear requerimiento" />';
    }

    echo '</div>
                            </div>
                            <div class="col-lg-12" id="divMensajesRequerimientos"></div>
                        </div>
                    </div>
                </div>';
}

function retornarPrecioDolares($datos, $opcion)
{

    $retorno = 0;

    if ($opcion === 1) {
        $retorno = floatval($datos["precioProducto"]) / floatval($datos["trm"]);
    }

    return number_format($retorno, 2);
}

function redondear_hacia_arriba($numero)
{
    return (int) ceil($numero);
}

function redondear($numero)
{
    if ($numero === 0) {
        return 0;
    } else {
        $decimales = explode(".", $numero);
        $tieneDecimales = count($decimales) > 1;
        $cifraDecimal = $tieneDecimales ? $decimales[1][0] : null;
        return $tieneDecimales ? (redondear_hacia_arriba($numero) - $numero) >= 0.5 ? $numero + 1 : $numero : $numero;
    }
}
