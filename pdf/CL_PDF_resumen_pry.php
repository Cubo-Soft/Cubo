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
include(C."/cls/clsParam.php");
include(C."/tcpdf/tcpdf.php");
if($motor=="my"){
      include(C."/cls/clsBdmy.php");
}

date_default_timezone_set("America/Bogota");
$odb     = new Bd($h,$pto,$u,$p,$d);
$tpry    = new Tabla($odb,"gr_prycosto"); 
$tparam  = new clsParam($odb);
$templeados = new Tabla($odb,"nm_empleados");
$tpersonas= new Tabla($odb,"nm_personas");
$tciudades= new Tabla($odb,"np_ciudades");
$tpryadm  = new Tabla($odb,"gr_pry_adm");
$tprypers = new Tabla($odb,"gr_pry_pers");
$tpryequi = new Tabla($odb,"gr_pry_equi");
$tprytube = new Tabla($odb,"gr_pry_tuberia");
$tpryvalv = new Tabla($odb,"gr_pry_valv");
$tprycabelec = new Tabla($odb,"gr_pry_cabelect");
$tprytubelec = new Tabla($odb,"gr_pry_tubelect");
$tpryperfiles= new Tabla($odb,"gr_pry_perfiles");
$tprypruebas = new Tabla($odb,"gr_pry_pruebas");
$tpryvarios  = new Tabla($odb,"gr_pry_varios");
$tpryvarmq   = new Tabla($odb,"gr_pry_varmq");

class CL_PDF_resumen_pry extends TCPDF{

  private $ruta_imagen = null, $html = null, $ap_param = array(), $cabecera = array(), $formatterES, $posicionY = 0;
  public $retorno = array();

  public function datosGenerales($datos){
    $this->ap_param = $datos[0];
    $this->cabecera = $datos[1];
  }

  //    //Page header
  /*
  public function Header(){

    unset($this->html);
    $hoy = date('Y-m-d');
    $partesFecha = explode(" ", $this->cabecera["pry"][0]["fechora"]);
    $partesFecha = explode("-", $partesFecha[0]);
    $anio = $partesFecha[0];
    $mes = $partesFecha[1];
    $dia = $partesFecha[2];
    $letra_nombre = substr($this->cabecera["nm_empleados"][0]["nombres"], 0, 1);
    $letra_apellido = substr($this->cabecera["nm_empleados"][0]["apellidos"], 0, 1);

    $this->html = '<table width="100%" style="margin:0px; padding-button:0px;">
      <tr><td colspan="11"></td></tr>
      <tr>
        <td colspan="3" rowspan="4" align="left" valign="top">
          <br><img src="../imagenes/app/logo_cotizaciones.png" width="130" height="50">
        </td>
        <td colspan="6" style="font-size: 7px; text-align: left; padding:0px; margin:0px" >
          <b>' . $this->ap_param['nomempre'] . '</b><br>
          <b>NIT: ' . $this->ap_param["nitempre"] . '</b><br>
          Dirección: ' . $this->ap_param["dirempre"] . ' / Telefono: ' . $this->ap_param["telempre"] . ' 
        </td>
        <td colspan="2" rowspan="3" style="padding:0px; margin:0px" >
            <table style="font-size:7px;">
              <tr>
                <td colspan="3"></td>
              </tr>
              <tr style="background-color: #003F80; color: #FFFFFF; text-align: center;">
                <td colspan="3">
                  <b>PROYECTO - ' . $letra_apellido . $letra_nombre . '</b>
                </td>
              </tr>
              <tr>
                <td colspan="3" style="text-align:center">
                  Nro.' . $this->cabecera["pry"][0]["ctro_costo"] . '
                </td>
              </tr>
              <tr style="background-color: #003F80; color: #FFFFFF; text-align: center;">
                <td colspan="3">
                  <b>FECHA DE EMISIÓN</b>
                </td>
              </tr>
              <tr>
                <td style="text-align:center"> DD </td>
                <td style="text-align:center"> MM </td>
                <td style="text-align:center">AAAA</td>
              </tr>
              <tr>
                <td style="text-align:center">
                  ' . $dia . '
                </td>
                <td style="text-align:center">
                  ' . $mes . '
                </td>
                  <td style="text-align:center">
                    ' . $anio . '
                  </td>
                </tr>
            </table>
        </td>		
      </tr>
    </table>
    <div style="width: 500px; height: 10px; background-color: #003F80; padding: 0; margin: 10px;"></div>';
    $this->writeHTML($this->html);
    $this->posicionY = $this->getY();
  } */

  // Page footer
  
  public function Footer(){

    $this->SetFont('helvetica', 'B', 8);

    // Establecer el contenido del pie de página
    $texto = $this->ap_param["nomempre"] . " - NIT " . $this->ap_param["nitempre"] . " - Teléfono: " . $this->ap_param["telempre"] . " - Página: " . $this->getAliasNumPage() . " -";
    $this->SetY(-15);
    $this->Cell(0, 10, $texto, 0, false, 'C', 0, '', 0, false, 'T', 'M');
  } 

  function mostrarTablaEncabezado($datos, $opcion){
    $this->posicionY += 1;
    $this->setY($this->posicionY);
    $anchoPagina = $this->getPageWidth();
    $this->SetFont('helvetica', '', 9);
    $this->html = '<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./CL_PDF_resumen_pry.css">
    </head>
    <body>
      <br><br><br>
      <table style="width:540pt;">
        <tr style="border:0.5px solid">
          <td style="width:137pt" class="xl227" >&nbsp;CIUDAD</td>
          <td class="xl137" Style="width:234pt">' . $this->cabecera['pry'][0]['nomciu_ori'] . '</td>
          <td class="xl227" style="width:87pt">&nbsp;FECHA</td>
          <td class="xl137" style="width:82pt;text-align:right;">' . substr($this->cabecera['pry'][0]['fechora'],0,10) .'</td>
        </tr>
        <tr style="height:13.95pt">
          <td colspan="4"></td>
        </tr>
        <tr height=18 style="height:13.95pt">
          <td class="xl227" >&nbsp;PROYECTO</td>
          <td colspan="3" class="xl85" >' . $this->cabecera['pry'][0]['descrip_proy'] .'</td>
        </tr>
        <tr height=18 style="height:13.95pt">
          <td class="xl227" >&nbsp;CLIENTE</td>
          <td colspan="3" class="xl85" >' . $this->cabecera['pry'][0]['nom_cliente'] . '</td>
        </tr>
        <tr height=18 style="height:13.95pt">
          <td class="xl227" >&nbsp;CIUDAD PROYECTO</td>
          <td colspan="3" class="xl85" >' . $this->cabecera['pry'][0]['nomciu_proy'] .'</td>
        </tr>
        <tr style="height:13.95pt">
          <td class="xl227" >&nbsp;CENTRO DE COSTO</td>
          <td colspan="3" class="xl85" >' . $this->cabecera['pry'][0]['ctro_costo'] .'</td>
        </tr>
        <tr style="height:13.95pt">
          <td class="xl227" >&nbsp;PROFIT %</td>
          <td colspan="3" class="xl227" style="padding:0;">
            <table style="width:100%;background-color:white;margin-left:0;">
              <tr>
                  <td class="xl85" style="width:20%;padding-left:0"> ' . $this->cabecera['pry'][0]['profit_proy'] .'</td>
                  <td style="width:20%" class="xl227">IVA %&nbsp; </td>
                  <td style="width:20%" class="xl85"> ' . $this->cabecera['pry'][0]['iva_proy'] .'</td>
                  <td style="width:20%" class="xl227">TRM&nbsp; </td>
                  <td style="width:20%" class="xl85"> ' . fpesos($this->cabecera['pry'][0]['trm_proy']) . ' </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>';
      $this->writeHTML($this->html);
      $this->posicionY = $this->getY();
  }
  
  function mostrarTablaCuerpoG($datos){ // cuerpo version General
    $this->posicionY += 1;
    $this->setY($this->posicionY);
    $anchoPagina = $this->getPageWidth();
    $this->SetFont('helvetica', '', 10);

    $this->html = '<html>
    <head>
        <link rel="stylesheet" type="text/css" href="./CL_PDF_resumen_pry.css">
    </head>
    <body>
      <table style="width:540pt;">
        <tr style="height:13.8pt">
          <td class="xl227" style="width:33pt;">ÍTEM</td>
          <td class="xl227" style="width:221pt">DESCRIPCIÓN</td>
          <td class="xl227" style="width:117pt">COSTO COP</td>
          <td class="xl227" style="width:87pt">COSTO USD</td>
          <td class="xl227" style="width:82pt">PORCENTAJE</td>
        </tr>
        <tr >
          <td class="valor" > 1 &nbsp;</td>
          <td >
              <u>ADMINISTRATIVOS</u><br>
              &nbsp;Incluye:<br>
              ° Pólizas<br>
              ° Personal COMPRAS + CONTABILIDAD
          </td>
          <td class=xl110 style="text-align:right">
                $ ' . fpesos($datos['secciones']['totadm']) . '
          </td>
          <td class=xl148 style="text-align:right">
                USD ' . fpesos($datos['secciones']['ustotadm']) . '
          </td>
          <td class="xl140 valor" style="border-left:none;">
                ' . fpesos($datos['secciones']['portotadm']) . ' %</td>
        </tr>
        <tr style="height:13.8pt">
          <td class="valor"> 2&nbsp;</td>
          <td class="xl232" >
            <u>PERSONAL ALFRIO</u><br>
              &nbsp;Incluye<br>
              ° Ingeniero ALFRIO<br>
              ° Técnico ALFRIO<br>
              ° Viáticos<br>
              ° Servicio Telefónico
          </td>
          <td class="valor" >$ ' . fpesos($datos['secciones']['totpersalfrio']) . ' </td>
          <td class="valor" >USD ' . fpesos($datos['secciones']['ustotpersalfrio']) . '</td>
          <td class="valor" >' . fpesos($datos['secciones']['portotpersalfrio']) . ' %</td>
        </tr>
      <tr style="height:13.8pt">
        <td class="valor"> 3 &nbsp;</td>
        <td class="xl224" >
          <u>INSTALACIÓN DE EQUIPOS</u><br>
            &nbsp;incluye<br>
            ° Costo de instalación<br>
            ° Costo de aislamiento
        </td>
        <td class="valor">$ ' . fpesos($datos['secciones']['totinsequipos']) . '</td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotinsequipos']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotinsequipos']) . '%</td>
      </tr>
      <tr style="height:13.8pt">
        <td class="valor">4&nbsp;</td>
        <td >
          <u>INSTALACIÓN DE TUBERÍA</u><br>
            &nbsp;Incluye<br>
              ° Costo de mano de obra<br>
              ° Costo de material<br>
              ° Costo de aislamiento<br>
              ° Costo de pintura<br>
              ° Soportería para tuberías
        </td>
        <td class="valor">$ ' . fpesos($datos['secciones']['totinstb']) . '</td>
        <td class="valor">USD ' . fpesos($datos['secciones']['ustotinstb']) . '</td>
        <td class="valor">' . fpesos($datos['secciones']['portotinstb']) . ' % </td>
      </tr>
      <tr style="height:13.8pt">
        <td class="valor"> 5 &nbsp;</td>
        <td >
          <u>INSTALACIÓN DE VÁLV Y ACC</u><br>
            &nbsp;Incluye<br>
              ° Costo de mano de obra<br>
              ° Costo de material<br>
              ° Costo de aislamiento<br>
              ° Costo de pintura
        </td>
        <td class="valor" >$ ' . fpesos($datos['secciones']['totinsvalv']) . '</td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotinsvalv']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotinsvalv']) . ' %</td>
      </tr>
      <tr style="height:13.8pt">
        <td class="valor"> 6 &nbsp;</td>
        <td >
          <u>INSTALACIÓN ELÉCTRICA</u><br>
              &nbsp;Incluye<br>
              ° Costo de mano de obra<br>
              ° Costo de material<br>
              ° Soporteria para bandejas/tuberia
        </td>
        <td class="valor" >$ ' . fpesos($datos['secciones']['totinselec']) . '</td>
        <td class="valor">USD ' . fpesos($datos['secciones']['ustotinselec']) . '</td>
        <td class="valor"> ' . fpesos($datos['secciones']['portotinselec']) . ' %</td>
      </tr>
      <tr style="height:13.8pt">
        <td class="valor"> 7 &nbsp;</td>
        <td >
          <u>PRUEBAS DE FUNCIONAMIENTO</u><br>
              &nbsp;Incluye<br>
              ° Pruebas de triple vacío<br>
              ° Pruebas de presión (75, 100, 200 psi)<br>
              ° Pruebas eléctricas
        </td>
        <td class="valor">$ ' . fpesos($datos['secciones']['totpruebas']) . '</td>
        <td class="valor">USD ' . fpesos($datos['secciones']['ustotpruebas']) . '</td>
        <td class="valor">' . fpesos($datos['secciones']['portotpruebas']) . ' %</td>
      </tr>
      <tr style="height:13.8pt">
        <td class="valor"> 8 &nbsp;</td>
        <td >
          <u>VARIOS</u>
            &nbsp;Incluye<br>
            ° Andamios<br>
            ° Viáticos de personal<br>
            ° Transporte de material<br>
            ° Personal SISO<br>
            ° Imprevistos
        </td>
        <td class="valor">$ ' . fpesos($datos['secciones']['totvarios']) . ' </td>
        <td class="valor">USD ' . fpesos($datos['secciones']['ustotvarios']) . '</td>
        <td class="valor">' . fpesos($datos['secciones']['portotvarios']) . ' %</td>
      </tr>
      <tr style="height:13.95pt">
        <td colspan="2" class="xl227">TOTAL COSTO</td>
        <td class="valor">$ ' . fpesos($datos['secciones']['totcostos']) . ' </td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotcostos']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotcostos']) . ' %</td>
      </tr>
      <tr style="height:13.95pt">
        <td colspan="2" class="xl227" >TOTAL PROFIT</td>
        <td class="valor" >$ ' . fpesos($datos['secciones']['totprofit']) . '</td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotprofit']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotprofit']) . ' %</td>
      </tr>
      <tr style="height:13.95pt">
        <td colspan="2" class="xl227" >TOTAL PRECIO DE VENTA (SIN IVA)</td>
        <td class="valor" >$ ' . fpesos($datos['secciones']['totprecio']) . '</td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotprecio']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotprecio']) . ' %</td>
      </tr>
      <tr style="height:13.95pt">
        <td colspan="2" class="xl227" >TOTAL IVA</td>
        <td class="valor" >$ ' . fpesos($datos['secciones']['totiva']) . '</td>
        <td class="valor" >USD ' . fpesos($datos['secciones']['ustotiva']) . '</td>
        <td class="valor" >' . fpesos($datos['secciones']['portotiva']) . ' %</td>
      </tr>
    </table>  
    ';
        //echo $this->html;            
        $this->writeHTML($this->html);
        $this->posicionY = $this->getY();
    }

    function mostrarTablaCuerpoC($datos){   // Cuerpo version Cliente
      $this->posicionY += 1;
      $this->setY($this->posicionY);
      $anchoPagina = $this->getPageWidth();
      $this->SetFont('helvetica', '', 10);
      
      $this->html = '<html>
      <head>
          <link rel="stylesheet" type="text/css" href="./CL_PDF_resumen_pry.css">
      </head>
      <body>
        <table style="width:540pt;">
          <tr style="height:13.8pt">
            <td class="xl227" style="width:33pt;">ÍTEM</td>
            <td class="xl227" style="width:507pt">DESCRIPCIÓN</td>
          </tr>
          <tr >
            <td class="valor" > 1 &nbsp;</td>
            <td >
                <u>ADMINISTRATIVOS</u><br>
                &nbsp;Incluye:<br>
                ° Pólizas<br>
                ° Personal COMPRAS + CONTABILIDAD
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 2&nbsp;</td>
            <td class="xl232" >
              <u>PERSONAL ALFRIO</u><br>
                &nbsp;Incluye<br>
                ° Ingeniero ALFRIO<br>
                ° Técnico ALFRIO<br>
                ° Viáticos<br>
                ° Servicio Telefónico
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 3 &nbsp;</td>
            <td class="xl224" >
              <u>INSTALACIÓN DE EQUIPOS</u><br>
                &nbsp;incluye<br>
                ° Costo de instalación<br>
                ° Costo de aislamiento
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor">4&nbsp;</td>
            <td >
              <u>INSTALACIÓN DE TUBERÍA</u><br>
                &nbsp;Incluye<br>
                  ° Costo de mano de obra<br>
                  ° Costo de material<br>
                  ° Costo de aislamiento<br>
                  ° Costo de pintura<br>
                  ° Soportería para tuberías
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 5 &nbsp;</td>
            <td >
              <u>INSTALACIÓN DE VÁLV Y ACC</u><br>
                &nbsp;Incluye<br>
                  ° Costo de mano de obra<br>
                  ° Costo de material<br>
                  ° Costo de aislamiento<br>
                  ° Costo de pintura
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 6 &nbsp;</td>
            <td >
              <u>INSTALACIÓN ELÉCTRICA</u><br>
                  &nbsp;Incluye<br>
                  ° Costo de mano de obra<br>
                  ° Costo de material<br>
                  ° Soporteria para bandejas/tuberia
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 7 &nbsp;</td>
            <td >
              <u>PRUEBAS DE FUNCIONAMIENTO</u><br>
                  &nbsp;Incluye<br>
                  ° Pruebas de triple vacío<br>
                  ° Pruebas de presión (75, 100, 200 psi)<br>
                  ° Pruebas eléctricas
            </td>
          </tr>
          <tr style="height:13.8pt">
            <td class="valor"> 8 &nbsp;</td>
            <td >
              <u>VARIOS</u><br>
                &nbsp;Incluye<br>
                ° Andamios<br>
                ° Viáticos de personal<br>
                ° Transporte de material<br>
                ° Personal SISO<br>
                ° Imprevistos
            </td>
          </tr>
          <tr style="height:13.95pt">
            <td colspan="2" class="xl227" style="padding:0">
              <table style="width:100%;margin:0;">
                <tr>
                  <td style="width:70%">TOTAL PRECIO DE VENTA (SIN IVA) </td>
                  <td class="valor" style="width:20%;background-color:white;color:black;">
                      USD ' . fpesos($datos['secciones']['ustotprecio']) . ' 
                  </td>
                  <td style="width:10%">  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr style="height:13.95pt">
            <td colspan="2" style="padding:10pt;text-align:justify;">
            NOTA: El precio está ofertado en DÓLARES AMERICANOS pagaderos en pesos colombianos 
            a la tasa representativa de mercado el día en que se realice cada pago. Nos reservamos 
            el derecho a solicitar reajuste de precio en caso de que se modifiquen las condiciones 
            tributarias (IVA, retefuente, etc.) impuestos por el Gobierno Nacional. A este valor 
            sumar el IVA.
            </td>
          </tr>
        </table>  
      ';
      /*





          <!--  <table>
              <tr>
                <td class="xl227" style="width:254pt">TOTAL PRECIO DE VENTA (SIN IVA)</td>
                <td class="valor" style="width:286pt">
                    USD ' . fpesos($datos['secciones']['ustotprecio']) . '</td>
              </tr>
            </table> -->

      */
        $this->writeHTML($this->html);
        $this->posicionY = $this->getY();
      }
  
}

function lee_perfiles($ar_p,$resto){
  $saldo = 0;
  for($x=0; $x < count($ar_p);$x++){
    if( $ar_p[$x]['resto'] == $resto){
       $saldo += ( $ar_p[$x]['cst_material'] + $ar_p[$x]['cst_mobra'] + $ar_p[$x]['cst_pintura'] );
    }
  }
  return $saldo;
}

$obj_pdf = new CL_PDF_resumen_pry('P','pt','letter',true,'UTF-8',false,false);
$id_pry = $_REQUEST['id_pry'];
$opcion = $_REQUEST['opcion'];
$ar_pry  = $tpry->lee(" WHERE id_prycosto = ".$id_pry,0,"A");
$trm = $ar_pry[0]['trm_proy'];
$profit = $ar_pry[0]['profit_proy'];
$ar_ciuori = $tciudades->lee(" WHERE id_ciudad='".$ar_pry[0]['cod_ciu_ori']."'",0,"A");
$ar_pry[0]['nomciu_ori'] = $ar_ciuori[0]['nom_ciudad']; 
$ar_ciudes = $tciudades->lee(" WHERE id_ciudad='".$ar_pry[0]['codciu_proy']."'",0,"A");
$ar_pry[0]['nomciu_proy'] = $ar_ciudes[0]['nom_ciudad']; 
$param['nitempre'] = $tparam->getDato('nitempre');
$param['nomempre'] = $tparam->getDato('nomempre');
$param['dirempre'] = $tparam->getDato('dirempre');
$param['telempre'] = $tparam->getDato('telempre');
$datos[0] = $param;
$retorno['nm_empleados'] = $templeados->lee(" WHERE codemple='".$ar_pry[0]['grabador']."'",0,"A");
$retorno['nm_empleados'] = $tpersonas->lee("WHERE numid='".$retorno['nm_empleados'][0]['numid']."'",0,"A");
$retorno['pry'] = $ar_pry; 
$datos[1] = $retorno;
$obj_pdf->datosGenerales($datos);
$obj_pdf->SetMargins(15, 5, 5, 5);
$obj_pdf->AddPage();
$obj_pdf->mostrarTablaEncabezado($datos,1);
$ar_pryadm = $tpryadm->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totadm'] = ( $ar_pryadm[0]['polizas'] + $ar_pryadm[0]['costo_fcro'] + $ar_pryadm[0]['pers_admtvo']);
$datos['secciones']['ustotadm'] = ( $datos['secciones']['totadm'] / $trm );
$datos['secciones']['portotadm'] =0;
$ar_prypers = $tprypers->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totpersalfrio'] = 0;
for($x=0; $x < count( $ar_prypers); $x++){
  $datos['secciones']['totpersalfrio'] += $ar_prypers[$x]['valor_total'];
}
$datos['secciones']['ustotpersalfrio'] = ( $datos['secciones']['totpersalfrio'] / $trm );
$datos['secciones']['portotpersalfrio'] = 0;
$ar_equi = $tpryequi->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$ar_perfiles = $tpryperfiles->lee(" WHERE id_prycosto=".$id_pry." ORDER BY resto",0,"A");

$datos['secciones']['totinsequipos'] = 0;
for($x=0; $x < count($ar_equi);$x++){
  $datos['secciones']['totinsequipos'] += ( $ar_equi[$x]['costo_instal'] + $ar_equi[$x]['costo_aislam'] );
}
$datos['secciones']['totinsequipos'] += lee_perfiles($ar_perfiles,'_0');

$datos['secciones']['ustotinsequipos'] = ( $datos['secciones']['totinsequipos'] / $trm );
$datos['secciones']['portotinsequipos'] = 0;
$ar_tb = $tprytube->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totinstb'] = 0;
for($x=0; $x < count($ar_tb);$x++){
  $datos['secciones']['totinstb'] += ( $ar_tb[$x]['cst_material'] + $ar_tb[$x]['cst_mobra'] + $ar_tb[$x]['cst_pintura'] + $ar_tb[$x]['cst_aislam'] );
}
$datos['secciones']['totinstb'] +=  lee_perfiles($ar_perfiles,'_1');
$datos['secciones']['ustotinstb'] = ( $datos['secciones']['totinstb'] / $trm );
$datos['secciones']['portotinstb'] = 0;
$ar_valv = $tpryvalv->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totinsvalv'] = 0;
for($x=0; $x < count($ar_valv);$x++){
  $datos['secciones']['totinsvalv'] += ( $ar_valv[$x]['cst_mobra'] + $ar_valv[$x]['cst_pintura'] + $ar_valv[$x]['cst_aislam'] );
}
$datos['secciones']['ustotinsvalv'] = ( $datos['secciones']['totinsvalv'] / $trm );
$datos['secciones']['portotinsvalv'] = 0;
$ar_cabel = $tprycabelec->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$ar_tubel = $tprytubelec->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totinselec'] = $datos['secciones']['ustotinselec'] = $datos['secciones']['portotinselec'] = 0; 
for($x=0; $x < count( $ar_cabel ); $x++ ){
  $datos['secciones']['totinselec'] += ( $ar_cabel[$x]['cst_material'] + $ar_cabel[$x]['cst_mobra'] );
}
for($x=0; $x < count( $ar_tubel ); $x++ ){
  $datos['secciones']['totinselec'] += ( $ar_tubel[$x]['cst_material'] + $ar_tubel[$x]['cst_mobra'] );
}
$datos['secciones']['totinselec'] += lee_perfiles($ar_perfiles,'_2');
$datos['secciones']['ustotinselec'] = ( $datos['secciones']['totinselec'] / $trm );
$datos['secciones']['totpruebas'] = $datos['secciones']['ustotpruebas'] = $datos['secciones']['portotpruebas'] = 0;
$ar_pruebas = $tprypruebas->lee(" WHERE id_prycosto=".$id_pry,0,"A");
for($x=0; $x < count($ar_pruebas);$x++){
  $datos['secciones']['totpruebas'] += $ar_pruebas[$x]['valor_total'];
}
$datos['secciones']['ustotpruebas'] = ( $datos['secciones']['totpruebas'] / $trm );
$ar_varios = $tpryvarios->lee(" WHERE id_prycosto=".$id_pry,0,"A");
$datos['secciones']['totvarios'] = $datos['secciones']['ustotvarios'] = $datos['secciones']['portotvarios'] = 0;
for( $x=0; $x < count( $ar_varios ); $x++ ){
  $datos['secciones']['totvarios'] += ( $ar_varios[$x]['valor_total']);
}
$ar_varmq = $tpryvarmq->lee(" WHERE id_prycosto=".$id_pry,0,"A");
for($x=0; $x < count( $ar_varmq ); $x++ ){
  $datos['secciones']['totvarios'] += ( $ar_varmq[$x]['valor_total']);
}
$datos['secciones']['ustotvarios'] = ( $datos['secciones']['totvarios'] / $trm );
$totcostos = $ustotcostos = $portotcostos = 0; $x = -1;
foreach($datos['secciones'] AS $clave => $valor ){
  if( substr($clave,0,3) === "tot" ){
    $x+=1;
    $totcostos += $valor;
  }
}

foreach($datos['secciones'] AS $clave=>$valor){
  if( substr($clave,0,3) === "tot" ){
    $clave2 = "us".$clave; $valor2 = $datos['secciones'][$clave2];
    $clave3 = "por".$clave;$valor3 = ( ( $valor / $totcostos ) * 100 );
    $datos['secciones'][$clave3] = $valor3;
    $portotcostos += $valor3;
  }  
  $datos['secciones']['totcostos'] = $totcostos;
  $datos['secciones']['ustotcostos'] = ( $totcostos / $trm );
  $datos['secciones']['portotcostos']= $portotcostos;
}
$utilid = ( $profit / 100 );
$costoPers = $datos['secciones']['totpersalfrio'];
$pventa = ( ( $totcostos - $costoPers ) / ( 1 - $utilid ) ) + $costoPers ;
$datos['secciones']['totprecio'] = $pventa;
$datos['secciones']['ustotprecio'] = ( $pventa / $trm );
$porc_pventa = ( $portotcostos / ( 1 - $utilid ) );
$datos['secciones']['portotprecio'] = $porc_pventa;
$profit = ( $pventa - $totcostos );
$datos['secciones']['totprofit'] = $profit;
$datos['secciones']['ustotprofit'] = ( $profit / $trm );

$porc_profit = ( $porc_pventa - $portotcostos );
$datos['secciones']['portotprofit'] = $porc_profit;
$porciva = ( $ar_pry[0]['iva_proy'] / 100 );
$vriva = ( $pventa * $porciva );
$porc_iva = ( $porc_pventa * $porciva );
$datos['secciones']['totiva'] = $vriva;
$datos['secciones']['ustotiva'] = ( $vriva / $trm );
$datos['secciones']['portotiva'] = $porc_iva;
switch($opcion){
  case 'G':$obj_pdf->mostrarTablaCuerpoG($datos);break;
  case 'C':$obj_pdf->mostrarTablaCuerpoC($datos);break;
}

$salida = 'resumen_pry.pdf';
$obj_pdf->Output($salida);
