<?php

session_start();

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
include_once '../modelos/CL_vm_dsctos_especiales.php';
include_once '../modelos/CL_vp_limites.php';
include_once '../modelos/CL_nm_contactos.php';

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
$OB_vp_limites = new CL_vp_limites();
$OB_vm_dsctos_especiales = new CL_vm_dsctos_especiales();
$OB_nm_contactos = new CL_nm_contactos();

if ($_POST["caso"] === '1') {

    $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
    $id_consecot = $_POST["datosAEnviar"]["id_consecot"];

    $retorno["vr_cotiza"] = $OB_vr_cotiza->leer($datos, 2);

    $datos["id_sucursal"] = $retorno["vr_cotiza"][0]["suc_cliente"];

    $datos["id_rol"] = $_SESSION["id_rol"];
    $retorno["vp_limites"] = $OB_vp_limites->leer($datos, 1);

    $datos["cliente"] = $retorno["vr_cotiza"][0]["numid"];
    $retorno["vm_dsctos_especiales"] = $OB_vm_dsctos_especiales->leer($datos, 1);

    $retorno["vr_cotizadet"] = $OB_vr_cotizadet->leer($datos, 1);

    if (count($retorno["vr_cotizadet"]) === 0) {

        $datos["vr_cotizadet"] = $OB_vr_cotizadet->leer($datos, 5);

        if ($datos["vr_cotizadet"][0]["misional"] === '01') {
            $retorno["vr_cotizadet"] = $OB_vr_cotizadet->leer($datos, 4);
            $retorno["vr_cotizadet"][0]["alter_item"] = 0;
        }
    }

    $retorno["caracteristicasRepuestos"] = array();

    for ($index = 0; $index < count($retorno["vr_cotizadet"]); $index++) {

        $codItem = trim($retorno["vr_cotizadet"][$index]["cod_item"]);

        // Solo si hay ítem válido
        if ($codItem !== '0' && strtoupper($codItem) !== 'NULL' && $codItem !== '') {
            $datos["cod_item"] = $codItem;
            $retorno["caracteristicasRepuestos"][$index] = $OB_im_items->leer($datos, 15);

            // ✅ Leer precio USD (leer(..., 8))
            $precioItem = $OB_im_items->leer($datos, 8);

            if (isset($precioItem[0]["precio_vta_usd"])) {
                $valorUSD = floatval($precioItem[0]["precio_vta_usd"]);

                // Obtener TRM actual
                $consultaTRM = "SELECT trm FROM cm_trm ORDER BY fecha DESC LIMIT 1";
                $OB_con = new CL_conexion();
                $resultadoTRM = $OB_con->retornar($consultaTRM);
                $trmActual = isset($resultadoTRM[0]["trm"]) ? floatval($resultadoTRM[0]["trm"]) : 0;

                $valorCOP = $trmActual > 0 ? round($valorUSD * $trmActual, 2) : 0;

                // Guardar en JSON de respuesta
                $retorno["vr_cotizadet"][$index]["valor_unit_usd"] = $valorUSD;
                $retorno["vr_cotizadet"][$index]["valor_unit_cop"] = $valorCOP;
                $retorno["vr_cotizadet"][$index]["precio_vta_usd"] = $valorUSD;

                // Valor unitario según moneda
                $retorno["vr_cotizadet"][$index]["valor_unit"] =
                    ($retorno["vr_cotiza"][0]["moneda"] === 'USD') ? $valorUSD : $valorCOP;

                // Esto solo agrega los valores ya calculados para que el PDF los reciba.
            $retorno["caracteristicasRepuestos"][$index][0]["valor_unit_usd"] = floatval($retorno["vr_cotizadet"][$index]["valor_unit"]);
            $retorno["caracteristicasRepuestos"][$index][0]["valor_unit_cop"] = floatval($retorno["vr_cotizadet"][$index]["valor_unit"] * ($retorno["vr_cotiza"][0]["trm"] ?? 1));
            $retorno["caracteristicasRepuestos"][$index][0]["iva_referencia"] = floatval($retorno["vr_cotizadet"][$index]["iva_referencia"] ?? 0);

            }

        } else {
            $retorno["caracteristicasRepuestos"][$index] = array();
        }

        // 👇 Grupos, tipos, marcas
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

        // 👇 Características adicionales
        $datos["id_consecot"] = $retorno["vr_cotizadet"][$index]["id_consecot"];
        $datos["id_orden"] = $retorno["vr_cotizadet"][$index]["id_orden"];
        $retorno["vr_cotizcar"][$index] = $OB_vr_cotizcar->leer($datos, 1);

        if (count($retorno["vr_cotizcar"][$index]) === 0) {
            $retorno["textosCaracteristicas"][$index][0] = array();
        } else {
            for ($index1 = 0; $index1 < count($retorno["vr_cotizcar"][$index]); $index1++) {
                $datos["codgrup"] = $retorno["vr_cotizadet"][$index]["articulo"];
                $datos["codcarac"] = $retorno["vr_cotizcar"][$index][$index1]["caract"];
                $retorno["textosCaracteristicas"][$index][$index1] = $OB_ir_caracte->leer($datos, 2);
            }
        }
    }


    $data_nm_sucursal = $OB_nm_sucursal->leer($datos, 2);

    $datos["numid"] = $data_nm_sucursal[0]["numid"];
    $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 4);

    if ($retorno["nm_nits"][0]["idclase"] === 31) {
        $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
    }

    if ($retorno["nm_nits"][0]["idclase"] === 13) {
        $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
    }

    if (count($retorno["nm_nits"]) === 0) {
        $datos["nit_cliente"] = $data_nm_sucursal[0]["numid"];
        $retorno["vm_clientesprov"] = $OB_vm_clientesprov->leer($datos, 1);
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '2') {

    $datos["termn_pago"] = $_POST["datosAEnviar"]["vp_termn_pago"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
    $datos["id_moneda"] = $_POST["datosAEnviar"]["id_moneda"];
    $datos["vigencia"] = $_POST["datosAEnviar"]["vigencia"];
    $datos["fecha_vence"] = $_POST["datosAEnviar"]["fecha_vence"];
    $datos["sem_entrega"] = $_POST["datosAEnviar"]["sem_entrega"];
    $datos["id_contacto"] = intval($_POST["datosAEnviar"]["id_contacto"]);

    $data_nm_contactos = $OB_nm_contactos->leer($datos, 5);
    $datos["suc_cliente"] = $data_nm_contactos[0]["id_sucursal"];

    echo json_encode($OB_vr_cotiza->actualizar($datos, 1));
}

if ($_POST["caso"] === '3') {

    $datos["fechaInicial"] = $_POST["datosAEnviar"]["fechaInicial"];
    $datos["fechaFinal"] = $_POST["datosAEnviar"]["fechaFinal"];
    $datos["usuario"] = $_POST["datosAEnviar"]["usuario"];
    $datos["estado"] = $_POST["datosAEnviar"]["estado"];

    echo json_encode($OB_vr_cotiza->leer($datos, 4));

}

if ($_POST["caso"] === '4') {

    $datos["usuario"] = $_POST["datosAEnviar"]["usuario"];
    echo json_encode($OB_vr_cotiza->leer($datos, 3));

}

if ($_POST["caso"] === '5') {

    $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
    $datos["descuento"] = $_POST["datosAEnviar"]["descuento"];
    $datos["vr_descuento"] = $_POST["datosAEnviar"]["vr_descuento"];
    $datos["subtotal"] = $_POST["datosAEnviar"]["subtotal"];
    $datos["iva"] = $_POST["datosAEnviar"]["iva"];
    $datos["cod_asesor"] = $_SESSION["codusr"];

    echo json_encode($OB_vr_cotiza->actualizar($datos, 3));

}