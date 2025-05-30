<?php

include_once '../modelos/CL_Base.php';

class CL_ap_subzonas {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "SELECT ap_subzonas.id_subzona,ap_subzonas.nom_subzona,ap_subzonas.estado,"
                        . "ap_zonas.nom_zona,UPPER(concat(ap_regiones.nom_region,' / ',ap_zonas.nom_zona,' / ',ap_subzonas.nom_subzona)) as nombreCompleto "
                        . "FROM ap_regiones,ap_subzonas,ap_zonas "
                        . "WHERE ap_regiones.id_region=ap_zonas.region "
                        . "AND ap_zonas.id_zona=ap_subzonas.id_zona "
                        //."AND ap_regiones.id_region=" . $datos["id_region"] . " "
                        . "AND ap_regiones.id_region <> 3 "
                        . "AND ap_subzonas.estado=80;";
            }

            if ($opcion === 2) {
                $this->sentencia = "select ap_subzonas.id_subzona,ap_subzonas.id_zona,"
                        . "UPPER(ap_subzonas.nom_subzona) as nom_subzona,ap_subzonas.estado as estadoSubZona,"
                        . "ap_zonas.estado as estadoZona "
                        . "from ap_subzonas,ap_zonas "
                        . "where ap_subzonas.id_zona=ap_zonas.id_zona "
                        . "AND ap_zonas.id_zona=" . $datos["id_zona"] . "";
                //echo $this->sentencia;
            }

            if ($opcion === 3) {
                $this->sentencia = "select * "
                        . "from ap_subzonas "
                        . "where ap_subzonas.id_subzona=" . $datos["id_subzona"] . ";";
            }

            if ($opcion === 4) {
                $this->sentencia = "SELECT UPPER(ap_subzonas.nom_subzona) as nom_subzona,ap_subzonas.id_subzona "
                        . "FROM ap_subzonas;";
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
                $this->sentencia = "insert into ap_subzonas (id_subzona,id_zona,nom_subzona,estado) "
                        . "values (null," . $datos["id_zona"] . ",'" . $datos["nom_subzona"] . "'," . $datos["estado"] . ")";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion) {
        try {
            $this->sentencia = "update ap_subzonas set ";

            if ($opcion === 1) {
                $this->sentencia .= "id_zona=" . $datos["id_zona"] . ",";
                $this->sentencia .= "nom_subzona=" . $datos["nom_subzona"] . " ";
                $this->sentencia .= "estado=" . $datos["estado"] . " ";
            }
            if ($opcion === 2) {
                $this->sentencia .= "id_zona=" . $datos["id_zona"] . ",";
                $this->sentencia .= "estado=" . $datos["estado"] . " ";
            }
            $this->sentencia .= "where id_subzona='" . $datos["id_subzona"] . "';";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
