<?php
session_start();
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function mezcla($a_items, $a_prov, $a_marcas, $a_lineas, $a_grupos, $a_tipos, $obj, $id_rol=0){
  for($x=0;$x<count($a_items);$x++){
    for($y=0;$y<count($a_prov);$y++){
      if($a_prov[$y]['id_sucursal'] == $a_items[$x]['id_proveedor']){
        if($a_prov[$y]['tipo_per'] == 23){
          $a_items[$x]['id_proveedor'] = $a_prov[$y]['apelli_nom'];
        }else{
          $a_items[$x]['id_proveedor'] = $a_prov[$y]['razon_social'];
        }
      }
    }
    for($y=0;$y<count($a_marcas);$y++){
      if($a_marcas[$y]['id_marca'] == $a_items[$x]['id_marca']){
        $a_items[$x]['id_marca'] = $a_marcas[$y]['nom_marca'];
      }
    }
    for($y=0;$y<count($a_lineas);$y++){
      if($a_lineas[$y]['id_linea'] == $a_items[$x]['linea']){
        $a_items[$x]['linea'] = $a_lineas[$y]['descrip'];
      }
    }
    for($y=0;$y<count($a_grupos);$y++){
      if($a_grupos[$y]['cod_grupo'] == $a_items[$x]['grup_item']){
        $a_items[$x]['grup_item'] = $a_grupos[$y]['nom_grupo'];
      }
    }

    for($y=0;$y<count($a_tipos);$y++){
      if($a_tipos[$y]['id_tipo'] == $a_items[$x]['tipo_item']){
        $a_items[$x]['tipo_item'] = $a_tipos[$y]['descrip'];
      }
    }

    if( $obj !== null ){
      $arr = array('id_marca'=>$a_items[$x]['id_marca'], 'alter_item'=>$a_items[$x]['alter_item'], 'id_rol'=>$id_rol );
      $a_precio = $obj->leePrecioVta($arr,0);
       if( ( $a_precio[0]['precio'] !== null && $a_precio[0]['precio'] !== $a_items[$x]['precio_vta_usd'] ) || empty($a_precio) ){
         $a_items[$x]['precio_vta_usd'] = $a_precio[0]['precio'];
         $a_items[$x]['moneda'] = $a_precio[0]['abr_moneda'];
       }  
    }
  }
  return $a_items;
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
include_once(C."/cls/clsPrecioProvee.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
}

$odb = new Bd($h,$pto,$u,$p,$d);
$items = new Tabla($odb,"im_items");
$nits = new Tabla($odb,"nm_nits");
$sucursales = new Tabla($odb,"nm_sucursal");
$personas = new Tabla($odb,"nm_personas");
$juridicas = new Tabla($odb,"nm_juridicas");
$grupos = new Tabla($odb,"ip_grupos");
$marcas = new Tabla($odb,"ip_marcas");
$lineas = new Tabla($odb,"ip_lineas");
$articulos = new Tabla($odb,"ip_articulos");
$tipos = new Tabla($odb,"ip_tipos");
$tprecioProv = new clsPrecioProvee($odb);
$id_rol = $_SESSION['id_rol'];
$sqli = "SELECT i.cod_item, i.alter_item, i.nom_item, i.id_proveedor, i.id_marca, 
          i.precio_vta, i.precio_vta_usd, i.minimo, i.maximo, s.saldo ";

$sqli2 = ", i.linea, i.grup_item, i.articulo, i.tipo_item, i.iva "; 
$sqlid = " FROM im_items i JOIN ir_salinve s ON s.cod_item=i.cod_item AND s.codbodeg=1 ";

$sqlp = "SELECT n.numid, n.idclase, n.tipo_per, s.id_sucursal, p.apelli_nom, j.razon_social 
FROM nm_sucursal s,nm_nits n LEFT JOIN nm_personas p ON p.numid=n.numid 
LEFT JOIN nm_juridicas j ON j.numid = n.numid WHERE s.numid=n.numid";

$a_prov = $nits->ejec($sqlp,"S","A"); 
$a_marcas = $marcas->lee(" ORDER BY id_marca");
$a_lineas = $lineas->lee(" ORDER BY id_linea");
$a_grupos = $grupos->lee(" ORDER BY cod_grupo");
$a_tipos  = $tipos->lee(" ORDER BY id_tipo");

if (isset( $_REQUEST['opcion'] ) ){
   $opcion = $_REQUEST['opcion'];
   $ar_sale['opcion'] = $opcion;
   $ar_sale['estado'] = true; 
   switch($opcion){
    case 'listaItems':
          if(isset($_REQUEST['entidad']) && isset($_REQUEST['proveedor']) && 
             isset($_REQUEST['marca'])   && isset($_REQUEST['tope'])){
              $entidad= $_REQUEST['entidad'];
              $proveedor=$_REQUEST['proveedor'];
              $marca=$_REQUEST['marca'];
              $tope = $_REQUEST['tope'];
              $w = $t = "";
              if($tope == "n"){
                $t = " AND s.saldo <= i.minimo ";
              }
              if($tope == "x"){
                $t = " AND s.saldo >= i.maximo ";
              }
            
              if( $proveedor >0 || $marca != "" ){
                $w = " WHERE ";
              }
            
              if($proveedor > 0 ){
                $a_sucprov = $sucursales->lee(" WHERE numid='".$proveedor."'");
                $w .= " i.id_proveedor=".$a_sucprov[0]['id_sucursal'];
              } 
            
              if($marca != ""){
                if( $proveedor > 0 ){
                  $w .= " AND ";
                }
                $w .= " i.id_marca=".$marca;
              }
              $sql = $sqli.$sqli2.$sqlid.$t.$w;
              $a_items = $items->ejec($sql,"S","A");
              
              $an_items = mezcla($a_items, $a_prov, $a_marcas, $a_lineas, $a_grupos, $a_tipos, null);
              $ar_sale['data'] = $an_items; 
          }   
          break;
    case 'listaPrecios':
          if( isset($_REQUEST['tipo_referencia']) && isset($_REQUEST['referencia']) && isset($_REQUEST['id_marca']) ){
            $id_marca   = $_REQUEST['id_marca']; 
            $tipoRef = $_REQUEST['tipo_referencia'];
            $referen = $_REQUEST['referencia'];
            $cantidad= $_REQUEST['cantidad'];
            $ar_sale['cantidad'] = $cantidad;
            $sql = $sqli." AND i.".$tipoRef." LIKE '".$referen."%'";
            if( $id_marca !== '-1' ){
              $sql .= " AND i.id_marca=".$id_marca;
            }
            $a_items = $items->ejec($sql,"S","A");
            $a_items = mezcla($a_items, $a_prov, $a_marcas, $a_lineas, $a_grupos, $a_tipos, $precioProv,$id_rol);
             
            $ar_sale['data'] = $a_items;
          }else{
            $ar_sale['error'] = "Falta tipo_referencia, referencia o marca";
          }
          break;
    default: $ar_sale['error'] = "Falta la opcion";$ar_sale['estado'] = false;
          break;
   }
}else{
  $ar_sale['opcion'] = "Falta la opcion";
}
echo json_encode($ar_sale);
?>