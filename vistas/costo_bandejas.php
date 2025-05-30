<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function trae($ar_cost,$elem,$compl,$bandeja){
  for($x=0;$x<count($ar_cost);$x++){
      if( $ar_cost[$x]['id_elemen']==$elem && $ar_cost[$x]['id_complem']==$compl &&
          $ar_cost[$x]['id_bandeja']==$bandeja ){
          return $ar_cost[$x]['valor'];
      }
  }
}

include_once("../cls/carga_ini.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_cst_bandejas";
$nprog  = "costo_bandejas.php";
$tabla = new Tabla($odb,$ntabla);
$existe = $tabla->ejec("show tables LIKE '".$tabla->nomTabla."'","S");
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$basicos = new clsBasicos($odb);
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$trroles = new cls_ar_roles($odb);
$tbandeja  = new Tabla($odb,"gp_bandeja");
$telemen   = new Tabla($odb,"gp_elemen");
$tcomplem  = new Tabla($odb,"gp_complem");
//$tdiametro = new Tabla($odb,"gp_diametros");
$titulo = $tabla->titTabla;
//$tabla->ver_campos();
//$tmaterial->ver_campos();
$ar_complem = $tcomplem->lee(" WHERE nom_complem !='Pintura'");
$totcomplem = count($ar_complem);
$ar_elemen = $telemen->lee(" WHERE nom_elemen !='Cap'");
$totelemen = count($ar_elemen);
$totcampos = ( $totelemen * $totcomplem ) + 1;
$ar_bandejas = $tbandeja->lee("");
$totbandeja = count($ar_bandejas);
$coe[0]= '#4A944C';
$coe[1]= '#378DBE';
$coe[2]= '#BEA537';
$coe[3]= '#A9A8A2';
$coe[4]= '#D5803A';
$coc[0]= '#A5D587';
$coc[1]= '#9BD4F4';
$coc[2]= '#EFD76C';
$coc[3]= '#ECEADF';
$coc[4]= '#F6AB6E';

$co[0]=$amarillo='#FFEE41';
$co[1]=$verde='#66FF41';
$co[2]=$naranja='#FF6E16';
//$ar_diametro = $tdiametro->lee("");
//$totdiametro = count($ar_diametro);
$ar_costbandeja = $tabla->lee(" ORDER BY id_cstbandeja,id_elemen,id_complem,id_bandeja");
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
        /*background-color:#83CBF3;*/ 
      }
      .tam_tabla1{
        margin-left: 0px;
        width: 85%;
        max-width: 900px;
      }

      input{
        text-align:right;
        margin:0px;
        padding:0px;
      }
      .blanco{
        color:white;
      }
      td{
        margin:0px;
        padding:0px;
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
    <input type='hidden' id='totelemen' value='<?php echo $totelemen ?>'>
    <input type='hidden' id='totcomplem' value='<?php echo $totcomplem ?>'>
    <input type='hidden' id='totbandeja' value='<?php echo $totbandeja ?>'>
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
                <div class='col-sm-5 letras_blancas' ><H3><?php echo $titulo ?></H3> </div>
                <div class='col-sm-3 letras_blancas' id='accion'></div>
                <div class='col-sm-4' id='idmensaje'></div>
              </div>
              </td>
            </tr>
            <tr>
              <th > 
                  Elemento  
              </th>
              <?php
              for($e=0; $e<count($ar_elemen);$e++){
                echo "<th colspan='".$totcomplem."' style='color:white;text-align:center;background-color:".$coe[$e]."'>".$ar_elemen[$e]['nom_elemen']."</th>";
              }  
              ?>
            </tr>
            <tr>
              <th > 
                  Bandeja </div>
              </th>
              <?php
              for($e=0; $e<count($ar_elemen);$e++){
                  for($c=0;$c<count($ar_complem);$c++){
                    echo "<th style='color:#172D8D;text-align:center;background-color:".$coc[$e].";'>".$ar_complem[$c]['nom_complem']."</th>";
                  }
              }  
              ?>
            </tr>   
 
            <?php
            for($b=0;$b<count($ar_bandejas);$b++){
                echo "<tr><td style='text-align:center;background-color:#C2C1C0'><B>".$ar_bandejas[$b]['nom_bandeja']."</B></td>";
                for($e=0; $e<count($ar_elemen);$e++){
                    for($c=0;$c<count($ar_complem);$c++){
                        //                           id= _ele_com_ban
                        //$vr_id = "_"; 
                        $vr_id = "_".$ar_elemen[$e]['id_elemen']."_".$ar_complem[$c]['id_complem']."_".$ar_bandejas[$b]['id_bandeja'];
                        $valor = '';
                        for($cst=0;$cst<count($ar_costbandeja);$cst++){
                            if( $ar_costbandeja[$cst]['id_elemen']==$ar_elemen[$e]['id_elemen'] &&
                                $ar_costbandeja[$cst]['id_complem']==$ar_complem[$c]['id_complem'] &&
                                $ar_costbandeja[$cst]['id_bandeja']==$ar_bandejas[$b]['id_bandeja']  ){
                                $valor = $ar_costbandeja[$cst]['valor'];    
                            }
                        }
                        echo "<td style='background-color:#C2C1C0'>
                                <input type='text' id='".$vr_id."' value='".$valor."'
                            size='8' maxlength='13' onchange='md_dato(this);' title='id:".$vr_id."' ></td>";
                      }
  
                }  
                echo "</tr>";
            }
            ?>
        <tbody>
      </table>
    </div>
    
    <!-- <button type="button" class="btn btn-primary" id="btn_limpia">Limpia</button> -->
  </form>
  </section>
  <script src='../js/bootstrap.bundle.min.js'></script>
  <script src="../js/vistas/costo_bandejas.js"></script>  
</body>
</html>