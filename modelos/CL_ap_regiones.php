<?php

include_once '../modelos/CL_Base.php';

class CL_ap_regiones {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select ap_regiones.id_region,UPPER(ap_regiones.nom_region) nom_region "                        
                        . "from ap_regiones";
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
                $this->sentencia = "insert into ap_regiones (id_region,nom_region,cubrimiento,estado) values "
                        . "(null,'" . $datos["nom_region"] . "','" . $datos["cubrimiento"] . "',76);";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion) {
        try {
            $this->sentencia = "update ap_regiones set ";
            if ($opcion === 1) {
                $this->sentencia .= "nom_region='" . $datos["nom_region"] . "',";
            }

            if ($opcion === 2) {
                $this->sentencia .= "cubrimiento='" . $datos["cubrimiento"] . "',";
            }

            $this->sentencia .= "estado=" . $datos["estado"] . " ";
            $this->sentencia .= "where id_region='" . $datos["id_region"] . "';";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
