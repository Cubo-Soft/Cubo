<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ip_dtbasicos {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {

            if ($opcion === 1) {
                $this->sentencia = DTBASICOS1;
            }

            if ($opcion === 2) {
                $this->sentencia = DTBASICOS1;
                $this->sentencia .= "where id_basico=" . $datos["id_basico"] . ";";                
            }

            if($opcion===3){
                $this->sentencia=DTBASICOS1;
                $this->sentencia.="where ip_dtbasicos.estado=1 and id_basico=" . $datos["id_basico"] . ";";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion) {
        try {
            $this->sentencia = "update ip_dtbasicos set ";
            if ($opcion === 1) {
                $this->sentencia .= "estado=" . $datos["estado"] . " ";                
            }

            if ($opcion === 2) {
                $this->sentencia .= "dt_basico='" . $datos["dt_basico"] . "' ";                
            }

            $this->sentencia .= "where sec_basico=" . $datos["sec_basico"] . ";";

            //echo $this->sentencia;exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ip_dtbasicos (id_basico,estado,dt_basico,sec_basico) values "
                        . "(" . $datos["id_basico"] . ",1,'" . $datos["dt_basico"] . "',null);";
            }

            //echo $this->sentencia;exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
