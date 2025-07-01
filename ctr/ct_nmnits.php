<?php
session_start();
$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
if($motor=="my"){
    include_once(C."/cls/clsBdmy.php");
}

$odb = new Bd($h,$pto,$u,$p,$d);
$nits = new Tabla($odb,"nm_nits");
$sucursales = new Tabla($odb,"nm_sucursal");
$personas = new Tabla($odb,"nm_personas");
$juridicas = new Tabla($odb,"nm_juridicas");
$entidad = $_REQUEST['entidad'];
//($entidad = $_POST['tipo_entidad'];
if($entidad != ""){
    $opcion = "";
    if($entidad != "0"){
        $opcion = " AND n.tipo_entidad=".$entidad;
    }
    $sql = "SELECT n.numid, n.idclase,n.tipo_per,s.id_sucursal ,p.apelli_nom , j.razon_social,
        '' AS nom_provee 
        FROM nm_sucursal s,nm_nits n LEFT JOIN nm_personas p ON p.numid=n.numid 
        LEFT JOIN nm_juridicas j ON j.numid = n.numid WHERE s.numid=n.numid".$opcion;
    $a_prov = $nits->ejec($sql,"S","A");
    $a_prv = [];
    for($x=0;$x<count($a_prov);$x++){
        if(trim($a_prov[$x]['razon_social'])=="" && trim($a_prov[$x]['apelli_nom'])==""){
            continue;
        }
        $a_prv[$x] = [];
        $a_prv[$x]['numid'] = $a_prov[$x]['numid']; 
        if(trim($a_prov[$x]['razon_social'])==""){
            $a_prv[$x]['nom_provee'] = $a_prov[$x]['apelli_nom'];
        }else{
            $a_prv[$x]['nom_provee']= $a_prov[$x]['razon_social'];
        }
    }
    
    $a_aux = [];
    foreach($a_prv AS $clave=>$valor){
        $a_aux[$clave] = strtolower($valor['nom_provee']);
    }
    array_multisort($a_aux,SORT_ASC,$a_prv); 
    echo json_encode($a_prv);
}
?>