<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("../PHPMailer/src/PHPMailer.php");
include_once "../modelos/CL_vr_cotiza.php";
include_once "../modelos/CL_nm_contactos.php";
$OB_vr_cotiza = new CL_vr_cotiza();
$OB_nm_contactos = new CL_nm_contactos();

$datos["id_consecot"] = $_GET["id_consecot"];
$data_vr_cotiza = $OB_vr_cotiza->leer($datos, 5);

$datos["id_contacto"] = $data_vr_cotiza[0]["id_contacto"];
$data_nm_contactos = $OB_nm_contactos->leer($datos, 5);

$nombreCotizacion = 'Re_CT_' . $data_vr_cotiza[0]["nro_cot"] . '_' . $data_vr_cotiza[0]["version"] . '.pdf';
$rutaCotizacion = '../cotizaciones/' . $nombreCotizacion;

if (filter_var($data_nm_contactos[0]["email"], FILTER_VALIDATE_EMAIL)) {

    $OB_php_mailer = new PHPMailer();
    $OB_php_mailer->Host = "cubosoftalfrio.com";
    $OB_php_mailer->From = "sistemas@cubosoftalfrio.com ";
    $OB_php_mailer->FromName = "Servidor web";
    $OB_php_mailer->Subject = "Cotizacion de repuestos";
    //$OB_php_mailer->AddAddress($data_nm_contactos[0]["email"]);
    $OB_php_mailer->AddAddress("sistemas@alfrio.com");
    $OB_php_mailer->IsHTML(true);
    $body = "Cordial saludo, <br> adjunto encuentra la cotización solicitada . ";
    $OB_php_mailer->Body = $body;
    //adjuntamos un archivo
    $OB_php_mailer->AddAttachment($rutaCotizacion, $nombreCotizacion);
    if ($OB_php_mailer->Send()) {        
        
        $OB_vr_cotiza->actualizar($datos,4);

        echo '<form action="../vistas/cotiza.php" method="GET">
                Solicitud enviada. Gracias.<br>
                <input type="hidden" id="id_consecot" name="id_consecot" value="'.$datos["id_consecot"].'" />
                <input type="submit" value="Volver" />
        </form>';        
    } else {
        echo '<form action="../vistas/cotiza.php" method="GET">
                <input type="hidden" id="id_consecot" name="id_consecot" value="'.$datos["id_consecot"].'" />                
                Ha fallado el envío. <br>
                Podría por favor revisar lo siguiente:<br>
                1. La dirección de correo del destinatario se encuentre bien escrita<br>
                2. El archivo del pdf de la cotización ya fue generado<br>
                En caso de persistir la falla por favor haga el envío de manera manual
                <input type="submit" value="Volver" />
        </form>';
    }
}else{
    echo '<form action="../vistas/cotiza.php" method="GET">
            <input type="hidden" id="id_consecot" name="id_consecot" value="'.$datos["id_consecot"].'" />            
                No se encuentra una dirección de correo válida. Por favor revise.<br>    
                <input type="submit" value="Volver" />
        </form>';    
}