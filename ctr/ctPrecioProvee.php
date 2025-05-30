<?php
session_start();
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function reemp_carac($texto,$carac){
  return str_replace($carac,$carac.$carac,$texto);
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
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
$o_precio = new clsPrecioProvee($odb);
$arch=fopen("salidaCargue","a+");
fwrite($arch,"Abriendo el ctPrecioProvee ... \n");
$ar_sale = [];
if (isset( $_REQUEST['opcion'] ) ){
    $opcion = $_REQUEST['opcion'];
    fwrite($arch," Opcion: ".$opcion." \n");
    $ar_sale['opcion'] = $opcion;
    $ar_sale['estado'] = true; 
    switch($opcion){
        case 'precioVenta':
            if( isset($_REQUEST['linea']) && isset($_REQUEST['ref_provee']) ){
              $arr['ref_provee'] = $_REQUEST['ref_provee']; $arr['id_rol'] = $_SESSION['id_rol'];
              $ar_sale['linea'] = $_REQUEST['linea'];
              $ar_sale['cantidad'] = $_REQUEST['cant'];
              $ar_sale['ref_provee'] = $_REQUEST['ref_provee'];
              $ar_sale['data'] = $o_precio->leePrecioVta($arr,0);
            }else{
              $ar_sale['error'] = "Falta ref_provee";
            }
            break;
        case 'leeTmpPrecios':
            if( !isset($_REQUEST['tmpTabla']) ){
              $ar_sale['error'] = "Falta la temporal";
            }else{
              $tmpTabla = $_REQUEST['tmpTabla'];
              $o_tmp = new Tabla($odb,$tmpTabla);
              if( !isset( $_REQUEST['archivo'] ) ){
                $ar_sale['error'] = "Falta archivo";
              }else{
                if( !file_exists($_REQUEST['archivo']) ){
                  $ar_sale['error'] = "el archivo ".$_REQUEST['archivo']." NO EXISTE !";
                }else{
                  fwrite($arch,"en ctPrecioProvee archivos OK... \n");
                  $o_tmp->limp();  // vacia la tabla temporal para el cargue del CSV.
                  if( $a_datos = file( $_REQUEST['archivo'] ) ){
                    fwrite($arch,"Cargados registros a arreglo ".count($a_datos)." registros... \n");
                    //  aqui cargar el listado CSV de precios, ojo en el orden de columnas
                    //  estruct CSV: id_marca(0), referencia(1), codigo_grupo(2), nombre(3), precio_usd(4)
                    for( $x=0; $x < count($a_datos); $x++ ){
                      $arl = explode(";",$a_datos[$x]);
                      // orden en temporal: marca, grupo, referencia, descripcion, precio
                      if( !is_numeric($arl[4]) || $arl[4] < 1 ){
                        $ar_sale['estado'] = "Error en campo PRECIO ".$arl[4];
                        break;
                      }
                      if( strpos($arl[1],"'") !== false ){
                        $arl[1] = reemp_carac($arl[1],"'");
                      }
                      if( strpos($arl[3],"'") !== false){
                        $arl[3] = reemp_carac($arl[3],"'");
                      }
                      $ar = array("id_marca"=>$arl[0],"codigo_grupo"=>$arl[2],"referencia"=>$arl[1],
                            "nombre"=>$arl[3],"precio_usd"=>$arl[4]); 
                      fwrite($arch," registro ".$ar[1]." \n");
                      if( $o_tmp->inst($ar) ){
                        fwrite($arch,"registro ".$x." adicionado \n");
                      }else{
                        fwrite($arch,"Falló adicion registro \n");
                      }
                    }
                  }else{
                    $ar_sale['estado'] = "Fallo en lectura de archivo";
                    break;
                  }
                }
              }
              $a_tmpPrecios = $o_tmp->lee("",0,"A");
              //echo "<pre>";print_r($a_tmpPrecios);echo "<pre>";
              $ar_sale['data'] = count($a_tmpPrecios); 
            }
            break;
        case 'actPrecios':
            $tmpPrecios = $_REQUEST['tmpTabla'];
            $fechaCarga = $_REQUEST['fecha_carga'];
            $id_moneda  = $_REQUEST['id_moneda'];
            $o_tmp      = new Tabla($odb,$tmpPrecios); 
            $ar_sale['data'] = $o_precio->act_precio($o_tmp,$fechaCarga,$id_moneda);
            break;
      default: $ar_sale['error'] = "Falta la opcion";$ar_sale['estado'] = false;
            break;
     }
}else{
  $ar_sale['opcion'] = "Falta la opcion";
}
fclose($arch);
echo json_encode($ar_sale);
?> 