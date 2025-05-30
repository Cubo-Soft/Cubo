<?php

include_once '../modelos/CL_Base.php';

class CL_vr_cotizcar {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if($opcion === 1) {
                $this->sentencia = "select * "
                    ."from vr_cotizcar "
                    ."where id_consecot=".$datos["id_consecot"]." "
                    ."and id_orden=".$datos["id_orden"].";";
            }

            if($opcion === 2) {
                $this->sentencia = "select * "
                    ."from vr_cotizcar "
                    ."where id_consecot=".$datos["id_consecot"].";";
            }

            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if($opcion === 1) {
                $this->sentencia = "insert into vr_cotizcar (id_consecot,id_orden,id_cotcar,caract,vr_caract) "
                    ."values(".$datos["id_consecot"].",".$datos["id_orden"].",null,'".$datos["caract"]."','".$datos["vr_caract"]."');";
            }
            //echo $this->sentencia; 
            //exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function borrar($datos, $opcion) {
        try {

            if($opcion === 1) {
                $this->sentencia = "delete from vr_cotizcar where id_orden=".$datos["id_orden"].";";
            }

            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion) {
        try {

            $this->sentencia = "update vr_cotizcar set ";

            if($opcion === 1) {
                $this->sentencia .= "vr_caract='".$datos["vr_caract"]."' ";
            }

            $this->sentencia .= "where id_cotcar=".$datos["id_cotcar"].";";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
