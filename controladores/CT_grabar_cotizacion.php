<?php
ob_start(); // ← para evitar errores de headers

session_start();

include_once '../modelos/CL_vr_requerim.php';
include_once '../modelos/CL_vr_requerimdet.php';
include_once '../modelos/CL_vr_requerimcar.php';

include_once '../modelos/CL_vr_cotiza.php';
include_once '../modelos/CL_vr_cotizadet.php';
include_once '../modelos/CL_vr_cotizcar.php';

include_once '../modelos/CL_am_alertas.php';
include_once '../modelos/CL_im_trans.php';

include_once '../modelos/CL_ir_resinve.php';
include_once '../modelos/CL_ir_salinve.php';
include_once '../modelos/CL_im_items.php';

include_once '../modelos/CL_ir_operaciones.php';

include_once '../modelos/CL_Base.php';

include_once './CT_general.php';

include_once '../cls/varios.php';

$OB_vr_requerim = new CL_vr_requerim();
$OB_vr_requerimdet = new CL_vr_requerimdet();
$OB_vr_requerimcar = new CL_vr_requerimcar();
$OB_vr_cotiza = new CL_vr_cotiza();
$OB_vr_cotizadet = new CL_vr_cotizadet();
$OB_vr_cotizcar = new CL_vr_cotizcar();
$OB_am_alertas = new CL_am_alertas();
$OB_im_trans = new CL_im_trans();
$OB_ir_resinve = new CL_ir_resinve();
$OB_ir_salinve = new CL_ir_salinve();
$OB_im_items = new CL_im_items();
$OB_cl_base = new CL_Base();

$crearAlerta = 0;

$datos["id_requerim"] = $_GET["id_requerim"];
$data_vr_requerim = $OB_vr_requerim->leer($datos, 2);
$datos["grupo"] = $data_vr_requerim[0]["grupo"];

if ($datos["grupo"] === '02') {
    $data_vr_requerimdet = $OB_vr_requerimdet->leer($datos, 2);
}

if ($datos["grupo"] === '01') {
    $data_vr_requerimdet = $OB_vr_requerimdet->leer($datos, 3);
}


//echo $OB_vr_requerimdet->leer($datos, 2);

$datos["numid"] = $_SESSION["numid"];

$linea = '';

$datos["tipo"] = 'COT';
$data_im_trans = $OB_im_trans->leer($datos, 1);

//leer las caracteristicas en caso de que existan
for ($index = 0; $index < count($data_vr_requerimdet); $index++) {
    $datos["id_reqdet"] = $data_vr_requerimdet[$index]["id_reqdet"];
    $data_vr_requerimcar[$index] = $OB_vr_requerimcar->leer($datos, 1);
}

$datos["nro_cot"] = $data_im_trans[0]["consec"];
$datos["version"] = 1;
$datos["fecha_ini"] = date("Y-m-d");
$datos["suc_cliente"] = $data_vr_requerim[0]["suc_cliente"];
$datos["id_contacto"] = $data_vr_requerim[0]["id_contacto"];
$datos["fecha_vence"] = date("Y-m-d", strtotime(date("Y-m-d") . " 5 days"));
$datos["id_moneda"] = 34;
$datos["subtotal"] = 0;
$datos["ctro_costo"] = '';
$datos["iva"] = 0;
$datos["descuento"] = 0;
$datos["termn_pago"] = 1;
$datos["autoriza"] = 0;
$datos["estado"] = 110;
$datos["vr_descuento"] = 0;
$datos["sem_entrega"] = 0;
$datos["vigencia"] = 5;
$datos["cod_grabador"] = $_SESSION["codusr"];
$datos["cod_trans"] = $data_im_trans[0]["cod_trans"];
$datos["trans_base"] = $data_vr_requerim[0]["cod_trans"] . '-' . $datos["id_requerim"];
$datos["saldo"] = 0;

//inicia creación de la cotización 
$retorno["vr_cotiza"] = $OB_vr_cotiza->crear($datos, 1);

for ($index1 = 0; $index1 < count($data_vr_requerimdet); $index1++) {

    $datos["id_consecot"] = $retorno["vr_cotiza"];
    $datos["version"] = 1;
    $datos["opcion"] = 1;
    $datos["linea"] = $data_vr_requerim[0]["de_linea"];
    $datos["misional"] = $data_vr_requerimdet[$index1]["misional"];
    $datos["articulo"] = $data_vr_requerimdet[$index1]["articulo"];
    $datos["tipo"] = $data_vr_requerimdet[$index1]["tipo"];
    $datos["marca"] = $data_vr_requerimdet[$index1]["marca"];
    $datos["cod_item"] = $data_vr_requerimdet[$index1]["cod_item"];
    $datos["dscto_item"] = 0;
    $datos["descrip"] = '';

    if (!isset($data_vr_requerimdet[$index1]["saldo"])) {
        $datos["saldo"] = 0;
    } else {
        $datos["saldo"] = intval($data_vr_requerimdet[$index1]["saldo"]);
    }

    $datos["cantidad"] = $data_vr_requerimdet[$index1]["cantidad"];

    if ($datos["misional"] === '01') {

        $crearAlerta = 0;

        $datos["valor_unit"] = 0;
        $datos["iva_referencia"] = 0;
        $datos["observs"] = $data_vr_requerimdet[$index1]["observs"];
        $datos["sem_dispo"] = 0;

        $retorno["vr_cotizadet"][$index1] = $OB_vr_cotizadet->crear($datos, 1);
        $data_vr_cotizadet = $OB_vr_cotizadet->leer($datos, 4);

        $datos["id_consecot"] = $data_vr_cotizadet[$index1]["id_consecot"];
        //$datos["id_orden"] = $data_vr_cotizadet2[$index1]["id_orden"];
        $datos["id_orden"] = $retorno["vr_cotizadet"][$index1];

        for ($index2 = 0; $index2 < count($data_vr_requerimcar[$index1]); $index2++) {
            $datos["caract"] = $data_vr_requerimcar[$index1][$index2]["caract"];
            $datos["vr_caract"] = $data_vr_requerimcar[$index1][$index2]["vr_caract"];

            $retorno["vr_cotizcar"][$index1][$index2] = $OB_vr_cotizcar->crear($datos, 1);
        }
    }

    if ($datos["misional"] === '02') {

        //verifica si la cantidad pedida es mayor que la cantidad real 
        //y crea el registro para tal fin
        $data_ir_resinve = $OB_ir_resinve->leer($datos, 3);
        $data_ir_salinve = $OB_ir_salinve->leer($datos, 1);
        $data_im_items = $OB_im_items->leer($datos, 8);

        $datos["reservados"] = intval($data_ir_resinve[0]["totalResInve"]);
        $datos["inventario"] = intval($data_ir_salinve[0]["saldo"]);
        $datos["minimo"] = intval($data_im_items[0]["minimo"]);

        $valorReal = $datos["inventario"] - $datos["reservados"];

        $faltanteCotización = 1;

        if ($valorReal <= $datos["cantidad"]) {

            $faltanteCotización = $datos["cantidad"] - $datos["inventario"];

            $crearAlerta = 1;

            $cantidad = $datos["cantidad"]; // almacenas la cantidad original solicitada

            // === CREAR LÍNEA PARA FALTANTE (sin inventario)
            $datos["cantidad"] = $faltanteCotización;
            $datos["codbodeg"] = 1;
            $datos["valor_unit"] = 0; // Aquí puedes cambiar si quieres usar precio estimado
            $datos["iva_referencia"] = $data_vr_requerimdet[$index1]["iva"];
            $datos["observs"] = $data_vr_requerimdet[$index1]["observs"];
            $datos["sem_dispo"] = 10; // o el valor real de semanas estimadas

            if ($data_vr_requerimdet[$index1]["misional"] !== '01') {
                $datos["cod_item"] = $data_vr_requerimdet[$index1]["cod_item"];
                $datos["descrip"] = $data_vr_requerimdet[$index1]["nom_item"];
            }

            $retorno["vr_cotizadet"][$index1] = $OB_vr_cotizadet->crear($datos, 1);

            $data_vr_cotizadet2 = $OB_vr_cotizadet->leer($datos, 1);
            $datos["id_consecot"] = $data_vr_cotizadet2[$index1]["id_consecot"];
            $datos["id_orden"] = $retorno["vr_cotizadet"][$index1];

            for ($index2 = 0; $index2 < count($data_vr_requerimcar[$index1]); $index2++) {
                $datos["caract"] = $data_vr_requerimcar[$index1][$index2]["caract"];
                $datos["vr_caract"] = $data_vr_requerimcar[$index1][$index2]["vr_caract"];
                $retorno["vr_cotizcar"][$index1][$index2] = $OB_vr_cotizcar->crear($datos, 1);
            }

            // === SOLO SI HAY DISPONIBLE EN INVENTARIO, CREAR LÍNEA ADICIONAL
            $cantidadDisponible = $cantidad - $faltanteCotización;
            if ($cantidadDisponible > 0) {
                $datos["cantidad"] = $cantidadDisponible;

                // Reservamos
                $datos["codbodeg"] = 1;
                $datos["saldo"] = $cantidadDisponible;
                $datos["fecha_arribo"] = date("Y-m-d");
                $OB_ir_resinve->crear($datos, 1);

                $datos["valor_unit"] = $data_vr_requerimdet[$index1]["precio_vta"] ?? 0;
                $datos["iva_referencia"] = $data_vr_requerimdet[$index1]["iva"];
                $datos["observs"] = $data_vr_requerimdet[$index1]["observs"];
                $datos["sem_dispo"] = 0;

                $retorno["vr_cotizadet"][$index1] = $OB_vr_cotizadet->crear($datos, 1);

                $data_vr_cotizadet = $OB_vr_cotizadet->leer($datos, 1);
                $datos["id_consecot"] = $data_vr_cotizadet[$index1]["id_consecot"];
                $datos["id_orden"] = $retorno["vr_cotizadet"][$index1];

                for ($index2 = 0; $index2 < count($data_vr_requerimcar[$index1]); $index2++) {
                    $datos["caract"] = $data_vr_requerimcar[$index1][$index2]["caract"];
                    $datos["vr_caract"] = $data_vr_requerimcar[$index1][$index2]["vr_caract"];
                    $retorno["vr_cotizcar"][$index1][$index2] = $OB_vr_cotizcar->crear($datos, 1);
                }
            }

        } else {
            // ✅ INVENTARIO COMPLETO DISPONIBLE, CREAR UNA SOLA LÍNEA
            $datos["codbodeg"] = 1;
            $datos["saldo"] = $datos["cantidad"];
            $datos["fecha_arribo"] = date("Y-m-d");
            $OB_ir_resinve->crear($datos, 1);

            $datos["valor_unit"] = $data_vr_requerimdet[$index1]["precio_vta"] ?? 0;
            $datos["iva_referencia"] = $data_vr_requerimdet[$index1]["iva"];
            $datos["observs"] = $data_vr_requerimdet[$index1]["observs"];
            $datos["sem_dispo"] = 0;

            if ($data_vr_requerimdet[$index1]["misional"] !== '01') {
                $datos["cod_item"] = $data_vr_requerimdet[$index1]["cod_item"];
                $datos["descrip"] = $data_vr_requerimdet[$index1]["nom_item"];
            }

            $retorno["vr_cotizadet"][] = $OB_vr_cotizadet->crear($datos, 1);

            $data_vr_cotizadet = $OB_vr_cotizadet->leer($datos, 1);
            $datos["id_consecot"] = $data_vr_cotizadet[0]["id_consecot"];
            $datos["id_orden"] = $retorno["vr_cotizadet"][count($retorno["vr_cotizadet"]) - 1];

            for ($index2 = 0; $index2 < count($data_vr_requerimcar[$index1]); $index2++) {
                $datos["caract"] = $data_vr_requerimcar[$index1][$index2]["caract"];
                $datos["vr_caract"] = $data_vr_requerimcar[$index1][$index2]["vr_caract"];
                $retorno["vr_cotizcar"][$index1][$index2] = $OB_vr_cotizcar->crear($datos, 1);
            }
        }


    }
}

$datos["consec"] = intval($datos["nro_cot"]) + 1;
$OB_im_trans->actualizar($datos, 1);

if ($crearAlerta === 1) {
    $sentencia = "CALL spListaRequerim(" . $datos["id_requerim"] . ");";
    $OB_cl_base->ejecutarPA($sentencia);
}
if (!isset($retorno["vr_cotizadet"])) {
    $retorno["vr_cotizadet"] = [];
}

if (intval($retorno["vr_cotiza"]) > 0 && count($retorno["vr_cotizadet"]) > 0) {

    $datos["estado"] = 83;
    $datos["id_requerim"] = $_GET["id_requerim"];
    $OB_vr_requerim->actualizar($datos, 2);

    $datos["id_estado"] = 60;
    $datos["id_proceso"] = $data_vr_requerim[0]["id_requerim"];
    $datos["fecha_fin"] = date("Y-m-d");
    $OB_am_alertas->actualizar($datos, 1);

    if ($datos["misional"] === '02') {
        header('Location: ../vistas/cotiza.php?id_consecot=' . $retorno["vr_cotiza"]);
    }

    if ($datos["misional"] === '01') {
        header('Location: ../vistas/cot_equipos.php?id_consecot=' . $retorno["vr_cotiza"]);
    }
} else {
    echo "❌ No se pudo crear la cotización o no se insertó ningún detalle.";
    print_r($retorno);
}

ob_end_flush(); // ← AÑADIR AQUÍ