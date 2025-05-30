<?php

include_once '../modelos/CL_Base.php';

class CL_vp_asesor_zona {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select UPPER(am_usuarios.nombre) as nombre,vp_asesor_zona.asesor "
                ."from vp_asesor_zona,am_usuarios "
                ."where vp_asesor_zona.asesor=am_usuarios.grabador "                
                ."and vp_asesor_zona.region like '".$datos["region"]."%' "
                ."and vp_asesor_zona.linea like '".$datos["linea"]."%' "
                ."and vp_asesor_zona.codgrupo='".$datos["grupo"]."';";
            }

            if($opcion===2){                
                    $this->sentencia="select UPPER(am_usuarios.nombre) as nombre,vp_asesor_zona.asesor,am_usuarios.codusr "
                    ."FROM vp_asesor_zona,am_usuarios "
                    ."WHERE vp_asesor_zona.asesor=am_usuarios.codusr "
                    ."AND vp_asesor_zona.linea LIKE '".$datos["linea"]."' "
                    ."GROUP BY vp_asesor_zona.asesor;";
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
//                
//            }
//            //echo $this->sentencia; exit();
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

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
