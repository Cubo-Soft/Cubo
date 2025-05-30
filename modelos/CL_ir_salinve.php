<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ir_salinve {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {

                $this->sentencia = "SELECT saldo "
                        . "FROM ir_salinve "
                        . "WHERE cod_item='" . $datos["cod_item"] . "' "
                        . "AND codbodeg=1;";

                //echo $this->sentencia;
                //exit();
            }

            if($opcion===2){
                $this->sentencia="SELECT ir_salinve.cod_item,CAST(ir_salinve.saldo AS INT) as saldo,ir_salinve.codbodeg,"
                ."UPPER(im_bodeg.nom_bodega) as nom_bodega,np_ciudades.nom_ciudad,"
                ."ir_salinve.fecha_arribo,"
                ."(SELECT CONCAT(nm_personas.nombres,' ',nm_personas.apellidos) FROM nm_personas WHERE nm_personas.numid=ir_salinve.numid) as nombreEmpleado,"
                ."(WEEK(ir_salinve.fecha_arribo)-WEEK(CURDATE())) as semanas_arribo "
                ."FROM ir_salinve,im_bodeg,np_ciudades "
                ."WHERE ir_salinve.codbodeg=im_bodeg.cod_bodega "
                ."AND im_bodeg.ciudad_bodega=np_ciudades.id_ciudad "
                ."AND ir_salinve.cod_item='" . $datos["cod_item"] . "' "
                ."AND im_bodeg.cod_bodega<>1;";
            }

            if($opcion===3){
                $this->sentencia="SELECT * FROM ir_salinve WHERE ir_salinve.cod_item like '%".$datos["cod_item"]."%' GROUP BY ir_salinve.cod_item;";
            }

            if($opcion===4){
                $this->sentencia=IRSALINVE1
                ."AND ir_salinve.cod_item ='".$datos["cod_item"]."';";
            }

            if($opcion===5){
                $this->sentencia=IRSALINVE1
                ."AND ir_salinve.cod_item ='".$datos["cod_item"]."' "
                ."AND ir_salinve.codbodeg=".$datos["codbodeg"].";";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function crear($datos, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into am_usuarios (codusr,nombre,nit,email,paswd,id_rol,estado,grabador,fec_graba,foto) values "
//                        . "('" . $datos["codusr"] . "','" . $datos["nombre"] . "','" . $datos["nit"] . "','" . $datos["email"] . "','" . $datos["paswd"] . "'," . $datos["id_rol"] . "," . $datos["estado"] . ",'" . $datos["grabador"] . "','" . $datos["fec_graba"] . "','" . $datos["foto"] . "');";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
//
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update am_usuarios set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "paswd='" . $datos["paswd"] . "' ";
//                $this->sentencia .= "where codusr='" . $datos["codusr"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
