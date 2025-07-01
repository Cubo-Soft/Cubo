<?php

include_once '../modelos/CL_Base.php';
include_once '../adicionales/varios.php';
include_once '../modelos/consultas_constantes.php';

class CL_nm_nits {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            
            if ($opcion === 1) {
                
                $digito_verificacion = calcularDigitoVerificacion($datos["numid"]);                
                $this->sentencia = "select * "
                        . "from nm_nits "
                        . "where nm_nits.numid='" . $datos["numid"] . "' "
                        . "and dv=" . $digito_verificacion . ";";
            }

            if ($opcion === 2) {
                $this->sentencia = GRUPONITS1;
                $this->sentencia .= "AND nm_contactos.id_contacto=" . $datos["id_contacto"] . ";";
            }

            if ($opcion === 3) {
                $this->sentencia = "select * "
                        . "from nm_nits "
                        . "where nm_nits.numid like '%" . $datos["numid"] . "%';";
            }

            if ($opcion === 4) {
                $this->sentencia = "select * "
                        . "from nm_nits "
                        . "where nm_nits.numid='" . $datos["numid"] . "';";
            }

            if ($opcion === 5) {
                $this->sentencia = "SELECT * "
                        . "FROM nm_contactos,nm_sucursal,nm_nits "
                        . "WHERE nm_contactos.id_sucursal=nm_sucursal.id_sucursal "
                        . "AND nm_sucursal.numid=nm_nits.numid "
                        . "AND nm_contactos.id_contacto=" . $datos["id_contacto"] . ";";
            }

            if ($opcion === 6) {
                $this->sentencia="SELECT CASE "
                ."WHEN nm_personas.apelli_nom IS NOT NULL THEN nm_personas.apelli_nom "
                ."ELSE nm_juridicas.razon_social "
                ."END AS nombre_persona,nm_nits.numid "
                ."FROM nm_nits "
                ."LEFT JOIN nm_personas ON nm_personas.numid=nm_nits.numid "
                ."LEFT JOIN nm_juridicas ON nm_juridicas.numid=nm_nits.numid "                 
                ."WHERE nm_personas.apelli_nom LIKE '%".$datos["nombre_persona"]."%' OR nm_juridicas.razon_social LIKE '%".$datos["nombre_persona"]."%'";
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
                $this->sentencia = "insert into nm_nits (numid,dv,idclase,stdnit,tipo_per,actividad,tipo_entidad) values "
                        . "('" . $datos["numid"] . "'," . $datos["dv"] . "," . $datos["idclase"] . "," . $datos["stdnit"] . "," . $datos["tipo_per"] . ",'" . $datos["actividad"] . "'," . $datos["tipo_entidad"] . ");";
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
            $this->sentencia = "update nm_nits set ";
            if ($opcion === 1) {
                $this->sentencia .= "stdnit=" . $datos["stdnit"] . ",actividad='" . $datos["actividad"] . "' ";
                $this->sentencia .= "where numid='" . $datos["numid"] . "';";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
