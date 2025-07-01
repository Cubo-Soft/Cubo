<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ir_resinve {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {

            if ($opcion === 1) {

                $this->sentencia = "SELECT UPPER(concat(ir_resinve.saldo,' ',am_usuarios.nombre)) as saldo_nombre, ir_resinve.saldo "
                    ."FROM ir_salinve,ir_resinve,am_usuarios "
                    ."WHERE ir_resinve.numid=am_usuarios.numid "
                    ."AND ir_salinve.cod_item=ir_resinve.cod_item "
                    ."AND ir_salinve.cod_item='".$datos["cod_item"]."' "
                    ."AND ir_salinve.codbodeg=1;";

                //echo $this->sentencia;
                //exit();
            }           

            if($opcion===2){
                $this->sentencia=IRRESINVE1
                ."AND ir_resinve.cod_item='".$datos["cod_item"]."';";
                //echo $this->sentencia;
                //exit();
            }

            //retorna el total de reservador de un repuesto
            if($opcion===3){

                $this->sentencia="SELECT SUM(ir_resinve.saldo) totalResInve "
                ."FROM ir_resinve "
                ."WHERE ir_resinve.cod_item='".$datos["cod_item"]."'; ";
            }

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

   public function crear($datos, $opcion) {
       try {
           if ($opcion === 1) {
               $this->sentencia = "insert into ir_resinve (codbodeg,cod_item,saldo,numid,fecha_arribo) values "
                       . "(".$datos["codbodeg"].",'".$datos["cod_item"]."',".$datos["saldo"].",'".$datos["numid"]."','".$datos["fecha_arribo"]."');";
           }
           $OB_CL_Base = new CL_Base();
           return $OB_CL_Base->crear($this->sentencia);
       } catch (PDOException $exc) {
           echo $exc->getTraceAsString();
       }
   }

   public function borrar($datos, $opcion)
    {
        try {

            if ($opcion === 1) {
                $this->sentencia = "delete from ir_resinve where codbodeg=" . $datos["codbodeg"] . " "
                ."AND cod_item='".$datos["cod_item"]."' "
                ."AND saldo=".$datos["saldo"]." "
                ."AND numid='".$datos["numid"]."' "
                ."AND fecha_arribo='".$datos["fecha_arribo"]."';";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update am_usuarios set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "paswd='" . $datos["paswd"] . "' ";
//                $this->sentencia .= "where codusr='" . $datos["codusr"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
