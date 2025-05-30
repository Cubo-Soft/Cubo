<?php
session_start();
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include(C."/cls/clsTablam.php");
include(C."/cls/varios.php");
include(C."/cls/clsSucursal.php");
if($motor=="my"){
    include(C."/cls/clsBdmy.php");
}

function selec_tabla($tabla,$w,$campo,$ncampo=""){
  $sale = "<select name='".$campo."' id='".$campo."'  onblur=\"cambia('".$campo."')\" style='width:95%'>
  <option value=''>Sin Elegir</option>
  ";
  $ar_tabla = $tabla->lee($w,0,"A");
  for($x=0;$x<count($ar_tabla);$x++){
    $sale .= "<option value='".$ar_tabla[$x][$tabla->llave]."'>".$ar_tabla[$x][$ncampo]."</option>
    "; 
  }
  $sale .= "</select>";
  return $sale;
}

date_default_timezone_set("America/Bogota");
$odb     = new Bd($h,$pto,$u,$p,$d);
$tgpmaterial = new Tabla($odb,"gp_material");
$tgpespesor  = new Tabla($odb,"gp_espesor");
$tgpdiametro = new Tabla($odb,"gp_diametros");
$tgpaislamie = new Tabla($odb,"gp_aislamie");
$tgpcables   = new Tabla($odb,"gp_cables");
$tgpconduleta= new Tabla($odb,"gp_conduleta");
$tprycosto   = new Tabla($odb,"gr_prycosto");
$tcmtrm      = new Tabla($odb,'cm_trm');
$tnpciudades = new Tabla($odb,"np_ciudades");
$tapctroscosto = new Tabla($odb,"ap_ctros_costo");
$tgrpry_adm  = new Tabla($odb,"gr_pry_adm");
$tgrpry_pers = new Tabla($odb,"gr_pry_pers");
$tgrpry_equi = new Tabla($odb,"gr_pry_equi");
$tgrpry_tubo = new Tabla($odb,"gr_pry_tuberia");
$tgrpry_valv = new Tabla($odb,"gr_pry_valv");
$tgrpry_eqel = new Tabla($odb,"gr_pry_cabelect");
$tgrpry_tuel = new Tabla($odb,"gr_pry_tubelect");
$tgrpry_prue = new Tabla($odb,"gr_pry_pruebas");
$tgrpry_vari = new Tabla($odb,"gr_pry_varios");
$tgp_perfils = new Tabla($odb,"gp_perfiles");
$tgrpry_perf = new Tabla($odb,"gr_pry_perfiles");  // soporteria de instalaciones proyecto
$ar_pryctros = $tprycosto->ejec("SELECT DISTINCT ctro_costo FROM ".$tprycosto->nomTabla." ORDER BY ctro_costo","S","A");
if(!isset($_REQUEST['ctro_costo'])){
  ?>  
  <!DOCTYPE html>
  <html lang="es">
  <head>  
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Resumen Proyecto</title>
      <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
  </head>
  <body>   
    <div style="width:30%;border: .5pt solid;margin-left: 20pt;margin-top: 15pt">
      <B style="margin: lef 15pt">Resumen de Proyecto</B>
      <form method='POST'>
          <label for="">Centro de Costo del Proyecto:</label>
          <select name="ctro_costo" class="form-select form-select-sm" onblur="validaCtro(this);">
              <option value="">Sin elegir</option>
              <?php
              for($x=0; $x<count($ar_pryctros);$x++){
                echo "<option value='".$ar_pryctros[$x]['ctro_costo']."'>".$ar_pryctros[$x]['ctro_costo']."</option>";
              }
              ?>
              <option value="N">Nuevo Centro de Costo</option>
          </select>
          <div id="AddNewCtro" style="display:none">
            <label for="NewCtro">Nuevo Centro Costo:</label>
            <input type="text" name="NewCtro" id="NewCtro" maxlength="15">
          </div>
          <div style="width:40px;padding:10px">
              <input type="submit" class="btn btn-primary btn-sm" >
          </div>          
      </form>      
    </div> 
    <script src="../js/jquery_dvlp_3_7_1.js"></script>
    <script>
      function validaCtro(obj){
        let opcion = $(obj).val();
        if( opcion == "N"){
            $("#AddNewCtro").css("display","block");
            $("#NewCtro").focus();
        }
      }
    </script>
  </body>
</html>
<?php  
}else{
  if( $_REQUEST['ctro_costo'] == "N"){
    $_REQUEST['ctro_costo'] = $_REQUEST['NewCtro']; 
  }
  $ctro_costo = $_REQUEST['ctro_costo'];
  $trm = lee_trm($tcmtrm,1);
  if( is_numeric($trm) && gettype($trm) == 'string' ){
    $trm = (float)$trm;    
  }
  $ar_totales = ['idtotadm'=>0];
  $ar_pry = $tprycosto->lee(" WHERE ctro_costo='$ctro_costo'",0,"A");
  if(empty($ar_pry)){
      $ar_pry['id_prycosto'] = null;
      $ar_pry['cod_ciu_ori'] = '11001';
      $ar_pry['fechora']     =  date("Y-m-d");
      $ar_pry['ctro_costo']  = $ctro_costo;
      $ar_pry['nom_cliente'] = null; 
      $ar_pry['descrip_proy']= null;
      $ar_pry['codciu_proy'] = null;
      $ar_pry['trm_proy']    = $trm;
      $ar_pry['profit_proy'] = '20%';
      $ar_pry['iva_proy']    = '19%';
      $ar_pry['fechora_act'] = null;
      $ar_pry['grabador']    = null;

      $ar_adm['id_prycosto'] = $ar_pry['id_prycosto'];
      $ar_adm['id_cons_adm'] = null;
      $ar_adm['polizas']     = null;
      $ar_adm['costo_fcro']  = null;
      $ar_adm['pers_admtvo']  = null;

      $ar_pers = [];
      $ar_pers[0] = [];

      $hay_equipos = 0;
      $hay_tuberia = 0;
      $hay_valvulas = 0;
      $hay_eqel = 0;
      $hay_tuel = 0;
      $hay_pruebas = 0;
      $hay_varios  = 0;
      $hay_perfiles   = 0;
      $hay_soptuberia = 0;
      $hay_sopElectri = 0;
  }else{
    $ar_pry = $ar_pry[0];
    $ar_adm = $tgrpry_adm->lee(" WHERE id_prycosto=".$ar_pry['id_prycosto'],0,"A");
    if(!empty($ar_adm)){
      $ar_adm = $ar_adm[0];
    }else{
      $ar_adm['id_prycosto'] = $ar_pry['id_prycosto'];
      $ar_adm['id_cons_adm'] = null;
      $ar_adm['polizas']     = null;
      $ar_adm['costo_fcro']  = null;
      $ar_adm['pers_admtvo']  = null;
    }
    $ar_pers = $tgrpry_pers->lee(" WHERE id_prycosto=".$ar_pry['id_prycosto']." ORDER BY orden",0,"A");
    for( $x=0; $x < 13; $x++ ){
        if(empty($ar_pers[$x])){
          $ar_pers[$x]['concepto'] = null;
          $ar_pers[$x]['cant'] = null;
          $ar_pers[$x]['valor_un'] = null;
          $ar_pers[$x]['valor_total'] = null;
        }  
    }
    $w = " WHERE id_prycosto=".$ar_pry['id_prycosto'];
    $hay_equipos = $tgrpry_equi->qt($w);
    $hay_tuberia = $tgrpry_tubo->qt($w);
    $hay_valvulas = $tgrpry_valv->qt($w);
    $hay_eqel = $tgrpry_eqel->qt($w);
    $hay_tuel = $tgrpry_tuel->qt($w);
    $hay_pruebas = $tgrpry_prue->qt($w);
    $hay_varios  = $tgrpry_vari->qt($w);
    $hay_perfiles   = $tgrpry_perf->qt($w." AND resto='_0'");
    $hay_soptuberia = $tgrpry_perf->qt($w." AND resto='_1'");
    $hay_sopElectri = $tgrpry_perf->qt($w." AND resto='_2'");    
  }
  $ar_fecha = explode(" ",$ar_pry['fechora']);
  $fecha = $ar_fecha[0];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Proyecto</title>
    <meta http-equiv=Content-Type content="text/html; charset=windows-1252">
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'> 
    <link rel="stylesheet" type='text/css' href="../css/resumen_pry.css">
</head>
<body>
  <B class="encab" id="Inicio">Resumen de Proyecto</B>
<div class="container" id="resumen" style="margin-left:5pt;display:block;">
  <table style="width:520pt">
      <tr style='height:13.8pt;'>
        <td style='width:33pt'>&nbsp;</td>
        <td style='width:11pt'>&nbsp;</td>
        <td style='width:13pt'>&nbsp;</td>
        <td style='width:80pt'>&nbsp;</td>
        <td style='width:117pt'>&nbsp;</td>
        <td style='width:97pt'>&nbsp;</td>
        <td style='width:87pt'>&nbsp;</td>
        <td style='width:82pt'>&nbsp;</td>
      </tr>
      <tr style='border:0.5px solid'>
        <td colspan=4 class='xl227' >&nbsp;CIUDAD</td>
        <td class=xl137 style='border-left:none' colspan="2"> 
            <?php echo $tnpciudades->selecc("ciudad","form-select form-select-sm",$ar_pry['cod_ciu_ori'],"","|"); ?></td>
        <!-- <td class=xl138></td> -->
        <td class=xl227>&nbsp;FECHA</td>
        <td class=xl137 style='border-left:none;text-align:right;'>
              <input type='date' name='fecha' id="fecha" size='10' value="<?php echo $fecha ?>" class="xl137"></td>
      </tr>
      <tr style='height:13.95pt'>
        <td colspan=8 style='height:13.95pt;'></td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=4 class=xl227 style='border-right:.5pt solid '>&nbsp;PROYECTO</td>
        <td colspan=4 class=xl85 style='border-left:none'>
            <input type='text' name='nom_proy' id="nom_proy" value='<?php echo $ar_pry['descrip_proy'] ?>' style="width:99.9%">
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=4 class=xl227 style='border-right:.5pt solid '>&nbsp;CLIENTE</td>
        <td colspan=4 class=xl85 style='border-left:none'>
            <input type='text' name='nom_cliente' id='nom_cliente' value='<?php echo $ar_pry['nom_cliente'] ?>' style="width:99.9%" >
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=4 class=xl227 style='border-right:.5pt solid '>&nbsp;CIUDAD </td>
        <td colspan=4 class=xl85 style='border-left:none'>
            <?php echo $tnpciudades->selecc("codciu_proy","form-select form-select-sm",$ar_pry['codciu_proy'],"","|"); ?> </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=4 class=xl227 style='border-right:.5pt solid '>&nbsp;CENTRO DE COSTO</td>
        <td colspan=4 class=xl85 style='border-left:none'> 
              <input type='text' name='ctro_costo' id='ctro_costo' value='<?php echo $_REQUEST['ctro_costo'] ?>' style="width:99.9%;" readonly>
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=4 class=xl227 style='border-right:.5pt solid '>&nbsp;PROFIT %</td>
        <td colspan=4 class=xl227 style='height:18pt;border-right:.5pt solid'>
          <div style="width:200px;float:left;height:18pt;">
              <input type='text' name='utilid' id='utilid'  class="valor" size="8" style="color:black;"
                  value='<?php echo $ar_pry['profit_proy'] ?>'>
              <input type='hidden' name='utilid_x' id='utilid_x' value='<?php echo ($ar_pry['profit_proy']) ?>' >
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;IVA %&nbsp;
              <input type='text' name='iva' id='iva' value='<?php echo $ar_pry['iva_proy'] ?>' 
                      class="valor" size="8" style="color:black">
              <input type='hidden' name='iva_x' id='iva_x' value='<?php echo ($ar_pry['iva_proy']) ?>' >
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TRM&nbsp;
              <input type='text' name='trm' id="trm" value='<?php echo fpesos($ar_pry['trm_proy']) ?>'
                      class="valor" size="10" style="color:black" >
              <input type='hidden' name='trm_x' id="trm_x" value='<?php echo $ar_pry['trm_proy'] ?>' >
          </div>
        </td>
      </tr>
 
    </table>

    <div id="divResumenGeneral" > 
    <table style="width:520pt;border:.5pt solid;">  
      <tr style='height:20pt;'>
        <td style='width:33pt'>&nbsp;</td>
        <td style='width:11pt'>&nbsp;</td>
        <td style='width:13pt'>&nbsp;</td>
        <td style='width:80pt'>&nbsp;</td>
        <td style='width:117pt'>&nbsp;</td>
        <td style='width:117pt'>&nbsp;</td>
        <td style='width:87pt;padding:5pt;'>&nbsp;
            <!-- BOTON activar Resumen a Clientes -->
            <button type='button' class='btn btn-primary btn-sm' id="xresumenGeneral" title="Versión Clientes">V. Clientes</button>
        </td>

        <td style='width:82pt;padding:5pt;'>   
                 <!-- BOTON Principal  --> 
            <button id="btnActProyecto" class="btn btn-success btn-sm" title="Guardar datos Básicos del proyecto" onclick="act_pry();">Guardar</button>
            <input type="hidden" name="id_prycosto" id="id_prycosto" value="<?php echo $ar_pry['id_prycosto'] ?>" size="1" readonly>
        </td>

      </tr>

      <tr height=18 style='height:13.8pt'>
        <td colspan=8 class=xl84>RESUMEN COSTO DE MONTAJE</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl71 style='border-top:none'>ÍTEM</td>
        <td colspan=4 class=xl221 style='border-right:.5pt solid ;border-left:none'>DESCRIPCIÓN</td>
        <td class=xl71 style='border-top:none;border-left:none'>COSTO COP</td>
        <td class=xl71 style='border-top:none;border-left:none'>COSTO USD</td>
        <td class=xl71 style='border-top:none;border-left:none'>PORCENTAJE</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">1&nbsp;</td>
        <td colspan=4 class=xl224 style='border-right:.5pt solid ;'>
            <a href="#" id="idpersadm"><span style='color:#203764;font-weight:700'>ADMINISTRATIVOS</span></a></td>
        <td class=xl110 style='text-align:right'>
              $ <input type='text' name="idtotadm" id="idtotadm" size='12' class="valor" readonly>
               <input type='hidden' id="idtotadm_x" class="Resumen">
        </td>
        <td class=xl148 style='text-align:right'>
              USD<input type='text' name='usidtotadm' id='usidtotadm'  size='12' class="valor" readonly></td>
        <td class=xl140 style='border-left:none;'>
              <input type='text' name='poridtotadm' id='poridtotadm' size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye </td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl82 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Pólizas</td>
        <td class=xl76 style='border-left:none'></td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl72>&nbsp;</td>
        <td class=xl73 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Personal COMPRAS + CONTABILIDAD</td>
        <td class=xl72 style='border-left:none'></td>
        <td class=xl74 style='border-left:none'>&nbsp;</td>
        <td class=xl75 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl81 valor">2&nbsp;</td>
        <td colspan=4 class=xl232 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idpersalfrio"><span style='color:#203764;font-weight:700'>PERSONAL ALFRIO</span></a>
        </td>
        <td class=xl111 style='text-align:right'>
            $ <input type='text' name='totperalfrio' id="totpersalfrio" size='12' class="valor" readonly>
             <input type='hidden' id="totpersalfrio_x" class="Resumen" >
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='uspersalfrio' id="ustotpersalfrio" size='12' class="valor" readonly>  
        </td>
        <td class=xl140 style='text-align:right'><input type='text' name='poridtotpersalfrio' id="portotpersalfrio" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl152 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Ingeniero ALFRIO</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Técnico ALFRIO</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Viáticos</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Servicio telefónico</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">3&nbsp;</td>
        <td colspan=4 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_equipos"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE EQUIPOS</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totinsequipos' id="totinsequipos" size='12' class="valor" readonly> 
             <input type='hidden' id="totinsequipos_x" class="Resumen"> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotinsequipos' id="ustotinsequipos" size='12' class="valor" readonly>
        </td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotinsequipos' id="portotinsequipos" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de instalación</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de aislamiento</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">4&nbsp;</td>
        <td colspan=4 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_tuberia"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE TUBERÍA</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totinstb' id="totinstb" size='12' class="valor" readonly> 
             <input type='hidden' id="totinstb_x" class="Resumen"> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotinstb' id="ustotinstb" size='12' class="valor usResumen" readonly>
        </td>
        <td class=xl140 style='text-align:right'>
            <input type='text' name='portotinstb' id="portotinstb" size='8' class="valor porResumen" readonly>%
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de mano de obra</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de material</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de aislamiento</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de pintura</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Soportería para tuberías</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">5&nbsp;</td>
        <td colspan=4 class=xl215 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_valvula"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE VÁLV Y ACC</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totinsvalv' id="totinsvalv" size='12' class="valor" readonly> 
             <input type='hidden' id="totinsvalv_x" class="Resumen"> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotinsvalv' id="ustotinsvalv" size='12' class="valor" readonly>
        </td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotinsvalv' id="portotinsvalv" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl153 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de mano de obra</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de material</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de aislamiento</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de pintura</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">6&nbsp;</td>
        <td colspan=4 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_electrica"><span style='color:#203764;font-weight:700'>INSTALACIÓN ELÉCTRICA</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totinselec' id="totinselec" size='12' class="valor" readonly> 
             <input type='hidden' id="totinselec_x" class="Resumen"> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotinselec' id="ustotinselec" size='12' class="valor" readonly>
        </td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotinselec' id="portotinselec" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de mano de obra</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Costo de material</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Soportería para bandejas/tubería</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">7&nbsp;</td>
        <td colspan=4 class=xl232 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="id_pruebas"><span style='color:#203764;font-weight:700'>PRUEBAS DE FUNCIONAMIENTO</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totpruebas' id="totpruebas" size='12' class="valor" readonly> 
             <input type='hidden' name='totpruebas_x' id="totpruebas_x" class="Resumen" readonly> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotpruebas' id="ustotpruebas" size='12' class="valor" readonly>
        </td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotpruebas' id="portotpruebas" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl152 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Pruebas de triple vacío</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Pruebas de presión (75, 100, 200 psi)</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Pruebas eléctricas</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">8&nbsp;</td>
        <td colspan=4 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="id_varios"><span style='color:#203764;font-weight:700'>VARIOS</span></a>
        </td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totvarios' id="totvarios" size='12' class="valor" readonly> 
             <input type='hidden' name='totvarios_x' id="totvarios_x" class="Resumen" readonly> 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotvarios' id="ustotvarios" size='12' class="valor" readonly></td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotvarios' id="portotvarios" size='8' class="valor porResumen" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=3 class=xl230 >Incluye</td>
        <td class=xl111 style='border-left:none'>&nbsp;</td>
        <td class=xl151 style='border-left:none'>&nbsp;</td>
        <td class=xl79 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Andamios</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Viáticos de personal</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Transporte de material</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Personal SISO</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=2 class=xl230 >Imprevistos</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl78 style='border-left:none'>&nbsp;</td>
        <td class=xl76 style='border-left:none'>&nbsp;</td>
      </tr>
      <tr height=18 style=height:13.95pt'>
        <td colspan=5 class=xl227 >TOTAL COSTO</td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totcostos' id="totcostos" size='12' class="valor" readonly> 
             <input type='hidden' name='totcostos' id="totcostos_x" > 
        </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotcostos' id="ustotcostos" size='12' class="valor" readonly></td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotcostos' id="portotcostos" size='8' class="valor" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=5 class=xl229 >TOTAL PROFIT</td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totprofit' id="totprofit" size='12' class="valor" readonly>
            <input type='hidden' name='totprofit_x' id="totprofit_x" >
            </td>
        <td class=xl148 style='text-align:right'>USD<input type='text' name='ustotprofit' id="ustotprofit" size='12' class="valor" readonly></td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotprofit' id="portotprofit" size='8' class="valor" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=5 class=xl229 >TOTAL PRECIO DE VENTA (SIN IVA)</td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totprecio' id="totprecio" size='12' class="valor" readonly> 
             <input type='hidden' name='totprecio_x' id="totprecio_x" > 
            </td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotprecio' id="ustotprecio" size='12' class="valor" readonly>
      </td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotprecio' id="portotprecio" size='8' class="valor" readonly>%</td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=5 class=xl227 >TOTAL IVA</td>
        <td class=xl110 style='text-align:right'>
            $ <input type='text' name='totiva' id="totiva" size='12' class="valor" readonly>
             <input type='hidden' name='totiva_x' id="totiva_x" class="valor" readonly> 
        </td>
        <td class=xl148 style='text-align:right'>USD<input type='text' name='ustotiva' id="ustotiva" size='12' class="valor" readonly></td>
        <td class=xl140 style='text-align:right'><input type='text' name='portotiva' id="portotiva" size='8' class="valor" readonly>%</td>
      </tr>
      <tr style='height:27.6pt;'>
        <td colspan=8 style='height:27.6pt;'></td>
      </tr>
    </table>

    </div>
  
    <div id="divResumenCliente" style="display:none;">
    <table style="border:.5pt solid;width:520pt">  
      <tr style='height:20pt;'>
        <td style='width:33pt'>&nbsp;</td>
        <td style='width:11pt'>&nbsp;</td>
        <td style='width:13pt'>&nbsp;</td>
        <td style='width:80pt'>&nbsp;</td>
        <td style='width:117pt'>&nbsp;</td>
        <td style='width:97pt'>&nbsp;</td>
        <td style='width:87pt;padding:5px'>&nbsp;
            <!-- BOTON activar Resumen General -->
            <button type='button' class='btn btn-primary btn-sm' id="xresumenCliente" title="Versión General">V. General</button>
        </td>
        <td style='width:82pt'>   
        </td>
      </tr>

      <tr height=18 style='height:13.8pt'>
        <td colspan=8 class=xl84>RESUMEN COSTO DE MONTAJE</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl71 style='border-top:none'>ÍTEM</td>
        <td colspan=7 class=xl221 style='border-right:.5pt solid ;border-left:none'>DESCRIPCIÓN</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">1&nbsp;</td>
        <td colspan=7 class=xl224 style='border-right:.5pt solid ;'>
            <a href="#" id="idpersadm"><span style='color:#203764;font-weight:700'>ADMINISTRATIVOS</span></a></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'></td> 
        <td colspan=6 class=xl230 >Incluye </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl82 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Pólizas</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl72>&nbsp;</td>
        <td class=xl73 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Personal COMPRAS + CONTABILIDAD</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl81 valor">2&nbsp;</td>
        <td colspan=7 class=xl232 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idpersalfrio"><span style='color:#203764;font-weight:700'>PERSONAL ALFRIO</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl152 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Ingeniero ALFRIO</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Técnico ALFRIO</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Viáticos</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Servicio telefónico</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">3&nbsp;</td>
        <td colspan=7 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_equipos"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE EQUIPOS</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de instalación</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de aislamiento</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">4&nbsp;</td>
        <td colspan=7 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_tuberia"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE TUBERÍA</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de mano de obra</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de material</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de aislamiento</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de pintura</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Soportería para tuberías</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">5&nbsp;</td>
        <td colspan=7 class=xl215 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_valvula"><span style='color:#203764;font-weight:700'>INSTALACIÓN DE VÁLV Y ACC</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl153 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de mano de obra</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de material</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de aislamiento</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de pintura</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">6&nbsp;</td>
        <td colspan=7 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="idinstal_electrica"><span style='color:#203764;font-weight:700'>INSTALACIÓN ELÉCTRICA</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de mano de obra</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Costo de material</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Soportería para bandejas/tubería</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">7&nbsp;</td>
        <td colspan=7 class=xl232 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="id_pruebas"><span style='color:#203764;font-weight:700'>PRUEBAS DE FUNCIONAMIENTO</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl152 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Pruebas de triple vacío</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Pruebas de presión (75, 100, 200 psi)</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Pruebas eléctricas</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class="xl80 valor">8&nbsp;</td>
        <td colspan=7 class=xl224 style='border-right:.5pt solid #203764;border-left:none'>
          <a href="#" id="id_varios"><span style='color:#203764;font-weight:700'>VARIOS</span></a>
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl81>&nbsp;</td>
        <td class=xl150 style='border-left:none'><u style='visibility:hidden;'>&nbsp;</u></td>
        <td colspan=6 class=xl230 >Incluye</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Andamios</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Viáticos de personal</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Transporte de material</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Personal SISO</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl76>&nbsp;</td>
        <td class=xl77 style='border-left:none'>&nbsp;</td>
        <td class=xl154>&#1413;</td>
        <td colspan=5 class=xl230 >Imprevistos</td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <td colspan=6 class=xl229 >&nbsp;TOTAL PRECIO DE VENTA</td>
        <td class=xl148 style='text-align:right'>
            USD<input type='text' name='ustotprecio' id="ustotprecio_y" size='12' class="valor" readonly>
      </td>
        <td class=xl140 style='text-align:right'>
      </tr>
      <tr >
        <td colspan=8 style='height:50pt;word-wrap: break-word;white-space:normal;padding:5pt;'>
          &nbsp;NOTA: El precio está ofertado en DÓLARES AMERICANOS pagaderos en pesos colombianos a la tasa representativa 
          de mercado el día en que se realice cada pago. Nos reservamos el derecho a solicitar reajuste de precio en 
          caso de que se modifiquen las condiciones tributarias (IVA, retefuente, etc.) impuestos por el Gobierno 
          Nacional. A este valor sumar el IVA.								
        </td>
      </tr>
    </table>

    </div>

  </div>

      <!-- COSTOS ADMINISTRATIVOS -->
  <div class="container" id="costos_adm" style="display:none;margin-left:5pt">
    <table cellpadding=0 cellspacing=0  style='border-collapse:collapse;'> 
      <col width=18 style='width:13pt'>
      <col width=285 style='width:214pt'>
      <col width=47 style='width:35pt'>
      <col width=113 style='width:85pt'>
      <col width=18 style='width:13pt'>
      <tr height=19 style='height:14.4pt'>
      <td style='width:13pt'>
      </td>
      <td width=285 style='width:214pt'>
      </td>
      <td width=47 style='width:35pt'></td>
      <td width=113 style='width:85pt'></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
      <td height=18 style='height:13.8pt'></td>
      <td colspan=3 class=xl235>RESUMEN COSTOS ADMINISTRATIVOS</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
      <td height=18 style='height:13.8pt'></td>
      <td colspan=2 class=xl86>COSTOS ADMINISTRATIVOS</td>
      <td class=xl86>&nbsp;&nbsp;&nbsp;&nbsp;COSTO</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
      <td height=18 style='height:13.8pt'></td>
      <td colspan=2 class=xl87>POLIZAS</td>
      <td class=xl116 style='text-align:right'>
          $<input type="text" class="valor" name="polizas" id="polizas" size="8" value="<?php echo fpesos($ar_adm['polizas']) ?>">
           <input type="hidden" id="polizas_x"  value="<?php echo $ar_adm['polizas'] ?>">
      </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
      <td height=18 style='height:13.8pt'></td>
      <td colspan=2 class=xl88 style='width:214pt'>COSTO FINANCIERO</td>
      <td class=xl116  style='text-align:right'>
          $<input type="text" class="valor" name="cst_fcro" id="cst_fcro" size="8" value="<?php echo fpesos($ar_adm['costo_fcro']) ?>">
           <input type="hidden" id="cst_fcro_x" value="<?php echo $ar_adm['costo_fcro'] ?>" >        
      </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
      <td height=18 style='height:13.8pt'></td>
      <td colspan=2 class=xl87 >PERSONAL COMPRAS + CONTABILIDAD</td>
      <td class=xl109 style='text-align:right'>
          $<input type="text" class="valor" name="comp_cntb" id="comp_cntb" size="8" value="<?php echo fpesos($ar_adm['pers_admtvo']) ?>">
           <input type="hidden" id="comp_cntb_x" value="<?php echo $ar_adm['pers_admtvo'] ?>" >
      </td>
      </tr>
      <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=2 class=xl158 style='border-top:none'>TOTAL COSTOS ADMINISTRATIVOS</td>
      <td class=xl161 style='text-align:right'>$<input type="text" class="valor" name="totcstadm" id="totcstadm" size="8" readonly></td>
      </tr>
      <tr>
        <td></td>
        <td style="padding:5px">
            <button type='button' class='btn btn-primary btn-sm' id="xcostos_adm">Regresar</button>
        </td>
        <td colspan="2" style="text-align:center;vertical-align:middle;height:20pt;padding:5px">
              <input type="hidden" name="id_cons_adm" id="id_cons_adm" value="<?php echo $ar_adm['id_cons_adm'] ?>" size="1" readonly >
        </td>
      </tr>
      </table>
      <div style='padding:.6pt 0pt 0pt .6pt;text-align:left'>
            <p class="font11">Costo financiero 3.20 % del valor de la venta,
            este porcentaje resume el costo de: retención en la fuente, ICA, Rete ICA,
            Gravamen Financiero, Iva de la Importación y Anticipo financiado al proveedor.</p>
      </div>
</div>

<!-- COSTOS DE PERSONAL ALFRIO -->
<div class="container" id="costos_pers_alfrio" style="display:none;margin-left:5pt">
    <table style='width:400pt;padding:0;border-collapse:collapse;background-color:lightgray;'> 
      <tr height=19 style='height:14.4pt'>
        <td style='width:300pt'></td>
        <td style='width:100pt'></td>
      </tr>
      <tr style='height:13.8pt'>
        <td colspan=2 class=xl235>RESUMEN COSTO POR PERSONAL ALFRÍO</td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl236>Costo Total Mano de Obra Ingeniero</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totmanoinge" id="totmanoinge" style="width:92%" class="valor" readonly> 
            <input type="hidden" name="totmanoinge_x" id="totmanoinge_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl236>Costo Total Mano de Obra Tecnico</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totmanotecn" id="totmanotecn" style="width:92%" class="valor" readonly> 
            <input type="hidden" name="totmanotecn_x" id="totmanotecn_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl236>Viaticos y Desplazamientos Tecnico</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totviattecn" id="totviattecn" style="width:92%" class="valor" readonly> 
            <input type="hidden" name="totviattecn_x" id="totviattecn_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl236>Viaticos y Desplazamientos Ingeniero</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totviatinge" id="totviatinge" style="width:92%" class="valor" readonly> 
            <input type="hidden" name="totviatinge_x" id="totviatinge_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl236>GARANTÍAS</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totgarantias" id="totgarantias" style="width:92%" class="valor" readonly> 
            <input type="hidden" name="totgarantias_x" id="totgarantias_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td class=xl237>TOTAL COSTOS POR PERSONAL ALFRÍO</td>
        <td class=xl188 style='text-align:right'> $ 
            <input type="text" name="totcstpers" id="totcstpers" style="width:92%" class="valor" readonly> 
            <input type="hidden" id="totcstpers_x" > 
        </td>
      </tr>
    </table>
    <table cellspacing=0  style='width:771px;border-collapse:collapse;padding:0'>
      <tr style='height:20pt;'>
        <td style="width:2px"></td>
        <td style="padding:5px;width:200px;">
          <button type='button' class='btn btn-primary btn-sm' id="xcostos_pers_alfrio" >Regresar</button>
        </td>
        <td style='height:20pt;width:70px;vertical-align:middle;text-align:center;padding:5px'></td>
        <td style="width:70px;"></td>
        <td style="width:70px;"></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl191>Personal Alfrío Labores en Planta</td>
        <td class=xl235 style='border-left:none'>Días</td>
        <td class=xl235 style='border-left:none'>Valor Día</td>
        <td class=xl235 style='border-left:none'>Total</td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 >Costo Ingeniero</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="caninge" id="caninge" style="width:92%" class="centro" 
            value="<?php if(isset($ar_pers[0]['cant'])){echo $ar_pers[0]['cant'];}else{ echo "";}; ?>" 
            onblur="multi(this,'id_020101','csttotinge','totmanoinge','');">
        </td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="cstinge" id="id_020101" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
            <input type="text" name="csttotinge" id="csttotinge" size="9" class="valor" readonly 
              > 
              <input type="hidden" id="csttotinge_x" 
                value="<?php if( isset($ar_pers[0]['valor_total'])){echo $ar_pers[0]['valor_total'];}else{echo "";} ?>" >
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr style='height:13.8pt'>
        <td style='height:13.8pt'></td>
        <td class=xl193 >Costo Tecnico</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cantecn" id="cantecn" size="4" class="centro" 
              value="<?php if(isset($ar_pers[1]['cant'])){echo $ar_pers[1]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020201','csttottecn','totmanotecn','');">
        </td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttecn" id="id_020201" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="csttottecn" id="csttottecn" size="9" class="valor" readonly 
            > 
            <input type="hidden" id="csttottecn_x"
              value="<?php if(isset($ar_pers[1]['valor_total'])){echo $ar_pers[1]['valor_total'];}else{echo "";} ?>" >
            </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl195></td>
        <td class=xl195></td>
        <td class=xl195></td>
        <td class=xl195></td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl192>Viaticos y Desplazamientos Ingeniero</td>
        <td class=xl235 style='border-left:none'>Cantidad</td>
        <td class=xl235 style='border-left:none'>Vr.Unitario</td>
        <td class=xl235 style='border-left:none'>Total</td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Tiquetes (Ida y Regreso) x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cantiqinge" id="cantiqinge" size="4" class="centro" 
              value="<?php if(isset($ar_pers[2]['cant'])){echo $ar_pers[2]['cant'];}else{echo "";} ?>" 
              onblur="multi(this,'id_020301','tottiqinge','totviatinge','inge');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttiqinge" id="id_020301" size="8" class="valor" readonly>
        </td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tottiqinge" id="tottiqinge" size="9" class="valor" readonly > 
          <input type="hidden" id="tottiqinge_x" 
            value="<?php if(isset($ar_pers[2]['valor_total'])){echo $ar_pers[2]['valor_total'];}else{echo "";} ?>">
        </td>
        <td></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Hospedaje x noche x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="canhosinge" id="canhosinge" size="4" class="centro" 
            value="<?php if(isset($ar_pers[3]['cant'])){echo $ar_pers[3]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020302','tothosinge','totviatinge','inge');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csthosinge" id="id_020302" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
            <input type="text" name="tothosinge" id="tothosinge" size="9" class="valor" readonly  > 
            <input type="hidden" id="tothosinge_x"
              value="<?php if(isset($ar_pers[3]['valor_total'])){echo $ar_pers[3]['valor_total'];}else{echo "";} ?>" >
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Alimentación x día x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="canaliinge" id="canaliinge" size="4" class="centro" 
            value="<?php if(isset($ar_pers[4]['cant'])){echo $ar_pers[4]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020303','totaliinge','totviatinge','inge');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="cstaliinge" id="id_020303" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
            <input type="text" name="totaliinge" id="totaliinge" size="9" class="valor" readonly > 
            <input type="hidden" id="totaliinge_x"
              value="<?php if(isset($ar_pers[4]['valor_total'])){echo $ar_pers[4]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Transporte x día x persona</td>
        <td class=xl202 style='text-align:center'> 
          <input type="text" name="cantrainge" id="cantrainge" size="4" class="centro" 
          value="<?php if(isset($ar_pers[5]['cant'])){echo $ar_pers[5]['cant'];}else{echo "";} ?>"  
          onblur="multi(this,'id_020304','tottrainge','totviatinge','inge');">
        </td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttrainge" id="id_020304" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tottrainge" id="tottrainge" size="9" class="valor" readonly > 
          <input type="hidden" id="tottrainge_x"
            value="<?php if(isset($ar_pers[5]['valor_total'])){ echo $ar_pers[5]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>

      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl195></td>
        <td class=xl196></td>
        <td class=xl195></td>
        <td class=xl195></td>
        <td colspan=2 ></td>
      </tr>
      
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl192>Viaticos y Desplazamientos Técnico</td>
        <td class=xl235 style='border-left:none'>Cantidad</td>
        <td class=xl235 style='border-left:none'>Vr.Unitario</td>
        <td class=xl235 style='border-left:none'>Total</td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Tiquetes (Ida y Regreso) x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cantiqtecn" id="cantiqtecn" size="4" class="centro" 
              value="<?php if(isset($ar_pers[6]['cant'])){echo $ar_pers[6]['cant'];}else{echo "";} ?>" 
              onblur="multi(this,'id_020401','tottiqtecn','totviattecn','tecn');">
        </td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttiqtecn" id="id_020401" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tottiqtecn" id="tottiqtecn" size="9" class="valor" readonly > 
          <input type="hidden" id="tottiqtecn_x"
            value="<?php if(isset($ar_pers[6]['valor_total'])){echo $ar_pers[6]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Hospedaje x noche x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="canhostecn" id="canhostecn" size="4" class="centro" 
            value="<?php if(isset($ar_pers[7]['cant'])){echo $ar_pers[7]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020402','tothostecn','totviattecn','tecn');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csthostecn" id="id_020402" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tothostecn" id="tothostecn" size="9" class="valor" readonly > 
          <input type="hidden" id="tothostecn_x"
             value="<?php if(isset($ar_pers[7]['valor_total'])){echo $ar_pers[7]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Alimentación x día x persona</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="canalitecn" id="canalitecn" size="4" class="centro" 
              value="<?php if(isset($ar_pers[8]['cant'])){echo $ar_pers[8]['cant'];}else{echo "";} ?>" 
              onblur="multi(this,'id_020403','totalitecn','totviattecn','tecn');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="cstalitecn" id="id_020403" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="totalitecn" id="totalitecn" size="9" class="valor" readonly > 
          <input type="hidden" id="totalitecn_x"
            value="<?php if(isset($ar_pers[8]['valor_total'])){echo $ar_pers[8]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl193 style='border-top:none'>Transporte x día x persona TECNICO</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cantratecn" id="cantratecn" size="4" class="centro" 
            value="<?php if(isset($ar_pers[9]['cant'])){echo $ar_pers[9]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020404','tottratecn','totviattecn','tecn');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttratecn" id="id_020404" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tottratecn" id="tottratecn" size="9" class="valor" readonly > 
          <input type="hidden" id="tottratecn_x"
            value="<?php if(isset($ar_pers[9]['valor_total'])){echo $ar_pers[9]['valor_total'];}else{echo "";} ?>" > 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl197></td>
        <td class=xl197></td>
        <td class=xl197></td>
        <td class=xl197></td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl198>Garantía</td>
        <td class=xl235>Cantidad</td>
        <td class=xl235 style='border-left:none'>Vr.Unitario</td>
        <td class=xl235 style='border-left:none'>Total</td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl85 style='border-top:none'>Transporte</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cantragara" id="cantragara" size="4" class="centro" 
            value="<?php if(isset($ar_pers[10]['cant'])){echo $ar_pers[10]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020501','tottragara','totgarantias','gara');">
        </td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="csttragara" id="id_020501" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="tottragara" id="tottragara" size="9" class="valor" readonly > 
          <input type="hidden" id="tottragara_x" placeholder="tottragara_x"
             value="<?php if(isset($ar_pers[10]['valor_total'])){echo $ar_pers[10]['valor_total'];}else{echo "";} ?>"> 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl85 style='border-top:none'>Sueldo técnico en visitas, Pasajes</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="cansuegara" id="cansuegara" size="4" class="centro" 
            value="<?php if(isset($ar_pers[11]['cant'])){echo $ar_pers[11]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020502','totsuegara','totgarantias','gara');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="cstsuegara" id="id_020502" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="totsuegara" id="totsuegara" size="9" class="valor" readonly > 
          <input type="hidden" id="totsuegara_x" placeholder="totsuegara_x"
            value="<?php if(isset($ar_pers[11]['valor_total'])){echo $ar_pers[11]['valor_total'];}else{echo "";} ?>"> 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 style='height:13.8pt'></td>
        <td class=xl85 style='border-top:none'>Viáticos personal ALFRÍO</td>
        <td class=xl202 style='text-align:center'> 
            <input type="text" name="canviagara" id="canviagara" size="4" class="centro" 
            value="<?php if(isset($ar_pers[12]['cant'])){echo $ar_pers[12]['cant'];}else{echo "";} ?>" 
            onblur="multi(this,'id_020503','totviagara','totgarantias','gara');"></td>
        <td class=xl194 style='text-align:rigth'>$ <input type="text" name="cstviaalfr" id="id_020503" size="8" class="valor" readonly></td>
        <td class=xl194 style='text-align:rigth'>$ 
          <input type="text" name="totviagara" id="totviagara" size="9" class="valor" readonly > 
          <input type="hidden" id="totviagara_x" placeholder="totviagara_x"
            value="<?php if(isset($ar_pers[12]['valor_total'])){echo $ar_pers[12]['valor_total'];}else{echo "";} ?>"> 
        </td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 colspan=3 style='height:13.8pt;'></td>
        <td class=xl141></td>
        <td class=xl141></td>
        <td colspan=2 ></td>
      </tr>
      <tr height=18 style='height:13.8pt'>
        <td height=18 colspan=3 style='height:13.8pt;'></td>
        <td class=xl141></td>
        <td class=xl141></td>
        <td colspan=2 ></td>
      </tr>
      </table>  
</div>
<!-- COSTOS DE INSTALACION EQUIPOS -->
<div class="container" id="costo_instal_equipos" style="display:none;margin-left:0pt;overflow:auto;width:100%;height:100%;padding:0;"> <!-- width:100%; -->
  <input type="hidden" name="hay_equipos" id="hay_equipos" value="<?php echo $hay_equipos ?>">
  <input type="hidden" name="hay_perfiles" id="hay_perfiles" value="<?php echo $hay_perfiles ?>">
  <br>
  <table style="border-collapse:collapse;background-color:lightgray;" id="tb_cst_equipos">
    <tr style='height:14.4pt;display:none;'>
      <td style='width:261pt'>&nbsp;</td>
      <td style='width:96px'>&nbsp;</td>
      <td style='width:97px'>&nbsp;</td>
      <td style='width:60pt'>&nbsp;</td>
      <td style='width:57pt'>&nbsp;</td>
      <td style='width:85px'>&nbsp;</td>
      <td style='width:115px'>&nbsp;</td>
      <td style='width:85px'>&nbsp;</td>
    </tr>
    <tr style='height:13.95pt'>
      <td colspan=3 class=xl238 style="width:454pt">RESUMEN COSTO DE INSTALACIÓN DE EQUIPOS</td>
      <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
      <td colspan=3 class=xl245>&nbsp; COSTO DE INSTALACIÓN COP/Kg</td>
      <td> <input type="text" name="vr_un_insteq" id="id_0301" style="width:95%" class="valor" readonly></td>
    </tr>
    <tr height=18 style='height:13.95pt'>
      <td colspan=1 class=xl243 >&nbsp;TOTAL COSTO DE INSTALACIÓN</td>
      <td  colspan=2 class=xl109 >$ 
          <input type="text" name="totCostInstal" id="totCostInstal" style="width:95%" class="valor" readonly> 
          <input type="hidden" name="totCostInstal_x" id="totCostInstal_x" > 
      </td>
      <td></td>
      <td colspan="3" class="xl245">&nbsp;% INCREMENTO AC ESTRUCTURAL</td>
      <td><input type="text" id="id_0907" style="width:95%" class="valor" readonly></td>
    </tr>
    <tr height=18 style='height:13.95pt'>
      <td colspan=1 class=xl243 >&nbsp;TOTAL COSTO DE AISLAMIENTO</td>
      <td  colspan=2 class=xl109 >$ 
          <input type="text" name="totCostAislam" id="totCostAislam" style="width:95%" class="valor" readonly>
          <input type="hidden" name="totCostAislam_x" id="totCostAislam_x" >
      </td>
      <td></td>
      <td colspan="3" class="xl245">&nbsp;% INCREMENTO M.O. SOLDADOR</td>
      <td><input type="text" id="id_0901" style="width:95%" class="valor" readonly></td>
    </tr>
    <tr height=18 style='height:13.95pt'>
      <td colspan=1 class=xl243 >&nbsp;SOPORTERÍA PARA EQUIPOS</td>
      <td  colspan=2 class=xl109 >$ 
          <input type="text" name="totCostSoport" id="totCostSoport" style="width:95%" class="valor" readonly>
          <input type="hidden" name="totCostSoport_x" id="totCostSoport_x" >
      </td>
      <td></td>
      <td colspan="3" class="xl245">&nbsp;% INCREMENTO M.O. ELÉCTRICO</td>
      <td><input type="text" id="id_0902" style="width:95%" class="valor" readonly></td>
    </tr>
    <tr height=18 style='height:13.8pt;'>
      <td coslpan="2" class=xl241 >&nbsp;TOTAL COSTO POR INSTALACIÓN DE EQUIPOS</td>
      <td  colspan=2 class=xl161 >$ 
          <input type="text" name="totCostEquipos" id="totCostEquipos" style="width:95%" class="valor" readonly>
          <input type="hidden" name="totCostEquipos_x" id="totCostEquipos_x" >
      </td>
      <td colspan=5 > </td>
    </tr>
  </table>

      <!-- sección de captura inst.equipos y soporteria -->
 <div id="cuerpoInsEquipos" style="width:100%;margin-bottom:10px"> <!-- display:flex;overflow-y:auto; -->
  
  <div id="" style="width:63.5%;">    <!-- sección captura y arreglo instalación equipos -->
    <table style='border-color:aliceblue;' >  
      <tr style='height:14.4pt'>
        <td style='width:220pt;padding:5px'>
            <input type="hidden" id="vr_pi" value="<?php echo pi() ?>" >
            <button type='button' class='btn btn-primary btn-sm' id="xcosto_instal_equipos">Regresar</button>
        </td>
        <td style='width:96px'></td>
        <td style='width:97px'>&nbsp;</td>
        <td style='width:60pt'>&nbsp;</td>
        <td style='width:57pt'> </td>
        <td style='width:85px'>&nbsp;</td>
        <td style='width:115px'>&nbsp;</td>
        <td style='width:115px'>&nbsp;</td>
        <td style='width:10px'>&nbsp;</td>
      </tr>
      <tr style='height:20pt;display:none;'>
        <td colspan=3 > </td>
        <td colspan="2" style='height:20pt;vertical-align:middle;text-align:center;'>
        </td>
        <td > <input type="hidden" class="form-control valor" name="" id="id_contador" value="0" ></td>
        <td > <input type="hidden" class="form-control valor" name="" id="sm_costInstal" ></td>
        <td > <input type="hidden" class="form-control valor" name="" id="sm_costAislam" >
              <input type="hidden" id="vlrAislam" ></td>
      </tr>
      <tr height=18 style='height:13.8pt;'>
        <!-- <td height=18 style='height:13.8pt'></td> -->
        <td class=xl104 align="center">EQUIPO</td>
        <td class=xl104 align="center">PESO</td>
        <td class=xl104 align="center">LARGO</td>
        <td class=xl104 align="center">ANCHO</td>
        <td class=xl104 align="center">ALTO</td>
        <td class=xl104 align="center">AISLAMIEN</td>
        <td class=xl104 align="center">CST INSTALAC</td>
        <td class=xl104 align="center">CST AISLAMIE</td>
      </tr>
      <tr style='height:13.8pt;background:#D9E1F2;'>
        <!-- <td id="lineaCaptura"></td> -->
        <td class=xl96 >
            <input type="text" name="nomEquipo_0" id="nomEquipo_0" style="width:90%">  
            <select id="idPesoEq_0" style="width:40px">
              <option value='L' title="Libras" selected>lb</option>
              <option value='K' title="Kilos">kg</option>
            </select>
        </td>
        <td class="xl208 valor" >
            <input type="text" name="pesoEq_0" id="pesoEq_0" style="width:85%" class="valor" title="Peso"></td>
        <td class="xl208 valor" >
            <select id="idMediEq_0" style="width:40px">
              <option value='P' title="Pulgadas" selected>in</option>
              <option value='M' title="Metros">m</option>
            </select>
            <input type="text" name="largoEq_0" id="largoEq_0" class="valor" style="width:60%"></td>  
        <td class="xl208 valor" >
            <input type="text" name="anchoEq_0" id="anchoEq_0" class="valor" style="width:95%"></td>  
        <td class="xl208 valor" >
            <input type="text" name="altoEq_0"  id="altoEq_0"  class="valor" style="width:87%"></td>
        <td class="xl97 valor" >
            <?php echo $tgpespesor->selecc('aislEq_0','','','','|');  ?>  <!-- form-select form-select-sm   -->
        </td>
        <td class=xl110 >
            $<input type="text" name="cstInstEq_0" id="cstInstEq_0" style="width:87%" class="valor" readonly></td>
        <td class=xl108 >
            $<input type="text" name="cstAislEq_0" id="cstAislEq_0" style="width:87%" class="valor" readonly></td>
      </tr>
    </table>
    <!-- capa de arreglo de inst. equipos -->
    <div id="divRegistrosInstEq" style="margin-left:0; background-color:burlywood"> 
        <table style='border-collapse:collapse;border:0.01pt solid;margin-left:0;padding-left:0;float:left;' id="idTablaLineas" > 
          <thead>     
            <tr style='height:13.8pt;'>
              <td class=xl104 style="width:220pt;text-align:center">Equipo</td>
              <td class=xl104 style="width:97px;text-align:center">Peso (kg)</td>
              <td class=xl104 style="width:99px;text-align:center">Largo (m)</td>
              <td class=xl104 style="width:80px;text-align:center">Ancho (m)</td>
              <td class=xl104 style="width:73px;text-align:center">Alto (m)</td>
              <td class=xl104 style="width:85px;text-align:center">Aislamiento</td>
              <td class=xl104 style="width:115px;text-align:center">Costo Instalac</td>
              <td class=xl104 style="width:115px;text-align:center">Costo Aislamie</td>
              <td class=xl104 style="width:10px;text-align:center"> # </td>
              <td class=xl104 style="width:100px;text-align:center;display:none;">Precio M2</td>
            </tr>  
          </thead>
          <tbody id="cuerpoEntrada">

          </tbody>         
        </table>
    </div>
  </div>
  <div id="divSoportEquipos" style="position:relative;width:36.5%;top:10px;">
      <br>
      <table style='border-collapse:collapse;margin-left:1px;border:0.05pt solid;' id="idTablaSoporteria" >  
        <thead>     
          <tr style='height:13.8pt;'>
            <td colspan="3" class="xl246" style="width:90px;">SOPORTE</td>
            <td colspan="3" class="xl247" style="width:240px;">COSTO</td>
          </tr>  

          <tr style='height:10pt;'>
            <td class=xl246 style="width:85px;">Perfil</td>
            <td class=xl246 style="width:62px;">Mat x Sop</td>
            <td class=xl246 style="width:65px;">Cant Sop</td>
            <td class=xl247 style="width:110px;">Material</td>
            <td class=xl247 style="width:107px;">M.Obra</td>
            <td class=xl247 style="width:107px;">Pintura</td>
          </tr>  
        </thead>
        <tbody id="cuerpoEntrada2">
          <tr>
            <td> <?php echo $tgp_perfils->selecc('perfil_0','','','','|'); ?> </td> <!-- form-select form-select-sm -->
            <td> <input type="text" name="matSop_0" id="matSop_0" style="width:99%" class="valor"> </td>
            <td> <input type="text" name="canSop_0" id="canSop_0" style="width:99%" class="valor" onblur="calcPerfil(this);"> </td>
            <td> 
                <input type="text" name="cstMaterial_0" id="cstMaterial_0" style="width:99%" class="valor" readonly><br>
                <input type="hidden" id="vrMaterial_0" >
            </td>
            <td> <input type="text" name="cstMobra_0" id="cstMobra_0" style="width:99%" class="valor" readonly><br>
                <input type="hidden" id="vrMobra_0" > 
            </td>
            <td> <input type="text" name="cstPintura_0" id="cstPintura_0" style="width:99%" class="valor" readonly><br>
                <input type="hidden"  id="vrPintura_0" > 
            </td>
          </tr>
        </tbody>         
      </table>
      <!-- capa de arreglo soporteria instal. equipos -->
      <div>
          <table style='border-collapse:collapse;margin-left:1px;border:0.01pt solid;' id="idTablaSoporteria" >   <!-- table-layout:fixed; -->
            <thead> 
              <tr style='height:13.8pt;'>
                <td class=xl246 style="width:85px;">Perfil</td>
                <td class=xl246 style="width:62px;">Mat x Sop</td>
                <td class=xl246 style="width:65px;">Cant Sop</td>
                <td class=xl247 style="width:110px;">Material</td>
                <td class=xl247 style="width:107px;">M.Obra</td>
                <td class=xl247 style="width:107px;">Pintura</td>
                <td class="xl247" style="width:10px;">#</td>
              </tr>                
            </thead>  
              <tbody id="divRegSoporteEquipos">

              </tbody>
          </table>
      </div>
    </div>

  </div>    
</div>

<!-- COSTOS DE INSTALACION TUBERIA -->
<div id="costo_instal_tuberia" style="display:none; margin-left:5pt">
<input type="hidden" name="hay_tuberia" id="hay_tuberia" size="1" value="<?php echo $hay_tuberia ?>" readonly>
<input type="hidden" name="hay_soptuberia" id="hay_soptuberia" size="1" value="<?php echo $hay_soptuberia ?>" readonly>

<div  style="display:flex;width:100%;overflow-y:auto">
  <div style="width:50%;background-color:lightgray;">
    <table  style='border-collapse:collapse;width:99%;background-color:lightgray;'>   
      <tr>
        <td style='height:14.4pt;width:2%'>
          <!-- <a href="#" id="xcosto_instal_tuberia"><span style='color:red'>X</span></a> --> 
        </td>
        <td style='width:70%'></td>
        <td  style='width:28%'></td>
      </tr>
      <tr style='height:13.95pt'>
        <!-- <td style='height:13.95pt'></td> -->
        <td colspan="3" class=xl235> RESUMEN COSTO DE INSTALACIÓN DE TUBERÍA</td>
      </tr>
      <tr style='height:13.95pt'>
        <!-- <td style='height:13.95pt'></td> -->
        <td  class=xl243 colspan=2 >&nbsp;TOTAL COSTO DE MATERIAL</td>
        <td class=xl249 style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtMatInstTuberia" class="valor" readonly style="width:90%"> 
            <input type="hidden" id="gtMatInstTuberia_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <!-- <td height=18 style='height:13.95pt'></td> -->
        <td class=xl243 colspan=2 >&nbsp;TOTAL COSTO DE MANO DE OBRA</td>
        <td class=xl249  style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtMobInstTuberia" class="valor" readonly style="width:90%"> 
            <input type="hidden" id="gtMobInstTuberia_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <!-- <td height=18 style='height:13.95pt'></td> -->
        <td class=xl243 colspan=2>&nbsp;TOTAL COSTO DE PINTURA</td>
        <td class=xl249  style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtPinInstTuberia" class="valor" readonly style="width:90%"> 
            <input type="hidden" id="gtPinInstTuberia_x" > 
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <!-- <td height=18 style='height:13.95pt'></td> -->
        <td class=xl243 colspan=2>&nbsp;TOTAL COSTO DE AISLAMIENTO</td>
        <td class=xl249  style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtAisInstTuberia" class="valor" readonly style="width:90%">
            <input type="hidden" id="gtAisInstTuberia_x" >
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <!-- <td height=18 style='height:13.95pt'></td> -->
        <td class=xl243 colspan=2>&nbsp;TOTAL COSTO DE SOPORTERÍA (PERFIL MXM) MATERIAL + M.O</td>
        <td class=xl249  style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtSopInstTuberia" class="valor" readonly style="width:90%">
            <input type="hidden" id="gtSopInstTuberia_x" >
        </td>
      </tr>
      <tr height=18 style='height:13.95pt'>
        <!-- <td height=18 style='height:13.95pt'></td> -->
        <td class=xl241 colspan=2>&nbsp;TOTAL COSTO DE INSTALACIÓN DE TUBERÍA</td>
        <td class=xl248  style='border-left:none;width:112pt'>$ 
            <input type="text" id="gtCstInstTuberia" class="valor" readonly style="width:90%">
            <input type="hidden" id="gtCstInstTuberia_x" >
        </td>
      </tr>
    </table style='border-collapse:collapse;width:35%'> 
  </div>
  <div style="width:25%;float:right;">
    <table style="width:100%;background-color:lightgray;">
      <tr style='height:14.4pt;'>
          <td style='width:5%'></td>
          <td style='width:65%'></td>
          <td style='width:30%'></td>
      </tr>
      <tr>
        <td></td>
        <td class='xl104'>% Incremento Ace inoxidable</td>
        <td > <input type="text" id="id_0904" style="width:90%" class="valor" readonly></td>
      </tr>
      <tr>
        <td></td>
        <td class='xl104'>% Incremento Ace Carbono</td>
        <td> <input type="text" id="id_0905" style="width:90%" class="valor" readonly></td>
      </tr>
      <tr>
        <td></td>
        <td class='xl104'>%Incremento Ace Galvanizado</td>
        <td> <input type="text" id="id_0906" style="width:90%" class="valor" readonly></td>
      </tr>
      <tr>
        <td></td>
        <td class='xl104'>% Incremento Cobre</td>
        <td> <input type="text" id="id_0908" style="width:90%" class="valor" readonly></td>
      </tr>
      <tr>
        <td></td>
        <td class='xl104'>% Incremento Aislamiento</td>
        <td> <input type="text" id="id_0903" style="width:90%" class="valor" readonly></td>
      </tr>
    </table>
  </div>
</div>

<div id="divInsTuberia" style="width:100%;overflow-y:auto"> <!-- display:flex; -->
      <div  style="width:95%;background-color:aquamarine">  <!-- div presentación y captura registros tuberia  -->
        <table cellspacing=0  style='border-collapse:collapse;padding:0'> <!-- width=1350;table-layout:fixed; -->
        <tr style='height:13.95pt'>
          <!-- <td style='height:13.95pt;width:15pt;'>1</td> --> 
          <td style='width:110pt;padding:5px'>            
              <button type='button' class='btn btn-primary btn-sm' id="xcosto_instal_tuberia">Regresar</button>
          </td>
          <td style='width:65pt;'>&nbsp;</td>
          <td style='width:65pt;'>&nbsp;</td>
          <td style='width:40pt;display:none'>&nbsp;</td>
          <td style='width:60pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:50pt;display:none'>&nbsp;</td>
          <td style='width:50pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:40pt;'>&nbsp;</td>
          <td style='width:60pt;'>&nbsp;</td>
          <td style='width:35pt;'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:37pt;display:none'>&nbsp;</td>
          <td style='width:60pt;padding:5px'> </td>
          <td style='width:35pt;display:none'>&nbsp;</td>
          <td style='width:37pt;'>&nbsp;</td>
          <td style='width:70pt;'>&nbsp;</td>
          <td style='width:70pt;'>&nbsp;</td>
          <td style='width:70pt;'>&nbsp;</td>
          <td style='width:70pt;'>&nbsp;</td>
        </tr> 
        <tr height=18 style='height:13.8pt'>
          <!-- <td height=18 style='height:13.8pt'></td> -->
          <td class=xl128>linea 2</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128>&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td class=xl128 style="display:none">&nbsp;</td>
          <td colspan=2 class=xl247>REDUCCIÓN</td>
          <td colspan=4 class=xl246 style='border-left:none'>COSTO</td>
        </tr>
        <tr style='height:13.8pt'>
          <!-- <td height=18 style='height:13.8pt'></td> -->
          <td class=xl104 >LINEA</td>
          <td class=xl104 >TIPO TUBO</td>
          <td class=xl104 >DIÁM</td>
          <td class=xl104 style="display:none">Col_1</td>
          <td class=xl104 style="display:none">Col_12</td>
          <td class=xl104 >LONG</td>
          <td class=xl104  style="display:none">Col_7</td>
          <td class=xl104  style="display:none">Col_2</td>
          <td class=xl104  style="display:none">Col_22</td>
          <td class=xl104 >ESP AIS</td>
          <td class=xl104 style="display:none" >Col_9</td>
          <td class=xl104 > CODO</td>
          <td class=xl104 style="display:none" >Col_8</td>
          <td class=xl104 style="display:none" >Col_3</td>
          <td class=xl104 style="display:none" >Col_33</td>
          <td class=xl104 >TEE</td>
          <td class=xl104 style="display:none" >Col_4</td>
          <td class=xl104 style="display:none" >Col_42</td>
          <td class=xl104 style="display:none" >Col_43</td>
          <td class=xl104 >UNION</td>
          <td class=xl104 style="display:none" >Col_5</td>
          <td class=xl104 style="display:none" >Col_52</td>
          <td class=xl104 style="display:none" >Col_53</td>
          <td class=xl104 >CAP</td>
          <td class=xl104 style="display:none" >Col_6</td>
          <td class=xl104 style="display:none" >Col_62</td>
          <td class=xl104 style="display:none" >Col_63</td>
          <td class=xl178 >MED</td>
          <td class=xl178 style="display:none" >Col_10</td>
          <td class=xl178 >CANT</td>
          <td class=xl246 >MATERIAL</td>
          <td class=xl246 >MANO OBR</td>
          <td class=xl246 > PINTURA</td>
          <td class=xl246 >AISLAMIE</td>
        </tr>
        
        <tr style='height:4pt'> <!-- 13.8pt -->
          <!-- <td ></td>  -->
          <td class=xl87 ><input type="text" name="linea_suc_des" id="linea_suc_des" style="width:99%" ></td>
          <td class=xl87><?php echo $tgpmaterial->selecc("idmat_suc_des","","","","|","width:97%"); ?> </td>
          <td class=xl87><?php echo $tgpdiametro->selecc("diam_suc_des", "","","","|","width:97%"); ?>
              <input type="hidden" id="vrmat_suc_des" >
              <input type="hidden" id="vrmob_suc_des" >
              <input type="hidden" id="vrpin_suc_des" >
          </td>
          <td class=xl87 style="display:none"><input type="text" id="" style="width:85%;display:none" readonly ></td>
          <td class=xl87 style="display:none"><input type="text" id="" style="width:85%;display:none" readonly ></td>
          <td class=xl87 ><input type="text" id="long_suc_des" class="valor fondo_azul" style="width:90%" onblur="longTb(this)"></td>
          <td class=xl87 style="display:none" ><input type="hidden" id="col7_suc_des"  style="width:98%" readonly></td>
          <td class=xl87 style="display:none" ><input type="hidden" id="col2_suc_des"  style="width:98%" readonly></td>
          <td class=xl87 style="display:none" ><input type="hidden" id="col22_suc_des" style="width:98%" readonly></td>
          <td class=xl87 ><?php echo $tgpaislamie->selecc("esAi_suc_des", "form-select form-select-sm","","","|","width:97%"); ?>
              <input type="hidden" id="cdmat_suc_des" style="width:95%" readonly>
              <input type="hidden" id="cdmob_suc_des" style="width:95%" readonly>
              <input type="hidden" id="cdpin_suc_des" style="width:95%" readonly>
          </td>
          <td class=xl69 style="display:none" ><input type="text" id="" size="3" class="valor" readonly  style="width:98%" placeholder="_"></td>
          <td class=xl87 ><input type="text" id="codo_suc_des" size="3" class="valor fondo_azul" onblur="vrCodo(this)" style="width:93%" >
              <input type="hidden" id="col8_suc_des"  readonly  style="width:95%" >
              <input type="hidden" id="col3_suc_des"  readonly  style="width:95%" >
              <input type="hidden" id="col33_suc_des" readonly  style="width:95%" >
          </td>
          <td class=xl87 style="display:none" ></td>
          <td class=xl87 style="display:none" ></td>
          <td class=xl87 style="display:none" ></td>
          <td class=xl87 ><input type="text" id="tee_suc_des" size="1" class="valor fondo_azul" onblur="cambia('tee_suc_des')" style="width:93%" >
              <input type="hidden" id="temat_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="temob_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="tepin_suc_des"  class="valor" style="width:95%" readonly>
          </td>
          <td class=xl87 style="display:none" ><input type="text" id="col4_suc_des" size="1" class="valor" readonly  style="width:98%" ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col42_suc_des" size="1" class="valor" readonly  style="width:98%" ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col43_suc_des" size="1" class="valor" readonly  style="width:98%" ></td>
          <td class=xl87 ><input type="text" id="uni_suc_des" size="1" class="valor fondo_azul" onblur="cambia('uni_suc_des')" style="width:93%" >
              <input type="hidden" id="unmat_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="unmob_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="unpin_suc_des" class="valor" style="width:95%" readonly>
          </td>
          <td class=xl87 style="display:none" ><input type="text" id="col5_suc_des"  class="valor" readonly style="width:98%" ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col52_suc_des" class="valor" readonly style="width:98%" ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col53_suc_des" class="valor" readonly style="width:98%" ></td>
          <td class=xl87 ><input type="text" id="cap_suc_des" size="1" class="valor fondo_azul" onblur="cambia('cap_suc_des')" style="width:93%" >
              <input type="hidden" id="camat_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="camob_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="capin_suc_des" class="valor" style="width:95%" readonly>
          </td>
          <td class=xl87 style="display:none" ><input type="text" id="col6_suc_des"  class="valor" readonly ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col62_suc_des" class="valor" readonly ></td>
          <td class=xl87 style="display:none" ><input type="text" id="col63_suc_des" class="valor" readonly ></td>
          <td class=xl87 >
            <select id="medi_suc_des" style="width:97%" >
              <option value='0'>Sin elegir</option>
            </select>
          </td>
          <td class=xl87 style="display:none" ><input type="text" id="" class="valor" readonly style="width:93%" ></td>
          <td class=xl87 >
              <input type="text" id="canr_suc_des" size="1" class="valor fondo_azul" onblur="canReduc(this)" style="width:99%" title="Cantidad Reducción">
              <input type="hidden" id="canrmt_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="canrmo_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="canrpi_suc_des" class="valor" style="width:95%" readonly>

              <input type="hidden" id="vrAis_suc_des" class="valor" style="width:95%" readonly>
              <input type="hidden" id="vrRed_suc_des" class="valor" style="width:95%" readonly>
            </td>
          <td class=xl109 > <input type="text" id="matCst_suc_des" class="valor" readonly style="width:99%" > </td>
          <td class=xl109 > <input type="text" id="mobCst_suc_des" class="valor" readonly style="width:99%" > </td>
          <td class=xl109 > <input type="text" id="pinCst_suc_des" class="valor" readonly style="width:99%" > </td>
          <td class=xl109 > <input type="text" id="aisCst_suc_des" class="valor" readonly style="width:99%" > </td>
        </tr>

        <tr style='height:13.8pt;display:none;'>
          <td colspan=35 style='height:13.8pt'> oculta ??</td>
        </tr>
        <tr style='height:13.8pt;display:none'>
          <!-- <td colspan=16 style='height:13.8pt;'></td> -->
          <td class=xl210 style="display:none"> <input type="text" id="sumaCstMat" size="11" class="valor" readonly style="width:89%"> </td>
          <td class=xl210 style="display:none"> <input type="text" id="sumaCstMob" size="11" class="valor" readonly style="width:89%"> </td>
          <td class=xl210 style="display:none"> <input type="text" id="sumaCstPin" size="11" class="valor" readonly style="width:89%"> </td>
          <td class=xl210 style="display:none"> <input type="text" id="sumaCstAis" size="11" class="valor" readonly style="width:89%"> </td>
        </tr> 
        </table>   
        <div>  <!--  div presentación arreglo de capturas tuberia -->
            <table border=1 cellpadding=0 cellspacing=0  style='border-collapse:collapse;'> 
              <thead>
                <tr style='height:13.95pt;'>
                  <!-- <td style='height:13.95pt;width:15pt;'></td> --> 
                  <td class="xl104" style='width:110pt;'>Línea</td>
                  <td class="xl104" style='width:65pt;'>TipoTubo</td>
                  <td class="xl104" style='width:65pt;'>Diám</td>
                  <td class="xl104" style='width:40pt;'>Long</td>
                  <td class="xl104" style='width:60pt;'>Esp Ais</td>
                  <td class="xl104" style='width:37pt;'>Codo</td>
                  <td class="xl104" style='width:37pt;'>Tee</td>
                  <td class="xl104" style='width:37pt;'>Union</td>
                  <td class="xl104" style='width:37pt;'>cap</td>
                  <td class="xl104" style='width:60pt;'>Med</td>
                  <td class="xl104" style='width:37pt;'>Cant</td>
                  <td class="xl104" style='width:70pt;'>Mater</td>
                  <td class="xl104" style='width:70pt;'>M.Obra</td>
                  <td class="xl104" style='width:70pt;'>Pintura</td>
                  <td class="xl104" style='width:70pt;'>Aislam</td>
                  <td class="xl104" style="width:10px">#</td>
                </tr> 
              </thead>
              <tbody id="reg_instuberia">

              </tbody>
          </table>
        </div>
      </div> 

      <div style="clear:both"></div>

      <div id="divSoporteriaTuberia" style="width:34.9%;"> <!-- div captura y presentación soporteria tuberia -->
      <table style='border-collapse:collapse;margin-left:10px;' id="idTablaSoporteria">   
            <thead>     
              <tr style='height:14pt;'>
                <td colspan="6"></td>
              </tr>
            <tr style='height:13.8pt;'>
                    <td colspan="3" class="xl246" style="width:212px;">SOPORTE</td>
                    <td colspan="3" class="xl247" style="width:300px;">COSTO</td>
                </tr>  

                <tr style='height:13.8pt;'>
                    <td class=xl246 style="width:88px;">Perfil</td>
                    <td class=xl246 style="width:62px;">Mat x Sop</td>
                    <td class=xl246 style="width:62px;">Cant Sop</td>
                    <td class=xl247 style="width:100px;">Material</td>
                    <td class=xl247 style="width:100px;">M.Obra</td>
                    <td class=xl247 style="width:100px;">Pintura</td>
                </tr>  
            </thead>
            <tbody id="cuerpoEntrada3">
                <tr>
                  <td> <?php echo $tgp_perfils->selecc('perfil_1','form-select form-select-sm','','','|',"width:99%"); ?> </td>
                  <td> <input type="text" name="matSop_1" id="matSop_1" style="width:95%" class="valor"> </td>
                  <td> <input type="text" name="canSop_1" id="canSop_1" style="width:95%" class="valor" onblur="calcPerfil(this);"> </td>
                  <td> 
                      <input type="text" name="cstMaterial_1" id="cstMaterial_1" style="width:95%" class="valor"><br>
                      <input type="hidden" id="vrMaterial_1" >
                  </td>
                  <td> <input type="text" name="cstMobra_1" id="cstMobra_1" style="width:95%" class="valor" readonly><br>
                       <input type="hidden" id="vrMobra_1"  > 
                  </td>
                  <td> <input type="text" name="cstPintura_1" id="cstPintura_1" style="width:95%" class="valor" readonly><br>
                       <input type="hidden"  id="vrPintura_1"  > 
                  </td>
                </tr>
            </tbody>         
        </table>
        
        <div style="width:100%"> <!-- capa de arreglo soporteria instal. tuberia -->
            <table style='border-collapse:collapse;margin-left:10px;border:0.01pt solid;' id="idTablaSoporteria" >  <!-- table-layout:fixed; --> 
              <thead> 
                <tr style='height:13.8pt;'>
                    <td class="xl246" style="width:88px;">Perfil</td>
                    <td class="xl246" style="width:62px;">Mat x Sop</td>
                    <td class="xl246" style="width:62px;">Cant Sop</td>
                    <td class="xl247" style="width:100px;">Material</td>
                    <td class="xl247" style="width:100px;">M.Obra</td>
                    <td class="xl247" style="width:100px;">Pintura</td>
                    <td class="xl247" style="width:5px;">#</td>
                </tr>                
              </thead>  
              <tbody id="divRegSoporteTuberia">

              </tbody>
            </table>
        </div>
      </div>

  </div>  <!-- fin captura y presentación instal tuberia y soporteria -->

</div>

<!-- COSTOS DE INSTALACION VALVULAS -->
<div class="container" id="costo_instal_valvula" style="display:none; margin-left:5pt">
  <input type="hidden" name="hay_valvulas" id="hay_valvulas" size="1" value="<?php echo $hay_valvulas ?>" readonly>
  <table style='border-collapse:collapse;background-color:lightgray;'>  <!-- table-layout:fixed; -->
    <tr>
      <td  style='height:14.4pt;width:8pt'>
        <!-- <a href="#" id="xcosto_instal_valvula"><span style='color:red'>X</span></a> -->
      </td>
      <td style='width:56pt'></td>
      <td style='width:65pt'></td>
      <td width=0></td>
      <td style='width:64pt'></td>
      <td style='width:150pt'></td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=5 class=xl235>RESUMEN INSTALACIÓN DE VÁLV Y ACC</td>
    </tr>
    <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=4 class=xl87>Mano de obra</td>
      <td class=xl109 >$
          <input type="text" id="totCstManValv" style="width:92%" class="valor" readonly>
          <input type="hidden" id="totCstManValv_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl87>Pintura</td>
      <td class=xl109 >$
          <input type="text" id="totCstPinValv" style="width:92%" class="valor" readonly>
          <input type="hidden" id="totCstPinValv_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl87>Aislamiento</td>
      <td class=xl109 >$
          <input type="text" id="totCstAisValv" style="width:92%" class="valor" readonly>
          <input type="hidden" id="totCstAisValv_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl158>TOTAL COSTO INSTALACIÓN VAL Y ACC</td>
      <td class=xl161 >$
          <input type="text" id="gtTotCstInstValv" style="width:92%" class="valor" readonly>
          <input type="hidden" id="gtTotCstInstValv_x" >
      </td>
    </tr>
  </table>
  <div style="display:flex;width:50%">
    <div  style="width:10%;text-align:left;margin:auto;margin-left:10pt;padding:5px;">
        <button type='button' class='btn btn-primary btn-sm' id="xcosto_instal_valvula">Regresar</button>
    </div>
  </div>
  <table>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt;width:8pt'></td>
      <td class=xl89 style='width:200pt'>&nbsp;</td>
      <td class=xl89 style='width:60pt'>&nbsp;</td>
      <td class=xl89 style='width:60pt'>&nbsp;</td>
      <td class=xl89 style='width:60pt'>&nbsp;</td>
      <td colspan=3 class=xl246 style='border-left:none;width:300pt'>Costo de instalación de tuberías</td>
    </tr>
    <tr>
      <td style='height:13.8pt'></td>
      <td class='xl89 centro' >Válvula</td>
      <td class='xl89 centro' >Diámetro</td>
      <td class='xl89 centro' >Cantidad</td>
      <td class='xl89 centro' >Esp Aislam</td>
      <td class='xl107 centro' style="width:100px">Mano de Obra</td>
      <td class='xl107 centro' style="width:100px">Pintura</td>
      <td class='xl107 centro' style="width:100px">Aislamiento</td>
    </tr>
    <tr>
      <td style='height:13.8pt'></td>
      <td ><input type='text' id='valvInsValv_0' style="width:99%"></td>
      <td >
          <?php echo $tgpdiametro->selecc("diamInsValv_0","form-select form-select-sm","","","|"); ?>
          <input type='hidden' id='vrManInsValv' >
          <input type='hidden' id='vrPinInsValv' >
      </td>
      <td ><input type='text' id='cantInsValv_0' style="width:90%" class="valor" onblur="canInsValv(this)"></td>
      <td >
          <?php echo $tgpaislamie->selecc("esAiInsValv_0", "form-select form-select-sm","","","|"); ?>
          <input type='hidden' id='vrAisTb' >
      </td>
      <td ><input type='text' id='vrManInsValv_0' style="width:99%" class="valor" readonly></td>
      <td ><input type='text' id='vrPinInsValv_0' style="width:99%" class="valor" readonly></td>
      <td ><input type='text' id='vrAisInsValv_0' style="width:99%" class="valor" readonly></td>
    </tr>
  </table>
  <div id="regInsValv" style="display:block">
    <table border=1 cellspacing=3 style='margin-left:10pt;border-collapse:collapse;'>  <!-- table-layout:fixed; -->
      <thead>
        <tr style='height:13.8pt'>
          <td class="xl89 centro" style='width:200pt'>Válvula</td>
          <td class="xl89 centro" style='width:60pt'>Diámetro</td>
          <td class="xl89 centro" style='width:60pt'>Cant</td>
          <td class="xl89 centro" style='width:60pt'>Aislam</td>
          <td class="xl107 centro" style='width:100pt'>Mano de Obra</td>
          <td class="xl107 centro" style='width:100pt'>Pintura</td>
          <td class="xl107 centro" style='width:100pt'>Aislamiento</td>
          <td class="xl104 centro" style="width:10px;"> # </td>
          </tr>        
      </thead>
      <tbody id="bodyInsValv">
      </tbody>
    </table>
  </div>
</div>

<!-- COSTOS DE INSTALACION ELECTRICA -->
<div class="container" id="costo_instal_electrica" style="display:none; margin-left:5pt">
  <input type="hidden" name="hay_eqelect" id="hay_eqelect" size="1" value="<?php echo $hay_eqel ?>" readonly>
  <input type="hidden" name="hay_tuelect" id="hay_tuelect" size="1" value="<?php echo $hay_tuel ?>" readonly>
  <input type="hidden" name="hay_sopElectri" id="hay_sopElectri" size="1" value="<?php echo $hay_sopElectri ?>" readonly>

  <div id="idresumen_electrica">
      <table style='border-collapse:collapse;background-color:lightgray;'>   <!-- table-layout:fixed;  -->
        <tr>
          <td style='height:14.4pt;width:8pt'>
            <!-- <a href="#" id="xcosto_instal_electrica"><span style='color:red'>X</span></a>  -->
          </td>
          <td style='width:99pt'>&nbsp;</td>
          <td style='width:125pt'>&nbsp;</td>
          <td style='width:127pt'>&nbsp;</td>
          <td style='width:91pt'>&nbsp;</td>
          <td style='width:97pt'>&nbsp;</td>
        </tr>
        <tr style='height:13.8pt'>
          <td style='height:13.8pt'></td>
          <td colspan=5 class='xl238' style='border-right:.5pt solid #203764'>RESUMEN INSTALACIÓN ELÉCTRICA</td>
        </tr>
        <tr style='height:13.8pt'>
          <td style='height:13.8pt'></td>
          <td colspan=4 class=xl245>DESCRIPCIÓN</td>
          <td class=xl89 style='border-top:none;border-left:none'>TOTAL COSTO</td>
        </tr>
        <tr style='height:13.95pt'>
          <td style='height:13.95pt'></td>
          <td colspan=4 class=xl85>COSTO MATERIAL CABLES (ALIMENTACIÓN + CONTROL)</td>
          <td class=xl109 style='border-top:none;border-left:none'>$
              <input type="text" name="totCstMtrCables" id="totCstMtrCables" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstMtrCables_x" id="totCstMtrCables_x" >
          </td>
        </tr>
        <tr style='height:13.95pt'>
          <td style='height:13.95pt'></td>
          <td colspan=4 class=xl85>COSTO MANO DE OBRA CABLES (ALIMENTACIÓN + CONTROL)</td>
          <td class=xl109 style='border-top:none;border-left:none'>$ 
              <input type="text" name="totCstMobCables" id="totCstMobCables" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstMobCables_x" id="totCstMobCables_x" >
          </td>
        </tr>
        <tr style='height:13.95pt'>
          <td style='height:13.95pt'></td>
          <td colspan=4 class=xl85>COSTO MATERIAL BANDEJAS/TUBO</td>
          <td class=xl109 style='border-top:none;border-left:none'>$
              <input type="text" name="totCstMtrBandej" id="totCstMtrBandej" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstMtrBandej_x" id="totCstMtrBandej_x" >
          </td>
        </tr>
        <tr style='height:13.95pt'>
          <td style='height:13.95pt'></td>
          <td colspan=4 class=xl85>COSTO MANO DE OBRA BANDEJAS/TUBOS</td>
          <td class=xl109 style='border-top:none;border-left:none'>$
              <input type="text" name="totCstMobBandej" id="totCstMobBandej" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstMobBandej_x" id="totCstMobBandej_x" >
          </td>
        </tr>
        <tr style='height:13.95pt'>
          <td style='height:13.95pt'></td>
          <td colspan=4 class=xl85>SOPORTERÍA PARA BANDEJAS/TUBOS (PERFIL MXM)</td>
          <td class=xl109 style='border-top:none;border-left:none'>$
              <input type="text" name="totCstSopBandej" id="totCstSopBandej" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstSopBandej_x" id="totCstSopBandej_x" >
          </td>
        </tr>
        <tr style='height:13.8pt'>
          <td style='height:13.8pt'></td>
          <td colspan=4 class=xl250>TOTAL COSTO POR INSTALACIÓN ELÉCTRICA</td>
          <td class=xl161 style='border-top:none;border-left:none'>$
              <input type="text" name="totCstInsElectr" id="totCstInsElectr" style="width:88%" class="valor" readonly>
              <input type="hidden" name="totCstInsElectr_x" id="totCstInsElectr_x" >
          </td>
        </tr>
      </table>
  </div>

  <div style="display:flex;width:50%">
    <div  style="width:10%;text-align:left;margin: 0.5pt 0.5pt 0 10pt;padding:5px">
        <button type='button' class='btn btn-primary btn-sm' id="xcosto_instal_electrica">Regresar</button>
    </div>
  </div>
  
  <div id="idcosto_electrico_padre" style="width:70%;"> <!-- overflow: auto; -->
      <div id="idcosto_electrico_equipos" style="width:100%;top:0px;left:0px;padding:0px;margin-bottom:10px;"> <!-- float:left; -->
        <table cellpadding=0 cellspacing=0 style='margin-left:0pt;border-collapse:collapse;'>  
          <tr style='height:13.8pt'>
            <td class=xl89 style="width:100px;">&nbsp;</td>
            <td colspan=2 class=xl246 style='border-left:none'>CALIBRE CABLES</td>
            <td colspan=2 class=xl251 style='border-right:.5pt solid #203764;border-left:none'>CNT MTR</td>
            <td class=xl70 colspan=2 style='border-left:none'>COSTO</td>
            <td  style='border-left:none;'>&nbsp;</td> 
            <td style="width:10px;"></td>
          </tr>
          <tr>
            <td class='xl89' >Equipo</td>
            <td class='xl107' style="width:132pt" >Potencia</td>
            <td class='xl107' style="width:132pt" >Control</td>
            <td class='xl120' style="width:30pt">Pot</td>
            <td class='xl120' style="width:30pt" >Cntr</td>
            <td class='xl89' style="width:77pt" >Material</td>
            <td class='xl89' style="width:80pt" >Mano De Obra</td>
            <td></td>
            </tr> 
          <tr>
            <td><input type="text" id="equi_electr_0" style="width:99%"></td>
            <td style="width:132pt">
                <?php echo selec_tabla($tgpcables," WHERE id_tipocable=1",'poteCalibr_0','descrip' ) ?>
            </td>
            <td style="width:132pt">
                <?php echo selec_tabla($tgpcables," WHERE id_tipocable=2",'contCalibr_0','descrip' ) ?>
            </td>
            <td><input type="text" id="poteMateri_0" class="valor" style="width:99%" onblur="cant_electr(this)"></td>
            <td><input type="text" id="contMateri_0" class="valor" style="width:99%" onblur="cant_datos(this)"></td>
            <td><input type="text" id="mateCstEle_0" class="valor" style="width:99%" readonly ></td>
            <td><input type="text" id="mobrCstEle_0" class="valor" style="width:99%" readonly ></td>
            <td> 
              <button title="Borrar" id="borra_eqElect">x</button><button title="Salvar Valores" id="salva_eqElect">s</button>
            </td>
          </tr>    
          <tr style="display:none">
            <td></td>
            <td>
                <input type="text" id="vrMatpoteMateri_0" readonly style="width:130pt"><br>
                <input type="text" id="vrMobpoteMateri_0" readonly style="width:130pt">
            </td>
            <td>
                <input type="text" id="vrMatcontMateri_0" readonly style="width:130pt"><br>
                <input type="text" id="vrMobcontMateri_0" readonly style="width:130pt">
            </td>
          </tr>
        </table>
        <div>
            <table style="margin-left:0pt;border:0.05pt solid;font-size:10px">
              <thead>
                <tr>
                  <td class='xl89'  style="width:100px" >Equipo</td>
                  <td class='xl107' style="width:132pt" >Potencia</td>
                  <td class='xl107' style="width:132pt" >Control</td>
                  <td class='xl120' style="width:30pt" >Pot</td>
                  <td class='xl120' style="width:30pt" >Cntr</td>
                  <td class='xl89'  style="width:77pt" >Material</td>
                  <td class='xl89'  style="width:80pt" >Mano de Obra</td>
                  <td class="xl104 centro" style="width:10px;">#</td>
                  </tr> 
              </thead>
              <tbody id="body_reg_equipos_eletricos">

              </tbody>
            </table>
        </div>
      </div>
      <div id="idcosto_electrico_bandejas" style="width:90%;padding-top:5px;"> <!-- float:left; -->

        <table cellpadding=0 cellspacing=0 style='margin-left:0pt;border-collapse:collapse;'> 
          <tr>
            <td style="width:80pt" class='xl89'>              </td>
            <td style="width:80pt" class='xl89'>              </td>
            <td colspan="4" class="xl246"> CANTIDAD MATERIAL  </td>
            <td colspan="2" class="xl70"> COSTO               </td>
            <td></td>
          </tr>
          <tr>
            <td class='xl89'>                     Tuberia/Bandj </td>
            <td class='xl89'>                     Dimension     </td>
            <td class="xl246" style="width:40pt"> Mtrs          </td>
            <td class="xl246" style="width:40pt"> Curvas        </td>
            <td class="xl246" style="width:40pt"> Tee           </td>
            <td class="xl246" style="width:40pt"> Uniones       </td>
            <td class="xl89" style="width:70pt"> Material      </td>
            <td class="xl89" style="width:70pt"> Mano de Obra  </td>
            <td></td>
          </tr>    
          <tr>
            <td>
              <?php echo $tgpconduleta->selecc("idtuberia_0","","","","|"); ?>
            </td>
            <td>
              <input type="hidden" name="opc_dimen" id="opc_dimen" value="tubería" style="width:40px">
              <?php echo $tgpdiametro->selecc("iddimension_0","",""," nom_diametro<=4","|"); ?>
            </td>
            <td><input type="text" name="canMtrTubos_0" id="canMtr_Tubos_0" style="width:99%" onblur="cambia_cantTb(this)" class="valor"></td>
            <td><input type="text" name="canCurTubos_0" id="canCur_Tubos_0" style="width:99%" onblur="cambia_cantTb(this)" class="valor"></td>
            <td><input type="text" name="canTeeTubos_0" id="canTee_Tubos_0" style="width:99%" onblur="cambia_cantTb(this)" class="valor"></td>
            <td><input type="text" name="canUniTubos_0" id="canUni_Tubos_0" style="width:99%" onblur="cambia_cantTb(this)" class="valor"></td>
            <td><input type="text" name="cstMtrTubos_0" id="cstMtrTubos_0" style="width:99%" class="valor" readonly></td>
            <td><input type="text" name="cstMobTubos_0" id="cstMobTubos_0" style="width:99%" class="valor" readonly></td>
            <td><button title="Borrar" id="borra_tbElect">x</button><button title="Salvar Valores" id="salva_tbElect">s</button></td>
          </tr>
          <tr style="display:block">
            <td><input type="hidden" name="tuboMtr" id="elem1_complem1" size="4"></td>
            <td><input type="hidden" name="tuboMob" id="elem1_complem2" size="4"></td>
            <td><input type="hidden" name="codoMtr" id="elem2_complem1" size="4"></td>
            <td><input type="hidden" name="codoMob" id="elem2_complem2" size="4"></td>
            <td><input type="hidden" name="tee_Mtr" id="elem3_complem1" size="4"></td>
            <td><input type="hidden" name="tee_Mob" id="elem3_complem2" size="4"></td>
            <td><input type="hidden" name="unioMtr" id="elem4_complem1" size="4"></td>
            <td><input type="hidden" name="unioMob" id="elem4_complem2" size="4"></td>
          </tr>  
        </table>  
        <table cellpadding='0' cellspacing='0' style='margin-left:0pt;border-collapse:collapse;border:0.05pt solid;'>  
          <thead>
          <tr>
            <td class='xl89' style="width:80pt">  Tuberia/Bandj </td>
            <td class='xl89' style="width:80pt">  Dimension     </td>
            <td class="xl246" style="width:40pt"> Mtrs          </td>
            <td class="xl246" style="width:40pt"> Curvas        </td>
            <td class="xl246" style="width:40pt"> Tee           </td>
            <td class="xl246" style="width:40pt"> Uniones       </td>
            <td class="xl89" style="width:70pt"> Material      </td>
            <td class="xl89" style="width:70pt"> Mano de Obra  </td>
            <td class="xl104 centro" style="width:10px;">#</td>
            </tr>    
          </thead>
          <tbody id="body_reg_tuberias">

          </tbody>
        </table>
      </div>

      <div id="idcosto_electrico_soporteria" style="width:90%;padding-top:10px;padding-bottom:10px;">
        <!-- INICIO div soporteria instal. electrica -->
        <table style='border-collapse:collapse;margin-top:10px;' id="idTablaSoporteriaElectrica" >  <!-- table-layout:fixed; -->
            <thead>     
            <tr style='height:13.8pt;'>
                    <td colspan="3" class="xl246" >SOPORTE</td>
                    <td colspan="3" class="xl247" style="width:240px;">COSTO</td>
                    <td styel="width:10px">&nbsp;</td>
                </tr>  

                <tr style='height:13.8pt;'>
                    <td class=xl246 style="width:150px;">Perfil</td>
                    <td class=xl246 style="width:62px;">Mat x Sop</td>
                    <td class=xl246 style="width:65px;">Cant Sop</td>
                    <td class=xl247 style="width:180px;">Material</td>
                    <td class=xl247 style="width:180px;">M.Obra</td>
                    <td class=xl247 style="width:180px;">Pintura</td>
                    <td></td>
                </tr>  
            </thead>
            <tbody id="cuerpoEntrada4">
                <tr>
                  <td> <?php echo $tgp_perfils->selecc('perfil_2','','','','|','width:95%'); ?> </td>
                  <td> <input type="text" name="matSop_2" id="matSop_2" style="width:60px" class="valor"> </td>
                  <td> <input type="text" name="canSop_2" id="canSop_2" style="width:60px" class="valor" onblur="calcPerfil(this);"> </td>
                  <td> 
                      <input type="text" name="cstMaterial_2" id="cstMaterial_2" style="width:97%" class="valor" readonly><br>
                      <input type="hidden" id="vrMaterial_2"  >
                  </td>
                  <td> <input type="text" name="cstMobra_2" id="cstMobra_2" style="width:97%" class="valor" readonly><br>
                       <input type="hidden" id="vrMobra_2" > 
                  </td>
                  <td> <input type="text" name="cstPintura_2" id="cstPintura_2" style="width:97%" class="valor" readonly><br>
                       <input type="hidden"  id="vrPintura_2"  > 
                  </td>
                </tr>
            </tbody>         
        </table>
        <!-- capa de arreglo soporteria instal. electrica -->
        <div style="width:100%;border:.5pt solid;">
            <table style='border-collapse:collapse;margin-left:1px;border:0.01pt solid;' id="idTablaSoporteriaElectr" >   
              <thead> 
                <tr style='height:13.8pt;'>
                    <td class=xl246 style="width:180px;">Perfil</td>
                    <td class=xl246 style="width:62px;">Mat x Sop</td>
                    <td class=xl246 style="width:65px;">Cant Sop</td>
                    <td class=xl247 style="width:180px;">Material</td>
                    <td class=xl247 style="width:180px;">M.Obra</td>
                    <td class=xl247 style="width:180px;">Pintura</td>
                    <td class="xl247" style="width:10px;">#</td>
                </tr>                
              </thead>  
              <tbody id="divRegSoporteElectrico">

              </tbody>
            </table>
        </div>

        <!-- FIN div soporteria instal. electrica -->
      </div>
  </div>
</div>

<!-- COSTO PRUEBAS -->
<div class="container" id="costo_pruebas" style="display:none; margin-left:5pt">
  <input type="hidden" name="hay_pruebas" id="hay_pruebas" size="1" value="<?php echo $hay_pruebas ?>" readonly>
   
  <table cellpadding="0" cellspacing="0" style='border-collapse:collapse;width:351pt;background-color:lightgray;'>  <!-- table-layout:fixed;  -->
    <tr height=19 style='height:14.4pt'>
      <td style='height:14.4pt;width:13pt'>
      </td>
      <td style='width:67pt'></td>
      <td style='width:67pt'></td>
      <td style='width:67pt'></td>
      <td style='width:85pt'></td>
      <td style='width:52pt'></td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=5 class=xl253>RESUMEN COSTO DE PRUEBAS</td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl253>DESCRIPCIÓN</td>
      <td colspan=2 class=xl253>COSTO</td>
      </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl85>Mano de obra para pruebas</td>
      <td colspan=2 class=xl147 >$
          <input type="text" id="totMobPruebas" style="width:90%" class="valor" readonly> 
          <input type="hidden" id="totMobPruebas_x" > 
      </td>
      </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl85>Insumos para prueba de presión</td>
      <td colspan=2 class=xl147 >$
        <input type="text" id="totIsmPruebas" style="width:90%" class="valor" readonly >
        <input type="hidden" id="totIsmPruebas_x" >
      </td>
      </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl85>Insumos para pruebas eléctricas</td>
      <td colspan=2 class=xl147 >$
        <input type="text" id="totElcPruebas" style="width:90%" class="valor" readonly >
        <input type="hidden" id="totElcPruebas_x" >
      </td>
      </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl250>TOTAL COSTO PRUEBAS</td>
      <td colspan=2 class=xl162 >$
        <input type="text" id="GtPruebas" style="width:90%" class="valor" readonly >
        <input type="hidden" id="GtPruebas_x" >
      </td>
    </tr>
    <tr>
      <td colspan="6">&nbsp;</td>
    </tr>
</table>
<table style='border-collapse:collapse;width:606pt;padding:0'>
    <tr style='height:13.8pt'>
      <td colspan=8 >
          <div style="display:flex;width:50%">
            <div  style="width:10%;text-align:left;margin: auto;margin-left:14pt;padding:5px">
                <button type='button' class='btn btn-primary btn-sm' id="xcosto_pruebas">Regresar</button>
            </div>
          </div>
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl254>Mano de obra para pruebas</td>
      <td class=xl86>Personal</td>
      <td class=xl86>Días</td>
      <td class=xl86>Costo día</td>
      <td  class=xl86>Total</td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=3 class=xl243>Prueba de presión con N<font class="font24"><sub>2</sub></font><font
      class="font9"> + limp de válv</font></td>
      <td class=xl87><input type="text" style="width:90%" id="canPers_pre" class="valor"></td>
      <td class=xl87><input type="text" style="width:90%" id="canDias_pre" class="valor" onblur="leeCantPrb(this,'id_070101','tot_Presion','canPers_pre')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070101" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Presion" class="valor" readonly>
          <input type="hidden" id="tot_Presion_x" >
      </td>
    </tr>
    <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=3 class=xl243>Prueba de RX</td>
      <td class=xl87 ><input type="text" style="width:90%" id="canPers_RX" class="valor"></td>
      <td class=xl87 ><input type="text" style="width:90%" id="canDias_RX" class="valor" onblur="leeCantPrb(this,'id_070102','tot_PruebaRX','canPers_RX')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070102" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_PruebaRX" class="valor" readonly >
          <input type="hidden" id="tot_PruebaRX_x" >
      </td>
    </tr>
    <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=3 class=xl243>Prueba de triple vacío</td>
      <td class=xl87><input type="text" style="width:90%" id="canPers_Triple" class="valor"></td>
      <td class=xl87><input type="text" style="width:90%" id="canDias_Triple" class="valor" onblur="leeCantPrb(this,'id_070103','tot_Triple','canPers_Triple')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070103" class="valor"  readonly> </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Triple" class="valor" readonly>
          <input type="hidden" id="tot_Triple_x" >
      </td>
    </tr>
    <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=3 class=xl243>Pruebas eléctricas</td>
      <td class=xl87><input type="text" style="width:90%" id="canPers_PrueElec" class="valor"></td>
      <td class=xl87><input type="text" style="width:90%" id="canDias_PrueElec" class="valor" onblur="leeCantPrb(this,'id_070104','tot_PrueElec','canPers_PrueElec')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070104" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_PrueElec" class="valor" readonly>
          <input type="hidden" id="tot_PrueElec_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td colspan=9 style='height:13.8pt;'></td>
    </tr>
    <tr style='height:13.95pt'>
      <td style='height:13.95pt'></td>
      <td colspan=4 class=xl70>Insumos para prueba de presión</td>
      <td class=xl89 style='border-left:none'>Cantidad</td>
      <td class=xl89 style='border-left:none'>Costo</td>
      <td  class=xl89 style='border-left:none'>Total</td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl85>Cilindros de NITRÓGENO 6m<font class="font21"><sup>3</sup></font></td>
      <td class=xl87><input type="text" style="width:90%" id="cant_Nitrogeno" class="valor" onblur="leeCantPrb(this,'id_070201','tot_Nitrogeno','')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070201" class="valor" readonly> </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Nitrogeno" class="valor" readonly>
          <input type="hidden" id="tot_Nitrogeno_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl85>Soldadura de plata, libra</td>
      <td class=xl87><input type="text" style="width:90%" id="cant_Soldadura" class="valor" onblur="leeCantPrb(this,'id_070202','tot_Soldadura','')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070202" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Soldadura" class="valor" readonly> 
          <input type="hidden" id="tot_Soldadura_x" > 
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl85>Alquiler de equipo de acetileno</td>
      <td class=xl87><input type="text" style="width:90%" id="cant_Alquiler" class="valor" onblur="leeCantPrb(this,'id_070203','tot_Alquiler','')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070203" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Alquiler" class="valor" readonly >
          <input type="hidden" id="tot_Alquiler_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl85>Transporte de materiales</td>
      <td class=xl87><input type="text" style="width:90%" id="cant_TranspMtr" class="valor" onblur="leeCantPrb(this,'id_070204','tot_TranspMtr','')"></td>
      <td class=xl109>$<input type="text" style="width:90%" id="id_070204" class="valor" readonly > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_TranspMtr" class="valor" readonly >
          <input type="hidden" id="tot_TranspMtr_x" >
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td colspan=8 style='height:13.8pt;'></td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl70>Insumos para pruebas eléctricas</td>
      <td class=xl89>Cantidad</td>
      <td class=xl89>Costo</td>
      <td  class=xl89>Total</td>
    </tr>
    <tr style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td colspan=4 class=xl85>Consumibles</td>
      <td class=xl87><input type="text" style="width:90%" id="cant_Consumib" class="valor" ></td> <!-- onblur="leeCantPrb(this,'id_070301','tot_Consumib','')" -->
      <td class=xl109>$<input type="text" style="width:90%" id="id_070301" class="valor" onblur="leeCantPrb('cant_Consumib','id_070301','tot_Consumib','')" > </td>
      <td  class="xl109 valor">$
          <input type="text" style="width:83%" id="tot_Consumib" class="valor" readonly >
          <input type="hidden" id="tot_Consumib_x"  >
      </td>
    </tr>
  </table>
</div>

<!-- COSTOS VARIOS -->
<div class="container" id="costo_varios" style="display:none; margin-left:5pt">
<input type="hidden" name="hay_varios" id="hay_varios" size="1" value="<?php echo $hay_varios ?>" readonly>
  <table cellpadding=0 cellspacing=0 width=655 style='border-collapse:collapse;width:491pt;background-color:lightgray;'>  
    <tr height=19 style='height:14.4pt'>
      <td height=19 style='height:14.4pt;width:13pt'>
          <!-- <a href="#" id="xcosto_varios"><span style='color:red'>X</span></a> -->
      </td>
      <td style='width:149pt'></td>
      <td style='width:72pt'></td>
      <td style='width:64pt'></td>
      <td style='width:76pt'></td>
      <td style='width:117pt'></td>
    </tr>
    <tr height=18 style='height:13.8pt'>
      <td height=18 class=xl181 style='height:13.8pt'></td>
      <td colspan=5 class=xl70>TOTAL COSTO POR ÍTEMS VARIOS</td>
    </tr>
    <tr style='height:13.8pt'>
      <td class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl70>DESCRIPCIÓN</td>
      <td class=xl70 >COSTO</td>
    </tr>
    <tr style='height:13.8pt'>
      <td class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl255>Total costos por transporte</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totTransVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totTransVrs_x" class="totVrs"> 
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl255>Total costos por gruas</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totGruasVrs" style="width:85%" class="valor" readonly>
        <input type="hidden" id="totGruasVrs_x" class="totVrs">
      </td>
    </tr>
    <tr style='height:13.8pt'>
      <td class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl255>Total costos por montacargas</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totMontaVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totMontaVrs_x" class="totVrs" > 
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costo por renta de andamios</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totAndamVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totAndamVrs_x" class="totVrs" > 
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costo por contenedores portátiles</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totContVrs" style="width:85%" class="valor" readonly>
        <input type="hidden" id="totContVrs_x" class="totVrs" >
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costos por personal</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totViatVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totViatVrs_x" class="totVrs" > 
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costos por personal SISO</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totPersiVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totPersiVrs_x" class="totVrs" > 
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costos por disposición de residuos</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totResidVrs" style="width:85%" class="valor" readonly>
        <input type="hidden" id="totResidVrs_x" class="totVrs" >
      </td>
    </tr>
    <tr  style='height:13.95pt'>
      <td  class=xl181 style='height:13.95pt'></td>
      <td colspan=4 class=xl255>Total costo por baños potátiles</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totBanosVrs" style="width:85%" class="valor" readonly>
        <input type="hidden" id="totBanosVrs_x" class="totVrs" >
      </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl255>Imprevistos</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totImpreVrs" style="width:85%" class="valor" onblur="cstImpre(this);"> 
        <input type="hidden" id="totImpreVrs_x" class="totVrs" > 
      </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  class=xl181 style='height:13.8pt'></td>
      <td colspan=4 class=xl241 >TOTAL COSTOS VARIOS</td>
      <td class="xl112 valor" >$ 
        <input type="text" id="totCostoVrs" style="width:85%" class="valor" readonly> 
        <input type="hidden" id="totCostoVrs_x" > 
      </td>
    </tr>    
  </table>
  <table  cellpadding=0 cellspacing=0 width=655 style='border-collapse:collapse;width:491pt;'>
    <tr  style='height:13.8pt'>
      <td  colspan=6 >
          <div style="display:flex;width:50%">
            <div  style="width:10%;text-align:left;margin: 0.5pt 0.5pt 0 10pt;padding:5px">
                <button type='button' class='btn btn-primary btn-sm' id="xcosto_varios">Regresar</button>
            </div>
          </div>
      </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl89>Costos por transporte</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Origen</td>
      <td class=xl70 >Destino</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69 >Transporte de montacargas</td>
      <td class="xl69 valor" ><input type="text" id="campo1_Trans_Mont" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="campo2_Trans_Mont" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_Trans_Mont" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_Trans_Mont" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69  >Transporte de grúas</td>
      <td class="xl69 valor" ><input type="text" id="campo1_Trans_Grua" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="campo2_Trans_Grua" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_Trans_Grua" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_Trans_Grua" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69  >Transporte de materiales</td>
      <td class="xl69 valor" ><input type="text" id="campo1_Trans_Mate" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="campo2_Trans_Mate" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_Trans_Mate" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_Trans_Mate" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69  >Transporte de rack de tubería</td>
      <td class="xl69 valor" ><input type="text" id="campo1_Trans_Rack" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="campo2_Trans_Rack" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_Trans_Rack" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_Trans_Rack" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69  >Transporte de contenedores</td>
      <td class="xl69 valor" ><input type="text" id="campo1_trans_Cont" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="campo2_trans_Cont" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_trans_Cont" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_trans_Cont" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69  >Transporte de baños</td>
      <td class="xl69 valor" ><input type="text" id="campo1_trans_Bano" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="campo2_trans_Bano" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="campo3_trans_Bano" style="width:85%" ></td>
      <td class="xl112 valor">
          $ <input type="text" id="id_trans_Bano" style="width:85%" class="valor transp" onblur="cstTranspVrs(this);"> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  colspan=6 style='height:13.8pt;'></td>
    </tr>
    <!-- INICIO registro VARIOS Gruas -->
    <tr  style='height:13.8pt'>
      <td style='height:13.8pt'></td>
      <td class=xl89 >Costos por gruas</td>
      <td class=xl70 >Capacidad</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Vr.Día</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style="height:13.8pt;display:table-row;" id="trGruas_0">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_0" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_0" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_0" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_0" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_0" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_1">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_1" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_1" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_1" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_1" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_1" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_2">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_2" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_2" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_2" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_2" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_2" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_3">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_3" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_3" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_3" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_3" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_3" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_4">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_4" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_4" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_4" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_4" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_4" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_5">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_5" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_5" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_5" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_5" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_5" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_6">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_6" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_6" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_6" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_6" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_6" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_7">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_7" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_7" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_7" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_7" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_7" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_8">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_8" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_8" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_8" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_8" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_8" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trGruas_9">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="idgrua_9" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapac_9" style="width:85%"></td>
      <td class=xl69 ><input type="text" id="idcant_9" style="width:85%" class="valor"></td>
      <td class=xl69 ><input type="text" id="idvrdia_9" style="width:85%" class="valor" onblur="cstGruasVrs(this)"></td>
      <td class="xl112 valor">$ <input type="text" id="idtotgrua_9" style="width:85%" class="valor gruas" readonly> </td>
    </tr>
<!--  FIN registro VARIOS Gruas -->

<!-- inicio registro VARIOS Montacargas -->
    <tr  style='height:13.8pt'>
      <td  colspan=6 style='height:13.8pt;'></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl89 >Costos por montacargas</td>
      <td class=xl70 >Capacidad</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Día</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt;display:table-row' id="trMonta_0">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_0" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_0" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_0" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_0" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_0" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_1">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_1" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_1" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_1" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_1" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_1" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_2">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_2" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_2" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_2" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_2" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_2" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_3">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_3" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_3" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_3" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_3" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_3" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_4">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_4" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_4" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_4" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_4" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_4" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_5">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_5" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_5" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_5" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_5" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_5" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_6">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_6" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_6" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_6" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_6" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_6" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_7">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_7" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_7" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_7" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_7" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_7" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_8">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_8" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_8" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_8" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_8" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_8" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>
    <tr  style='height:13.8pt;display:none' id="trMonta_9">
      <td  style='height:13.8pt'></td>
      <td class=xl69  ><input type="text" id="iddesMonta_9" style="width:95%" ></td>
      <td class="xl69 valor" ><input type="text" id="idcapMonta_9" style="width:85%" ></td>
      <td class=xl69 ><input type="text" id="idcanMonta_9" style="width:85%" class="valor" ></td>
      <td class=xl69 ><input type="text" id="idvrMonta_9" style="width:85%" class="valor" onblur="cstMontaVrs(this);" ></td>
      <td class="xl112 valor">$ <input type="text" id="idcstMonta_9" style="width:85%" class="valor Montacargas" readonly> </td>
    </tr>

<!-- FIN registro VARIOS Montacargas -->

<tr  style='height:13.8pt'>
      <td  colspan=6 style='height:13.8pt;'></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl89>Costo por andamios</td>
      <td class=xl70 >Días</td>
      <td class=xl70 >Secciones</td>
      <td class=xl70 >Costo día</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69 ><input type="text" id="idescAndam_1" style="width:95%" value="Para soldadores" readonly></td>
      <td class="xl69 valor" ><input type="text" id="iddiasAndam_1" style="width:85%" class="valor" ></td>
      <td class="xl69 valor">
          <input type="text" id="idseccAndam_1" style="width:85%" class="valor" onblur="cstAndamios(this,'iddiasAndam_1','id_080401','idcostAndam_1');"></td>
      <td class="xl69 valor"><input type="text" id="id_080401" style="width:85%" class="valor" readonly></td>
      <td class="xl112 valor">$ <input type="text" id="idcostAndam_1" style="width:85%" class="valor" readonly > </td>

    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td class=xl69 ><input type="text" id="iddescAndam_2" style="width:95%" value="Para eléctricos" readonly></td>
      <td class="xl69 valor" > <input type="text" id="iddiasAndam_2" style="width:85%" class="valor"></td>
      <td class="xl69 valor" > 
          <input type="text" id="idseccAndam_2" style="width:85%" class="valor" onblur="cstAndamios(this,'iddiasAndam_2','id_080402','idcostAndam_2');"></td>
      <td class="xl112 valor"> <input type="text" id="id_080402" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="idcostAndam_2" style="width:85%" class="valor" readonly> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  colspan=6 style='height:13.8pt;'></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl258 >Costos por contenedores</td>
      <td class=xl70 >Días</td>
      <td class=xl70 >Costo día</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl256 ><input type="text" id="txt_Cont_1" style="width:97%" value="Contenedor para personal alfrio" readonly></td>
      <td class=xl69 ><input type="text" id="can_Cont_1" style="width:85%" class="valor" onblur="cst1(this,'id_08050','idCst');" ></td>
      <td class=xl112 >$ <input type="text" id="id_080501" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Cont_1" style="width:85%" class="valor Cont" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl256 ><input type="text" id="txt_Cont_2" style="width:97%" value="Contenedor para soldadores" readonly></td>
      <td class=xl69 ><input type="text" id="can_Cont_2" style="width:85%" class="valor" onblur="cst1(this,'id_08050','idCst');" ></td>
      <td class=xl112 >$ <input type="text" id="id_080502" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Cont_2" style="width:85%" class="valor Cont" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl256 ><input type="text" id="txt_Cont_3" style="width:97%" value="Contenedor para eléctricos" readonly></td>
      <td class=xl69 ><input type="text" id="can_Cont_3" style="width:85%" class="valor" onblur="cst1(this,'id_08050','idCst');" ></td>
      <td class=xl112 >$ <input type="text" id="id_080503" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Cont_3" style="width:85%" class="valor Cont" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  colspan=6 style='height:13.8pt;'></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl142>Viaticos y desplazamientos personal general</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Unitario</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl260><input type="text" id="tit_Viat_1" style="width:97%" value="Tiquetes (Ida y Regreso) x persona" readonly></td>
      <td class=xl183 ><input type="text" id="can_Viat_1" style="width:85%" class="valor" onblur="cst1(this,'id_08060');" ></td>
      <td class=xl184 >$ <input type="text" id="id_080601" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Viat_1" style="width:85%" class="valor Viat" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl260><input type="text" id="tit_Viat_2" style="width:97%" value="Hospedaje x noche x persona" readonly></td>
      <td class=xl183 ><input type="text" id="can_Viat_2" style="width:85%" class="valor" onblur="cst1(this,'id_08060');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080602" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Viat_2" style="width:85%" class="valor Viat" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl260><input type="text" id="tit_Viat_3" style="width:97%" value="Alimentación x día x persona" readonly></td>
      <td class=xl183 ><input type="text" id="can_Viat_3" style="width:85%" class="valor" onblur="cst1(this,'id_08060');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080603" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Viat_3" style="width:85%" class="valor Viat" readonly> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl260><input type="text" id="tit_Viat_4" style="width:97%" value="Transporte x día x persona" readonly></td>
      <td class=xl183 ><input type="text" id="can_Viat_4" style="width:85%" class="valor" onblur="cst1(this,'id_08060');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080604" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Viat_4" style="width:85%" class="valor Viat" readonly> </td>
    </tr>
    <tr style='height:13.8pt'>
      <td colspan="6"></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td></td>
      <td colspan=2 class=xl142>Costos personal SISO</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Unitario</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td> 
      <td colspan=2 class=xl260><input type="text" id="txt_Persi_1" style="width:97%" value="Personal SISO" readonly></td>
      <td class=xl183 ><input type="text" id="cant_Persi_1" style="width:85%" class="valor" onblur="cst1(this,'id_08070');" ></td>
      <td class=xl184 >$ <input type="text" id="id_080701" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Persi_1" style="width:85%" class="valor Persi" readonly> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Persi_2" style="width:97%" value="Tiquetes (Ida y Regreso) x persona" readonly></td>
      <td class=xl183 ><input type="text" id="cant_Persi_2" style="width:85%" class="valor" onblur="cst1(this,'id_08070');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080702" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Persi_2" style="width:85%" class="valor Persi" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Persi_3" style="width:97%" value="Hospedaje x noche x persona" readonly></td>
      <td class=xl183 ><input type="text" id="cant_Persi_3" style="width:85%" class="valor" onblur="cst1(this,'id_08070');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080703" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Persi_3" style="width:85%" class="valor Persi" readonly></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  style='height:13.8pt'></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Persi_4" style="width:97%" value="Alimentación x día x persona" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Persi_4" style="width:85%" class="valor" onblur="cst1(this,'id_08070');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080704" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Persi_4" style="width:85%" class="valor Persi" readonly> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Persi_5" style="width:97%" value="Transporte x día x persona" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Persi_5" style="width:85%" class="valor" onblur="cst1(this,'id_08070');"  ></td>
      <td class=xl184 >$ <input type="text" id="id_080705" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Persi_5" style="width:85%" class="valor Persi" readonly> </td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  colspan=6 ></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl142>Costos disposición de residuos</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Unitario</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Resid_1" style="width:97%" value="Reciclables" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Resid_1" style="width:85%" class="valor" onblur="cst1(this,'id_08080');" ></td>
      <td class=xl184 >$ <input type="text" id="id_080801" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Resid_1" style="width:85%" class="valor Resid" readonly ></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Resid_2" style="width:97%" value="Reutilizables" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Resid_2" style="width:85%" class="valor" onblur="cst1(this,'id_08080');" ></td>
      <td class=xl184 >$ <input type="text" id="id_080802" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Resid_2" style="width:85%" class="valor Resid" readonly ></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Resid_3" style="width:97%" value="NO reutilizables" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Resid_3" style="width:85%" class="valor" onblur="cst1(this,'id_08080');" ></td>
      <td class=xl184 >$ <input type="text" id="id_080803" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor">$ <input type="text" id="cst_Resid_3" style="width:85%" class="valor Resid" readonly ></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td  colspan=6 ></td>
    </tr>
    <tr  style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl142>Costos renta de baños portátiles</td>
      <td class=xl70 >Cantidad</td>
      <td class=xl70 >Unitario</td>
      <td class=xl70 >Costo</td>
    </tr>
    <tr style='height:13.8pt'>
      <td ></td>
      <td colspan=2 class=xl260><input type="text" id="txt_Banos_1" style="width:97%" value="Baño portátil para uso de personal" readonly></td>
      <td class=xl183 > <input type="text" id="cant_Banos_1" style="width:85%" class="valor" onblur="cst1(this,'id_08090');"></td>
      <td class=xl184 >$ <input type="text" id="id_080901" style="width:85%" class="valor" readonly> </td>
      <td class="xl112 valor" >$ <input type="text" id="cst_Banos_1" style="width:85%" class="valor Banos" readonly ></td>
    </tr>
  </table>
  <br>
  <br>

</div>
<script src='../js/bootstrap.bundle.min.js'></script>
<script src="../js/jquery_dvlp_3_7_1.js?v=3.7.2"></script>
<script src="../js/vistas/resumen_pry.js??ramdom=<?= time() ?>"></script>
<script src="../js/ajax.js"></script>
</body>
</html>
<?php
}
?>