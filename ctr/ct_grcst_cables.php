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
$ntabla = "gr_cst_cables";
$tcables = new Tabla($odb,$ntabla);
//echo "en la tabla ".$tcables->nomTabla."<br>";
//print_r($_REQUEST);echo "<br>";
$opcion = strtolower($_REQUEST['opcion']);
switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
              break;
    case 'leevr_cable': 
              if(isset($_REQUEST['tipocable']) && isset($_REQUEST['id_cable'])){
                $w = " WHERE id_cable='".$_REQUEST['id_cable']."' AND id_tipocable='".$_REQUEST['tipocable']."'";
                $ar = $tcables->lee($w,0,"A");
              }else{
                $ar = array("Error");
              }
              echo json_encode($ar);
              break;
    default: echo "por default";
              break;
}