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
$ntabla = "gp_bandeja";
$tbandeja = new Tabla($odb,$ntabla);
$ar_sale = [];
if( !isset( $_REQUEST['opcion'] ) ){
  $ar_sale['opcion'] = "Falta la opcion";
}else{
  $opcion = $_REQUEST['opcion'];
  $ar_sale['opcion'] = $opcion;
  switch($opcion){
      case 'lee_dimensiones':   // consulta todos los registros de gp_bandeja.
          if( !isset( $_REQUEST['resto'] ) ){
              $ar_sale['error'] = "Falta resto";
          }else{
              $resto = $_REQUEST['resto'];
              $destino = $_REQUEST['destino'];
              $ar_sale['resto'] = $resto;
              $ar_medi  = $tbandeja->lee("",0,"N");
              $ar_sale['dato'] = $ar_medi;    
              $ar_sale['destino'] = $destino;                    
          }
          break;
      default :   // leemos todos los diámetros de medidas 
          $ar_medi = $tbandeja->lee("",0,"A");
          $ar_sale['dato'] = $ar_medi;
          break;
  }  
}
echo json_encode($ar_sale);
