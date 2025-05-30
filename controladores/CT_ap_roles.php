<?php

include_once '../modelos/CL_ap_roles.php';

$OB_ap_roles = new CL_ap_roles();

if ($_POST["caso"] === '1') {
    echo json_encode($OB_ap_roles->leer(null, 1));
}