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
$tpryadm = new Tabla($odb,"gr_pry_adm");
$thryadm = new Tabla($odb,"gh_pry_adm");
$ar_sale = [];
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'lee_cst_adm':   // lee costos admtvos
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "SIN id_prcosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $id_cons_adm = $_REQUEST['id_cons_adm'];
                $polizas     = $_REQUEST['polizas'];
                $costo_fcro  = $_REQUEST['costo_fcro'];
                $pers_admtvo = $_REQUEST['pers_admto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $a = ['id_prycosto'=>$id_prycosto,'polizas'=>$polizas,'costo_fcro'=>$costo_fcro,'pers_admtvo'=>$pers_admtvo,'fechora_act'=>date('Y-m-d H:i:s'),
                      'grabador'=>$_SESSION['codusr'] ];
                $ar = $tpryadm->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar)){
                    $r = $tpryadm->ins($a);
                    if($r){
                        $lastid = $tpryadm->last_id();
                        $ar_sale['id_cons_adm'] = $lastid;
                    }else{
                        $ar_sale['id_cons_adm'] = $r;
                    }
                }else{ 
                    $r = $thryadm->ins($ar[0]);
                    $r = $tpryadm->mod($a," WHERE id_prycosto=".$id_prycosto);
                    if($r){
                        $ar_sale['id_cons_adm'] = $ar[0]['id_cons_adm'];
                    }
                }
            }
            break;
        default:
            $ar_sale['opcion'] = " opcion default";
            break;
    }
}else{
    $ar_sale['opcion'] = "no viene la OPCION";
}
echo json_encode( $ar_sale );
