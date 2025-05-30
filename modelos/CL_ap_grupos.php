<?php

include_once '../modelos/CL_Base.php';

class CL_ap_grupos {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from ap_grupos;";
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
                $this->sentencia = "insert into ap_programs (codprog,nomprog,estado,path,grupo) values "
                        . "('" . $data["codprog"] . "','" . $data["nomprog"] . "'," . $data["estado"] . ",'" . $data["path"] . "','" . $data["grupo"] . ");";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
