<?php 
session_start();
// cargue de archivo plano CSV para programa precio.php
$arch=fopen("salidaCargue","w+");
fwrite($arch,"Abriendo el Controlador ... \n");
$ar_sale = [];
$ar_sale['estado'] = "Ok"; $ar_sale['error'] = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codusr = $_POST['coduser'];
    $uploadDir = '../uploads/';
    //$uploadFile = $uploadDir . basename($_FILES['file']['name']);
    $uploadFile = $uploadDir . $codusr . ".csv";
    $readFile1 = $uploadDir . $codusr . "_1.csv";
    $readFile2 = $uploadDir . $codusr . "_2.csv";
    fwrite($arch,"cargando el archivo: ".$_FILES['file']['name']." \n");
    $archivo = $_FILES['file']['name'];
    $a_archivo = explode(".",$archivo);
    fwrite($arch,"desglose del archivo ".$archivo." con extension: ".$a_archivo[1]."\n");
    if( strtoupper($a_archivo[1]) !== "CSV"){
        $ar_sale['error'] = true;
        $ar_sale['estado'] = "El archivo ".$archivo." NO es CSV";
    }else{
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            fwrite($arch,"cargue Ok del archivo ".$uploadFile." \n");
            $a_datos = file($uploadFile);
            $a_datos = array_filter($a_datos);
            for($x=0; $x < count( $a_datos ); $x++){
                $a_linea = explode("\r\n",$a_datos[$x]);
                if( isset( $_POST['id_marca'] ) ){
                    $listaDatos[] = $_POST['id_marca'].";".$a_linea[0];
                }else{
                    $listaDatos[] = explode(";",$a_linea[0]); 
                }
            }
            if( isset( $_POST['id_marca'] ) ){
                if( file_put_contents($readFile1, implode(PHP_EOL, $listaDatos ) ) ){
                    chmod($readFile1,0777);
                    $ar_sale['salida'] = $readFile1;
                }
            }
            $ar_sale['data'] = $listaDatos;
            $ar_sale['estado'] = 'Archivo copiado correctamente.';
        } else {
            fwrite($arch,"cargue ERRADO !! \n");
            $ar_sale['estado'] = 'Error al cargar archivo.';
        }
    }
} else {
    fwrite($arch,"Método NO VALIDO !! \n");
    $ar_sale['estado'] = 'Método de solicitud no válido.';
}
fclose($arch);
echo json_encode($ar_sale);
?>