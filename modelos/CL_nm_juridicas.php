<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_nm_juridicas {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * "
                        . "from nm_juridicas "
                        . "where nm_juridicas.numid like '%" . $datos["numid"] . "%';";
            }

            if ($opcion === 2) {
                $this->sentencia = GRUPONITS1;
                $this->sentencia .= "AND nm_juridicas.numid=" . $datos["numid"] . ";";
            }

            if ($opcion === 3) {
                $this->sentencia = GRUPONITS3 
                        . "and (nm_nits.tipo_entidad=73 OR nm_nits.tipo_entidad=74 OR nm_nits.tipo_entidad=70) "
                        ."and nm_juridicas.razon_social like '%" . $datos["razon_social"] . "%';";
            }

            if ($opcion === 4) {
                $this->sentencia = GRUPONITS1;
                $this->sentencia .= "AND nm_juridicas.razon_social='" . $datos["razon_social"] . "';";
            }

            if ($opcion === 5) {
                $this->sentencia = "select * "
                        . "from nm_juridicas "
                        . "where nm_juridicas.numid=" . $datos["numid"] . ";";
            }

            if($opcion===6){
                $this->sentencia = GRUPONITS2;
                $this->sentencia.="AND (nm_nits.tipo_entidad=70 OR nm_nits.tipo_entidad=71 or nm_nits.tipo_entidad=73 OR nm_nits.tipo_entidad=74) "
                ."AND nm_juridicas.razon_social like '%".$datos["razon_social"]."%'";
            }

            if ($opcion === 7) {
                $this->sentencia = GRUPONITS2;
                $this->sentencia.="AND (nm_nits.tipo_entidad=70 OR nm_nits.tipo_entidad=71 or nm_nits.tipo_entidad=73 OR nm_nits.tipo_entidad=74 ) "
                ."AND nm_juridicas.razon_social like '%".$datos["razon_social"]."%'";                
            }

            //echo $this->sentencia;exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into nm_juridicas (numid,razon_social) values "
                        . "('" . $datos["numid"] . "','" . $datos["razon_social"] . "');";
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
            $this->sentencia = "update nm_juridicas set ";
            if ($opcion === 1) {
                $this->sentencia .= "razon_social='" . $datos["razon_social"] . "' ";
                $this->sentencia .= "where numid='" . $datos["numid"] . "';";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
