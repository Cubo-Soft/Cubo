<?php

session_start();

include_once '../modelos/CL_np_activeco.php';

$OB_np_activeco = new CL_np_activeco();

//envia donde nm_activeco.js indique
if ($_POST["caso"] === '1') {
    echo json_encode($OB_np_activeco->leer(null, 1));
}