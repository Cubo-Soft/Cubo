<?php
session_start();
 //$_SESSION['id_rol']=1;
function act_maq( $id_pryc,$tipomq,$tpry,$thry,$arr){
    $w = " WHERE id_prycosto=".$id_pryc." AND tipomaq='".$tipomq."'";
    $ar_exg = $tpry->lee($w,0,"A");
    $sigue = true;
    for($x=0; $x < count( $ar_exg ); $x++ ){
        $r = $thry->ins($ar_exg[$x]);
        if( !$r ){
            $sigue = false; break;
        }
    }
    if( $sigue ){
        $tpry->bor($w);
        if( is_array( $arr ) ){
            for($x=0; $x < count( $arr ); $x++ ){
                $arr[$x]['id_pryvarmq']  = null;
                $arr[$x]['id_prycosto']  = $id_pryc;
                $arr[$x]['tipomaq']      = $tipomq;
                $arr[$x]['fechora_act']  = date('Y-m-d H:i:s');
                $arr[$x]['grabador']     = $_SESSION['codusr'];
                $r = $tpry->ins( $arr[$x] );
                if( !$r ){
                    $sigue = false; break;
                }    
            }
        }
    }
    return $sigue;
}

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
$tpryvarios = new Tabla($odb,"gr_pry_varios");
$thryvarios = new Tabla($odb,"gh_pry_varios");
$tpryvarmq  = new Tabla($odb,"gr_pry_varmq");
$thryvarmq  = new Tabla($odb,"gh_pry_varmq");

//$arf = fopen("salida",'a');
//fwrite($arf,date('Y-m-d H:i:s')." Abriendo ct_grpry_varios.php\n");
$ar_sale['sale'] = "1";
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'save_cst_varios':   // guarda costos varios
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "falta id_prycosto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arr = "";
                if(isset($_REQUEST['dato'])){
                    $arr = $_REQUEST['dato'];
                }
                $ar_ex = $tpryvarios->lee(" WHERE id_prycosto=".$id_prycosto,0,"A");
                $sigue = true;
                for( $x=0; $x < count($ar_ex); $x++ ){
                    $r = $thryvarios->ins($ar_ex[$x]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        $sigue = false;
                        break;
                    }
                }
                if($sigue){
                    $tpryvarios->bor(" WHERE id_prycosto=".$id_prycosto);
                    if( !empty($arr) && count( $arr ) > 0 ){
                        for ($x=0; $x < count($arr); $x++ ){
                            if( $arr[$x]['valor_total'] == "" || $arr[$x]['valor_total'] == null ){
                                continue;
                            }else{
                                $ar = ['id_prycosto'=>$id_prycosto,'concepto'=>$arr[$x]['concepto'],'campo1'=>$arr[$x]['campo1'],
                                        'campo2'=>$arr[$x]['campo2'],'campo3'=>$arr[$x]['campo3'],
                                        'valor_total'=>$arr[$x]['valor_total'],'fechora_act'=>date('Y-m-d H:i:s'),
                                        'grabador'=>$_SESSION['codusr']];
                                $ar['id_pryvarios'] = null;
                                $r = $tpryvarios->ins($ar);
                                if(!$r){
                                    $ar_sale['error'] = $r;
                                    //fwrite($arf,date('Y-m-d H:i:s')." id_prycosto:".$id_prycosto.", sale:".$ar_sale['error']."\n");
                                    break;
                                }
                            }
                        }    
                    }
                }
                // procesar gruas y monta

                $arr = ""; $r = true;
                if( isset( $_REQUEST['gruas'] ) ){
                    $arr = $_REQUEST['gruas'];
                    $r = act_maq( $id_prycosto,"Gruas",$tpryvarmq,$thryvarmq,$arr);
                }
                if( $r ){
                    if( isset( $_REQUEST['monta'] ) ){
                        $arr = $_REQUEST['monta'];
                        $r = act_maq( $id_prycosto,"Monta",$tpryvarmq,$thryvarmq,$arr);
                    }
                }
                $ar_sale['sale'] = $r;
            }
            break;
        case 'lee_cst_varios':   // lee costos varios
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $w = " WHERE id_prycosto=".$id_prycosto;
                $ar_ex = $tpryvarios->leec("concepto,campo1,campo2,campo3,valor_total",$w." ORDER BY id_pryvarios",0,"A");
                $ar_sale['dato'] = $tpryvarios->leec("concepto,campo1,campo2,campo3,valor_total",$w." ORDER BY id_pryvarios",0,"A");
                $ar_sale['gruas'] = $tpryvarmq->leec("concepto,campo1,campo2,campo3,valor_total",$w." AND tipomaq='Gruas'",0,"A");
                $ar_sale['monta'] = $tpryvarmq->leec("concepto,campo1,campo2,campo3,valor_total",$w." AND tipomaq='Monta'",0,"A");
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