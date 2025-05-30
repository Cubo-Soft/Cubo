<?php

include_once '../modelos/CL_np_paises.php';

$OB_np_paises = new CL_np_paises();

/**
 * retorna toda la lista de paises
 */
if ($_POST["caso"] === '1' || $_POST["caso"] === '3') {
    echo json_encode($OB_np_paises->leer(null, 1));
}

/*
 * retorna el pais en función del id_ciudad de la 
 * tabla np_ciudades
 */
if ($_POST["caso"] === '2') {
    echo json_encode($OB_np_paises->leer($datos, $opcion));
}