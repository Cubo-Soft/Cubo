<?php

global $trm;

include_once '/home/u955681615/domains/cubosoftalfrio.com/public_html/desarrollo/modelos/parametros_conexion.php';
$fecha = new DateTime(null, new DateTimeZone('America/Bogota'));

// URL del servicio web del Banco de la República de Colombia
$url = "https://www.datos.gov.co/resource/32sa-8pi3.json";
// Realizar la solicitud GET a la API
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
// Decodificar la respuesta JSON
$data = json_decode($response);
// Verificar si la solicitud fue exitosa y obtener el precio del dólar
if ($data !== null && !empty($data)) {
    $trm = $data[0]->valor;
    //echo "El precio del dólar hoy en Colombia es: $dolar COP";
} else {

    $url = "https://api.exchangerate-api.com/v4/latest/USD";
    // Realizar la solicitud GET a la API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decodificar la respuesta JSON
    $data = json_decode($response, true);

    // Verificar si la solicitud fue exitosa y obtener el precio del dólar
    if ($data && isset($data['rates']) && isset($data['rates']['COP'])) {
        $trm = $data['rates']['COP'];
    } else {
        $trm = '0000';
    }
}


//$trm=valorTRM();
//pruebas
/*
$USER = 'u955681615_pruebas';
$PASSWORD = 'R$i#a$d)6';
$HOST = 'localhost';
$BD = 'u955681615_pruebas';
$PUERTO = '3306';
*/

//desarrollo
$USER = 'u955681615_desarrollo';
$PASSWORD = 'R$i#a$d)6';
$HOST = 'localhost';
$BD = 'u955681615_desarrollo';
$PUERTO = '3306';


$conn = mysqli_connect($HOST, $USER, $PASSWORD, $BD);

if ($conn === false) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

#$consulta="insert into cm_trm (id_moneda,fecha,trm) values (35,'date('Y-m-d')',".$trm.");";
$consulta = "insert into cm_trm (id_moneda,fecha,trm) values (35,'date'," . $trm . ");";

$results = mysqli_query($conn, $consulta);

if ($results === false) {
    die("Error al realizar la consulta: " . mysqli_error($conn));
}

mysqli_close($conn);
