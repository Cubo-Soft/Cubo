<?php

include_once '../modelos/CL_Base.php';

class CL_np_ciudades {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select id_ciudad,nom_ciudad "
                        . "from np_ciudades "
                        . "where id_pais=" . $datos["id_pais"] . " "
                        . "order by np_ciudades.nom_ciudad;";
            }
            if ($opcion === 2) {
                $this->sentencia = "select id_ciudad,concat(np_ciudades.nom_ciudad,' , ',UPPER(np_deptos.nom_dpto),' , ',np_paises.nom_pais) nom_ciudad "
                        . "from np_ciudades,np_deptos,np_paises "
                        . "where np_paises.id_pais=np_deptos.id_pais "
                        . "and np_deptos.id_dpto=np_ciudades.id_dpto "
                        . "order by np_ciudades.nom_ciudad;";
            }

            if ($opcion === 3) {

                $this->sentencia = "select id_ciudad,concat(np_ciudades.nom_ciudad,' , ',UPPER(np_deptos.nom_dpto),' , ',np_paises.nom_pais) nom_ciudad "
                        . "from np_ciudades,np_deptos,np_paises "
                        . "where np_paises.id_pais=np_deptos.id_pais "
                        . "and np_deptos.id_dpto=np_ciudades.id_dpto "
                        . "and np_ciudades.id_ciudad=" . $datos["id_ciudad"] . ""
                        . "order by np_ciudades.nom_ciudad;";
            }

            if ($opcion === 4) {
                $this->sentencia = "select * "
                        . "from np_ciudades "
                        . "where np_ciudades.id_ciudad=" . $datos["id_ciudad"] . ";";
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
