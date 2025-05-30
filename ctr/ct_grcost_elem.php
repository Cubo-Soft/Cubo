<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}
function lee_increm($tab,$id){
  switch($id){
    case '1': $idn = '0905';break;
    case '2': $idn = '0904';break;
    case '3': $idn = '0908';break;
    case 'Inc. MO Soldador': $idn = '0901';break;
    default: $idn="";break;
  }
  $ar = $tab->lee(" WHERE id_general='$idn'",0,"A");
  $incr = $ar[0]['vr_unit'];
  if( $ar[0]['u_medida'] == "%"){
    $incr = (1 + ( $incr / 100 ) );
  }
  return $incr;
}

include_once("../cls/carga_ini.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_cost_elem";
$tcostelem = new Tabla($odb,$ntabla);
$telemen = new Tabla($odb,"gp_elemen");
$tcomple = new Tabla($odb,"gp_complem");
$tdiamet = new Tabla($odb,"gp_diametros");
$tabincr = new Tabla($odb,"gp_cst_generales");
$idmaterial = $_REQUEST['material'];
$opcion = $_REQUEST['opcion'];
switch($opcion){
  case '0':  // llama cantidad de opciones en tablas para limpiar.
        $ar_elemen=$telemen->lee("");
        $ar_comple=$tcomple->lee("");
        $ar_diamet=$tdiamet->lee("");
        $ar = array('tot_elemen'=>count($ar_elemen),'tot_complem'=>count($ar_comple),'tot_diamet'=>count($ar_diamet));
        echo json_encode($ar);
        break;
  case '1':
        if(isset($_REQUEST['elemento']) && isset($_REQUEST['complemento']) && isset($_REQUEST['diametro'])){
            // actualizar dato de celda.
          $idelemen   = $_REQUEST['elemento'];
          $idcomplem  = $_REQUEST['complemento'];
          $iddiametro = $_REQUEST['diametro'];
          $valor      = $_REQUEST['valor'];
          $w = " WHERE id_material=$idmaterial AND id_elemen=$idelemen AND id_complem=$idcomplem AND id_diametro=$iddiametro";
          $ar_cost    = $tcostelem->lee($w,0,"A");
          $ar = array('id_material'=>$idmaterial,'id_elemen'=>$idelemen,'id_complem'=>$idcomplem,'id_diametro'=>$iddiametro,'valor'=>$valor);
          if(empty($ar_cost)){
            $res = $tcostelem->ins($ar);
            echo $res;
          }else{
            $res = $tcostelem->mod($ar," WHERE id_cost_elem=".$ar_cost[0]['id_cost_elem']);
            echo $res;
          }
        }else{
            // leer TODOS los valores de ese material
            $ar_costelem = $tcostelem->lee(' ORDER BY id_material,id_elemen,id_complem,id_diametro',0,"A");
            echo json_encode($ar_costelem);    
        }
        break;
  case '2':
  case '3':
  case '4':
  case '5':
  case '6':
        if(isset($_REQUEST['elemento']) && isset($_REQUEST['diametro']) && $_REQUEST['material']){
          // consultar el valor de celda.
          $idelemen   = $_REQUEST['elemento'];
          $idcomple   = $_REQUEST['comple'];
          $iddiametro = $_REQUEST['diametro'];
          $idmaterial = $_REQUEST['material'];
          $resto      = $_REQUEST['resto'];
          $comple = $idcomple;
          if(strpos($idcomple,"_") !== false){
            $comple = str_replace("_",",",$idcomple);
          }
          $w = " WHERE id_material=$idmaterial AND id_elemen=$idelemen AND id_diametro=$iddiametro AND ";
          $w .= " id_complem IN( $comple ) ";
          $ar_cost = $tcostelem->lee($w,0,"A");
          $incrMatr = lee_increm($tabincr,$idmaterial);
          $incrMob  = lee_increm($tabincr,'Inc. MO Soldador');
          for($x=0; $x < count($ar_cost); $x++ ){
              $ar_cost[$x]['resto'] = $resto;
              switch( $ar_cost[$x]['id_complem'] ){
                case '1': $ar_cost[$x]['valor'] = ( $ar_cost[$x]['valor'] * $incrMatr );break;
                case '2': $ar_cost[$x]['valor'] = ( $ar_cost[$x]['valor'] * $incrMob );break;
              }
          }
          echo json_encode($ar_cost);
        }else{
          $ar_sale['opcion'] = $opcion;
          $ar_sale['error'] = "Falta algún parámetro";
          echo json_encode($ar_sale);
        }    
        break;
}