<?php

include_once '../modelos/CL_Base.php';

class CL_nm_compleme {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * from nm_compleme where numid=" . $datos["numid"] . ";";
            }
            if ($opcion === 2) {
                $this->sentencia = "select * from nm_compleme where id_comple=" . $datos["id_comple"] . ";";
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
                $this->sentencia = "insert into nm_compleme (id_comple,numid,credito,factu_despacho,docs_pra_facturar,cierre_factu,area_contacto) values "
                        . "(null,'" . $datos["numid"] . "','" . $datos["credito"] . "','" . $datos["factu_despacho"] . "','" . $datos["docs_pra_facturar"] . "','" . $datos["cierre_factu"] . "','" . $datos["area_contacto"] . "');";
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
            $this->sentencia = "update nm_compleme set ";
            if ($opcion === 1) {
                $this->sentencia .= "credito='" . $datos["credito"] . "',";
                $this->sentencia .= "factu_despacho='" . $datos["factu_despacho"] . "',";
                $this->sentencia .= "docs_pra_facturar='" . $datos["docs_pra_facturar"] . "',";
                $this->sentencia .= "cierre_factu='" . $datos["cierre_factu"] . "',";
                $this->sentencia .= "area_contacto='" . $datos["area_contacto"] . "' ";
                $this->sentencia .= "where id_comple=" . $datos["id_comple"] . ";";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
