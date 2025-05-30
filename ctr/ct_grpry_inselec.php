<?php
session_start();
 //$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} 

function lee_t($tabla,$campo,$valor,$resp){
    $ar = $tabla->lee(" WHERE ".$campo."=".$valor,0,"A");
    if(empty($ar)){
        return "Sin definir";
    }else{
        return $ar[0][$resp];
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
$tprycabelec = new Tabla($odb,"gr_pry_cabelect");
$thrycabelec = new Tabla($odb,"gh_pry_cabelect");
$tprytubelec = new Tabla($odb,"gr_pry_tubelect");
$thrytubelec = new Tabla($odb,"gh_pry_tubelect");
$tgp_cables  = new Tabla($odb,"gp_cables"); 
$tgp_condule = new Tabla($odb,"gp_conduleta");
$tgp_aislami = new Tabla($odb,"gp_aislamie");
//$arf = fopen("salida",'a');
//fwrite($arf,date('Y-m-d H:i:s')." Abriendo ct_grpry_inselec.php\n");
$ar_sale['sale'] = "1";
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'save_cst_inselec':   // guarda costos instal. eléctrica
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arr_e = $arr_t = array();
                if(isset($_REQUEST['datoe'])){
                    $arr_e = $_REQUEST['datoe'];
                }
                if(isset($_REQUEST['datot'])){
                    $arr_t = $_REQUEST['datot'];
                }

                $ar_ex = $tprycabelec->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;

                for( $x=0; $x < count($ar_ex); $x++ ){
                    $r = $thrycabelec->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }
                if($sigue){
                    $tprycabelec->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( !empty($arr_e) && count( $arr_e ) > 0 ){
                        for ($x=0; $x < count($arr_e); $x++ ){
                            if( $arr_e[$x]['equipo'] == "" || $arr_e[$x]['equipo'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'equipo'=>$arr_e[$x]['equipo'],'id_cabelect'=>$arr_e[$x]['id_cabelect'],
                                        'id_cabdatos'=>$arr_e[$x]['id_cabdatos'],'can_cabelect'=>$arr_e[$x]['can_cabelect'],
                                        'can_cabdatos'=>$arr_e[$x]['can_cabdatos'],'cst_material'=>$arr_e[$x]['cst_material'],
                                        'cst_mobra'=>$arr_e[$x]['cst_mobra'],'fechora_act'=>date('Y-m-d H:i:s'),
                                        'grabador'=>$_SESSION['codusr']];
                                $ar['id_prycables'] = null;
                                $r = $tprycabelec->ins($ar);
                                if(!$r){
                                    $ar_sale['error'] = $r;
                                    $sigue = false;
                                    //fwrite($arf,date('Y-m-d H:i:s')." id_prycosto:".$id_prycosto.", sale:".$ar_sale['error']."\n");
                                    break;
                                }
                            }
                        }    
                    }
                }

                $ar_ex = $tprytubelec->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;

                for($x=0;$x < count($ar_ex);$x++){
                    $r = $thrytubelec->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }
                if($sigue){
                    $tprytubelec->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( !empty($arr_t) && count( $arr_t ) > 0 ){
                        for($x=0; $x<count($arr_t);$x++){
                            if( $arr_t[$x]['id_tuberia'] == "" || $arr_t[$x]['id_tuberia'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'id_tuberia'=>$arr_t[$x]['id_tuberia'],
                                       'id_dimension'=>$arr_t[$x]['id_dimension'],'metros'=>$arr_t[$x]['metros'],
                                       'curvas'=>$arr_t[$x]['curvas'],'tees'=>$arr_t[$x]['tees'],'uniones'=>$arr_t[$x]['uniones'],
                                       'cst_material'=>$arr_t[$x]['cst_material'],'cst_mobra'=>$arr_t[$x]['cst_mobra'],
                                       'fechora_act'=>date('Y-m-d H:i:s'),'grabador'=>$_SESSION['codusr']];                
                                $ar['id_prytubelect'] = null;
                                $r = $tprytubelec->ins($ar);
                                if(!$r){
                                    $ar_sale['error'] = $r;
                                    fwrite($arf,date('Y-m-d H:i:s')." id_prycosto:".$id_prycosto.", sale:".$ar_sale['error']."\n");
                                    break;
                                }
                            }
                        }    
                    }
                }  
                $ar_sale['sale'] = $sigue;
            }
            break;
        case 'lee_cst_inselec':    // lee costos instalación eléctrica
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $ar_prycabelec = $tprycabelec->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_prycabelec)){
                    $ar_sale['datoe'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    for($x=0; $x < count( $ar_prycabelec ); $x++ ){
                        $ar_prycabelec[$x]['id_cabelect_0'] = lee_t($tgp_cables,'id_cable',$ar_prycabelec[$x]['id_cabelect'],'descrip');
                        $ar_prycabelec[$x]['id_cabdatos_0'] = lee_t($tgp_cables,'id_cable',$ar_prycabelec[$x]['id_cabdatos'],'descrip');
                    }
                    $ar_sale['datoe'] = $ar_prycabelec;
                }
                $ar_prytubelec =$tprytubelec->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_prytubelec)){
                    $ar_sale['datot'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    for($x=0; $x < count( $ar_prytubelec ); $x++ ){
                        $ar_prytubelec[$x]['id_tuberia_0'] = lee_t($tgp_condule,'id_conduleta',$ar_prytubelec[$x]['id_tuberia'],'nom_conduleta');
                        //$ar_prytubelec[$x]['id_dimension_0'] = lee_t($tgp_aislami,'id_aislam',$ar_prytubelec[$x]['id_dimension'],'valor');
                    }
                    $ar_sale['datot'] = $ar_prytubelec;
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
//fwrite($arf,json_encode($ar_sale)." \n");
//fclose($arf);
echo json_encode($ar_sale);
            