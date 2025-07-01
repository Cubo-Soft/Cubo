<?php

session_start();

include_once "./CL_PDF.php";
include_once '../modelos/CL_vr_cotiza.php';
include_once '../modelos/CL_vr_cotizadet.php';
include_once '../modelos/CL_vr_cotizcar.php';
include_once '../modelos/CL_im_items.php';
include_once '../modelos/CL_ip_grupos.php';
include_once '../modelos/CL_ip_tipos.php';
include_once '../modelos/CL_ip_marcas.php';
include_once '../modelos/CL_ir_caracte.php';
include_once '../modelos/CL_nm_sucursal.php';
include_once '../modelos/CL_nm_nits.php';
include_once '../modelos/CL_nm_juridicas.php';
include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_vm_clientesprov.php';
include_once '../modelos/CL_nm_empleados.php';
include_once '../modelos/CL_vp_vigencia.php';
include_once '../modelos/CL_vh_cotizapdf.php';
include_once '../modelos/CL_ap_param.php';
include_once '../cls/varios.php';

$OB_vr_cotiza = new CL_vr_cotiza();
$OB_vr_cotizadet = new CL_vr_cotizadet();
$OB_vr_cotizcar = new CL_vr_cotizcar();
$OB_im_items = new CL_im_items();
$OB_ip_grupos = new CL_ip_grupos();
$OB_ip_tipos = new CL_ip_tipos();
$OB_ip_marcas = new CL_ip_marcas();
$OB_ir_caracte = new CL_ir_caracte();
$OB_nm_sucursal = new CL_nm_sucursal();
$OB_nm_nits = new CL_nm_nits();
$OB_nm_juridicas = new CL_nm_juridicas();
$OB_nm_personas = new CL_nm_personas();
$OB_vm_clientesprov = new CL_vm_clientesprov();
$OB_nm_empleados = new CL_nm_empleados();
$OB_vp_vigencia = new CL_vp_vigencia();
$OB_vh_cotizapdf = new CL_vh_cotizapdf();
$OB_ap_param = new CL_ap_param();

$data_ap_param = $OB_ap_param->leer(null, 1);

$datos["id_consecot"] = $_GET["id_consecot"];
$id_consecot = $_GET["id_consecot"];
$retorno["vr_cotiza"] = $OB_vr_cotiza->leer($datos, 2);
$data_vr_cotiza=$retorno["vr_cotiza"];

$datos["fecha"] = $retorno["vr_cotiza"][0]["fecha_ini"];

$retorno["cm_trm"] = lee_politrm();

$datos["dias"] = $retorno["vr_cotiza"][0]["vigencia"];
$retorno["vp_vigencia"] = $OB_vp_vigencia->leer($datos, 2);

$datos["codemple"] = $retorno["vr_cotiza"][0]["cod_grabador"];
$retorno["nm_empleados"] = $OB_nm_empleados->leer($datos, 2);

$datos["id_sucursal"] = $data_vr_cotiza[0]["suc_cliente"];

$retorno["vr_cotizadet"] = $OB_vr_cotizadet->leer($datos, 3);

$retorno["caracteristicasRepuestos"] = array();

$indice=0;

for ($index = 0; $index < count($retorno["vr_cotizadet"]); $index++) {

    $datos["id_consecot"] = $retorno["vr_cotizadet"][$index]["id_consecot"];
    $datos["id_orden"] = $retorno["vr_cotizadet"][$index]["id_orden"];
    $retorno["vr_cotizcar"][$index] = $OB_vr_cotizcar->leer($datos, 1);

    if ($retorno["vr_cotizadet"][$index]["cod_item"] !== '0' || $retorno["vr_cotizadet"][$index]["cod_item"] !== 'NULL') {

        $datos["cod_item"] = preg_replace('/\s+/', '', $retorno["vr_cotizadet"][$index]["cod_item"]);
        $retorno["caracteristicasRepuestos"][$index] = $OB_im_items->leer($datos, 15);
    } else {
        $retorno["caracteristicasRepuestos"][$index] = array();
    }

    if ($retorno["vr_cotizadet"][$index]["misional"] === '01' || $retorno["vr_cotizadet"][$index]["misional"] === '04') {
        $datos["cod_grupo"] = $retorno["vr_cotizadet"][$index]["articulo"];
        $retorno["ip_grupos"][$index] = $OB_ip_grupos->leer($datos, 3);

        $datos["id_tipo"] = $retorno["vr_cotizadet"][$index]["tipo"];
        $retorno["ip_tipos"][$index] = $OB_ip_tipos->leer($datos, 2);

        $datos["id_marca"] = $retorno["vr_cotizadet"][$index]["marca"];
        $retorno["ip_marcas"][$index] = $OB_ip_marcas->leer($datos, 2);
    } else {

        $retorno["ip_grupos"][$index] = array();
        $retorno["ip_tipos"][$index] = array();
        $retorno["ip_marcas"][$index] = array();
    }

    if (count($retorno["vr_cotizcar"][$index]) > 0) {

        for ($index1 = 0; $index1 < count($retorno["vr_cotizcar"][$index]); $index1++) {

            $indice=$index1;

            $datos["codgrup"] = $retorno["vr_cotizadet"][$index]["articulo"];
            $datos["codcarac"] = $retorno["vr_cotizcar"][$index][$index1]["caract"];

            $retorno["textosCaracteristicas"][$index][$index1] = $OB_ir_caracte->leer($datos, 2);
        }
    } else {

        $retorno["textosCaracteristicas"][$index][$indice] = array();
    }

}

$data_nm_sucursal = $OB_nm_sucursal->leer($datos, 2);
$retorno["nm_sucursal"] = $data_nm_sucursal;

$datos["numid"] = $data_nm_sucursal[0]["numid"];
$retorno["nm_nits"] = $OB_nm_nits->leer($datos, 4);

if ($retorno["nm_nits"][0]["idclase"] === 31) {
    $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 2);
}

if ($retorno["nm_nits"][0]["idclase"] === 13) {
    $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 2);
}

if (count($retorno["nm_nits"]) === 0) {
    $datos["nit_cliente"] = $data_nm_sucursal[0]["numid"];
    $retorno["vm_clientesprov"] = $OB_vm_clientesprov->leer($datos, 1);
}

//inicio de la construcción del pdf 
$OB_cotizacion = new CL_PDF();
$datosGenerales[0] = $data_ap_param;
$datosGenerales[1] = $retorno;
$OB_cotizacion->establecerDatosGenerales($datosGenerales);
$OB_cotizacion->SetMargins(5, 5, 5, 5);
$OB_cotizacion->AddPage();
$OB_cotizacion->mostrarTablaDatosCliente($retorno, 1);
$OB_cotizacion->mostrarTablaRepuestos($retorno, 1);

//actualizar totales de la tabla vr_cotiza
$datos["subtotal"] = floatval($OB_cotizacion->retorno["subTotal"]);
$datos["iva"] = floatval($OB_cotizacion->retorno["totalValorIva"]);
$datos["descuento"] = floatval($OB_cotizacion->retorno["descuento"]);
$datos["vr_descuento"] = floatval($OB_cotizacion->retorno["descuento"]);
$datos["cod_asesor"] = $_SESSION["codusr"];

$OB_vr_cotiza->actualizar($datos, 2);

$datos["nro_cot"] = $retorno["vr_cotiza"][0]["nro_cot"];
$datos["version"] = $retorno["vr_cotiza"][0]["version"];
$data_vh_cotizapdf = $OB_vh_cotizapdf->leer($datos, 1);

if (count($data_vh_cotizapdf) <= 0) {
    $datos["cod_grabador"] = $_SESSION["codusr"];
    $datos["fechora_pdf"] = date("Y-m-d H:m:s");
    $OB_vh_cotizapdf->crear($datos, 1);
}

$nombreCliente = '';
if (isset($retorno["nm_juridicas"]) > 0) {
    $nombreCliente = $retorno["nm_juridicas"][0]["razon_social"];
} else if (count($retorno["nm_personas"]) > 0) {
    $nombreCliente = $retorno["nm_personas"][0]["apelli_nom"];
} else {
    $nombreCliente = $retorno["vm_clientesprov"][0]["nombre"];
}

$nombreCotizacion = "Re_CT_" . $retorno["vr_cotiza"][0]["nro_cot"] . "_" . $retorno["vr_cotiza"][0]["version"];

//verificar existencia de directorio
$directorio = realpath('../cotizaciones');

//guardar en ../cotizaciones
$OB_cotizacion->Output($directorio . '/' . $nombreCotizacion . '.pdf', 'F');
//mostrar en el navegador
$OB_cotizacion->Output($nombreCotizacion . '.pdf', 'I');
