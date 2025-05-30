<?php

include_once '../modelos/CL_Base.php';

class CL_ap_zonas {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select ap_zonas.id_zona,UPPER(ap_zonas.nom_zona) as nom_zona,"
                        . "ap_zonas.region,ap_zonas.estado as estadoZona,ap_regiones.estado as estadoRegion "
                        . "from ap_regiones,ap_zonas "
                        . "where ap_regiones.id_region=ap_zonas.region "
                        . "AND ap_zonas.region=" . $datos["region"] . " ";
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
                $this->sentencia = "insert into ap_zonas (id_zona,nom_zona,region,estado) values "
                        . "(null,'" . $datos["nom_zona"] . "','" . $datos["region"] . "',78);";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion) {
        try {
            $this->sentencia = "update ap_zonas set ";
            if ($opcion === 1) {
                $this->sentencia .= "nom_zona='" . $datos["nom_zona"] . "',";
                $this->sentencia .= "region=" . $datos["region"] . ",";
                $this->sentencia .= "estado=" . $datos["estado"] . " ";
            }

            if ($opcion === 2) {
                $this->sentencia .= "estado=" . $datos["estado"] . " ";
            }

            $this->sentencia .= "where id_zona=" . $datos["id_zona"] . ";";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
