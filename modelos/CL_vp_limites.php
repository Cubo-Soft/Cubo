<?php

include_once '../modelos/CL_Base.php';

class CL_vp_limites {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select vp_limites.minimo,vp_limites.maximo "
                ."from vp_limites "
                ."where id_rol=".$datos["id_rol"].";";
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
//                
//            }
//            //echo $this->sentencia; exit();
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

//    public function actualizar($datos, $opcion) {
//        try {
//       
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
