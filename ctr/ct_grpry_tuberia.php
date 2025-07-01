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
$tprytubos = new Tabla($odb,"gr_pry_tuberia");
$thprytubos= new Tabla($odb,"gh_pry_tuberia");
$ar_sale = [];
//$arf = fopen("salida",'a');
//fwrite($arf,date('Y-m-d H:i:s')." Abriendo ct_grpry_tuberia.php\n");
if(isset($_REQUEST['opcion'])){
    $opcion = $_REQUEST['opcion'];
    $ar_sale['opcion'] = $opcion;
    //fwrite($arf,"opcion: ".$opcion."\n");
    switch($opcion){
        case 'save_cst_tuberia':   // guarda costos instal. tuberia proyecto
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "FALTA id_prycosto";
                $ar_sale['sale'] = "0";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $arreglo = "";
                if( isset($_REQUEST['dato']) ){
                    $arreglo = $_REQUEST['dato'];
                }
                if( is_array($arreglo)){
                    $hay_arreglo = count( $arreglo );
                }else{
                    $hay_arreglo = 0;
                }
                $w = " WHERE id_prycosto = ".$id_prycosto;
                $ar_ex = $tprytubos->lee($w,0,"A");
                $hay_tabla = count( $ar_ex );
                $sigue = true;
                // ==== inicio cambio =========================
                for($ex=0; $ex < count($ar_ex); $ex++){
                    $ar_h = $thprytubos->lee($w." AND linea='".$ar_ex[$ex]['linea']."'");
                    if( count( $ar_h) > 0 ){
                        $thprytubos->bor($w." AND linea='".$ar_ex[$ex]['linea']."'");
                    }
                    $r = $thprytubos->ins($ar_ex[$ex]);
                    if(!$r){
                        $ar_sale['sale'] = $r;
                        //fwrite($arf,"error:".$r."\n");
                        $sigue = false;
                        break;
                    }else{
                        $tprytubos->bor($w." AND linea = '".$ar_ex[$ex]['linea']."'");
                    }
                }    
                if( $hay_arreglo > 0 && $sigue ){ 
                    for($a=0; $a < count($arreglo); $a++){
                        $arreglo[$a]['fechora_act'] = date('Y-m-d H:i:s');
                        $arreglo[$a]['grabador'] = $_SESSION['codusr'];
                        $r = $tprytubos->ins($arreglo[$a]);
                        if(!$r){
                            $ar_sale['sale'] = $r;
                            //fwrite($arf,"error:".$r."\n");
                            $sigue = false;
                            break;
                        }    
                    }
                }
                //========= fin cambio  ==========================================
            }
            break;
        case 'lee_cst_tuberia':
            if(!isset($_REQUEST['id_prycosto'])){
                $ar_sale['id_prycosto'] = "Falta el id del proyecto";
            }else{
                $id_prycosto = $_REQUEST['id_prycosto'];
                $ar_sale['id_prycosto'] = $id_prycosto;
                $campos = "linea,tipotubo,diametro,longitud,aislam,codo,tee,uniones,cap,medi_reduc,cant,cst_material,cst_mobra,cst_pintura,cst_aislam";
                $ar_prytubos = $tprytubos->leec($campos," WHERE id_prycosto=".$id_prycosto,0,"A");
                if(empty($ar_prytubos)){
                    $ar_sale['sale'] = " No existe el proyecto ".$id_prycosto;
                }else{
                    $ar_sale['datos'] = $ar_prytubos;
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
