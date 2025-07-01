<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_am_alertas
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            $this->sentencia = AMALERTAS1;

            if ($opcion === 1) {
                $this->sentencia .= "and am_alertas.fecha_show<='" . date("Y-m-d") . "' "
                    . "and am_alertas.usuario_asignd='" . $datos["usuario_asignd"] . "' "
                    . "and am_alertas.id_tipoalerta=" . $datos["id_tipoalerta"] . " ";
                    //. "GROUP BY am_alertas.id_proceso;;";
            }

            if ($opcion === 2) {

                $this->sentencia .= "and am_alertas.fecha_show<='" . date("Y-m-d") . "' "
                    . "and am_alertas.id_tipoalerta=" . $datos["id_tipoalerta"] . ";";
            }

            //echo $this->sentencia;exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //    public function crear($datos, $opcion) {
    //        try {
    //            if ($opcion === 1) {
    //                
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

            $this->sentencia = "update am_alertas set ";

            if ($opcion === 1) {
                $this->sentencia .= "id_estado=" . $datos["id_estado"] . ",fecha_fin='" . $datos["fecha_fin"] . "' "
                    . "where id_proceso=" . $datos["id_proceso"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia .= "usuario_asignd='" . $datos["usuario_asignd"] . "' "
                    . "where id_proceso=" . $datos["id_proceso"] . ";";
            }

            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
