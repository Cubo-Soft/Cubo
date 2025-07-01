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
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
}

function trae($ar_mul,$fact,$grupo){
    for($x=0;$x<count($ar_mul);$x++){
        if( $ar_mul[$x]['id_fact'] == $fact && $ar_mul[$x]['cod_grupo']==$grupo ){
            return $ar_mul[$x]['valor'];
        }
    }
}

date_default_timezone_set("America/Bogota");
$titulo = "Actualizar Multiplicadores";
$odb = new Bd($h,$pto,$u,$p,$d);
$grupos_prov = new Tabla($odb,"cp_grupos_provee");
$factor_prov = new Tabla($odb,"cp_factor_provee");
$tabla = new Tabla($odb,"cp_multi_provee");
$basicos = new clsBasicos($odb,"ip_basicos");
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$trroles = new cls_ar_roles($odb);
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$ar_factor = $factor_prov->lee("ORDER BY id_fact",0,"A");
$ar_grupos = $grupos_prov->lee(" ORDER BY orden",0,"A");
$ar_mul    = $tabla->lee("",0,"A");
$aper = $trroles->permi($_SESSION['id_rol'],$_SERVER['PHP_SELF']);
if(strpos(C,"htdocs") !== false){
    echo " Variable C:".C."   ";
    echo " Permisos: ";foreach($aper AS $k=>$v){echo $v." ";};
}
//$tabla->ver_campos();
//echo "<pre>";print_r($ar_mul);echo "</pre>";
$rojo='#FF0000';
$amarillo='#FFEE41';
$verde='#66FF41';
$naranja='#FF6E16'
?>
<!DOCTYPE html>
<html lang='es'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title><?php echo $titulo ?></title>
      <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
      <link rel="stylesheet" href="../css/ppal.css">
      <script src="../js/jquery_dvlp_3_7_1.js"></script>
      <script src='../js/ajax.js'></script>
      <style type='text/css'>
        input{
            text-align:center;
        }
      </style>
      <script >
      function inicio(){
        document.location.href="<?php echo $_SERVER['PHP_SELF'] ?>";
      }
      </script>
    </head>
    <body>
        <div class="conteiner" style="margin-left:10px;width:80%;font-size:small" id="divcriterios">
        <?php
            include("./adiciones/cabeza.php");
        ?>
            <form action="" method="POST">
            <table class="table table-striped table-hover table-bordered table-sm table-responsive-sm caption-top">
                <tablehead>
                    <tr>
                        <th style='width:30%'>
                            Marca   <div id='idmensaje'></div>
                        </th>
                        <th> LP</th>
                    <?php
                    for($f=0; $f<count($ar_factor);$f++){
                        echo "<th>".$ar_factor[$f]['fact_largo']." </th>";  // ".$ar_factor[$f]['id_fact']."
                    }
                    ?>
                    </tr>
                </tablehead>
                <tablebody>
                   <?php
                   for($g=0;$g<count($ar_grupos);$g++){
                        echo "<tr>";
                        echo "<td>".$ar_grupos[$g]['descrip']."</td><td>".$ar_grupos[$g]['cod_grupo']."</td>";
                        for($f1=0;$f1<count($ar_factor);$f1++){
                            $lee = "";
                            if($ar_factor[$f1]['mostrar'] == false){$lee = ' readonly';}
                            $valor = trae($ar_mul,$ar_factor[$f1]['id_fact'],$ar_grupos[$g]['cod_grupo']);
                            echo "<td><input type='text' name='' size='5' id='".$ar_grupos[$g]['cod_grupo']."-".$ar_factor[$f1]['id_fact']."'
                                    onchange='cambia(this)' value='".$valor."' ".$lee." title='".$ar_grupos[$g]['cod_grupo']."-".$ar_factor[$f1]['id_fact']."'>";
                            echo "</td>";
                        } 
                        echo "</tr>";
                   }
                   
                    ?>
                </tablebody>

            </table>

            </form>
        </div>
        <script src='../js/bootstrap.bundle.min.js'></script>
        <script src="../js/vistas/act_multip.js?ramdom=<?= time() ?>"></script>
    </body>    
</html>