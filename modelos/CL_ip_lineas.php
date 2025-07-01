<?php

include_once '../modelos/CL_Base.php';

class CL_ip_lineas {
    
    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if($opcion===1){
                $this->sentencia="select ip_lineas.id_linea,UPPER(ip_lineas.descrip) as descrip "
                        . "from ip_lineas;";
            }
            
            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);            
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
//
//    public function crear($datos, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into am_usuarios (codusr,nombre,nit,email,paswd,id_rol,estado,grabador,fec_graba,foto) values "
//                        . "('" . $datos["codusr"] . "','" . $datos["nombre"] . "','" . $datos["nit"] . "','" . $datos["email"] . "','" . $datos["paswd"] . "'," . $datos["id_rol"] . "," . $datos["estado"] . ",'" . $datos["grabador"] . "','" . $datos["fec_graba"] . "','" . $datos["foto"] . "');";
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
