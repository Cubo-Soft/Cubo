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
$odb = new Bd($h,$pto,$u,$p,$d);
$tprypruebas = new Tabla($odb,"gr_pry_pruebas");
$thrypruebas = new Tabla($odb,"gh_pry_pruebas");

$arf = fopen("salida",'a');
//fwrite($arf,date('Y-m-d H:i:s')." Abriendo ct_grpry_pruebas.php\n");
$ar_sale['sale'] = "1";
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'save_cst_pruebas':   // guarda costos pruebas
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                if(isset($_REQUEST['dato'])){
                    $arr = $_REQUEST['dato'];
                }
                //$arf = fopen("salida",'a');

                $ar_ex = $tprypruebas->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;

                for( $x=0; $x < count($ar_ex); $x++ ){
                    $r = $thrypruebas->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }

                if($sigue){ 
                    $tprypruebas->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( !empty($arr) && count( $arr ) > 0 ){
                        for ($x=0; $x < count($arr); $x++ ){
                            if( $arr[$x]['cantidad'] == "" || $arr[$x]['cantidad'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'concepto'=>$arr[$x]['concepto'],'personal'=>$arr[$x]['personal'],
                                        'cantidad'=>$arr[$x]['cantidad'],'valor_u'=>$arr[$x]['valor_un'],
                                        'valor_total'=>$arr[$x]['valor_total'],'fechora_act'=>date('Y-m-d H:i:s'),
                                        'grabador'=>$_SESSION['codusr']];
                                $ar['id_prypruebas'] = null;
                                $r = $tprypruebas->ins($ar);
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
        case 'lee_cst_pruebas':   // lee costos de pruebas
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $ar_ex = $tprypruebas->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_ex)){
                    $ar_sale['dato'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    $ar_sale['dato'] = $ar_ex;
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
fclose($arf);
echo json_encode($ar_sale);