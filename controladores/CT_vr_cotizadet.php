<?php

session_start();

include_once '../modelos/CL_vr_cotizadet.php';
include_once '../modelos/CL_vr_cotizcar.php';
include_once '../modelos/CL_ir_salinve.php';

$OB_vr_cotizadet = new CL_vr_cotizadet();
$OB_vr_cotizcar = new CL_vr_cotizcar();
$OB_ir_salinve=new CL_ir_salinve();

$retono = array();

if($_POST["caso"] === '1') {

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];
    echo json_encode($OB_vr_cotizadet->actualizar($datos, 1));
}

if($_POST["caso"] === '2') {

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $retorno["vr_cotizcar"] = $OB_vr_cotizcar->borrar($datos, 1);
    $retorno["vr_cotizadet"] = $OB_vr_cotizadet->borrar($datos, 1);

    echo json_encode($retorno);
}

if($_POST["caso"] === '3') {

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];    
    $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];   
    $data_ir_salinve=$OB_ir_salinve->leer($datos,1);

    //verifica si el saldo es menor o igual que la cantidad solicitada
    if($data_ir_salinve[0]["saldo"]<=$datos["cantidad"]){
        $datos["cantidad"]=$data_ir_salinve[0]["saldo"];
    }else{
        $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];
    }    

    $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["misional"] = $_POST["datosAEnviar"]["misional"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"][0];
    $datos["tipo"] = $_POST["datosAEnviar"]["tipo"][0];
    $datos["marca"] = $_POST["datosAEnviar"]["marca"][0];
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];    

    
    $datos["observs"] = $_POST["datosAEnviar"]["observs"];
    $datos["version"] = $_POST["datosAEnviar"]["version"];
    $datos["valor_unit"] = $_POST["datosAEnviar"]["precio_vta"];
    $datos["iva_referencia"] = $_POST["datosAEnviar"]["iva"];
    $datos["descrip"] = $_POST["datosAEnviar"]["iva"];
    $datos["opcion"] = 1;
    $datos["dscto_item"] = 0;
    $datos["descrip"] = $_POST["datosAEnviar"]["descrip"];
    $datos["nom_item"] = $_POST["datosAEnviar"]["nom_item"];
    $datos["valor_unit"] = $_POST["datosAEnviar"]["precio_vta"];
    $datos["caracteristicasRepuestos"] = $_POST["datosAEnviar"]["caracteristicasRepuestos"];
    $datos["arregloCaracteristicas"] = $_POST["datosAEnviar"]["arregloCaracteristicas"];

    //aqui las semanas disponible están pendientes 
    //por ahora lo dejo en cero para poder continuar con la codificación
    $datos["sem_dispo"]=0;

    $retorno["vr_cotizadet"] = $OB_vr_cotizadet->crear($datos, 1);

    if(strlen($datos["arregloCaracteristicas"][0]) > 0) {

        for($index = 0; $index < count($datos["arregloCaracteristicas"]); $index++) {
            $datos["id_orden"] = $retorno["vr_cotizadet"];
            $datos["caract"] = $datos["arregloCaracteristicas"][$index];
            $datos["vr_caract"] = $datos["caracteristicasRepuestos"][$index];
            $retorno["vr_cotizcar"][$index] = $OB_vr_cotizcar->crear($datos, 1);            
        }
    }

    echo json_encode($retorno);

}

if($_POST["caso"] === '4') {

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $datos["observs"] = $_POST["datosAEnviar"]["observs"];
    echo json_encode($OB_vr_cotizadet->actualizar($datos, 2));

}

if($_POST["caso"] === "5") {

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $datos["valor_unit"] = floatval(str_replace('.', '', $_POST["datosAEnviar"]["valor_unit"]));
    echo json_encode($OB_vr_cotizadet->actualizar($datos, 3));

}

if($_POST["caso"] === "6") {

    $datos["tipo"] = $_POST["datosAEnviar"]["tipo"];
    $datos["marca"] = $_POST["datosAEnviar"]["marca"];
    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    echo json_encode($OB_vr_cotizadet->actualizar($datos, 4));

}

if($_POST["caso"] === '7') {

    $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
    $datos["version"] = $_POST["datosAEnviar"]["version"];
    $datos["opcion"] = 1;
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["misional"] = $_POST["datosAEnviar"]["misional"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"];
    $datos["tipo"] = $_POST["datosAEnviar"]["tipo"];
    $datos["marca"] = $_POST["datosAEnviar"]["marca"];
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];
    $datos["observs"] = $_POST["datosAEnviar"]["observs"];
    $datos["valor_unit"] = 0;
    $datos["dscto_item"] = 0;
    $datos["iva_referencia"] = 19.00;

    $retorno["vr_cotizadet"] = $OB_vr_cotizadet->crear($datos, 1);

    if(isset($_POST["datosAEnviar"]["caracteristicasRepuestos"])) {

        for($index = 0; $index < count($_POST["datosAEnviar"]["caracteristicasRepuestos"]); $index++) {

            $datos["id_consecot"] = $_POST["datosAEnviar"]["id_consecot"];
            $datos["id_orden"] = $retorno["vr_cotizadet"];
            $datos["vr_caract"] = $_POST["datosAEnviar"]["caracteristicasRepuestos"][$index];
            $datos["caract"] = $_POST["datosAEnviar"]["arregloCaracteristicas"][$index];
            $retorno["vr_cotizcar"][$index] = $OB_vr_cotizcar->crear($datos, 1);
        }
    }

    echo json_encode($retorno);
}

if($_POST["caso"]==='8'){

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $datos["dscto_item"] = $_POST["datosAEnviar"]["dscto_item"];

    echo json_encode($OB_vr_cotizadet->actualizar($datos, 5));

}

if($_POST["caso"]==='9'){

    $datos["id_orden"] = $_POST["datosAEnviar"]["id_orden"];
    $datos["sem_dispo"] = $_POST["datosAEnviar"]["sem_dispo"];

    echo json_encode($OB_vr_cotizadet->actualizar($datos, 6));

}