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
$ntabla = "gp_medi_mercado";
$tmedimercado = new Tabla($odb,$ntabla);
$ar_sale = [];
if( !isset( $_REQUEST['opcion'] ) ){
  $ar_sale['opcion'] = "Falta la opcion";
}else{
  $opcion = $_REQUEST['opcion'];
  $ar_sale['opcion'] = $opcion;
  switch($opcion){
      case '7':   // consulta de registros de medidas dependen del diámetro.
          if( !isset( $_REQUEST['diametro'] ) || !isset($_REQUEST['resto'] ) ){
              $ar_sale['error'] = "Falta diametro y/o resto";
          }else{
              $diametro = $_REQUEST['diametro'];
              $resto = $_REQUEST['resto'];
              $ar_sale['resto'] = $resto;
              $w = " WHERE diametro=".$diametro;
              $ar_medi  = $tmedimercado->leec("pulg_medi",$w,0,"A");
              $ar_sale['dato'] = $ar_medi;                        
          }
          break;
      default :   // leemos todos los diámetros de medidas 
          $ar_medi  = $tmedimercado->lee("",0,"A");
          $ar_sale['dato'] = $ar_medi;
          break;
  }  
}
echo json_encode($ar_sale);
