<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ir_detalle_oper {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {

            if ($opcion === 1) {
                $this->sentencia = "SELECT * ";
                //echo $this->sentencia;
                //exit();
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
               $this->sentencia = "insert into ir_detalle_oper (id_operacion,id_detalle,origen,destino,cod_item,cantidad,cantidad_entregada,costo,valor_unitario,iva,fec_entrega_item) values " 
                       . "(".$datos["id_operacion"].",NULL,".$datos["origen"].",".$datos["destino"].",'".$datos["cod_item"]."',".$datos["cantidad"].",".$datos["cantidad_entregada"].",".$datos["costo"].",".$datos["valor_unitario"].",".$datos["iva"].",'".$datos["fec_entrega_item"]."');";
           }

           //echo $this->sentencia; 

           $OB_CL_Base = new CL_Base();
           return $OB_CL_Base->crear($this->sentencia);
       } catch (PDOException $exc) {
           echo $exc->getTraceAsString();
       }
   }

//    public function borrar($datos, $opcion)
//     {
//         try {
//             if ($opcion === 1) {
//                 $this->sentencia = "delete from ";
//             }
//             //echo $this->sentencia; exit();
//             $OB_CL_Base = new CL_Base();
//             return $OB_CL_Base->borrar($this->sentencia);
//         } catch (PDOException $exc) {
//             echo $exc->getTraceAsString();
//         }
//     }
//
   public function actualizar($datos, $opcion) {
       try {
           $this->sentencia = "update ir_detalle_oper set ";
           if ($opcion === 1) {
               $this->sentencia .= "cantidad=" . $datos["cantidad"] . " ";               
           }
           $this->sentencia .= "where id_detalle=" . $datos["id_detalle"] . ";";
           $OB_CL_Base = new CL_Base();
           return $OB_CL_Base->actualizar($this->sentencia);
       } catch (PDOException $exc) {
           echo $exc->getTraceAsString();
       }
   }
}
