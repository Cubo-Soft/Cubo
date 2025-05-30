<?php
session_start();
 //$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} 

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);

include_once(C."/cls/clsTablam.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
} 
date_default_timezone_set("America/Bogota");
//print_r($_REQUEST);
$odb = new Bd($h,$pto,$u,$p,$d);
$tpryvalv = new Tabla($odb,"gr_pry_valv");
$thryvalv = new Tabla($odb,"gh_pry_valv");
//$tpryequi->ver_campos();
//$arf = fopen("salida",'a');
$ar_sale['sale'] = "1";
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'save_cst_insvalv':   // guarda costos instal. válvulas
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arreglo = "";
                if( isset( $_REQUEST['dato'])){
                    $arreglo = $_REQUEST['dato'];
                }
                
                $ar_ex = $tpryvalv->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;

                for($x=0;$x<count($ar_ex);$x++){
                    $r = $thryvalv->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }
                if($sigue){
                    $tpryvalv->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( is_array($arreglo)){
                        for($x=0; $x<count($arreglo);$x++){
                            if( $arreglo[$x]['valvula'] == "" || $arreglo[$x]['valvula'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'valvula'=>$arreglo[$x]['valvula'],'id_diam'=>$arreglo[$x]['id_diam'],
                                        'cantidad'=>$arreglo[$x]['cantidad'],'id_aislam'=>$arreglo[$x]['id_aislam'],
                                        'cst_mobra'=>$arreglo[$x]['cst_mobra'],'cst_pintura'=>$arreglo[$x]['cst_pintura'],
                                        'cst_aislam'=>$arreglo[$x]['cst_aislam'],'fechora_act'=>date('Y-m-d H:i:s'),
                                        'grabador'=>$_SESSION['codusr']];
                                $w = " WHERE id_prycosto=".$id_prycosto." AND valvula='".$arreglo[$x]['valvula']."'";        
                                $ar['id_pryvalv'] = null;
                                $r = $tpryvalv->ins($ar);
                                if(!$r){
                                    $ar_sale['error'] = $r;
                                    //fwrite($arf,date('Y-m-d H:i:s')." id_prycosto:".$id_prycosto.", sale:".$ar_sale['error']."\n");
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            break;
        case 'lee_cst_insvalv':
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $ar_pryvalv = $tpryvalv->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_pryvalv)){
                    $ar_sale['sale'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    $ar_sale['datos'] = $ar_pryvalv;
                }
            }
            break;
        default:
            $ar_sale['opcion'] = " opcion default";
            break;
    }
}else{
    $ar_sale['opcion'] = ' SIN opcion'; 
}
echo json_encode($ar_sale);
