<?php

include_once '../modelos/CL_Base.php';

class CL_ap_permpro {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from ap_permpro;";
            }

            if ($opcion === 2) {
                $this->sentencia = "select * "
                        . "from ap_permpro "
                        . "where codprog='" . $datos["codprog"] . "';";
            }

            if ($opcion === 3) {
                $this->sentencia = " select * "
                        . "from ap_permpro "
                        . "where permpro='" . $datos["permpro"] . "' "
                        . "and codprog='" . $datos["codprog"] . "';";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "update ap_permpro "
                        . "set estado=" . $data["estado"] . " "
                        . "where id_permpro=" . $data["id_permpro"] . ";";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ap_permpro (id_permpro,codprog,permpro,estado) values "
                        . "(null,'" . $data["codprog"] . "','" . $data["permpro"] . "'," . $data["estado"] . ");";
            }
            
            //echo $this->sentencia; exit();
            
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
