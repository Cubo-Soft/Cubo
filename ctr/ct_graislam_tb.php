<?php
session_start();
/* $_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} */

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_aislam_tb";
$taislamtb  = new Tabla($odb,$ntabla);
$taislamie  = new Tabla($odb,"gp_aislamie");
$tdiametros = new Tabla($odb,"gp_diametros");
$ar_sale = [];

if( !isset( $_REQUEST['opcion'] ) ){
  $ar_sale['opcion'] = "Error,Falta opción";
}else{
  $opcion = $_REQUEST['opcion'];
  $ar_sale['opcion'] = $opcion;
  $resto = "";
  if( isset( $_REQUEST['resto'] ) ){
    $resto = $_REQUEST['resto'];
  }
  $ar_sale['resto'] = $resto;

  switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
              $ar_comple=$tcomple->lee("");
              $ar_medida=$tmedidas->lee("");
              $ar = array('tot_complem'=>count($ar_comple),'tot_medidas'=>count($ar_medida));
              $ar_sale['dato'] = $ar;
              $ar_sale['sale'] = 1;
              break;
    case '2':   // actualizar dato de celda.
              if( isset($_REQUEST['diametro']) && isset($_REQUEST['aislamiento'])){
                $iddiametro  = $_REQUEST['diametro'];
                $idaislamie  = $_REQUEST['aislamiento'];
                $valor       = $_REQUEST['valor'];
                $id_vraisla  = $_REQUEST['id'];
                $w =  " WHERE id_vraislam=$id_vraisla ";
                $ar_aislam_tb = $taislamtb->lee($w,0,"A");
                $ar = array('id_diametro'=>$iddiametro,'id_aislamie'=>$idaislamie,'valor'=>$valor);
                if(empty($ar_aislam_tb)){
                    $res = $taislamtb->ins($ar);
                    $ar_sale = $res;
                }else{
                    $res = $taislamtb->mod($ar,$w);
                    $ar_sale = $res;
                }
              }else{
                $ar_sale['sale'] = "Falta Diametro y/o aislamiento";
              }
              break;  
    case 'lee2' :  // lee valor desde diametro y aislam para resume_pry. Ojo, la medida es ej: '4x3'.
              if(isset($_REQUEST['diametro']) && isset($_REQUEST['aislam']) && isset($_REQUEST['medida'])){
                //print_r($_REQUEST);echo "<br>";
                if($_REQUEST['medida'] == "" || $_REQUEST['medida'] == "0"  || $_REQUEST['medida'] == "Sin elegir" ){ 
                    $_REQUEST['medida'] = '4x2';
                }
                $id_dia = $_REQUEST['diametro']; $id_ais = $_REQUEST['aislam']; $med = $_REQUEST['medida'];
                $tmedidas = new Tabla($odb,"gp_medidas");
                $ar_med = $tmedidas->lee(" WHERE pulg_medida='".$med."'",0,"A");
                //print_r($ar_med);echo "<br>";
                $id_med = $ar_med[0]['id_medida'];
                //echo "Viene id_idametro:".$id_dia." id_aislam: ".$id_ais." id_medida: ".$id_med."<br>";
                $ar_ais = $taislamtb->lee(" WHERE id_diametro=$id_dia AND id_aislam=$id_ais",0,"A");
                //print_r($ar_ais);echo "<br>";
                $taislr = new Tabla($odb,"gr_aisl_reduc");
                $ar_red = $taislr->lee(" WHERE id_aislam=$id_ais AND id_medida=$id_med",0,"A");
                //print_r($ar_red);echo "<br>";
                $ar = array('vr_aislam'=>$ar_ais[0]['valor'],'vr_reduc'=>$ar_red[0]['valor'],'resto'=>$_REQUEST['resto']);
                $ar_sale['dato'] = $ar;
              }else{
                $ar_sale['dato'] = $ar = false;
              }
              break;
    case 'leeaisl_tb':
              if(isset($_REQUEST['diametro']) && isset($_REQUEST['aislam'])){
                $ar_ais = $taislamtb->lee(" WHERE id_diametro=".$_REQUEST['diametro']." AND id_aislam=".$_REQUEST['aislam'],0,"A");
                $ar_sale['dato'] = $ar_ais;
              }else{
                $ar_sale['error'] =" Faltan diametro y/o aislamiento";
              }
              break;
    default :   // leer TODOS los valores de ese material
              $ar_vraislamtb = $taislamtb->lee(' ORDER BY id_vraislam,id_diametro,id_aislam',0,"A");
              $ar_sale['dato'] = $ar_vraislamtb;    
              break;
  }
}

echo json_encode($ar_sale);