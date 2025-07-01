<?php

include_once '../modelos/CL_ap_programs.php';

$OB_ap_programs=new CL_ap_programs();

/*
 * 2023 08 29 retorna todos los programas a la función 
 * ../js/modelos/ap_programs 
 * funcion retornarAPPrograms(opcion)
 */
if($_POST["caso"]==='1'){
    echo json_encode($OB_ap_programs->leer(null, 3));
}