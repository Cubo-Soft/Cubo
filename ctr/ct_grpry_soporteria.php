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
$tprysoporte = new Tabla($odb,"gr_pry_perfiles");
$thrysoporte = new Tabla($odb,"gh_pry_perfiles");
//$tpryequi->ver_campos();
$ar_sale['sale'] = [];
$ar_sale['estado'] = true;
$arf = fopen("salida",'a');
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    fwrite($arf,"opcion:".$opcion."\n");
    switch($opcion){
        case 'save_cst_soporteria':   // guarda costos soporteria proyecto
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
                $ar_sale['estado'] = false;
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $resto = "";
                if( isset($_REQUEST['resto']) ){
                    $resto = $_REQUEST['resto'];
                }
                $arreglo = "";
                if( isset( $_REQUEST['dato']) ){
                    $arreglo = $_REQUEST['dato'];
                }
                $sigue = true;
                if( $resto == "" ){
                    $ar_sale['resto'] = "Falta resto ";
                    $ar_sale['estado'] = false;
                }else{
                    $ar_sale['resto'] = $resto;
                    $w = " WHERE id_prycosto=".$id_prycosto." AND resto = '".$resto."'";
                    $ar_ex = $tprysoporte->lee($w,0,"A");
                    for($x=0;$x<count($ar_ex);$x++){
                        $r = $thrysoporte->ins($ar_ex[$x]);
                        if(!$r){
                            $ar_sale['error'] = $r;
                            $ar_sale['estado'] = false;
                            $sigue = false;
                            break;
                        }
                    }    
                    
                    //if($sigue && count( $arreglo ) > 0 ){
                    if($sigue ){
                        $tprysoporte->bor(" WHERE id_prycosto=".$id_prycosto." AND resto='".$resto."'");
                        if( is_array($arreglo) ){                            
                            for( $x=0; $x < count($arreglo); $x++ ){
                                if( $arreglo[$x]['descr_perfil'] == "" || $arreglo[$x]['descr_perfil'] == null ){
                                    continue;
                                }else{
                                    $ar = ['id_pryperfil'=>null,'id_prycosto'=>$id_prycosto,'resto'=>$resto,
                                            'descr_perfil'=>$arreglo[$x]['descr_perfil'],
                                            'matsop'=>$arreglo[$x]['matsop'],'cansop'=>$arreglo[$x]['cansop'],
                                            'cst_material'=>$arreglo[$x]['cst_material'],'cst_mobra'=>$arreglo[$x]['cst_mobra'],
                                            'cst_pintura'=>$arreglo[$x]['cst_pintura'],
                                            'fechora_act'=>date('Y-m-d H:i:s'),'grabador'=>$_SESSION['codusr']];
                                    $r = $tprysoporte->ins($ar);
                                    if(!$r){
                                        $ar_sale['error'] = $r;
                                        $ar_sale['estado'] = false;
                                        break;
                                    }
                                }
                            }
                        }
                    }    
                }
            }
            break;
        case 'lee_cst_soporteria':    // lee costos soporteria proyecto.
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
                $ar_sale['estado'] = false;
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $resto = "";
                if( isset( $_REQUEST['resto'] ) ){
                    $resto = $_REQUEST['resto'];
                }
                if( $resto == "" ){
                    $ar_sale['resto'] = " Falta resto";
                    $ar_sale['estado'] = false;
                }else{
                    $ar_sale['resto'] = $resto;
                    $campos = "descr_perfil,matsop,cansop,cst_material,cst_mobra,cst_pintura";
                    $ar_prysoporte = $tprysoporte->leec($campos," WHERE id_prycosto=".$id_prycosto." AND resto='".$resto."'",0,"A");
                    if(empty($ar_prysoporte)){
                        $ar_sale['sale'] = " No existe el proyecto ".$id_prycosto;
                        $ar_sale['estado'] = false;
                    }else{
                        $ar_sale['datos'] = $ar_prysoporte;
                    }    
                }
            }
            break;
        default:
            $ar_sale['opcion'] = " opcion default";
            $ar_sale['estado'] = false;
            break;
    }
}else{
    $ar_sale['opcion'] = ' SIN opcion';
    $ar_sale['estado'] = false; 
    //fwrite($arf,"opcion: SIN opcion \n");
}
//fclose($arf);
echo json_encode($ar_sale);
                                