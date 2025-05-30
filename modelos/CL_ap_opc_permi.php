<?php

include_once '../modelos/CL_Base.php';

class CL_ap_opc_permi {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from ap_opc_permi;";
            }
            if ($opcion === 2) {
                $this->sentencia = "SELECT ap_permpro.id_permpro,ap_permpro.codprog,ap_permpro.permpro,"
                        . "ap_opc_permi.descrip , ar_roles.estado AS estado_perm_rol "
                        . "FROM ap_opc_permi,ap_permpro "
                        . "LEFT OUTER JOIN ar_roles ON ar_roles.id_permpro=ap_permpro.id_permpro "
                        . "AND ar_roles.id_rol=".$datos["id_rol"]." "
                        . "WHERE ap_opc_permi.cod_opcion=ap_permpro.permpro "
                        . "AND ap_permpro.codprog='".$datos["codprog"]."' "
                        . "ORDER BY ap_permpro.id_permpro;";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ap_opc_permi (cod_opcion,descrip) values "
                        . "('" . $data["cod_opcion"] . "','" . $data["descrip"] . "');";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    

}
