<?php

include_once '../modelos/CL_Base.php';

class CL_ip_basicos {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from ip_basicos;";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ip_basicos (id_basico,descrip) values "
                        . "(null,'" . $data["descrip"] . "');";
            }

            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "update ip_basicos set descrip='" . $data["descrip"] . "' "
                        . "where id_permpro=" . $data["id_basico"] . " ";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
