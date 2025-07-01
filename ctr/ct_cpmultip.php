<?php
session_start();
$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function separa($formula,$ar,$arch){
    fwrite($arch,"\t\tEN SEPARA ARREGLO ar: ".json_encode($ar)."\n");
    $ar_formula = explode(" ",$formula);
    for( $n=0; $n < count($ar_formula); $n++ ){
        if( strlen( $ar_formula[$n] ) > 1 ){
            foreach($ar AS $key=>$dato ){
                if( $key == $ar_formula[$n] ){
                    $ar_formula[$n] = $dato;
                } 
            } 
        }
    }
    return $ar_formula;
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
}
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$multip = new Tabla($odb,"cp_multi_provee");
$tfactor= new Tabla($odb,"cp_factor_provee");
$ar_sale = array(); $ar = [];
$arch = fopen('salida','w+');
fwrite($arch,"LOG seguimiento RUTINA formulas multiplicador precio de venta ".date('Y-m-d H:i:s')." \n");
fwrite($arch,"================================================================================= \n");
if( isset($_REQUEST['factor'] ) && isset( $_REQUEST['grupo'] ) && isset( $_REQUEST['valor'] ) ){
    $factor = $_REQUEST['factor'];
    $grupo  = $_REQUEST['grupo'];
    $valor  = $_REQUEST['valor'];
    $ar_sale['datos'] = "VIENEN  factor: ".$factor." grupo: ".$grupo." valor: ".$valor;
    fwrite($arch,"Llegan parametros => factor: $factor, grupo: $grupo, valor: $valor \n");
    $ar_factor = $tfactor->lee(" ORDER BY id_fact",0,"A");
    $w0 = "SELECT m.*,f.mostrar,f.fact_corto,f.formula FROM cp_multi_provee m,cp_factor_provee f 
     WHERE m.cod_grupo='$grupo' AND f.id_fact=m.id_fact ORDER BY m.id_fact;";
    $ar_mul = $multip->ejec($w0,"S","A");
    $ar_sale['estado'] = $r = true; $ar = array();
    for($m=0; $m < count( $ar_mul ); $m++ ){
        fwrite($arch," REGISTRO: ".$m." VIENE: ".json_encode($ar_mul[$m])."\n" );
        $ar[ $ar_mul[$m]['fact_corto'] ] = $ar_mul[$m]['valor']; 
        fwrite($arch,"\t ARREGLO ar :".json_encode($ar)."\n");      
        if($ar_mul[$m]['id_fact'] == $factor && $ar_mul[$m]['cod_grupo']==$grupo){
            fwrite($arch,"ABRIENDO if1 registro.id_fact = $factor y registro.cod_grupo = $grupo \n");
            $ar_mul[$m]['valor'] = $valor;
            fwrite($arch,"\t\tLLEVAMOS el valor enviado ".$valor." al registro.valor \n");
            $ar[ $ar_mul[$m]['fact_corto'] ] = $ar_mul[$m]['valor']; 
            fwrite($arch,"\t\t\ten arreglo ar[ ".$ar_mul[$m]['fact_corto']." ] = ".$valor." \n");
            $ar_sale[ $ar_mul[$m]['fact_corto'] ] = $valor;
            $ardato = ['valor'=>$valor];
            fwrite($arch,"\t\t\ten arreglo ardato: ".json_encode($ardato)." \n");
            $w  = " WHERE id_fact = '".$factor."' AND cod_grupo='".$grupo."'";
            fwrite($arch,"\t\tMOD pasando:".json_encode($ardato)." -> ".$w." \n");
            $r = $multip->mod($ardato,$w);
            fwrite($arch," FIN DEL if1 \n");
        }
        if( !$r ){
            $ar_sale['estado'] = 0;
            break;
        }
        if( $ar_mul[$m]['mostrar'] == '0' ){
            fwrite($arch,"\n IF2 registro.mostrar == 0  \n");
            fwrite($arch,"\t\tSEPARANDO: ".$ar_mul[$m]['formula']." ARREGLO: ar : ".json_encode($ar)."\n");    
            $ar_formula = separa($ar_mul[$m]['formula'],$ar,$arch);
                fwrite($arch,"\t\tFORMULA: ".$ar_mul[$m]['formula']." \n");
                $formulan = implode("",$ar_formula);
                $res = eval("return ".$formulan.";");
                fwrite($arch,"\t\tRESULTADO res = ".$res."\n");
                $res = round($res,3);
                $ar_mul[$m]['valor'] = $res;
                fwrite($arch,"\t\tLlevamos a registro.valor = ".$res."  \n");
                $ar[ $ar_mul[$m]['fact_corto'] ] = $res;
                fwrite($arch,"\t\tEN arreglo ar:".json_encode($ar)."  \n");
                $factorf = $ar_mul[$m]['id_fact'];
                $grupof  = $ar_mul[$m]['cod_grupo'];
                fwrite($arch,"\t\tTRAEMOS a variable factorf = registro.id_fact y grupof = registro.cod_grupo  \n");
                $ardato  = ['valor'=>$res];
                fwrite($arch,"\t\ten arreglo ardato:".json_encode($ardato)." \n");
                $w  = " WHERE id_fact = '".$factorf."' AND cod_grupo='".$grupof."'";
                fwrite($arch,"\t\tMOD2: arreglo ardato en tabla multip : ".json_encode($ardato)." -> ".$w."\n");                
                $r = $multip->mod($ardato,$w);
                if(!$r){
                    $ar_sale['estado'] = 0;
                    break;
                }
                $ar_sale['estado'] = true;
                fwrite($arch,"FIN DEL if2 \n");
                //$ar_sale['tcos'] =  
                //$ar_sale['salem'] =
                //$ar_sale['engco'] =
        }
    }
}else{
    $ar_sale['error'] = "Falta el Factor, el grupo o el valor";
}
fwrite($arch,"EN ar_sale: ".json_encode($ar_sale)." \n");
echo json_encode($ar_sale);     
?>