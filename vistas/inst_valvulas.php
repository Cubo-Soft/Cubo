<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function trae($ar_instvalvulas,$complem,$diametro){
  $ar = array();
  for($va=0;$va<$ar_instvalvulas;$va++){
    if( $ar_instvalvulas[$va]['id_complem'] == $complem &&
        $ar_instvalvulas[$va]['id_diametro'] == $diametro  
      ){
        $ar['valor'] = $ar_instvalvulas[$va]['valor'];
        $ar['id']    = $ar_instvalvulas[$va]['id_instvalvula']; 
        return $ar;
    }
  }
}

include_once("../cls/carga_ini.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_inst_valvulas";
$nprog  = $_SERVER['PHP_SELF'];
$tabla = new Tabla($odb,$ntabla);
$existe = $tabla->ejec("show tables LIKE '".$tabla->nomTabla."'","S");
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$basicos = new clsBasicos($odb);
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$trroles = new cls_ar_roles($odb);
$tcomplem = new Tabla($odb,"gp_complem");
$tdiametro = new Tabla($odb,"gp_diametros");
$titulo = $tabla->titTabla;
//$tabla->ver_campos();
$ar_complem = $tcomplem->lee("");
$totcomplem = count($ar_complem);
$totcampos = ( $totcomplem );  // + 1;
$ar_diametro = $tdiametro->lee("");
$coe[0]= '#4A944C';
$coe[1]= '#378DBE';
$coe[2]= '#BEA537';
$coe[3]= '#A9A8A2';
$coe[4]= '#D5803A';
/* $co[0]=$amarillo='#FFEE41';
$co[1]=$verde='#66FF41';
$co[2]=$naranja='#FF6E16'; */
$co[0]=$amarillo='#BEA537';
$co[1]=$verde='#4A944C';
$co[2]=$naranja='#D5803A';
$totdiametros = count($ar_diametro);
$ar_instvalvulas = $tabla->lee(" ORDER BY id_instvalvula,id_complem,id_diametro");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../css/ppal.css'>
    <script src="../js/jquery_dvlp_3_7_1.js"></script>
    <script src='../js/ajax.js'></script>
    <style>

      .tabla1{
        font-size: 12px;
        /*background-color:#D4CAC2;*/ 
      }
      
      .tam_tabla1{
        margin-left: 5px;
        width: 95%;
        max-width: 1000px;
      }

      input{
        text-align:right;
      }
      
      .blanco{
        color:white;
      }
      
      td{
        margin:0px;
        padding:0px;
        text-align:center;
      }
      
      .fondoMater{
        text-align:center;
        font-size:15px;
        background-color:#172D8D;
      }

      th.encab_opc {
        text-align:center;
        font-size:18px;
        background-color:#D5803A;
      }

      th.subencab {
        /*color:white; */
        text-align:center;
        background-color:#D5803A;
      }

    </style>
    <script >
        function inicio(){
          document.location.href='<?php echo $_SERVER['PHP_SELF'] ?>';
        }

        function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
        }

        function vaciar(obj){
          obj.value = '';
        }  
        
    </script>
</head>
<body>
<section class="tam_tabla1">
<form name='Interface' method='post' onkeypress='return anular(event)' enctype='multipart/form-data'>
    <input type='hidden' name='tabla' value='<?php echo $ntabla ?>'>
    <input type='hidden' name='nomprg' value='<?php echo $nprog ?>'>
    <div>
      <table class="table table-striped table-hover table-bordered table-sm table-responsive-sm caption-top tabla1">
        <tbody> 
            <tr>
              <td colspan='<?php echo $totcampos ?>'>
                <div class='row fondo_negro' >
                    <div class='col-sm-3'></div>  
                    <div class='col-sm-6 titulo_empresa' ><?php echo $aempre[0][0] ?></div>
                    <div class='col-sm-3'></div>             
                </div>
              </td>
            </tr>
            <tr>
            <td colspan='<?php echo $totcampos ?>'>
              <div class='row fondo_negro'>
                <div class='col-sm-9 letras_blancas' ><H3><?php echo $tabla->titTabla ?></H3> </div>
                <div class='col-sm-3 letras_blancas' id='accion'></div>
              </div>
              </td>
            </tr>
            <tr>
              <th style='text-align:center' > 
                  \
              </th>
              <th colspan='<?php echo ($totcampos -1 ) ?>' class='encab_opc' > 
                   Complemento
              </th>
            </tr>
            <tr>
              <th > 
                  Diámetro 
              </th>
              <?php
                  for($c=1;$c<count($ar_complem);$c++){
                    echo "<th class='subencab' >".$ar_complem[$c]['nom_complem']."</th>";
                  }
              ?>
            </tr>   
 
            <?php
            for($d=0;$d<count($ar_diametro);$d++){
                echo "<tr><td align='center'><B>".$ar_diametro[$d]['nom_diametro']."</B></td>";
                for($c=1;$c<count($ar_complem);$c++){
                    //                           id= _complem_diametro_id-instvalvula
                    $vr_id = "_".$ar_complem[$c]['id_complem']."_".$ar_diametro[$d]['id_diametro']; 
                    $ar = trae($ar_instvalvulas,$ar_complem[$c]['id_complem'],$ar_diametro[$d]['id_diametro']); 
                    $valor = $ar['valor'];
                    $vr_id .= "_".$ar['id'];
                    echo "</td><td><input type='text' id='".$vr_id."' value='".$valor."' size='8'
                       maxlength='13' onchange='md_dato(this);' title='id:".$vr_id."' ></td>";
                }
              echo "</tr>";
            }
            ?>
        <tbody>
      </table>
    </div>
  </form>
  </section>
  <script src='../js/bootstrap.bundle.min.js'></script>
  <script src="../js/vistas/inst_valvulas.js"></script>  
</body>
</html>