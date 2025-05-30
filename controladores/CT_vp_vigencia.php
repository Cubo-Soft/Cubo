<?php

include_once '../modelos/CL_vp_vigencia.php';

$OB_vp_vigencia = new CL_vp_vigencia();

if ($_POST["caso"] === '1') {
    echo json_encode($OB_vp_vigencia->leer(null, 1));
}