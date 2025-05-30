<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_sr_prog_mant
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            
            if ($opcion === 1) {
                $this->sentencia = "SELECT sr_prog_mant.id_prog,sr_prog_mant.fecha_ini,sr_prog_mant.suc_cliente,"
                ."sr_prog_mant.equipo,sr_prog_mant.cod_item,sr_prog_mant.nro_parte,sr_prog_mant.fec_ult_mant,"
                ."sr_prog_mant.fec_prox_mant,sr_prog_mant.nro_serie,ip_grupos.nom_grupo,"
                ."(SELECT ip_grupos.nom_grupo FROM ip_grupos WHERE ip_grupos.cod_grupo=LEFT(im_items.grup_item,4) ) as tipoEquipo,"
                ."ip_marcas.nom_marca "
                ."FROM sr_prog_mant,im_items,ip_grupos,ip_marcas "
                ."WHERE sr_prog_mant.cod_item=im_items.cod_item "
                ."AND im_items.grup_item=ip_grupos.cod_grupo "
                ."AND im_items.id_marca=ip_marcas.id_marca "
                ."AND sr_prog_mant.suc_cliente=".$datos["suc_cliente"].";";
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
    // public function actualizar($datos, $opcion)
    // {
    //     try {
    //         //echo $this->sentencia; exit();
    //         $OB_CL_Base = new CL_Base();
    //         return $OB_CL_Base->actualizar($this->sentencia);
    //     } catch (PDOException $exc) {
    //         echo $exc->getTraceAsString();
    //     }
    // }
}
