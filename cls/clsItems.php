<?php

include_once("clsTablam.php");

class clsItems extends Tabla{
 
    public function __construct($odb,$ntabla="im_items"){
        parent::__construct($odb,$ntabla);
    }
 
    public function leeCon($arr,$opcion=0){
        // $arr['linea']="-1",$arr['grupo']="-1",$arr['articulo']="-1",$arr['tipo']="-1",$arr['marca']="-1",$arr['modelo']="-1"
        $campos = "linea,grup_item,articulo,tipo_item,id_marca,modelo";
        $a_campos = explode(",",$campos);
        $where = " WHERE ";$va = 0; $son = count($arr);
        // SELECT id_linea,descrip FROM ip_lineas ORDER BY id_linea  // extrae lista de líneas
        // SELECT cod_grupo, nom_grupo FROM ip_grupos WHERE subdivide='S' ORDER BY cod_grupo // extrae lista de Misionales
        // SELECT cod_grupo, nom_grupo FROM ip_grupos WHERE subdivide='N' AND  // extrae segun Misional 01-equipo, 02-repuestos,etc.
        // cod_grupo LIKE ' %'     
        // ORDER BY cod_grupo
        foreach($arr AS $k => $v){
            $va += 1;
            if($v == "-1" ){ 
                continue;
            }
            $where .= $k." = ".$v;
            if($va < $son ){
                $where .= " AND ";
            }
        }
        $sql = " SELECT ".$a_campos[$opcion]." FROM ".$this->nomTabla.$where." GROUP BY ".$a_campos[$opcion];
        echo $sql;exit;
    }

}