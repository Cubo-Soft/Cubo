<?php

include_once '../modelos/CL_Base.php';

class CL_np_paises {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select id_pais,nom_pais "
                        . "from np_paises "
                        . "order by np_paises.nom_pais;";
            }

            if ($opcion === 2) {
                $this->sentencia = "select id_pais,nom_pais "
                        . "from np_paises "
                        . "where id_ciudad=" . $datos["id_ciudad"] . " "
                        . "order by np_paises.nom_pais;";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function actualizar($data, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "update ap_permpro "
//                        . "set estado=" . $data["estado"] . " "
//                        . "where id_permpro=" . $data["id_permpro"] . ";";
//            }
//            //echo $this->sentencia; exit();
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
//
//    public function crear($data, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into ap_permpro (id_permpro,codprog,permpro,estado) values "
//                        . "(null,'" . $data["codprog"] . "','" . $data["permpro"] . "'," . $data["estado"] . ");";
//            }
//            
//            //echo $this->sentencia; exit();
//            
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
