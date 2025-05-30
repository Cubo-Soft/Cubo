<?php

include_once 'parametros_conexion.php';

class CL_conexion {
    
    private $server = "mysql:host=localhost;dbname=" . BD . "";
    private $user = USER;
    private $pass = PASSWORD;
    private $con = null;
    private $prepare = null;
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, 
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", 
    PDO::ATTR_PERSISTENT => true);

    private $inTransaction = false; // Variable para controlar el estado de la transacción

    public function __construct() {
        try {
            if ($this->con === null) {
                //date_default_timezone_set("America/Bogota");
                $this->con = new PDO($this->server, $this->user, $this->pass,$this->options);
                $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $this->con->setAttribute(PDO::ATTR_PERSISTENT, true);
                $this->con->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
//                $this->con->setAttribute(PDO::ATTR_HTTP_HEADER,[ 'Content-Type: application/json; charset=utf-8']);
            }
        } catch (PDOException $e) {
            echo "There is a problem in database connection: " . $e->getMessage();
        }
    }

    public function beginTransaction() {
        try {
            $this->con->beginTransaction();
            $this->inTransaction = true;
        } catch (PDOException $e) {
            echo "Error starting transaction: " . $e->getMessage();
        }
    }

    public function commit() {
        try {
            $this->con->commit();
            $this->inTransaction = false;
        } catch (PDOException $e) {
            echo "Error committing transaction: " . $e->getMessage();
        }
    }

    public function rollBack() {
        try {
            $this->con->rollBack();
            $this->inTransaction = false;
        } catch (PDOException $e) {
            echo "Error rolling back transaction: " . $e->getMessage();
        }
    }

    public function inTransaction() {
        return $this->inTransaction;
    }

    /**
     * 
     * @param type $sencente la sentencia sql
     * @return int 1 si la sentencia fue ejecutada con exito, 0 si no 
     * insert y update
     */
    public function ejecutarInsertUpdateDelete($sencente) {
        try {
            //echo $sencente; exit();
            $this->prepare = $this->con->prepare($sencente);
            if ($this->prepare->execute()) {
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /**
     * 
     * @param type $sentence la sentencia sql
     * @return type arreglo con los datos de la sentencia, por lo general es select
     */
    public function retornar($sentence) {
        try {
            $this->prepare = $this->con->prepare($sentence);
            $this->prepare->execute();                
            return $this->prepare->fetchAll(PDO::FETCH_ASSOC); //  <- Aquí el cambio
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
    

    

    /**
     * 
     * @param type $sentence la sentencia sql
     * @return int si la consulta es efectiva retorna el ultimo id creado sino retorna
     */
    public function retornarUltimoIdCreado($sentence) {
        try {
            $this->prepare = $this->con->prepare($sentence);
            if ($this->prepare->execute()) {
                return $this->con->lastInsertId();
            } else {
                return 0;
            }
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
