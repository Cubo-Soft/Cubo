<?php

include_once '../modelos/CL_vp_terminospago.php';

$OB_vp_terminospago = new CL_vp_terminospago();

if ($_POST["caso"] === '1') {
    echo json_encode($OB_vp_terminospago->leer(null, 1));
}