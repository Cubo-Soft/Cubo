<?php

include_once '../modelos/CL_ar_roles.php';

$OB_ar_roles = new CL_ar_roles();

/*
 * proviene de ../js/modelos/ar_roles.js function cambiarARRoles(opcion, id) {
 * retorna uno se creó o actualizó un registro, cero para error
 */

if($_POST["caso"]==='1'){
    
    $retorno=array();
    
    $datos["id_rol"]=$_POST["datosAEnviar"]["id_rol"];
    $datos["id_permpro"]=$_POST["datosAEnviar"]["id_permpro"];
    $datos["estado"]=$_POST["datosAEnviar"]["estado"];
    
    if($_POST["datosAEnviar"]["condicion"]==='a'){
        $retorno[0]=1;        
        $retorno[1]=$OB_ar_roles->actualizar($datos, 1);
    }
    
    if($_POST["datosAEnviar"]["condicion"]==='c'){
        $retorno[0]=0;        
        $retorno[1]=$OB_ar_roles->crear($datos, 1);
    }
    
    echo json_encode($retorno);
}


/*
 * viene de ar_roles.js funtion retornarARRoles opcion 2
 * retorna los permisos del módulo según el rol
 */
if($_POST["caso"]==='2'){
    
    $datos["id_rol"]=$_POST["datosAEnviar"]["id_rol"];
    $datos["codprog"]=$_POST["datosAEnviar"]["codprog"];    
    
    echo json_encode($OB_ar_roles->leer($datos, 2));
}