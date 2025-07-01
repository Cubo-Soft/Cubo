<?php

include_once '../modelos/CL_conexion.php';

class CL_Base {

    public $conexion, $sentencia, $retorno;

    public function crear($sentencia) {
        try {
            $this->conexion = new CL_conexion();
            $this->retorno = $this->conexion->retornarUltimoIdCreado($sentencia);
            $this->conexion = null;
            return $this->retorno;
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function leer($sentencia) {
        try {
            $this->conexion = new CL_conexion();
            $this->retorno = $this->conexion->retornar($sentencia);            
            $this->conexion = null;
            return $this->retorno;            
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($sentencia) {
        try {
            $this->conexion = new CL_conexion();
            $this->retorno = $this->conexion->ejecutarInsertUpdateDelete($sentencia);
            $this->conexion = null;
            return $this->retorno;
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function borrar($sentencia) {
        try {
            $this->conexion = new CL_conexion();
            $this->retorno = $this->conexion->ejecutarInsertUpdateDelete($sentencia);
            $this->conexion = null;
            return $this->retorno;
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ejecutarPA($sentencia) {
        try {
            $this->conexion = new CL_conexion();
            $this->retorno = $this->conexion->ejecutarInsertUpdateDelete($sentencia);
            $this->conexion = null;
            return $this->retorno;
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
