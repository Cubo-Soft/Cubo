<?php

include_once '../modelos/CL_ir_operaciones.php';
include_once '../modelos/CL_ir_detalle_oper.php';
include_once '../modelos/CL_ir_oper_det2.php';
include_once '../modelos/CL_ir_oper_car.php';
include_once '../modelos/CL_ap_tipoalerta.php';
include_once '../modelos/CL_nm_empleados.php';
include_once '../modelos/CL_am_alertas.php';


/** 
 *  datos requeridos 
 *  $datos["num_antiguo_trans"]
 *  $datos["trans_base"]
 */
function crearListaRequerim($datos,$opcion){

    $OB_ir_operaciones=new CL_ir_operaciones();
    $OB_ir_detalle_oper=new CL_ir_detalle_oper();
    $OB_ir_oper_det2=new CL_ir_oper_det2();
    $OB_ir_oper_car = new CL_ir_oper_car();

    $OB_ap_tipoalerta=new CL_ap_tipoalerta();
    $OB_nm_empleados=new CL_nm_empleados();
    $OB_am_alertas=new CL_am_alertas();

    //verificar si ya existe el requerimiento creado para compras
    $data_ir_operaciones=$OB_ir_operaciones->leer($datos,1);
    
    if(count($data_ir_operaciones)>0){

        $datos["id_operacion"]=$data_ir_operaciones[0]["id_operacion"];        
        $datos["id_detalle"]='0';
        $datos["origen"]='0';
        $datos["destino"]='0';                
        $datos["cantidad_entregada"]='0';
        $datos["costo"]='0';
        $datos["valor_unitario"]='0';
        $datos["iva"]='0';
        $datos["fec_entrega_item"]='0000-00-00';
        
        $retorno["ir_detalle_oper"]=$OB_ir_detalle_oper->crear($datos,1);        
        $datos["id_detalle"]=$retorno["ir_detalle_oper"];
        $retorno["ir_oper_det2"]=$OB_ir_oper_det2->crear($datos,1);
        
        $data_vr_requerimcar=$datos["vr_requerimcar"][0];

        for($i=0;$i<count($data_vr_requerimcar);$i++){
            $datos["id_detcar"]=$data_vr_requerimcar[$i]["id_reqcar"];
            $datos["caract"]=$data_vr_requerimcar[$i]["caract"];
            $datos["vr_caract"]=$data_vr_requerimcar[$i]["vr_caract"];
            $retorno["ir_oper_car"][$i]=$OB_ir_oper_car->crear($datos,1);
        }

    }else{


    }


}
