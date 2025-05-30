<?php
session_start();
//$_SESSION['id_rol'] = 1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb     = new Bd($h,$pto,$u,$p,$d);
$ntabla  = "gr_aislam_eq";
$tabla   = new Tabla($odb,$ntabla);

$opcion = $_REQUEST['opcion'];
if( $opcion == '1' && isset( $_REQUEST['idespesor'] ) ) { 
    $ar_tabla = $tabla->lee(" WHERE id_espesor='".$_REQUEST['idespesor']."'",0,"A");
    echo json_encode($ar_tabla);
}