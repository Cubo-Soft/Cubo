<?php 
// cargue de archivo plano CSV para programa precio.php
$arch=fopen("salidaCargue","w+");
fwrite($arch,"Abriendo el Controlador ... \n");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $uploadDir = './uploads/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        fwrite($arch,"cargando el archivo: " . basename($_FILES['file']['name']) . " \n");

        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            fwrite($arch,"cargue Ok \n");
            echo 'El archivo se ha cargado correctamente.';
        } else {
            fwrite($arch,"cargue ERRADO !! \n");
            echo 'Error al mover el archivo.';
        }
    } else {
        fwrite($arch,"cargue ERRADO !! \n");
        echo 'Error al cargar el archivo.';
    }
} else {
    fwrite($arch,"Método NO VALIDO !! \n");
    echo 'Método de solicitud no válido.';
}
fclose($arch);
?>