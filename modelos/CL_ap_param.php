<?php

include_once '../modelos/CL_Base.php';

class CL_ap_param {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select ap_param.variable,ap_param.descrip,ap_param.valor from ap_param;";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function crear($data, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into ap_opc_permi (id_rrol,id_rol,id_permpro) values "
//                        . "(" . $data["id_rrol"] . "," . $data["id_rol"] . "," . $data["id_permpro"] . ");";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

}
