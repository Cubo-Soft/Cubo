<?php

include_once '../modelos/CL_Base.php';

class CL_ap_tipoalerta {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "SELECT id_tipoalerta FROM ap_tipoalerta WHERE tabla_ini='".$datos["tabla_ini"]."' AND programa LIKE '%".$datos["programa"]."%';";
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
//                $this->sentencia = "insert  "
//                        . "();";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

}
