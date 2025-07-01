<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

function trae($ar_cost,$matr,$elem,$compl,$diam){
  for($x=0;$x<count($ar_cost);$x++){
      if( $ar_cost[$x]['id_matrial'] == $matr && $ar_cost[$x]['id_elemen']==$elem && $ar_cost[$x]['id_complem']==$compl &&
          $ar_cost[$x]['id_diametro']==$diam ){
          return $ar_cost[$x]['valor'];
      }
  }
}

include_once("../cls/carga_ini.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
date_default_timezone_set("America/Bogota");
$odb = new Bd($h,$pto,$u,$p,$d);
$ntabla = "gr_medi_material";
$nprog  = "medidas_material.php";
$tabla = new Tabla($odb,$ntabla);
$existe = $tabla->ejec("show tables LIKE '".$tabla->nomTabla."'","S");
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$basicos = new clsBasicos($odb);
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$trroles = new cls_ar_roles($odb);
$tmaterial = new Tabla($odb,"gp_material");
$tmedidas  = new Tabla($odb,"gp_medidas");
$tcomplem  = new Tabla($odb,"gp_complem");
$tdiametro = new Tabla($odb,"gp_diametros");
$titulo = $tabla->titTabla;
//$tabla->ver_campos();
$ar_complem = $tcomplem->lee("");
$totcomplem = count($ar_complem);
$totcampos = ( $totcomplem ) + 1;
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
$ar_medidas = $tmedidas->lee("");
$totmedidas = count($ar_medidas);
$ar_medimaterial = $tabla->lee(" ORDER BY id_material,id_complem,id_medida");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo ?></title>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../css/ppal.css'>
    <style>

      .tabla1{
        font-size: 12px;
        /*background-color:#D4CAC2;*/ 
      }
      
      .tam_tabla1{
        margin-left: 5px;
        width: 85%;
        max-width: 700px;
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
    <input type='hidden' id='totcomplem' value='<?php echo $totcomplem ?>'>
    <input type='hidden' id='totmedidas' value='<?php echo $totmedidas ?>'>

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
                <!-- <div class='col-sm-4' id='idmensaje'></div> -->
              </div>
              </td>
            </tr>
            <tr>
              <?php
                  echo "<th colspan='".$totcampos."' class='fondoMater' style='background-color:#172D8D'><span class='blanco'> Material  </span> ";
                  $clase='form-select form-select-sm';
                  $opcion ='';
                  echo $tmaterial->selecc('id_material',$clase,$opcion);
              ?>
              </th>
            </tr>
            <tr>
              <th > 
                  Medida </div>
              </th>
              <?php
                  for($c=0;$c<count($ar_complem);$c++){
                    echo "<th style='color:white;text-align:center;background-color:".$co[$c].";'>".$ar_complem[$c]['nom_complem']."</th>";
                  }
              //}  
              ?>
            </tr>   
 
            <?php
            for($d=0;$d<count($ar_medidas);$d++){
              echo "<tr><td align='center'><B>".$ar_medidas[$d]['pulg_medida']."</B></td>";
                for($c=0;$c<count($ar_complem);$c++){
                    //                           id= _ele_com_dia
                    $vr_id = "_".$ar_complem[$c]['id_complem']."_".$ar_medidas[$d]['id_medida']; 
                    echo "<td>
                    <input type='text' id='".$vr_id."' maxlength='13' onchange='md_dato(this);' title='id:".$vr_id."' >
                    </td>";
                }
              echo "</tr>";
            }
            ?>
        <tbody>
      </table>
    </div>
  </form>
  </section>
  <script>var gb_rpta = '';</script>
  <script src="../js/jquery_dvlp_3_7_1.js"></script>
  <script src='../js/ajax.js'></script>
  <script src='../js/bootstrap.bundle.min.js'></script>
  <script src="../js/vistas/medidas_material.js"></script>  
</body>
</html>