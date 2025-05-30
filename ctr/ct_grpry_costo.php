<?php
session_start();
 $_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} 

function vie($re,$variable){
    if( isset( $re[$variable] ) ){
        return $re[$variable];
    }else{
        return "";
    }
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);

include_once(C."/cls/clsTablam.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
} 
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$tprycosto = new Tabla($odb,"gr_prycosto");
//$arf = fopen("salida","w");
$ar_sale = [];
$ar_sale['sale'] = '1';
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'lee_prycosto':
                $id_prycosto = vie($_REQUEST,'id_prycosto');
                $descrip_pry = vie($_REQUEST,'descrip_pry');
                $nom_cliente = vie($_REQUEST,'nom_cliente');
                $ciudad      = vie($_REQUEST,'ciudad');
                $ciudad_proy = vie($_REQUEST,'ciudad_proy');
                $utilidad    = vie($_REQUEST,'utilidad');
                $iva         = vie($_REQUEST,'iva');
                $trm         = vie($_REQUEST,'trm');
                $fecha       = vie($_REQUEST,'fecha');    
                $ctro_costo  = vie($_REQUEST,'ctro_costo');
                $ar = ['cod_ciu_ori'=>$ciudad,'fechora'=>date('Y-m-d H:i:s'),'ctro_costo'=>$ctro_costo,'nom_cliente'=>$nom_cliente,
                        'descrip_proy'=>$descrip_pry,'codciu_proy'=>$ciudad_proy,'trm_proy'=>$trm,'profit_proy'=>$utilidad,'iva_proy'=>$iva,
                    'grabador'=>$_SESSION['codusr']];
                if( $id_prycosto == "" || $id_prycosto == null ){
                    $r = $tprycosto->ins($ar);
                    if($r){
                        $lastid = $tprycosto->last_id();
                        $ar_sale['id_prycosto'] = $lastid;
                    }else{
                        $ar_sale['error'] = $r;
                        
                    }    
                }else{
                    $ar_pry = $tprycosto->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                    if(empty($ar_pry)){
                        $r = $tprycosto->ins($ar);
                        if($r){
                            $lastid = $tprycosto->last_id();
                            $ar_sale['id_prycosto'] = $lastid;    
                        }else{
                            $ar_sale['error'] = $r;
                        }
                    }else{
                        $r = $tprycosto->mod($ar," WHERE id_prycosto=".$id_prycosto);
                        if($r){
                            $ar_sale['id_prycosto'] = $id_prycosto;
                        }else{
                            $ar_sale['error'] = $r;
                        }
                    }
                }
                break;
        default:
                $ar_sale['opcion'] = "sin opcion";
                break;
    }
}else{
    $ar_sale['opcion'] = " sin opcion ";
}
echo json_encode( $ar_sale );