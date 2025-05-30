<?php

include_once '../modelos/CL_Base.php';

class CL_im_bodeg {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {

                $this->sentencia = "SELECT im_bodeg.cod_bodega,UPPER(CONCAT(nom_bodega,' - ',np_ciudades.nom_ciudad)) as nom_bodega_ciudad "
                        . "FROM im_bodeg,np_ciudades "
                        . "WHERE im_bodeg.ciudad_bodega=np_ciudades.id_ciudad "
                        ."AND im_bodeg.estado_bodeg=78 "
                        ."ORDER BY im_bodeg.cod_bodega;";                        

                /*echo $this->sentencia;
                exit();*/
            }
            
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

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
