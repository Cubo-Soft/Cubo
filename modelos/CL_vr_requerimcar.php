<?php

include_once '../modelos/CL_Base.php';

class CL_vr_requerimcar {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * "
                        . "from vr_requerimcar "
                        . "where id_requerim=" . $datos["id_requerim"] . " "
                        . "and id_reqdet=" . $datos["id_reqdet"] . ";";
            }

            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function borrar($datos, $opcion) {
        try {

            if ($opcion === 1) {
                $this->sentencia = "delete from vr_requerimcar where id_reqdet=" . $datos["id_reqdet"] . ";";
            }

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia="insert into vr_requerimcar (id_reqcar,id_requerim,id_reqdet,caract,vr_caract) "
                        . "values (null,".$datos["id_requerim"].",".$datos["id_reqdet"].",'".$datos["caract"]."','".$datos["vr_caract"]."')";
            }
            //echo $this->sentencia;             
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update **** set ";
//            if ($opcion === 1) {
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
