<?php

include_once '../modelos/CL_Base.php';

class CL_cm_trm {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from cm_trm where fecha='" . $datos["fecha"] . "' and id_moneda=35;";
            }

            if ($opcion === 2) {
                $this->sentencia = "select * from cm_trm where fecha BETWEEN '" . $datos["fecha1"] . "' and  '" . $datos["fecha2"] . "' "
                ."order by fecha desc";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into cm_trm (id_moneda,fecha,trm) "
                        . "values(" . $datos["id_moneda"] . ",'" . $datos["fecha"] . "'," . $datos["trm"] . ")";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

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
