<?php
session_start();
$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_aisl_reduc";
$taislredu  = new Tabla($odb,$ntabla);
$taislamie  = new Tabla($odb,"gp_aislamie");
$tmedidas   = new Tabla($odb,"gp_medidas");
$id_vraisla = $_REQUEST['id'];
$opcion = $_REQUEST['opcion'];
if( $opcion == '0'){ // llama cantidad de opciones en tablas para limpiar.
}else{
  if( isset($_REQUEST['medida']) && isset($_REQUEST['aislamiento'])){
      // actualizar dato de celda.
    $idmedida   = $_REQUEST['medida'];
    $idaislamie = $_REQUEST['aislamiento'];
    $valor      = $_REQUEST['valor'];
    $w =  " WHERE id_aislreduc=$id_vraisla ";
    $ar_aislreduc = $taislredu->lee($w,0,"A");
    $ar = array('id_aislamie'=>$idaislamie,'id_medida'=>$idmedida,'valor'=>$valor);
    if(empty($ar_aislreduc)){
      $res = $taislredu->ins($ar);
        echo $res;
    }else{
      $res = $taislredu->mod($ar,$w);
      echo $res;
    }
  }else{
      // leer TODOS los valores de ese material
      $ar_vraislreduc = $taislredu->lee(' ORDER BY id_aislreduc,id_aislam,id_medida',0,"A");
      echo json_encode($ar_vraislreduc);    
  }
}