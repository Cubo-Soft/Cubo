<?php

setlocale(LC_TIME, 'es_ES');

include_once '../tcpdf/tcpdf.php';
include_once '../adicionales/varios.php';


class CL_PDF extends TCPDF
{

    private $ruta_imagen = null, $html = null, $ap_param = array(), $cabecera = array(), $formatterES, $posicionY = 0;
    public $retorno = array();

    public function establecerDatosGenerales($datos)
    {
        $this->ap_param = $datos[0];
        $this->cabecera = $datos[1];
        //para cuando se llegó a necesitar convertir las letras a números
        $this->formatterES = new NumberFormatter("es-ES", NumberFormatter::SPELLOUT);
    }

    public function retornarPrecioIva($datos, $opcion)
    {

        $valorIva = 0;
        $valorMasIva = 0;
        $retorno = 0;

        if (strlen($datos["iva"]) === 1) {
            $valorIva = '1.0' + $datos["iva"];
        } else {
            $valorIva = '1.' + $datos["iva"];
        }

        if ($opcion === 1) {

            $valorMasIva = floatval($datos["precioProducto"]) * floatval($valorIva);
            $retorno = floatval($valorMasIva) - floatval($datos["precioProducto"]);
        }

        if (opcion === 2) {
            $retorno = floatval($datos["precioProducto"]) * floatval($valorIva);
        }

        return number_format($retorno, 2);
    }

    //    //Page header
    public function Header()
    {
        unset($this->html);

        //var_dump($this->cabecera);

        $partesFecha = explode("-", $this->cabecera["vr_cotiza"][0]["fecha_ini"]);
        $anio = $partesFecha[0];
        $mes = $partesFecha[1];
        $dia = $partesFecha[2];

        $letra_nombre = substr($this->cabecera["nm_empleados"][0]["nombres"], 0, 1);
        $letra_apellido = substr($this->cabecera["nm_empleados"][0]["apellidos"], 0, 1);

        //var_dump($letra_nombre);

        $this->html = '<table width="100%" style="margin:0px; padding-button:0px;">
        <tr><td colspan="11"></td></tr>
        <tr>
		    <td colspan="2" rowspan="5" align="left" valign="top"><br><img src="../imagenes/app/logo_cotizaciones.png" width="100" height="70"></td>
		    <td colspan="7" style="font-size: 7px; text-align: justify; padding:0px; margin:0px" ><b>' . $this->ap_param[8]["valor"] . '</b><br><b>NIT: ' . $this->ap_param[9]["valor"] . '</b><br>Dirección: ' . $this->ap_param[4]["valor"] . ' / Telefono: ' . $this->ap_param[13]["valor"] . '  <br><b><font color="#800000" >' . $this->ap_param[0]["valor"] . '</font></b><br>' .$this->ap_param[7]["valor"] . '</td>
		    <td colspan="2" rowspan="3" style="padding:0px; margin:0px" >
                <table style="font-size:7px;">
                    <tr><td colspan="3"></td></tr>
                    <tr style="background-color: #003F80; color: #FFFFFF; text-align: center;"><td colspan="3"><b>COTIZACIÓN ' . $letra_apellido . $letra_nombre . '</b></td></tr>
                    <tr><td colspan="3" style="text-align:center">Nro.' . $this->cabecera["vr_cotiza"][0]["nro_cot"] . ' - v' . $this->cabecera["vr_cotiza"][0]["version"] . '</td></tr>
                    <tr style="background-color: #003F80; color: #FFFFFF; text-align: center;"><td colspan="3"><b>FECHA DE EMISIÓN</b></td></tr>
                    <tr><td style="text-align:center">DD</td><td style="text-align:center">MM</td><td style="text-align:center">AAAA</td></tr>
                    <tr><td style="text-align:center">' . $dia . '</td><td style="text-align:center">' . $mes . '</td><td style="text-align:center">' . $anio . '</td></tr>
                </table>
            </td>		
	    </tr>
        </table>
        <div style="width: 500px; height: 10px; background-color: #003F80; padding: 0; margin: 10px;"></div>';
        $this->writeHTML($this->html);

        $this->posicionY = $this->getY();
    }

    // Page footer
    public function Footer()
    {

        //echo $this->GetY();

        $this->SetFont('helvetica', 'B', 8);

        // Establecer el contenido del pie de página
        //$texto = "- " . $this->ap_param[8]["valor"] . " - NIT " . $this->ap_param[7]["valor"] . " - " . $this->ap_param[2]["valor"] . " - Teléfono: " . $this->ap_param[10]["valor"] . " - Página: " . $this->getAliasNumPage() . " -";
        $texto = "- Página: " . $this->getAliasNumPage() . " -";
        $this->SetY(-15);
        $this->Cell(0, 10, $texto, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    function mostrarTablaDatosCliente($datos, $opcion)
    {

        $this->html = '';

        if ($opcion === 1) {

            $arregloFechaFormateada = explode('-', date_create_from_format('Y-m-d', $datos["vr_cotiza"][0]["fecha_ini"])->format('d-m-Y'));

            if (isset($datos["nm_juridicas"])) {

                $nombreEmpresa = $datos["nm_juridicas"][0]["razon_social"];
                $nit = $datos["nm_juridicas"][0]["numid"];
                $direccion = $datos["nm_juridicas"][0]["direccion"];
                $ciudad = $datos["nm_sucursal"][0]["nom_ciudad"];

                $telefono = $datos["nm_sucursal"][0]["telefono"] . ' ';

                if ($datos["nm_sucursal"][0]["telefono2"] !== '0') {
                    //$telefono.=$datos["nm_sucursal"][0]["telefono2"]. ' ';
                }
            }

            if (isset($datos["nm_personas"])) {

                $nombreEmpresa = $datos["nm_personas"][0]["apelli_nom"];
                $nit = $datos["nm_personas"][0]["numid"];
                $direccion = $datos["nm_personas"][0]["direccion"];
                $ciudad = $datos["nm_personas"][0]["nom_ciudad"];
                $telefono = $datos["nm_personas"][0]["telefono"];;
            }


            $this->posicionY += 1;

            $this->setY($this->posicionY);
            $anchoPagina = $this->getPageWidth();

            $this->html = '<table width="100%" style="margin:0px; padding-top:0px; font-size:9px;">
    <tr>
        <td></td>
        <td><strong>SEÑORES</strong></td>
        <td colspan="7" align="left">' . $nombreEmpresa . '</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>NIT</strong></td>
        <td colspan="7" align="left">' . $nit . '</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>DIRECCIÓN</strong></td>
        <td colspan="7" align="left">' . $direccion . '</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>CIUDAD</strong></td>
        <td colspan="7" align="left">' . $ciudad . '</td>
    </tr>
    <tr>
        <td></td>
        <td><strong>CONTACTO</strong></td>
        <td colspan="7" align="left"></td>
    </tr>
    <tr>
        <td></td>
        <td><strong>TELÉFONOS</strong></td>
        <td colspan="7" align="left">' . $telefono . '</td>
    </tr>    
</table>';

            //echo $this->html;            

            $this->writeHTML($this->html);
        }
    }

    function mostrarTablaRepuestos($datos, $option)
    {
        //$this->html = '';

        $valorBruto = 0;
        $descuento = 0;
        $subTotal = 0;
        $valorIva = 0;
        $valorTotal = 0;
        $totalValorSinIva = 0;
        $totalValorIva = 0;
        $iva = 0;
        $totalPorcentajeDescuento = 0;
        $totalDescuento = 0;
        $textoDisponibilidad = '';
        $textoDescuento = '';
        $totalDescuentos = 0;
        $totalesIva = 0;

        $repuestos = array();

        $trm = $datos["cm_trm"];

        $iva = $datos["vr_cotizadet"][0]["iva_referencia"];

        $this->posicionY += 24;

        $this->setY($this->posicionY);

        $contador = 0;

        $this->html = '<table with="100%"><tr style="background-color: #003F80; font-size: 7px;" >'
            . '<th style="text-align: center; color:white; width:20px;"><strong>ITEM</strong></th>'
            . '<th style="text-align: center; color:white; width:25px;" ><strong>CANT.</strong></th>'
            . '<th style="text-align: center; color:white; width:40px;"><strong>REF.</strong></th>'
            . '<th style="text-align: center; color:white; width:127px;"><strong>DESCRIPCIÓN</strong></th>'
            . '<th style="text-align: center; color:white;width:70px;"><strong>DISPONIBILIDAD</strong></th>'
            . '<th style="text-align: center; color:white"><strong>MARCA</strong></th>'
            . '<th style="text-align: center; color:white"><strong>DCTO(%)</strong></th>'
            . '<th style="text-align: center; color:white"><strong>IVA(%)</strong></th>'
            . '<th style="text-align: center; color:white"><strong>VALOR UNIT ' . $datos["vr_cotiza"][0]["moneda"] . '</strong></th>'
            . '<th style="text-align: center; color:white"><strong>VALOR TOTAL ' . $datos["vr_cotiza"][0]["moneda"] . '</strong></th>'
            . '</tr>';

        for ($i = 0; $i < count($datos["vr_cotizadet"]); $i++) {

            if ($datos["vr_cotizadet"][$i]["misional"] === '02') {

                for ($index = 0; $index < count($datos["caracteristicasRepuestos"]); $index++) {

                    if ($datos["vr_cotizadet"][$index]["misional"] === "02") {

                        //calculo de precios para los repuestos
                        if (!in_array($datos["vr_cotizadet"][$index]["cod_item"], $repuestos)) {
                            $repuestos[$index] = $datos["vr_cotizadet"][$index]["cod_item"];
                            //pesos col
                            if ($datos["vr_cotiza"][0]["id_moneda"] === 34) {
                                $precioVenta = redondear(floatval($datos["caracteristicasRepuestos"][$index][0]["precio_vta"]) * floatval($datos["vr_cotizadet"][$index]["cantidad"]));
                            }

                            //dolar usd
                            if ($datos["vr_cotiza"][0]["id_moneda"] === 35) {
                                $datos["precioProducto"] = $datos["caracteristicasRepuestos"][$index][0]["precio_vta"];
                                $datos["trm"] = $trm;
                                $precioVenta = retornarPrecioDolares($datos, 1);
                            }

                            if ($datos["vr_cotizadet"][$index]["sem_dispo"] === 0) {
                                $textoDisponibilidad = 'INMEDIATA';
                            } else {
                                $textoDisponibilidad = $datos["vr_cotizadet"][$index]["sem_dispo"] . ' SEMANA(S)';
                            }

                            if ($datos["vr_cotizadet"][$index]["dscto_item"] !== 0) {
                                $textoDescuento = $datos["vr_cotizadet"][$index]["dscto_item"];
                            } else {
                                $textoDescuento = '';
                            }

                            $contador += 1;

                            if (floatval($datos["vr_cotizadet"][$index]["dscto_item"]) !== 0) {
                                $valorDescuento = (floatval($datos["vr_cotizadet"][$index]["dscto_item"]) * $precioVenta) / 100;
                            } else {
                                $valorDescuento = 0;
                            }

                            //para el dolar
                            if ($datos["vr_cotiza"][0]["id_moneda"] === 35) {
                                $valorConDescuento = $precioVenta - $valorDescuento;
                            } else {
                                $valorConDescuento = redondear($precioVenta - $valorDescuento);
                            }

                            $valorIva = $valorConDescuento * floatval($datos["vr_cotizadet"][$index]["iva_referencia"]) / 100;
                            $valorConIva = $valorConDescuento + $valorIva;

                            $subTotal += $precioVenta;
                            $totalDescuentos += $valorDescuento;
                            $valorBruto += $valorConDescuento;
                            $totalesIva += $valorIva;

                            //echo $datos["caracteristicasRepuestos"][$index][0]["nom_item"];

                            $this->html .= '<tr>'
                                . '<td border="1" style="font-size: 7px; text-align: center;">' . $contador . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: center;"> ' . $datos["vr_cotizadet"][$index]["cantidad"] . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: center;"> ' . $datos["vr_cotizadet"][$index]["cod_item"] . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: left;"> ' . $datos["caracteristicasRepuestos"][$index][0]["nom_item"] . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: center;">' . $textoDisponibilidad . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: center;"> ' . $datos["vr_cotizadet"][$index]["nom_marca"] . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: right;"> ' . $textoDescuento . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: right;"> ' . $datos["vr_cotizadet"][$index]["iva_referencia"] . '</td>'
                                . '<td border="1" style="font-size: 7px; text-align: right;"> ' . $datos["caracteristicasRepuestos"][$index][0]["precio_vta"] . '</td>';

                            //para el dolar
                            if ($datos["vr_cotiza"][0]["id_moneda"] === 35) {
                                $this->html .= '<td border="1" style="font-size: 7px; text-align: right;"> ' . number_format(floatval($precioVenta) * intval($datos["vr_cotizadet"][$index]["cantidad"]), 2) . '</td>';
                            } else {
                                $this->html .= '<td border="1" style="font-size: 7px; text-align: right;"> ' . number_format(redondear(floatval($precioVenta) * intval($datos["vr_cotizadet"][$index]["cantidad"])), 2) . '</td>';
                            }

                            $this->html .= '</tr>';

                            if (count($datos["vr_cotizcar"][$index]) > 0) {
                                $this->html .= '<tr><td colspan="12" border="1" style="font-size: 7px;text-align: left;" ><div class="col-lg-12 bg-info"> Caracteristicas de: <strong>' . $datos["vr_cotizadet"][$index]["descripcionArticulo"] . '</strong> <br/>';
                                for ($k = 0; $k < count($datos["textosCaracteristicas"][$index]); $k++) {
                                    $this->html .= ' <strong>' . $datos["textosCaracteristicas"][$index][$k][0]["desccarac"] . ' :</strong> ';
                                    $this->html .= ' ' . $datos["vr_cotizcar"][$index][$k]["vr_caract"] . '<br/>';
                                }
                                $this->html .= '</div></td></tr>';
                            }

                            if (strlen($datos["vr_cotizadet"][$index]["observs"]) > 0) {
                                $this->html .= '<tr><td colspan="12" border="1" style="font-size: 7px;text-align: left;" > Observaciones: ' . $datos["vr_cotizadet"][$index]["observs"] . ' ';
                                $this->html .= '</td></tr>';
                            }
                        }
                    }
                }
            }
        }

        //echo $totalesIva;       

        $this->html .= '<tr>'
            . '<td style="font-size: 7px;" colspan="11" border="1" ></td>'
            . '</tr>';

        //echo $iva;

        $this->html .= '<tr>'
            . '<td style="font-size: 7px;" border="1" colspan="8" rowspan="5">' . $this->ap_param[5]["valor"] . '</td>'
            . '<td style="font-size: 7px; text-align:right" border="1">VALOR BRUTO</td>'
            . '<td style="font-size: 7px; text-align:right;" border="1">' . number_format($subTotal, 2) . '</td>'
            . '</tr>';

        $this->retorno["valorBruto"] = $subTotal;

        $this->html .= '<tr>'
            . '<td style="font-size: 7px; text-align:right" border="1">DESCUENTOS</td>'
            . '<td style="font-size: 7px; text-align:right" border="1">' . number_format($totalDescuentos, 2) . '</td>'
            . '</tr>';

        $this->retorno["descuento"] = $totalDescuentos;


        $this->html .= '<tr>'
            . '<td style="font-size: 7px; text-align:right" border="1">SUBTOTAL</td>'
            . '<td style="font-size: 7px; text-align:right" border="1">' . number_format($valorBruto, 2) . '</td>'
            . '</tr>';

        $this->retorno["subTotal"] = $subTotal;

        $this->html .= '<tr>'
            . '<td style="font-size: 7px; text-align:right" border="1">VALOR IVA</td>'
            . '<td style="font-size: 7px; text-align:right" border="1">' . number_format($totalesIva, 2) . '</td>'
            . '</tr>';

        $this->retorno["totalValorIva"] = number_format($totalesIva, 2);

        $valorTotal = $totalesIva + $valorBruto;

        $this->html .= '<tr>'
            . '<td style="font-size: 7px; text-align:right" border="1">VALOR TOTAL</td>'
            . '<td style="font-size: 7px; text-align:right" border="1">' . number_format($valorTotal, 2) . ' </td>'
            . '</tr>';

        $this->retorno["valorTotal"] = number_format($valorTotal, 2);

        //este texto no va, era para el valor en letras
        /*$valorConIva = str_replace(",", "", $valorConIva);
        $izquierda = intval(floor($valorConIva));
        $derecha = intval(($valorConIva - floor($valorConIva)) * 100);
        $this->html .= '<tr>'
        . '<td style="font-size: 7px; text-align:left" border="1" colspan="11"> <b>Valor en letras: </b> SON ' . strtoupper($this->formatterES->format($izquierda)) . " CON " . strtoupper($this->formatterES->format($derecha)) . '</td></tr>';
        */

        $this->html .= '<tr>'
            . '<td style="font-size: 7px; text-align:center" colspan="11" border="1"><b>CONDICIONES COMERCIALES</b></td></tr>';

        $direccionEntrega = $datos["nm_sucursal"][0]["nom_pais"] . ',' . $datos["nm_sucursal"][0]["nom_ciudad"] . ',' . $datos["nm_sucursal"][0]["direccion"];

        $this->html .= '<tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>FORMA DE PAGO</b></td><td style="font-size: 7px;" colspan="3">' . $datos["vr_cotiza"][0]["terminoPago"] . '</td><td></td><td colspan="2"></td>'
            . '</tr>'
            /*. '<tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>MARCA</b></td><td style="font-size: 7px;"  colspan="3"></td><td></td><td colspan="2"></td>'
            . '</tr>'*/
            . '<tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>MONEDA</b></td><td style="font-size: 7px;"  colspan="3">' . $datos["vr_cotiza"][0]["moneda"] . '</td><td></td><td colspan="2"></td>'
            . '</tr><tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>TIEMPO DE ENTREGA</b></td><td style="font-size: 7px;" colspan="3">' . $datos["vr_cotiza"][0]["sem_entrega"] . ' SEMANA(S)</td><td style="font-size: 7px;" >Asesor comercial</td><td colspan="2" style="font-size: 7px;" >' . $datos["nm_empleados"][0]["nombreEmpleado"] . '</td>'
            . '</tr><tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>LUGAR DE ENTREGA</b></td><td style="font-size: 7px;" colspan="3">' . $direccionEntrega . '</td><td style="font-size: 7px;">Teléfono</td><td colspan="2" style="font-size: 7px;" >' . $datos["nm_empleados"][0]["telefono"] . '</td>'
            . '</tr><tr>'
            . '<td style="font-size: 7px;" colspan="3"> <b>VALIDEZ DE LA OFERTA</b></td><td style="font-size: 7px;" colspan="3">' . $datos["vp_vigencia"][0]["descrip"] . ' A PARTIR DE LA FECHA</td><td></td><td colspan="2"></td>'
            . '</tr>';

        $this->html .= "</table>";

        $this->writeHTML($this->html);
    }

    function mostrarTablaEquipos($datos, $opcion)
    {
        $this->html = "<table><thead>";

        $this->html .= '<tr style="background-color: #003F80; font-size: 7px;" border=1>'
            . '<th style="text-align: center; color:white;" colspan="3"><strong>EQUIPO</strong></th>'
            . '<th style="text-align: center; color:white;" colspan="2"><strong>TIPO</strong></th>'
            . '<th style="text-align: center; color:white;" colspan="2"><strong>MARCA</strong></th>'
            . '<th style="text-align: center; color:white;"><strong>CANT.</strong></th>'
            . '<th style="text-align: center; color:white;"><strong>PRECIO UNIT ' . $datos["vr_cotiza"][0]["moneda"] . '</strong></th>'
            . '<th style="text-align: center; color:white;"><strong>IVA %</strong></th>'
            . '<th style="text-align: center; color:white;"><strong>TOTAL SIN IVA ' . $datos["vr_cotiza"][0]["moneda"] . '</strong></th>'
            . '</tr></thead><tbody>';

        $valorBruto = 0;
        $totalValorSinIva = 0;

        for ($i = 0; $i < count($datos["vr_cotizadet"]); $i++) {

            if ($datos["vr_cotizadet"][$i]["misional"] === '01') {

                $valorConIva = (floatval($datos["vr_cotizadet"][$i]["valor_unit"]) * floatval($datos["vr_cotizadet"][$i]["iva_referencia"])) / 100;
                $valorTotal = floatval($datos["vr_cotizadet"][$i]["valor_unit"]) + $valorConIva;
                $valorIva = floatval($datos["vr_cotizadet"][$i]["valor_unit"]) - $valorConIva;
                $valorBruto += floatval($datos["vr_cotizadet"][$i]["valor_unit"]) * floatval($datos["vr_cotizadet"][$i]["cantidad"]);
                $totalValorSinIva += $valorConIva;

                $this->retorno["subTotal"]=$totalValorSinIva;
                $this->retorno["iva"]=$valorIva;
                $this->retorno["descuento"]=0;
                $this->retorno["vr_descuento"]=0;
                $this->retorno["totalValorIva"]=0;
                
                //var_dump($datos["vr_cotizadet"][0]);

                $this->html .= '<tr>'
                    . '<td border="1" style="font-size: 8px; text-align: center;" colspan="3">' . $datos["vr_cotizadet"][$i]["descripcionArticulo"] . '</td>'
                    . '<td border="1" style="font-size: 8px; text-align: center;" colspan="2" > ' . $datos["vr_cotizadet"][$i]["descripcionTipo"] . '</td>'
                    . '<td border="1" style="font-size: 8px; text-aign: center;" colspan="2"> ' . $datos["vr_cotizadet"][$i]["nom_marca"] . '</td>'
                    . '<td border="1" style="font-size: 8px; text-align: left;"> ' . $datos["vr_cotizadet"][$i]["cantidad"] . '</td>';

                $this->html .= '<td border="1" style="font-size: 8px; text-align:right; padding-right:20px"> ' . $datos["vr_cotizadet"][$i]["valor_unit"] . '</td>'
                    . '<td border="1" style="font-size: 8px; text-align:right; padding-right:20px"> ' . $datos["vr_cotizadet"][$i]["iva_referencia"] . '</td>'
                    . '<td border="1" style="font-size: 8px;text-align:right; padding-right:20px"> ' . number_format(floatval($datos["vr_cotizadet"][$i]["valor_unit"]) * intval($datos["vr_cotizadet"][$i]["cantidad"]), 2) . '</td>';

                $this->html .= '<td border="1" style="font-size: 8px;"></td>'
                    . '</tr>';

                if (count($datos["vr_cotizcar"][$i]) > 0) {

                    $this->html .= '<tr><td colspan="12" border="1" style="font-size: 8px;text-align: left;" ><div class="col-lg-12 bg-info"> Caracteristicas de <strong>' . $datos["vr_cotizadet"][$i]["descripcionArticulo"] . '</strong> <br /> ';

                    for ($k = 0; $k < count($datos["textosCaracteristicas"][$i]); $k++) {
                        $this->html .= ' <strong>' . $datos["textosCaracteristicas"][$i][$k][0]["desccarac"] . ' :</strong> ';
                        $this->html .= ' ' . $datos["vr_cotizcar"][$i][$k]["vr_caract"] . ' <br>';
                    }

                    $this->html .= '</div></td></tr>';
                }

                if (strlen($datos["vr_cotizadet"][$i]["observs"]) > 0) {
                    $this->html .= '<tr><td colspan="12" border="1" style="font-size: 8px;text-align: left;" > Observaciones: ' . $datos["vr_cotizadet"][$i]["observs"] . ' ';
                    $this->html .= '</td></tr>';
                }
            }
        }

        $this->html .= '</tbody></html>';

        //echo $this->html;

        $this->writeHTML($this->html);
    }
}
