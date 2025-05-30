<?php

include_once '../modelos/CL_Base.php';

class CL_ar_roles {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from ar_roles;";
            }
            if ($opcion === 2) {
                $this->sentencia = "SELECT ap_permpro.permpro,ar_roles.estado "
                        . "FROM ap_permpro,ar_roles "
                        . "WHERE ap_permpro.id_permpro=ar_roles.id_permpro "
                        . "AND ar_roles.id_rol=".$datos["id_rol"]." "
                        . "AND ap_permpro.codprog='".$datos["codprog"]."';";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ar_roles (id_rrol,id_rol,id_permpro,estado) values "
                        . "(null," . $data["id_rol"] . "," . $data["id_permpro"] . ",1);";
            }

            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "update ar_roles set estado=" . $data["estado"] . " "
                        . "where id_permpro=" . $data["id_permpro"] . " "
                        . "and id_rol=" . $data["id_rol"] . ";";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
