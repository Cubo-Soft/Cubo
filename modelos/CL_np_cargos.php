<?php


include_once '../modelos/CL_Base.php';

class CL_np_cargos {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select np_cargos.id_cargo,UPPER(np_cargos.nom_cargo) as nom_cargo "                
                        . "from np_cargos;";                        
            }
           
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
            //print_r($OB_CL_Base->leer($this->sentencia));
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
