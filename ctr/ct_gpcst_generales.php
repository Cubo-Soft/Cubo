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
$ntabla  = "gp_cst_generales";
$tabla   = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tdiamet = new Tabla($odb,"gp_diametros");
//$idmaterial = $_REQUEST['material'];
$opcion = $_REQUEST['opcion'];
if( $opcion == '0'){ // lee la tabla principal.
    $ar_tabla = $tabla->lee("",0,"A");
    echo json_encode($ar_tabla);
}