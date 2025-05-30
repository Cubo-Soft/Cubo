<?php

include_once '../modelos/CL_Base.php';
include_once '../adicionales/varios.php';

$OB_cl_base=new CL_Base();

$sentencia="SELECT n.numid,s.id_sucursal,s.direccion,s.ciudad,c.nom_ciudad,s.id_region,"
."(SELECT nm_juridicas.razon_social  FROM nm_juridicas WHERE nm_juridicas.numid=n.numid) as juridica,"
."(SELECT nm_personas.apelli_nom FROM nm_personas WHERE nm_personas.numid=n.numid ) as persona "
."FROM nm_nits n,nm_sucursal s,np_ciudades c "
."WHERE n.tipo_entidad<>109 "
."and s.numid=n.numid "
."and s.ciudad=c.id_ciudad "
."and s.pais=7 "
//esto va a cambiar para que responda a la tabla ip_dtbasicos 
//."and s.estado=33 " 
."and s.estado=1 " 
."and n.stdnit=32 " 
."and (s.id_region='010201' or s.id_region='');";

$data=$OB_cl_base->leer($sentencia);

echo retornarCabeceraInicial("Cubo");

//header("Location: listado.php");

echo '<input type="button" value="Recargar" onclick="location.reload()" class="btn btn-info"/>';

echo ' Cantidad de registros: '.count($data);

$tabla='<table class="table table-sm">';
$tabla.='<thead>';
$tabla.='<tr>';
$tabla.='<th></th><th>Nombre</th><th>Dirección</th><th>Ciudad</th><th>ID Sucursal</th><th>ID</th>';
$tabla.='</tr>';
$tabla.='</thead>';
$tabla.='<tbody>';

for($a=0;$a<count($data);$a++){
    $tabla.='<tr>';

    if($data[$a]["juridica"]===null){
        $tabla.='<td>'.($a+1).'</td><td>'.$data[$a]["persona"].'</td><td>'.$data[$a]["direccion"].'</td><td>'.$data[$a]["nom_ciudad"].'</td><td>'.$data[$a]["id_sucursal"].'</td><td><a href="admon_clie.php?numid='.$data[$a]["numid"].'">'.$data[$a]["numid"].'</a></td>';
    }else{
        $tabla.='<td>'.($a+1).'</td><td>'.$data[$a]["juridica"].'</td><td>'.$data[$a]["direccion"].'</td><td>'.$data[$a]["nom_ciudad"].'</td><td>'.$data[$a]["id_sucursal"].'</td><td><a href="admon_clie.php?numid='.$data[$a]["numid"].'">'.$data[$a]["numid"].'</a></td>';
    }

    
    $tabla.='</tr>';
}

$tabla.='</tbody>';

$tabla.='</table>';

echo $tabla;
