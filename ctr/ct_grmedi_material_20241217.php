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
$ntabla = "gr_medi_material";
$tcostelem = new Tabla($odb,$ntabla);
$tcomple = new Tabla($odb,"gp_complem");
$tmedidas = new Tabla($odb,"gp_medidas");
$idmaterial = $_REQUEST['material'];
$opcion = $_REQUEST['opcion'];
switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
              $ar_comple=$tcomple->lee("");
              $ar_medida=$tmedidas->lee("");
              $ar = array('tot_complem'=>count($ar_comple),'tot_medidas'=>count($ar_medida));
              echo json_encode($ar);
              break;
    case '1':
              if( isset($_REQUEST['complemento']) && isset($_REQUEST['medida'])){
                // actualizar dato de celda.
                $idcomplem  = $_REQUEST['complemento'];
                $idmedida   = $_REQUEST['medida'];
                $valor      = $_REQUEST['valor'];
                $w =  " WHERE id_material=$idmaterial AND id_complem=$idcomplem AND id_medida=$idmedida";
                $ar_cost    = $tcostelem->lee($w,0,"A");
                $ar = array('id_material'=>$idmaterial,'id_complem'=>$idcomplem,'id_medida'=>$idmedida,'valor'=>$valor);
                if(empty($ar_cost)){
                  $res = $tcostelem->ins($ar);
                    echo $res;
                }else{
                  $res = $tcostelem->mod($ar," WHERE id_medimaterial=".$ar_cost[0]['id_medimaterial']);
                  echo $res;
                }
              }else{
                // leer TODOS los valores de ese material
                $ar_costelem = $tcostelem->lee(' ORDER BY id_material,id_complem,id_medida',0,"A");
                echo json_encode($ar_costelem);    
              }
              break;
    case '8':  // lectura desde resumen_pry costo material por medida
              if( isset($_REQUEST['resto']) && isset($_REQUEST['medida'])){
                  $medida = $_REQUEST['medida'];  
                  $w = "SELECT id_complem,valor FROM ".$tcostelem->nomTabla." WHERE id_material=$idmaterial AND ";
                  $w .=" id_medida IN ( SELECT id_medida FROM gp_medidas WHERE pulg_medida='$medida' ) ORDER BY id_complem";
                  $ar_medi_mat = $tcostelem->ejec($w,"S","A");
                  for($x=0; $x<count($ar_medi_mat);$x++){
                    $ar_medi_mat[$x]['resto'] = $_REQUEST['resto'];
                  }
                  echo json_encode($ar_medi_mat);
              }  
              break;
}
