<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_cst_conduleta";
$tcostcondule = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tdiamet = new Tabla($odb,"gp_diametros");
$opcion = $_REQUEST['opcion'];
switch($opcion){
  case '0':   // llama cantidad de opciones en tablas para limpiar.
            $ar_elemen=$telemen->lee("");
            $ar_comple=$tcomple->lee("");
            $ar_diamet=$tdiamet->lee("");
            $ar = array('tot_elemen'=>count($ar_elemen),'tot_complem'=>count($ar_comple),'tot_diamet'=>count($ar_diamet));
            echo json_encode($ar);  
            break;
  case '1':   // leer TODOS los valores de ese material 
              $idconduleta = $_REQUEST['conduleta'];
              $ar_costcondule = $tcostcondule->lee(' ORDER BY id_conduleta,id_elemen,id_complem,id_diametro',0,"A");
              echo json_encode($ar_costcondule);    
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
                    echo $res;
                }else{
                  $res = $tcostcondule->mod($ar," WHERE id_cstconduleta=".$ar_cost[0]['id_cstconduleta']);
                  echo $res;
                }
            }
            break;
    case 'leevr_conduleta':  // lee los valores de material y mano de obra desde tuberia y dimension complem='1_2'; elemen='1_2_3_4';
            if(isset($_REQUEST['tuberia']) && isset($_REQUEST['dimension']) && isset($_REQUEST['complem']) && isset($_REQUEST['elemen'])){
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
  
              // voy aquiiiiii
            }else{
              $ar = array("faltan datos");
            }
            echo json_encode($ar);
            break;
}
