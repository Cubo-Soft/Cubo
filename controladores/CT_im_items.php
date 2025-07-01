<?php

include_once '../modelos/CL_im_items.php';
include_once '../modelos/CL_ip_grupos.php';
include_once '../modelos/CL_ir_resinve.php';
include_once '../modelos/CL_nm_sucursal.php';
include_once '../modelos/CL_nm_nits.php';
include_once '../modelos/CL_nm_juridicas.php';
include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_ap_camposx.php';

$OB_im_items = new CL_im_items();
$OB_ip_grupos = new CL_ip_grupos();
$OB_ir_resinve = new CL_ir_resinve();
$OB_nm_sucursal = new CL_nm_sucursal();
$OB_nm_nits = new CL_nm_nits();
$OB_nm_juridicas = new CL_nm_juridicas();
$OB_nm_personas = new CL_nm_personas();
$OB_ap_camposx = new CL_ap_camposx();

if ($_POST["caso"] === '1') {
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $datos["ip_grupos"] = $_POST["datosAEnviar"]["ip_grupos"];

    //EQUIPOS
    //PROYECTOS
    if ($datos["ip_grupos"] === '01' || $datos["ip_grupos"] === '04') {
        echo json_encode($OB_ip_grupos->leer($datos, 2));
    }

    //REPUESTOS
    if ($datos["ip_grupos"] === '02') {
        echo json_encode($OB_im_items->leer($datos, 1));
    }

    //
    if ($datos["ip_grupos"] === '03') {
        echo json_encode($OB_im_items->leer($datos, 1));
    }
}

if ($_POST["caso"] === '2') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 2));
}

if ($_POST["caso"] === '3') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 3));
}

if ($_POST["caso"] === '4') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_marca"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 4));
}

if ($_POST["caso"] === '5') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_marca"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["modelo"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 5));
}

if ($_POST["caso"] === '6') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_marca"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["modelo"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $datos["dimensiones"] = $_POST["datosAEnviar"]["dimensiones"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 6));
}

if ($_POST["caso"] === '7') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_marca"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["modelo"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $datos["dimensiones"] = $_POST["datosAEnviar"]["dimensiones"][0];
    $datos["unidad"] = $_POST["datosAEnviar"]["unidad"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    echo json_encode($OB_im_items->leer($datos, 7));
}

if ($_POST["caso"] === '9') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 9);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '10') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"][0];

    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 10);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '11') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["ip_modelos"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 11);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '12') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["ip_modelos"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $datos["ip_dimens"] = $_POST["datosAEnviar"]["ip_dimens"][0];
    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 12);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '13') {
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
    $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
    $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"][0];
    $datos["ip_modelos"] = $_POST["datosAEnviar"]["ip_modelos"][0];
    $datos["ip_dimens"] = $_POST["datosAEnviar"]["ip_dimens"][0];
    $datos["unidad"] = $_POST["datosAEnviar"]["ip_unidades"][0];

    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 13);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '14') {

    if ($_POST["datosAEnviar"]["filtro"] === '1') {
        $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"][0];
        $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"][0];
        $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
        $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"][0];
        $datos["ip_modelos"] = $_POST["datosAEnviar"]["ip_modelos"][0];
        $datos["ip_dimens"] = $_POST["datosAEnviar"]["ip_dimens"][0];
        $datos["unidad"] = $_POST["datosAEnviar"]["ip_unidades"][0];
        $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"][0];
    }

    if($_POST["datosAEnviar"]["filtro"]==='0'){
        $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
        $datos["tipo_item"] = $_POST["datosAEnviar"]["id_tipos"];
        $datos["ip_lineas"] = $_POST["datosAEnviar"]["ip_lineas"];
        $datos["ip_marcas"] = $_POST["datosAEnviar"]["ip_marcas"];
        $datos["ip_modelos"] = $_POST["datosAEnviar"]["ip_modelos"];
        $datos["ip_dimens"] = $_POST["datosAEnviar"]["ip_dimens"];
        $datos["unidad"] = $_POST["datosAEnviar"]["ip_unidades"];
        $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    }

    $retorno["datosRepuesto"] = $OB_im_items->leer($datos, 14);

    if (count($retorno["datosRepuesto"]) > 0) {
        $datos["cod_item"] = $retorno["datosRepuesto"][0]["cod_item"];
        $retorno["ir_resinve"] = $OB_ir_resinve->leer($datos, 1);
    } else {
        $retorno["ir_resinve"] = [0];
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '15') {
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    echo json_encode($OB_im_items->leer($datos, 16));
}

if ($_POST["caso"] === '16') {
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $retorno["im_items"] = $OB_im_items->leer($datos, 8);

    if (count($retorno["im_items"]) === 0) {
        $retorno["im_items"] = [];
    } else {
        $datos["id_sucursal"] = $retorno["im_items"][0]["id_proveedor"];
        $retorno["nm_sucursal"] = $OB_nm_sucursal->leer($datos, 2);

        $datos["numid"] = $retorno["nm_sucursal"][0]["numid"];
        $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 1);

        $retorno["nm_juridicas"] = [];
        $retorno["nm_personas"] = [];

        //si es persona juridica
        if ($retorno["nm_nits"][0]["tipo_per"] === 24) {
            $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
        }

        //si es persona natural
        if ($retorno["nm_nits"][0]["tipo_per"] === 23) {
            $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
        }
    }

    echo json_encode($retorno);
}

//actualiza la foto del repuesto
if ($_POST["caso"] === "17") {

    //arma los datos de la foto para la base
    $datos["cod_item"] = $_POST["cod_item"];

    $nombreArchivo = "../img_inve/" . $datos["cod_item"] . '_' . date("Ymdhms") . '.jpg';

    //revisa si la foto ya esta creada
    $data_im_items = $OB_im_items->leer($datos, 8);
    //borra la imagen actual
    if (strpos($data_im_items[0]["foto"], $datos["cod_item"]) > 0) {
        unlink($data_im_items[0]["foto"]);
    }

    $datos["foto"] = $nombreArchivo;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $nombreArchivo)) {
        echo json_encode($OB_im_items->actualizar($datos, 1));
    } else {
        echo json_encode(0);
    }
}

//actualiza los demás datos del repuesto
if ($_POST["caso"] === "18") {

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];
    $datos["nom_item"] = preg_replace('/\'|"/', "'", $_POST["datosAEnviar"]["nom_item"]);
    $datos["unidad"] = $_POST["datosAEnviar"]["unidad"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["numid"] = $_POST["datosAEnviar"]["numid"];
    $datos["id_marca"] = $_POST["datosAEnviar"]["id_marca"];
    $datos["unid_desgaste"] = $_POST["datosAEnviar"]["unid_desgaste"];
    $datos["cant_desgaste"] = $_POST["datosAEnviar"]["cant_desgaste"];
    $datos["facturable"] = $_POST["datosAEnviar"]["facturable"];
    $datos["area_item"] = $_POST["datosAEnviar"]["area_item"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["tipo_item"];
    $datos["num_parte"] = $_POST["datosAEnviar"]["num_parte"];
    $datos["estado_item"] = $_POST["datosAEnviar"]["estado_item"];
    $datos["iva"] = $_POST["datosAEnviar"]["iva"];
    $datos["precio_vta"] = $_POST["datosAEnviar"]["precio_vta"];
    $datos["modelo"] = $_POST["datosAEnviar"]["modelo"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["peso"] = $_POST["datosAEnviar"]["peso"];
    $datos["volumen"] = $_POST["datosAEnviar"]["volumen"];
    $datos["dimensiones"] = $_POST["datosAEnviar"]["dimensiones"];
    $datos["precio_vta_usd"] = $_POST["datosAEnviar"]["precio_vta_usd"];
    $datos["minimo"] = $_POST["datosAEnviar"]["minimo"];
    $datos["maximo"] = $_POST["datosAEnviar"]["maximo"];
    $datos["id_proveedor"] = $_POST["datosAEnviar"]["id_proveedor"];
    $datos["ap_camposx"] = explode("|", $_POST["datosAEnviar"]["ap_camposx"]);

    for ($a = 0; $a < count($datos["ap_camposx"]); $a++) {
        unset($datos[$datos["ap_camposx"][$a]]);
    }

    if (empty($datos["ap_camposx"])) {
        echo json_encode($OB_im_items->actualizar($datos, 2));
    } else {
        echo json_encode($OB_im_items->actualizar($datos, 3));
    }
}
//listado de todos los item 
if ($_POST["caso"] === "19") {
    echo json_encode($OB_im_items->leer(null, 17));
}

//buscar por alter_item desde la vista refe_inve.php al pulsar en Referencia alterna
if ($_POST["caso"] === "20") {
    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];
    echo json_encode($OB_im_items->leer($datos, 18));
}

if ($_POST["caso"] === "21") {

    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];
    $retorno["im_items"] = $OB_im_items->leer($datos, 19);

    if (count($retorno["im_items"]) === 0) {
        $retorno["im_items"] = [];
    } else {
        $datos["id_sucursal"] = $retorno["im_items"][0]["id_proveedor"];
        $retorno["nm_sucursal"] = $OB_nm_sucursal->leer($datos, 2);

        $datos["numid"] = $retorno["nm_sucursal"][0]["numid"];
        $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 1);

        $retorno["nm_juridicas"] = [];
        $retorno["nm_personas"] = [];

        //si es persona juridica
        if ($retorno["nm_nits"][0]["tipo_per"] === 24) {
            $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
        }

        //si es persona natural
        if ($retorno["nm_nits"][0]["tipo_per"] === 23) {
            $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
        }
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === "22") {

    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];
    $datos["nom_item"] = $_POST["datosAEnviar"]["nom_item"];
    $datos["unidad"] = $_POST["datosAEnviar"]["unidad"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["id_proveedor"] = $_POST["datosAEnviar"]["id_proveedor"];
    $datos["id_marca"] = $_POST["datosAEnviar"]["id_marca"];
    $datos["unid_desgaste"] = $_POST["datosAEnviar"]["unid_desgaste"];
    $datos["cant_desgaste"] = $_POST["datosAEnviar"]["cant_desgaste"];
    $datos["facturable"] = $_POST["datosAEnviar"]["facturable"];
    $datos["area_item"] = $_POST["datosAEnviar"]["area_item"];
    $datos["tipo_item"] = $_POST["datosAEnviar"]["tipo_item"];
    $datos["num_parte"] = $_POST["datosAEnviar"]["num_parte"];
    $datos["estado_item"] = $_POST["datosAEnviar"]["estado_item"];
    $datos["iva"] = $_POST["datosAEnviar"]["iva"];
    $datos["precio_vta"] = $_POST["datosAEnviar"]["precio_vta"];
    $datos["modelo"] = $_POST["datosAEnviar"]["modelo"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["peso"] = $_POST["datosAEnviar"]["peso"];
    $datos["volumen"] = $_POST["datosAEnviar"]["volumen"];
    $datos["dimensiones"] = $_POST["datosAEnviar"]["dimensiones"];
    $datos["precio_vta_usd"] = $_POST["datosAEnviar"]["precio_vta_usd"];
    $datos["minimo"] = $_POST["datosAEnviar"]["minimo"];
    $datos["maximo"] = $_POST["datosAEnviar"]["maximo"];
    $datos["foto"] = '../img_inve/sin_imagen.jpg';

    echo json_encode($OB_im_items->crear($datos, 1));
}

//para los filtros en la toma del requerimiento 
if ($_POST["caso"] === "23") {
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    echo json_encode($OB_im_items->leer($datos, 20));
}

if ($_POST["caso"] === "24") {
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    echo json_encode($OB_im_items->leer($datos, 21));
}

//por alter_item desde toma del requerimiento 
if ($_POST["caso"] === "25") {
    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    echo json_encode($OB_im_items->leer($datos, 22));
}

if ($_POST["caso"] === "26") {
    $datos["alter_item"] = $_POST["datosAEnviar"]["alter_item"];    
    echo json_encode($OB_im_items->leer($datos, 23));
}

//por nom_item desde toma del requerimiento
if ($_POST["caso"] === "27") {
    $datos["nom_item"] = $_POST["datosAEnviar"]["nom_item"];
    $datos["grup_item"] = $_POST["datosAEnviar"]["grup_item"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    echo json_encode($OB_im_items->leer($datos, 24));
}

if ($_POST["caso"] === "28") {
    $datos["nom_item"] = $_POST["datosAEnviar"]["nom_item"];    
    echo json_encode($OB_im_items->leer($datos, 25));
}
