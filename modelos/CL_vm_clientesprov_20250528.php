<?php

include_once '../modelos/CL_Base.php';

class CL_vm_clientesprov {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia="select nombre "
                        . "from vm_clientesprov "
                        . "where nombre like '%".$datos["nombre"]."%' "
                        . "order by vm_clientesprov.nombre";
            }
            
            if($opcion===2){
                $this->sentencia="select * "
                        . "from vm_clientesprov "
                        . "where nombre='".$datos["nombre"]."';";
            }
            
            if($opcion===3){
                $this->sentencia="select * "
                        . "from vm_clientesprov "
                        . "where nit_cliente='".$datos["nit_cliente"]."';";
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
                $this->sentencia = "insert into vm_clientesprov (id_provis,nit_cliente,nombre,direccion,telefono,email,contacto,grabador,fechora) values "
                        . "(null,'".$datos["nit_cliente"]."','".$datos["nombre"]."','".$datos["direccion"]."','".$datos["telefono"]."','".$datos["email"]."','".$datos["contacto"]."','".$datos["grabador"]."','".$datos["fechora"]."');";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
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
