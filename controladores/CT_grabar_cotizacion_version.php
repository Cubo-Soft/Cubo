<?php

session_start();

include_once '../modelos/CL_vr_cotiza.php';
include_once '../modelos/CL_vr_cotizadet.php';
include_once '../modelos/CL_vr_cotizcar.php';
include_once '../modelos/CL_am_alertas.php';

$OB_vr_cotiza = new CL_vr_cotiza();
$OB_vr_cotizadet = new CL_vr_cotizadet();
$OB_vr_cotizcar = new CL_vr_cotizcar();
$OB_am_alertas = new CL_am_alertas();

$datos["nro_cot"] = $_GET["nro_cot"];
$datos["version"] = $_GET["version"];
$data_vr_cotiza = $OB_vr_cotiza->leer($datos, 6);

$datos["id_consecot"] = $data_vr_cotiza[0]["id_consecot"];

$data_vr_cotiza = $OB_vr_cotiza->leer($datos, 5);

$datos["nro_cot"] = $data_vr_cotiza[0]["nro_cot"];
$datos["version"] = intval($data_vr_cotiza[0]["version"]) + 1;
$datos["fecha_ini"] = date("Y-m-d");
$datos["suc_cliente"] = $data_vr_cotiza[0]["suc_cliente"];
$datos["id_contacto"] = $data_vr_cotiza[0]["id_contacto"];
$datos["vigencia"] = $data_vr_cotiza[0]["vigencia"];
$datos["fecha_vence"] = date("Y-m-d", strtotime(date("Y-m-d")."+".$datos["vigencia"]." days"));
$datos["id_moneda"] = $data_vr_cotiza[0]["id_moneda"];
$datos["subtotal"] = $data_vr_cotiza[0]["subtotal"];
$datos["ctro_costo"]='';
$datos["iva"] = $data_vr_cotiza[0]["iva"];
$datos["descuento"] = $data_vr_cotiza[0]["descuento"];
$datos["termn_pago"]=1;
$datos["autoriza"]=0;
$datos["vr_descuento"] = $data_vr_cotiza[0]["vr_descuento"];
$datos["termn_pago"] = $data_vr_cotiza[0]["termn_pago"];
$datos["autoriza"] = $data_vr_cotiza[0]["autoriza"];
$datos["estado"] = 110;
$datos["cod_grabador"] = $data_vr_cotiza[0]["cod_grabador"];
$datos["sem_entrega"] = $data_vr_cotiza[0]["sem_entrega"];
$datos["cod_asesor"] = $data_vr_cotiza[0]["cod_asesor"];
$datos["cod_trans"]=$data_vr_cotiza[0]["cod_trans"];
$datos["trans_base"]=$data_vr_cotiza[0]["trans_base"];

$data_vr_cotizadet = $OB_vr_cotizadet->leer($datos, 1);

$data_vr_cotizcar = $OB_vr_cotizcar->leer($datos, 2);

$retorno["vr_cotiza"] = $OB_vr_cotiza->crear($datos, 1);

for($i = 0; $i < count($data_vr_cotizadet); $i++) {

    $datos["id_consecot"] = $retorno["vr_cotiza"];
    $datos["opcion"] = $data_vr_cotizadet[$i]["opcion"];
    $datos["linea"] = $data_vr_cotizadet[$i]["linea"];
    $datos["misional"] = $data_vr_cotizadet[$i]["misional"];
    $datos["articulo"] = $data_vr_cotizadet[$i]["articulo"];
    $datos["tipo"] = $data_vr_cotizadet[$i]["tipo"];
    $datos["marca"] = $data_vr_cotizadet[$i]["marca"];
    $datos["cod_item"] = $data_vr_cotizadet[$i]["cod_item"];
    $datos["descrip"] = $data_vr_cotizadet[$i]["descrip"];
    $datos["cantidad"] = $data_vr_cotizadet[$i]["cantidad"];
    $datos["valor_unit"] = $data_vr_cotizadet[$i]["valor_unit"];
    $datos["dscto_item"] = $data_vr_cotizadet[$i]["dscto_item"];
    $datos["iva_referencia"] = $data_vr_cotizadet[$i]["iva_referencia"];
    $datos["observs"] = $data_vr_cotizadet[$i]["observs"];
    $datos["id_orden"] = $data_vr_cotizadet[$i]["id_orden"];
    $datos["sem_dispo"]=$data_vr_cotizadet[$i]["sem_dispo"];

    $retorno["vr_cotizadet"][$i] = $OB_vr_cotizadet->crear($datos, 1);

}

//var_dump($data_vr_cotizcar); exit();

for($j = 0; $j < count($data_vr_cotizadet); $j++) {

    for($k = 0; $k < count($data_vr_cotizcar); $k++) {

        if($data_vr_cotizadet[$j]["id_orden"] === $data_vr_cotizcar[$k]["id_orden"]) {
            $datos["id_orden"] = $retorno["vr_cotizadet"][$j];
            $datos["caract"] = $data_vr_cotizcar[$k]["caract"];
            $datos["vr_caract"] = $data_vr_cotizcar[$k]["vr_caract"];
            $retorno["vr_cotizcar"][$k] = $OB_vr_cotizcar->crear($datos, 1);
        }
    }
}

if(intval($retorno["vr_cotiza"]) > 0 && count($retorno["vr_cotizadet"]) > 0) {
    header('Location: ../vistas/cotiza.php?id_consecot='.$retorno["vr_cotiza"]);

} else {

}
