<?php

include_once '../modelos/CL_np_ciudades.php';

$OB_np_ciudades=new CL_np_ciudades();

if($_POST["caso"]==='1'){
    
    $datos["id_pais"]=$_POST["datosAEnviar"]["id_pais"];    
    echo json_encode($OB_np_ciudades->leer($datos, 1));
}

if($_POST["caso"]==='2'){    
    echo json_encode($OB_np_ciudades->leer(null, 2));
}

if($_POST["caso"]==='3'){    
    $datos["id_pais"]=$_POST["datosAEnviar"]["id_ciudad"];    
    echo json_encode($OB_np_ciudades->leer(null, 2));
}