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
$ntabla = "gr_inst_valvulas";
$tinstvalvulas = new Tabla($odb,$ntabla);
$tcomplem   = new Tabla($odb,"gp_complem");
$tdiametros = new Tabla($odb,"gp_diametros");
//print_r($_REQUEST);
$opcion = strtolower($_REQUEST['opcion']);
switch($opcion){
  case '0':   // llama cantidad de opciones en tablas para limpiar.
            break;
  case 'leeinsvalv':
            if(isset($_REQUEST['diametro']) && isset($_REQUEST['complem'])){
              if(strpos($_REQUEST['complem'],"_") !==false ){
                $complem = str_replace("_",",",$_REQUEST['complem']);
              }else{
                $complem = $_REQUEST['complem'];
              }
              $w = " WHERE id_diametro=".$_REQUEST['diametro']." AND id_complem IN ( ".$complem." ) ORDER BY id_complem";
              //echo "Queda complem:".$complem."<br>";
              $ar = $tinstvalvulas->lee($w,0,"A");
            }else{
              $ar = array("Error");
            }
            echo json_encode($ar);
            break;
  case 'actinsvalv':
            if( isset($_REQUEST['complem']) && isset($_REQUEST['diametro'])){
              // actualizar dato de celda.
              //print_r($_REQUEST);
              $idcomplem  = $_REQUEST['complem'];
              $iddiametro = $_REQUEST['diametro'];
              $valor      = $_REQUEST['valor'];
              $id_vrins   = $_REQUEST['id'];
              $w =  " WHERE id_instvalvula=$id_vrins ";
              $ar_instvalvulas = $tinstvalvulas->lee($w,0,"A");
              $ar = array('id_complem'=>$idcomplem,'id_diametro'=>$iddiametro,'valor'=>$valor);
              if(empty($ar_instvalvulas)){
                  //echo " Se inserta <br>";
                  $resp = $tinstvalvulas->ins($ar);
              }else{
                  //echo " Se Modifica <br>";
                  $resp = $tinstvalvulas->mod($ar,$w);
              }
              echo $resp;
            }
            break;
  default :
            // leer TODOS los valores de ese material
            $ar_vrainstvalvulas = $tinstvalvulas->lee(' ORDER BY id_instvalvula,id_complem,id_diametro',0,"A");
            echo json_encode($ar_vrinstvalvulas);    
            break;  

}
