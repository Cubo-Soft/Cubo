<?php

include_once '../modelos/CL_Base.php';

class CL_im_trans
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select im_trans.cod_trans,im_trans.consec "
                    . "from im_trans,ip_oper "
                    . "where im_trans.tipo_oper=ip_oper.tipo "
                    ."and im_trans.tipo_oper='".$datos["tipo"]."' "
                    ."and im_trans.estado_trans=1;";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //    public function crear($datos, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into ip_articulos (id_articulo,descrip) values "
//                        . "('" . $datos["id_articulo"] . "','" . $datos["descrip"] . "');";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
//
    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update im_trans set ";
            if ($opcion === 1) {
                $this->sentencia .= "consec=" . $datos["consec"] . " ";
                $this->sentencia .= "where cod_trans='" . $datos["cod_trans"] . "';";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
