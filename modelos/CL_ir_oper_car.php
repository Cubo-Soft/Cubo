<?php

include_once '../modelos/CL_Base.php';

class CL_ir_oper_car {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select  ";                        
            }

            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia="insert into ir_oper_car (id_operacion,id_detalle,id_detcar,caract,vr_caract) "
                        . "values (".["id_operacion"].",".["id_detalle"].",".["id_detcar"].",'".["caract"]."','".["vr_caract"]."')";
            }
            //echo $this->sentencia;             
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    // public function borrar($datos, $opcion) {
    //     try {
    //         if ($opcion === 1) {
    //             $this->sentencia = "delete from ;";
    //         }
    //         $OB_CL_Base = new CL_Base();
    //         return $OB_CL_Base->borrar($this->sentencia);
    //     } catch (PDOException $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }
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
