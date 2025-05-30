<?php

include_once '../modelos/CL_vr_requerimdet.php';
include_once '../modelos/CL_vr_requerimcar.php';
include_once '../modelos/CL_Base.php';

$OB_vr_requerimdet = new CL_vr_requerimdet();
$OB_vr_requerimcar = new CL_vr_requerimcar();

$retorno = array();

if ($_POST["caso"] === '1') {

    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["misional"] = $_POST["datosAEnviar"]["misional"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"][0];
    $datos["tipo"] = $_POST["datosAEnviar"]["tipo"][0];
    $datos["marca"] = $_POST["datosAEnviar"]["marca"][0];
    $datos["cod_item"] = $_POST["datosAEnviar"]["cod_item"];
    $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];
    $datos["observs"] = $_POST["datosAEnviar"]["observs"];

    $retorno["vr_requerimdet"] = $OB_vr_requerimdet->crear($datos, 1);

    if (isset($_POST["datosAEnviar"]["caracteristicasRepuestos"])) {

        for ($index = 0; $index < count($_POST["datosAEnviar"]["caracteristicasRepuestos"]); $index++) {

            $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
            $datos["id_reqdet"] = $retorno["vr_requerimdet"];
            $datos["vr_caract"] = $_POST["datosAEnviar"]["caracteristicasRepuestos"][$index];
            $datos["caract"] = $_POST["datosAEnviar"]["arregloCaracteristicas"][$index];
            $retorno["vr_requerimcar"][$index] = $OB_vr_requerimcar->crear($datos, 1);
        }
    }

    echo json_encode($retorno);
}

if ($_POST["caso"] === '2') {

    $datos["id_reqdet"] = $_POST["datosAEnviar"]["id_reqdet"];

    if(isset($_POST["datosAEnviar"]["id_requerim"])){
        $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    }
    
    $retorno["vr_requerimcar"] = $OB_vr_requerimcar->borrar($datos, 1);
    $retorno["vr_requerimdet"] = $OB_vr_requerimdet->borrar($datos, 1);
    echo json_encode($retorno);
}

if ($_POST["caso"] === '3') {

    $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
    $datos["linea"] = $_POST["datosAEnviar"]["linea"];
    $datos["misional"] = $_POST["datosAEnviar"]["misional"];
    $datos["articulo"] = $_POST["datosAEnviar"]["articulo"];
    $datos["tipo"] = $_POST["datosAEnviar"]["tipo"];
    $datos["marca"] = $_POST["datosAEnviar"]["marca"];
    $datos["cantidad"] = $_POST["datosAEnviar"]["cantidad"];
    $datos["observs"] = $_POST["datosAEnviar"]["observs"];
    $datos["cod_item"] = 0;

    $retorno["vr_requerimdet"] = $OB_vr_requerimdet->crear($datos, 1);

    for ($index = 0; $index < count($_POST["datosAEnviar"]["caracteristicas"]); $index++) {

        $datos["id_requerim"] = $_POST["datosAEnviar"]["id_requerim"];
        $datos["id_reqdet"] = $retorno["vr_requerimdet"];        
        $datos["vr_caract"] = $_POST["datosAEnviar"]["valoresCaracteristicas"][$index];
        $datos["caract"] = $_POST["datosAEnviar"]["caracteristicas"][$index];
        $retorno["vr_requerimcar"][$index] = $OB_vr_requerimcar->crear($datos, 1);
    }

    echo json_encode($retorno);
}

if($_POST["caso"]==='4'){

    $datos["a_compras"]=$_POST["datosAEnviar"]["a_compras"];
    $datos["id_reqdet"]=$_POST["datosAEnviar"]["id_reqdet"];   
    echo json_encode($OB_vr_requerimdet->actualizar($datos,1));

}

if($_POST["caso"]==='5'){    
    $datos["id_requerim"]=$_POST["datosAEnviar"]["id_requerim"];
    $sentencia="CALL spListaRequerim(".$datos["id_requerim"].")";
    //echo $sentencia;
    $OB_CL_Base = new CL_Base();

    try{
        echo json_encode($OB_CL_Base->ejecutarPA($sentencia));
    }catch(error){
        echo json_encode($OB_CL_Base->ejecutarPA($sentencia));
    }    
}

if($_POST["caso"]==='6'){

    $datos["id_reqdet"]=$_POST["datosAEnviar"]["id_reqdet"];
    $datos["modo_import"]=$_POST["datosAEnviar"]["modo_import"];

    echo json_encode($OB_vr_requerimdet->actualizar($datos,2));

}