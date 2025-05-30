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
$ar_sale = [];
if( !isset( $_REQUEST['opcion'] ) ){
  $ar_sale['opcion'] = "FALTA la opcion";
}else{
  $opcion = $_REQUEST['opcion'];
  $ar_sale['opcion'] = $opcion;
  switch($opcion){
    case '0':   // llama cantidad de opciones en tablas para limpiar.
        $ar_comple=$tcomple->lee("");
        $ar_medida=$tmedidas->lee("");
        $ar = array('tot_complem'=>count($ar_comple),'tot_medidas'=>count($ar_medida));
        $ar_sale = $ar;
        break;
    case '1':  // leer TODOS los valores de ese material
        if( !isset( $_REQUEST['material'] ) ){
          $ar_sale['error'] = "FALTA el material";
        }else{
          $idmaterial = $_REQUEST['material'];
          $ar_costelem = $tcostelem->lee(" WHERE id_material=".$idmaterial." ORDER BY id_material,id_complem,id_medida",0,"A");
          $ar_sale = $ar_costelem;    
        }
        break;
    case '2':    // actualizar dato de celda.
        if( isset($_REQUEST['complemento']) && isset($_REQUEST['medida']) && 
            isset($_REQUEST['material'])    && isset($_REQUEST['valor'])    ){
          $idcomplem  = $_REQUEST['complemento'];
          $idmedida   = $_REQUEST['medida'];
          $idmaterial = $_REQUEST['material'];
          $valor      = $_REQUEST['valor'];
          $w =  " WHERE id_material=$idmaterial AND id_complem=$idcomplem AND id_medida=$idmedida";
          $ar_cost    = $tcostelem->lee($w,0,"A");
          $ar = array('id_material'=>$idmaterial,'id_complem'=>$idcomplem,'id_medida'=>$idmedida,'valor'=>$valor);
          if(empty($ar_cost)){
            $res = $tcostelem->ins($ar);
            $ar_sale = $res;
          }else{
            $res = $tcostelem->mod($ar," WHERE id_medimaterial=".$ar_cost[0]['id_medimaterial']);
            $ar_sale = $res;
          }
        }else{
          $ar_sale['error'] = "FALTA complemento y/o medida";
        }
        break;
    case '8':  // lectura desde resumen_pry costo material por medida
        if( isset($_REQUEST['resto']) && isset($_REQUEST['medida']) && isset($_REQUEST['material'])){
          $medida = $_REQUEST['medida'];  $idmaterial=$_REQUEST['material'];
          $w = "SELECT id_complem,valor FROM ".$tcostelem->nomTabla." WHERE id_material=$idmaterial AND ";
          $w .=" id_medida IN ( SELECT id_medida FROM gp_medidas WHERE pulg_medida='$medida' ) ORDER BY id_complem";
          $ar_medi_mat = $tcostelem->ejec($w,"S","A");
          for($x=0; $x<count($ar_medi_mat);$x++){
              $ar_medi_mat[$x]['resto'] = $_REQUEST['resto'];
          }
          $ar_sale = $ar_medi_mat;
        }  
        break;
  }  
}
echo json_encode($ar_sale);