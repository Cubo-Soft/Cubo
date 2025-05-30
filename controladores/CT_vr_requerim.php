<?php

include_once '../modelos/CL_vr_requerim.php';
include_once '../modelos/CL_nm_nits.php';
include_once '../modelos/CL_vm_clientesprov.php';
include_once '../modelos/CL_nm_juridicas.php';
include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_vr_requerimdet.php';
include_once '../modelos/CL_vr_requerimcar.php';
include_once '../modelos/CL_ir_caracte.php';
include_once '../modelos/CL_im_items.php';
include_once '../modelos/CL_ip_grupos.php';
include_once '../modelos/CL_ip_tipos.php';
include_once '../modelos/CL_ip_marcas.php';
include_once '../modelos/CL_vr_cotiza.php';
include_once '../modelos/CL_am_alertas.php';
include_once '../modelos/CL_ir_resinve.php';
include_once '../modelos/CL_sr_prog_mant.php';

$OB_vr_requerim = new CL_vr_requerim();
$OB_nm_nits = new CL_nm_nits();
$OB_vm_clientesprov = new CL_vm_clientesprov();
$OB_nm_juridicas = new CL_nm_juridicas();
$OB_nm_personas = new CL_nm_personas();
$OB_vr_requerimdet = new CL_vr_requerimdet();
$OB_vr_requerimcar = new CL_vr_requerimcar();
$OB_ir_caracte = new CL_ir_caracte();
$OB_im_items = new CL_im_items();
$OB_ip_grupos = new CL_ip_grupos();
$OB_ip_tipos = new CL_ip_tipos();
$OB_ip_marcas = new CL_ip_marcas();
$OB_vr_cotiza = new CL_vr_cotiza();
$OB_am_alertas = new CL_am_alertas();
$OB_ir_resinve = new CL_ir_resinve();
$OB_sr_prog_mant = new CL_sr_prog_mant();

$retorno = array();

if ($_POST["caso"] === '1') {

    $datos['dtRInicial'] = $_POST["datosAEnviar"]['dtRInicial'];
    $datos['dtRFinal'] = $_POST["datosAEnviar"]['dtRFinal'];
    $datos['am_usuarios'] = $_POST["datosAEnviar"]['am_usuarios'];
    $datos['estadoRequerimiento'] = $_POST["datosAEnviar"]['estadoRequerimiento'];

    if ($datos['am_usuarios'] === '-2' && $datos['estadoRequerimiento'] === '-2') {
        echo json_encode($OB_vr_requerim->leer($datos, 3));
    } else if ($datos['am_usuarios'] !== '-2' && $datos['estadoRequerimiento'] === '-2') {
        echo json_encode($OB_vr_requerim->leer($datos, 4));
    } else if ($datos['am_usuarios'] === '-2' && $datos['estadoRequerimiento'] !== '-2') {
        echo json_encode($OB_vr_requerim->leer($datos, 5));
    } else {
        echo json_encode($OB_vr_requerim->leer($datos, 1));
    }
}

if ($_POST["caso"] === '2') {

    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    $datos["nro_cot"] = $_POST["datosAEnviar"]["id_requerim"];

    // --- INICIO BLOQUE CONVERSIÓN AUTOMÁTICA CLIENTE PROVISIONAL ---
    error_log("Validando requerimiento ID: " . $datos["id_requerim"]);//borrar

    // Obtener datos actuales del requerimiento para verificar si es cliente provisional
    $datosRequerim = $OB_vr_requerim->leer($datos, 2);

    if (count($datosRequerim) > 0 && isset($datosRequerim[0]['clien_provis']) && $datosRequerim[0]['clien_provis'] == 1) {
        error_log("Cliente provisional detectado para requerimiento " . $datos["id_requerim"]);//borrar
        // Cliente provisional detectado, intentamos convertirlo
        $conversionExitosa = $OB_vr_requerim->convertirClienteProvisional($datos["id_requerim"]);

        if (!$conversionExitosa) {
            // Si la conversión falla, enviar error y detener ejecución para evitar más problemas
            error_log("Error al convertir cliente provisional para requerimiento " . $datos["id_requerim"]);//borrar
            echo json_encode(["error" => "Error al convertir cliente provisional"]);
            exit;
        } else {//borrar
            error_log("Conversión cliente provisional exitosa para requerimiento " . $datos["id_requerim"]);//borrar
        }

        // Volver a cargar datos del requerimiento ya actualizado con cliente normal
        $datosRequerim = $OB_vr_requerim->leer($datos, 2);
    } else {//borrar
        error_log("No es cliente provisional o ya convertido para requerimiento " . $datos["id_requerim"]);//borrar
    }

    // Asignamos los datos actualizados al retorno para usarlos luego
    $retorno["vr_requerim"] = $datosRequerim;

    // --- FIN BLOQUE CONVERSIÓN AUTOMÁTICA CLIENTE PROVISIONAL ---

    //revisar si ya hay cotizacion
    $retorno["vr_cotiza"] = $OB_vr_cotiza->leer($datos, 1);

    if (count($retorno["vr_cotiza"]) > 0) {
        //si la hay actualizar el estado del requerimiento a en proceso
        //revisar si el requerimiento ya esta en proceso

        $data_vr_requerim = $OB_vr_requerim->leer($datos, 2);

        //el estado 82 es abierto el 84 es en proceso el 83 es cerrado
        if ($data_vr_requerim[0]["estado"] === '82') {
            $datos["estado"] = '84';
            $data_vr_requerim = $OB_vr_requerim->actualizar($datos, 2);
        }
    }

    $retorno["vr_requerim"] = $OB_vr_requerim->leer($datos, 2);
    $retorno["vr_requerimdet"] = $OB_vr_requerimdet->leer($datos, 1);
    $retorno["caracteristicasRepuestos"] = array();
    $retorno["repuestosNoExiste"] = array();
    $retorno["repuestosConSaldo"] = array();
    $retorno["repuestosSinSaldo"] = array();
    $retorno["ir_resinve"] = array();

    for ($index = 0; $index < count($retorno["vr_requerimdet"]); $index++) {

        $datos["id_reqdet"] = $retorno["vr_requerimdet"][$index]["id_reqdet"];
        $retorno["vr_requerimcar"][$index] = $OB_vr_requerimcar->leer($datos, 1);

        if ($retorno["vr_requerimdet"][$index]["cod_item"] !== '0') {

            $datos["cod_item"] = preg_replace('/\s+/', '', $retorno["vr_requerimdet"][$index]["cod_item"]);
            $datos["im_items"] = $OB_im_items->leer($datos, 15);
            $retorno["ir_resinve"][$index] = $OB_ir_resinve->leer($datos, 1);

            if ($retorno["vr_requerimdet"][$index]["misional"] === '02') {
                // //retorna los repuestos que tienen saldo mayor a cero 
                if (intval($datos["im_items"][0]["saldo"]) > 0) {
                    $retorno["repuestosConSaldo"][$index] = $datos["im_items"];
                }

                //retorna los repuestos que tienen saldo igual a cero 
                if (intval($datos["im_items"][0]["saldo"]) === 0) {
                    $retorno["repuestosSinSaldo"][$index] = $datos["im_items"];
                }
            }

            if ($retorno["vr_requerimdet"][$index]["misional"] === '03') {
                $retorno["equipos"][$index] = $OB_im_items->leer($datos, 26);
                $datos["cod_grupo"] = $retorno["vr_requerimdet"][$index]["observs"];
                $retorno["mantenimiento_a_realizar"][$index] = $OB_ip_grupos->leer($datos, 3);
            }
        }

        $retorno["tipos_mantenimiento"] = $OB_ip_grupos->leer(null, 4);

        if ($retorno["vr_requerimdet"][$index]["misional"] === '01' || $retorno["vr_requerimdet"][$index]["misional"] === '04') {
            $datos["cod_grupo"] = $retorno["vr_requerimdet"][$index]["articulo"];
            $retorno["ip_grupos"][$index] = $OB_ip_grupos->leer($datos, 3);

            $datos["id_tipo"] = $retorno["vr_requerimdet"][$index]["tipo"];
            $retorno["ip_tipos"][$index] = $OB_ip_tipos->leer($datos, 2);

            $datos["id_marca"] = $retorno["vr_requerimdet"][$index]["marca"];
            $retorno["ip_marcas"][$index] = $OB_ip_marcas->leer($datos, 2);
        }

        if ($retorno["vr_requerimdet"][$index]["cod_item"] === '0' && $retorno["vr_requerimdet"][$index]["misional"] === '02') {

            $datos["cod_grupo"] = $retorno["vr_requerimdet"][$index]["articulo"];
            $data_ip_grupos = $OB_ip_grupos->leer($datos, 3);
            $retorno["repuestosNoExiste"][$index]["nom_grupo"] = $data_ip_grupos[0]["nom_grupo"];

            $datos["id_tipo"] = $retorno["vr_requerimdet"][$index]["tipo"];
            $data_ip_tipos = $OB_ip_tipos->leer($datos, 2);
            $retorno["repuestosNoExiste"][$index]["descrip"] = $data_ip_tipos[0]["descrip"];

            $datos["id_marca"] = $retorno["vr_requerimdet"][$index]["marca"];
            $data_ip_marcas = $OB_ip_marcas->leer($datos, 2);
            $retorno["repuestosNoExiste"][$index]["nom_marca"] = $data_ip_marcas[0]["nom_marca"];
        } else {

            $retorno["repuestosNoExiste"][$index] = null;
            $retorno["repuestosNoExiste"][$index] = null;
            $retorno["repuestosNoExiste"][$index] = null;
        }

        if (count($retorno["vr_requerimcar"][$index]) === 0) {

            $retorno["textosCaracteristicas"][$index] = array();
        } else {
            for ($index1 = 0; $index1 < count($retorno["vr_requerimcar"][$index]); $index1++) {

                $datos["codgrup"] = $retorno["vr_requerimdet"][$index]["articulo"];
                $datos["codcarac"] = $retorno["vr_requerimcar"][$index][$index1]["caract"];

                $retorno["textosCaracteristicas"][$index][$index1] = $OB_ir_caracte->leer($datos, 2);
            }
        }
    }

    $datos["numid"] = $retorno["vr_requerim"][0]["nit_cliente"];
    $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 4);

    if (count($retorno["nm_nits"]) > 0) {
        if ($retorno["nm_nits"][0]["idclase"] === 31) {
            $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
        } elseif ($retorno["nm_nits"][0]["idclase"] === 13) {
            $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
        }
    } else {
        $datos["nit_cliente"] = $retorno["vr_requerim"][0]["nit_cliente"];
        $retorno["vm_clientesprov"] = $OB_vm_clientesprov->leer($datos, 1);

        
    }


    //var_dump($retorno["repuestosConSaldo"]);

    echo json_encode($retorno);
}

if ($_POST["caso"] === '3') {

    $datos["observs"] = $_POST["datosAEnviar"]["observs"];
    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    echo json_encode($OB_vr_requerim->actualizar($datos, 1));
}

if ($_POST["caso"] === '4') {

    $datos["estado"] = $_POST["datosAEnviar"]["estado"];
    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    echo json_encode($OB_vr_requerim->actualizar($datos, 2));
}

if ($_POST["caso"] === '5') {

    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    $datos["nro_cot"] = $_POST["datosAEnviar"]["id_requerim"];

    // El estado 82 es abierto, 84 en proceso, 83 cerrado
    $datos["estado"] = '84';
    $data_vr_requerim = $OB_vr_requerim->actualizar($datos, 2);

    $retorno["vr_requerim"] = $OB_vr_requerim->leer($datos, 2);
    $retorno["vr_requerimdet"] = $OB_vr_requerimdet->leer($datos, 2);
    $retorno["caracteristicasRepuestos"] = array();

    for ($index = 0; $index < count($retorno["vr_requerimdet"]); $index++) {

        $datos["id_reqdet"] = $retorno["vr_requerimdet"][$index]["id_reqdet"];
        $retorno["vr_requerimcar"][$index] = $OB_vr_requerimcar->leer($datos, 1);

        if ($retorno["vr_requerimdet"][$index]["cod_item"] !== '0' || $retorno["vr_requerimcar"][$index]["cod_item"] !== 'NULL') {
            $datos["cod_item"] = preg_replace('/\s+/', '', $retorno["vr_requerimdet"][$index]["cod_item"]);
            $retorno["caracteristicasRepuestos"][$index] = $OB_im_items->leer($datos, 15);
        } else {
            $retorno["caracteristicasRepuestos"][$index] = array();
        }

        if ($retorno["vr_requerimdet"][$index]["misional"] === '01' || $retorno["vr_requerimdet"][$index]["misional"] === '04') {
            $datos["cod_grupo"] = $retorno["vr_requerimdet"][$index]["articulo"];
            $retorno["ip_grupos"][$index] = $OB_ip_grupos->leer($datos, 3);

            $datos["id_tipo"] = $retorno["vr_requerimdet"][$index]["tipo"];
            $retorno["ip_tipos"][$index] = $OB_ip_tipos->leer($datos, 2);

            $datos["id_marca"] = $retorno["vr_requerimdet"][$index]["marca"];
            $retorno["ip_marcas"][$index] = $OB_ip_marcas->leer($datos, 2);
        } else {
            $retorno["ip_grupos"][$index] = array();
            $retorno["ip_tipos"][$index] = array();
            $retorno["ip_marcas"][$index] = array();
        }

        for ($index1 = 0; $index1 < count($retorno["vr_requerimcar"][$index]); $index1++) {
            $datos["codgrup"] = $retorno["vr_requerimdet"][$index]["articulo"];
            $datos["codcarac"] = $retorno["vr_requerimcar"][$index][$index1]["caract"];
            $retorno["textosCaracteristicas"][$index][$index1] = $OB_ir_caracte->leer($datos, 2);
        }
    }

    $datos["numid"] = $retorno["vr_requerim"][0]["nit_cliente"];
    $retorno["nm_nits"] = $OB_nm_nits->leer($datos, 4);

    if (count($retorno["nm_nits"]) > 0) {
        if ($retorno["nm_nits"][0]["idclase"] === 31) {
            $retorno["nm_juridicas"] = $OB_nm_juridicas->leer($datos, 5);
        } elseif ($retorno["nm_nits"][0]["idclase"] === 13) {
            $retorno["nm_personas"] = $OB_nm_personas->leer($datos, 1);
        }
    } else {
        $datos["nit_cliente"] = $retorno["vr_requerim"][0]["nit_cliente"];
        $retorno["vm_clientesprov"] = $OB_vm_clientesprov->leer($datos, 1);
    }

    echo json_encode($retorno);
}


if ($_POST["caso"] === '6') {

    $datos["asesor_asignd"] = $_POST["datosAEnviar"]["asesor_asignd"];
    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    $datos["usuario_asignd"] = $_POST["datosAEnviar"]["asesor_asignd"];
    $datos["id_proceso"] = $_POST["datosAEnviar"]["id_requerim"];

    $OB_am_alertas->actualizar($datos, 2);

    echo json_encode($OB_vr_requerim->actualizar($datos, 3));
}

if ($_POST["caso"] === '7') {

    $datos['dtRInicial'] = $_POST["datosAEnviar"]['dtRInicial'];
    $datos['dtRFinal'] = $_POST["datosAEnviar"]['dtRFinal'];
    $datos['am_usuarios'] = $_POST["datosAEnviar"]['am_usuarios'];
    $datos['estadoRequerimiento'] = $_POST["datosAEnviar"]['estadoRequerimiento'];
    if ($datos['am_usuarios'] === '-2' && $datos['estadoRequerimiento'] === '-2') {
        //para los requerimientos que no se les asigna asesor
        echo json_encode($OB_vr_requerim->leer($datos, 3));
    } else if ($datos['am_usuarios'] !== '-2' && $datos['estadoRequerimiento'] === '-2') {
        echo json_encode($OB_vr_requerim->leer($datos, 4));
    } else if ($datos['am_usuarios'] === '-2' && $datos['estadoRequerimiento'] !== '-2') {
        echo json_encode($OB_vr_requerim->leer($datos, 5));
    } else {
        echo json_encode($OB_vr_requerim->leer($datos, 1));
    }
}

if ($_POST["caso"] === '8') {


}
