<?php
session_start();
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function apli_porc( $ar_incr ){
  $valor = $ar_incr[0]['vr_unit'];
  if( $ar_incr[0]['u_medida'] == "%"){
    $valor = ( $valor / 100 );
  }
  return ( 1 + $valor );
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_cst_bandejas";
$tcostbandejas = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tbandej = new Tabla($odb,"gp_bandeja");
$tcstgen = new Tabla($odb,"gp_cst_generales");
//$idconduleta = $_REQUEST['conduleta'];
$ar_sale = [];
if( isset( $_REQUEST['opcion'] ) ){
  $opcion = $_REQUEST['opcion'];
  switch($opcion){
      case '0':   // llama cantidad de opciones en tablas para limpiar.
              $ar_elemen=$telemen->lee("");
              $ar_comple=$tcomple->lee("");
              $ar_bandej=$tbandej->lee("");
              $ar = array('tot_elemen'=>count($ar_elemen),'tot_complem'=>count($ar_comple),'tot_bandej'=>count($ar_bandej));
              $ar_sale = $ar;    
              break;
      case '2':     // actualizar dato de celda.
              if(isset($_REQUEST['elemento']) && isset($_REQUEST['complemento']) && isset($_REQUEST['bandeja'])){
                $idelemen   = $_REQUEST['elemento'];
                $idcomplem  = $_REQUEST['complemento'];
                $idbandeja  = $_REQUEST['bandeja'];
                $valor      = $_REQUEST['valor'];
                $w =  " WHERE id_elemen=$idelemen AND id_complem=$idcomplem AND id_bandeja=$idbandeja";
                $ar_cost    = $tcostbandejas->lee($w,0,"A");
                $ar = array('id_elemen'=>$idelemen,'id_complem'=>$idcomplem,'id_bandeja'=>$idbandeja,'valor'=>$valor);
                if(empty($ar_cost)){
                  $res = $tcostbandejas->ins($ar);
                    $ar_sale = $res;
                }else{
                    $res = $tcostbandejas->mod($ar," WHERE id_cstbandeja=".$ar_cost[0]['id_cstbandeja']);
                    $ar_sale = $res;
                }
              }
              break;
      case 'lee_valores':
              if(isset($_REQUEST['elemen']) && isset($_REQUEST['complem']) && isset($_REQUEST['bandeja'])){
                $elemen   = $_REQUEST['elemen'];
                $complem  = $_REQUEST['complem'];
                $idbandeja  = $_REQUEST['bandeja'];
                if(strpos($complem,"_")!==false){
                  $comple = str_replace("_",",",$complem);
                }else{
                  $comple = $complem;
                }
                if(strpos($elemen,"_")!==false){
                  $eleme = str_replace("_",",",$elemen);
                }else{
                  $eleme = $elemen;
                }
                $w =  " WHERE id_elemen IN($eleme) AND id_complem IN($comple) AND id_bandeja='$idbandeja'";
                $ar = $tcostbandejas->lee($w,0,"A");

                $incr_acerogalv = $tcstgen->lee(" WHERE id_general='0906'",0,"A");
                $incr_mobsoldad = $tcstgen->lee(" WHERE id_general='0901'",0,"A");
  
                $mult_galv = apli_porc( $incr_acerogalv );
                $mult_sold = apli_porc( $incr_mobsoldad ); 

                for( $x=0; $x < count( $ar ); $x++ ){
                    switch( $ar[$x]['id_complem']){
                      case '1': $ar[$x]['valor'] *= $mult_galv;break;
                      case '2': $ar[$x]['valor'] *= $mult_sold;break;
                    }
                }
                  
                $ar_sale['dato'] = $ar;
              }else{
                $ar_sale['error'] = "Faltan datos";
              }  
              break;
      default:
              // leer TODOS los valores de ese material
              $ar_costbandejas = $tcostbandejas->lee(' ORDER BY id_cstbandeja,id_elemen,id_complem,id_bandeja',0,"A");
              $ar_sale = $ar_costbandejas;
              break;
  }
}else{
  $ar_sale['opcion'] = "falta la opcion";
}
echo json_encode($ar_sale);