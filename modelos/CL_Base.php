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

    // // Prepara una consulta SQL daniel2025
    // public function preparar($sql)
    // {
    //     try {
    //         $this->conexion = new CL_conexion();
    //         $pdo = $this->conexion->getPDO();
    //         $this->stmt = $pdo->prepare($sql);
    //     } catch (PDOException $exc) {
    //         echo "Error en preparar: " . $exc->getMessage();
    //         $this->stmt = false;
    //     }
    // }

    // // Ejecuta la consulta preparada con parámetros opcionales daniel2025
    // public function ejecutar($params = [])
    // {
    //     try {
    //         if (!$this->stmt)
    //             return false;
    //         $this->retorno = $this->stmt->execute($params);
    //         return $this->retorno;
    //     } catch (PDOException $exc) {
    //         echo "Error en ejecutar: " . $exc->getMessage();
    //         return false;
    //     }
    // }

    // // Retorna el último id insertado daniel2025
    // public function ultimoId()
    // {
    //     try {
    //         if (!$this->conexion)
    //             return false;
    //         $pdo = $this->conexion->getPDO();
    //         return $pdo->lastInsertId();
    //     } catch (PDOException $exc) {
    //         echo "Error en ultimoId: " . $exc->getMessage();
    //         return false;
    //     }
    // }
}
