<?php
session_start();
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_cst_bandejas";
$tcostbandejas = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tbandej = new Tabla($odb,"gp_bandeja");
//$idconduleta = $_REQUEST['conduleta'];
$opcion = $_REQUEST['opcion'];
switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
            $ar_elemen=$telemen->lee("");
            $ar_comple=$tcomple->lee("");
            $ar_bandej=$tbandej->lee("");
            $ar = array('tot_elemen'=>count($ar_elemen),'tot_complem'=>count($ar_comple),'tot_bandej'=>count($ar_bandej));
            echo json_encode($ar);    
            break;
    case '':     // actualizar dato de celda.
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
                  echo $res;
              }else{
                  $res = $tcostbandejas->mod($ar," WHERE id_cstbandeja=".$ar_cost[0]['id_cstbandeja']);
                  echo $res;
              }
            }
            break;
    default:
            // leer TODOS los valores de ese material
            $ar_costbandejas = $tcostbandejas->lee(' ORDER BY id_cstbandeja,id_elemen,id_complem,id_bandeja',0,"A");
            echo json_encode($ar_costbandejas);
            break;
}
