<?php

include_once '../modelos/CL_im_bodeg.php';

$OB_im_bodeg=new CL_im_bodeg();

if ($_POST["caso"] === '1') {
        
    echo json_encode($OB_im_bodeg->leer(null,1));
    
}
