<?php
session_start();
//$_SESSION['id_rol']=1;
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
$ntabla = "gr_cst_conduleta";
$tcostcondule = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tdiamet = new Tabla($odb,"gp_diametros");
$tcstgen = new Tabla($odb,"gp_cst_generales");
$ar_sale = [];
if( isset( $_REQUEST['opcion'] ) ){
  $opcion = $_REQUEST['opcion'];
  $ar_sale['opcion'] = $opcion;
  switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
            $ar_elemen=$telemen->lee("");
            $ar_comple=$tcomple->lee("");
            $ar_diamet=$tdiamet->lee("");
            $ar = array('tot_elemen'=>count($ar_elemen),'tot_complem'=>count($ar_comple),'tot_diamet'=>count($ar_diamet));
            $ar_sale = $ar;  
            break;
    case '1':   // leer TODOS los valores de ese material 
            $idconduleta = $_REQUEST['conduleta'];
            $ar_costcondule = $tcostcondule->lee(' ORDER BY id_conduleta,id_elemen,id_complem,id_diametro',0,"A");
            $ar_sale = $ar_costcondule;    
            break;
    case '2':   // actualizar dato de celda.
            if(isset($_REQUEST['elemento']) && isset($_REQUEST['complemento']) && isset($_REQUEST['diametro']) ){
              $idelemen   = $_REQUEST['elemento'];
              $idcomplem  = $_REQUEST['complemento'];
              $iddiametro = $_REQUEST['diametro'];
              $idconduleta = $_REQUEST['conduleta'];
              $valor      = $_REQUEST['valor'];
              $w =  " WHERE id_conduleta=$idconduleta AND id_elemen=$idelemen AND id_complem=$idcomplem AND id_diametro=$iddiametro";
              $ar_cost    = $tcostcondule->lee($w,0,"A");
              $ar = array('id_conduleta'=>$idconduleta,'id_elemen'=>$idelemen,'id_complem'=>$idcomplem,'id_diametro'=>$iddiametro,'valor'=>$valor);
              if(empty($ar_cost)){
                    $res = $tcostcondule->ins($ar);
              }else{
                    $res = $tcostcondule->mod($ar," WHERE id_cstconduleta=".$ar_cost[0]['id_cstconduleta']);
              }
              $ar_sale = $res;
            }else{
              $ar_sale['error'] = "Faltan datos";
            }
              break;
      case 'lee_valores':  // lee los valores de material y mano de obra desde tuberia y dimension complem='1_2'; elemen='1_2_3_4';
              if(isset($_REQUEST['tuberia']) && isset($_REQUEST['dimension']) && 
                 isset($_REQUEST['complem']) && isset($_REQUEST['elemen'])){
                $tuberia=$_REQUEST['tuberia'];
                $dimension=$_REQUEST['dimension'];
                $complem=$_REQUEST['complem'];
                $elemen=$_REQUEST['elemen'];
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
                $ar = $tcostcondule->lee(" WHERE id_conduleta=".$tuberia." AND id_elemen IN($eleme) AND id_complem IN($comple) AND id_diametro=".$dimension,0,"A");
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
              }else{
                $ar = array("faltan datos");
              }
              $ar_sale['dato'] = $ar;
              break;
  }  
}else{
  $ar_sale['opcion'] = "Falta la opcion";
}
echo json_encode($ar_sale);