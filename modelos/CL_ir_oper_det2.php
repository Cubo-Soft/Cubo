<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ir_oper_det2 {

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
               $this->sentencia = "insert into ir_oper_det2 (id_operacion, id_detalle, linea, misional, articulo, tipo, marca) values " 
                       . "(".$datos["id_operacion"].",".$datos["id_detalle"].",'".$datos["linea"]."','".$datos["misional"]."','".$datos["articulo"]."',".$datos["tipo"].",".$datos["marca"].");";
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
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update am_usuarios set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "paswd='" . $$datos["paswd"] . "' ";
//                $this->sentencia .= "where codusr='" . $$datos["codusr"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
