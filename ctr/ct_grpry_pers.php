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
$tprypers = new Tabla($odb,"gr_pry_pers");
$thprypers= new Tabla($odb,"gh_pry_pers");
$ar_sale = [];
//$arf = fopen("salida",'a');
//fwrite($arf,date('Y-m-d H:i:s')." Abriendo ct_grpry_pers.php\n");
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    switch($opcion){
        case 'lee_cst_pers':   // lee costos personal alfrio
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "FALTA id_prycosto";
                $ar_sale['sale'] = "0";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arreglo = $_REQUEST['dato'];
                if(!is_array($arreglo)){
                    //fwrite($arf,date('Y-m-d H:i:s')." NO ES arreglo:".$arreglo);
                    $ar_sale['sale'] = " NO ES arreglo \n";
                }else{                     
                    $exito = true;
                    for( $x=0; $x < count($arreglo); $x++ ){
                        $reg  = " id_prycosto:".$id_prycosto;
                        $reg .= " concepto: ".$arreglo[$x]['concepto']." cant: ".$arreglo[$x]['cant'];
                        $reg .= " vr_un: ".$arreglo[$x]['valor_un']." vr_total: ".$arreglo[$x]['valor_total'];
                        //fwrite($arf,date('Y-m-d H:i:s').$reg."\n");
                        if( $arreglo[$x]['cant'] == "" || $arreglo[$x]['cant'] == null || is_nan($arreglo[$x]['cant'])){
                            $arreglo[$x]['cant'] = 0;
                        } 
                        $ar = [ 'id_prydet'=>null,'id_prycosto'=>$id_prycosto,'orden'=>($x+1),'concepto'=>$arreglo[$x]['concepto'],'cant'=> $arreglo[$x]['cant'],
                                'valor_un'=>$arreglo[$x]['valor_un'],'valor_total'=>$arreglo[$x]['valor_total'],'fechora_act'=>date('Y-m-d H:i:s'),
                                'grabador'=>$_SESSION['codusr'] ];
                        $w = " WHERE id_prycosto=".$id_prycosto." AND concepto='".$arreglo[$x]['concepto']."'";        
                        $ar_ex = $tprypers->lee($w,0,"A");
                        $salta = false;
                        if(!empty($ar_ex) ){
                            if( $arreglo[$x]['valor_total'] !== $ar_ex[0]['valor_total']){
                                $r = $thprypers->ins($ar_ex[0]);
                                //fwrite($arf,"Borrando registro: ".$ar_ex[0]['id_prydet']." concepto: ".$ar_ex[0]['concepto']." vr total: ".$ar_ex[0]['valor_total']);
                                $r = $tprypers->bor($w);    
                            }else{
                                $salta = true;
                            }
                        }
                        if(!$salta){
                            $r = $tprypers->ins($ar);
                            $ar_sale['sale'] = $r;
                            if(!$r){
                                //fwrite($arf,"error: ".$r);
                                break;
                            }    
                        }
                    } 
                }
            }
            break;
        default:
            $ar_sale['opcion'] = " VIENE opcion default";
            break;
    }
}else{
    $ar_sale['opcion'] = " SIN opcion";
    $ar_sale['sale'] = "0";
}
//fwrite($arf,json_encode($ar_sale)." \n");
//fclose($arf);
echo json_encode($ar_sale);
