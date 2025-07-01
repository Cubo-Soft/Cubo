<?php

include_once '../modelos/CL_Base.php';

class CL_ip_marcas {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select id_marca,UPPER(nom_marca) as nom_marca "
                        . "from ip_marcas; ";                        
            }           
            
            if ($opcion === 2) {
                $this->sentencia = "select id_marca,UPPER(nom_marca) as nom_marca "
                        . "from ip_marcas "
                        . "where id_marca=".$datos["id_marca"].";";                        
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
