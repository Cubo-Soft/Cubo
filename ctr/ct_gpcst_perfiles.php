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
$ntabla = "gp_cst_perfiles";
$tvrperfiles = new Tabla($odb,$ntabla);
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'leevr_perfil':  //lee valores de perfiles
            if(isset($_REQUEST['id_perfil'])){
                $id_perfil = $_REQUEST['id_perfil'];
                $ar_ex = $tvrperfiles->lee(" WHERE id_perfil=".$id_perfil,0,"A");
                if(count($ar_ex) > 0){
                    $ar_sale['dato'] = $ar_ex;
                }else{
                    $ar_sale['dato'] = " sin dato";
                }
            }else{
                $ar_sale['error'] = "Falta el Perfil";
            }    
            if(isset($_REQUEST['resto'])){
                $ar_sale['resto'] = $_REQUEST['resto'];
            }
            break;
    }
}else{
    $ar_sale['opcion'] = " SIN opcion";
    $ar_sale['sale'] = "0";
}
//fwrite($arf,json_encode($ar_sale)." \n");
//fclose($arf);
echo json_encode($ar_sale);