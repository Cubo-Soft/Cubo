<?php

include_once '../modelos/CL_Base.php';

class CL_vm_dsctos_especiales {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia="select `vm_dsctos_especiales`.`dscto_%` "
                        . "from `vm_dsctos_especiales` "
                        . "where `vm_dsctos_especiales`.`cliente`='".$datos["cliente"]."';";                        
            }
                        
            //echo $this->sentencia; exit();
            
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    // public function crear($datos, $opcion) {
    //     try {
    //         if ($opcion === 1) {

    //         }
    //         //echo $this->sentencia; exit();
    //         $OB_CL_Base = new CL_Base();
    //         return $OB_CL_Base->crear($this->sentencia);
    //     } catch (PDOException $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }
//
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update am_usuarios set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "paswd='" . $datos["paswd"] . "' ";
//                $this->sentencia .= "where codusr='" . $datos["codusr"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

}
