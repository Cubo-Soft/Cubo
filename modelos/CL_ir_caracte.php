<?php

include_once '../modelos/CL_Base.php';

class CL_ir_caracte {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "SELECT r.codgrup,r.codcarac,p.desccarac "
                        . "FROM ir_caracte r, ip_caracte p "
                        . "WHERE r.codgrup='" . $datos["codgrup"] . "' "
                        . "AND p.codcarac=r.codcarac;";
            }

            if ($opcion === 2) {
                $this->sentencia = "SELECT ip_caracte.desccarac "
                        . "FROM ir_caracte,ip_caracte "
                        . "WHERE ir_caracte.codcarac=ip_caracte.codcarac "
                        . "AND ir_caracte.codgrup='" . $datos["codgrup"] . "' "
                        . "AND ir_caracte.codcarac='" . $datos["codcarac"] . "';";
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
//                $this->sentencia = "insert into ip_articulos (id_articulo,descrip) values "
//                        . "('" . $datos["id_articulo"] . "','" . $datos["descrip"] . "');";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
//
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update ip_articulos set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "descrip='" . $datos["descrip"] . "' ";
//                $this->sentencia .= "where id_articulo='" . $datos["id_articulo"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
