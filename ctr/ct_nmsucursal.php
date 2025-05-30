<?php
session_start();
 $_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} 


include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);

include_once(C."/cls/clsTablam.php");
include_once(C."/cls/clsSucursal.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
} 

$odb = new Bd($h,$pto,$u,$p,$d);
$nits = new Tabla($odb,"nm_nits");
$sucursal = new clsSucursal($odb);
$personas = new Tabla($odb,"nm_personas");
$juridicas = new Tabla($odb,"nm_juridicas");
//$sucursal->ver_campos();
$ar_sale = [];
if( isset($_REQUEST['campo']) && isset( $_REQUEST['valor']) && isset( $_REQUEST['sucursal'] )){
    $campo = $_REQUEST['campo'];
    $valor = $_REQUEST['valor'];
    $idsuc = $_REQUEST['sucursal'];
    $opcion= $_REQUEST['opcion'];
    $ar_sale['campo'] = $campo;
    $ar_sale['opcion'] = $opcion;
    $arsuc = $sucursal->lee(" WHERE id_sucursal=".$idsuc,0,"A");
    //echo "<pre>";print_r($arsuc);echo "</pre>";

    $arr = [$campo=>$valor];
    $exito = $sucursal->modCampo($arr,$idsuc);

    //$arsuc = $sucursal->lee(" WHERE id_sucursal=".$idsuc,0,"A");
    //echo "<pre>";print_r($arsuc);echo "</pre>";
    $ar_sale['sale'] = $exito;
}
echo json_encode($ar_sale);
//$ar = $sucursal->retornaAllNombreSucursal();
?>