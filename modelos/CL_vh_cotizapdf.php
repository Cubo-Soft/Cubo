<?php

include_once '../modelos/CL_Base.php';

class CL_vh_cotizapdf {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if($opcion===1){                
                $this->sentencia = "select * "
                        . "from vh_cotizapdf "
                        . "where nro_cot=" . $datos["nro_cot"] . " "
                        . "and version=" . $datos["version"] . ";";                
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
                $this->sentencia="insert into vh_cotizapdf (nro_cot,version,cod_grabador,fechora_pdf) "
                        . "values(".$datos["nro_cot"].",".$datos["version"].",'".$datos["cod_grabador"]."','".$datos["fechora_pdf"]."');";
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
