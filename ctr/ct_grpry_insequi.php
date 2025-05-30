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
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
} 
date_default_timezone_set("America/Bogota");
//print_r($_REQUEST);
$odb = new Bd($h,$pto,$u,$p,$d);
$tpryequi = new Tabla($odb,"gr_pry_equi");
$thryequi = new Tabla($odb,"gh_pry_equi");
//$tpryequi->ver_campos();
$ar_sale['sale'] = "1";
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'save_cst_insequi':   // guarda costos instal. equipos
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arreglo = "";
                if( isset( $_REQUEST['dato'] )){
                    $arreglo = $_REQUEST['dato'];
                }
                $arf = fopen("salida",'a');
                $ar_ex = $tpryequi->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;
                for($x=0;$x<count($ar_ex);$x++){
                    $r = $thryequi->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }
                if($sigue ){
                    $tpryequi->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( is_array( $arreglo )){
                        for( $x=0; $x < count($arreglo); $x++ ){
                            if( $arreglo[$x]['equipo'] == "" || $arreglo[$x]['equipo'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'equipo'=>$arreglo[$x]['equipo'],'peso'=>$arreglo[$x]['peso'],'largo'=>$arreglo[$x]['largo'],
                                'ancho'=>$arreglo[$x]['ancho'],'alto'=>$arreglo[$x]['alto'],'aislam'=>$arreglo[$x]['aislam'],'costo_instal'=>$arreglo[$x]['costo_instal'],
                                'costo_aislam'=>$arreglo[$x]['costo_aislam'],'fechora_act'=>date('Y-m-d H:i:s'),'grabador'=>$_SESSION['codusr']];
                                $w = " WHERE id_prycosto=".$id_prycosto." AND equipo='".$arreglo[$x]['equipo']."'";        
                                $ar['id_pryequi'] = null;
                                $r = $tpryequi->ins($ar);
                                if(!$r){
                                    $ar_sale['error'] = $r;
                                    fwrite($arf,date('Y-m-d H:i:s')." id_prycosto:".$id_prycosto.", sale:".$ar_sale['error']."\n");
                                    break;
                                }
                            }
                        }
                    }
                }else{
                        $ar_sale['error'] = "sin datos ";
                    }
                }
            break;
        case 'lee_cst_insequi':   // lee costos instal. equipos
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $ar_pryequi = $tpryequi->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_pryequi)){
                    $ar_sale['sale'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    $ar_sale['datos'] = $ar_pryequi;
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
