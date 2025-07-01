<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_vr_requerim
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = VRREQUERIM1;
                $this->sentencia .= "and vr_requerim.estado=" . $datos['estadoRequerimiento'] . " "
                    //. "and vr_requerim.fechora BETWEEN '" . $datos['dtRInicial'] . "' and '" . $datos['dtRFinal'] . "' "
                    . "and vr_requerim.asesor_asignd='" . $datos['am_usuarios'] . "';";
            }

            if ($opcion === 2) {
                $this->sentencia = "select vr_requerim.id_fuente,vr_requerim.fechora,vr_requerim.nom_cliente,vr_requerim.nit_cliente,"
                     ."vr_requerim.suc_cliente,vr_requerim.id_contacto,vr_requerim.de_linea,vr_requerim.asesor_asignd,vr_requerim.observs,"
                     ."vr_requerim.estado,vr_requerim.cod_grabador,vr_requerim.area,vr_requerim.id_requerim,vr_requerim.cod_trans,"
                     ."ip_lineas.descrip,vr_requerim.grupo "
                    . "from vr_requerim,ip_lineas "
                    . "where vr_requerim.de_linea=ip_lineas.id_linea "
                    ."and id_requerim=" . $datos["id_requerim"] . ";";

            }

            if ($opcion === 3) {
                //echo ':O';
                $this->sentencia = VRREQUERIM1;
                $this->sentencia .= "and vr_requerim.fechora BETWEEN '" . $datos['dtRInicial'] . "' and '" . $datos['dtRFinal'] . "' ";
                $this->sentencia .= "GROUP BY vr_requerim.id_requerim;";
            }

            if ($opcion === 4) {
                $this->sentencia = VRREQUERIM1;
                $this->sentencia .= "and vr_requerim.fechora BETWEEN '" . $datos['dtRInicial'] . "' and '" . $datos['dtRFinal'] . "' "
                    . "and vr_requerim.asesor_asignd='" . $datos['am_usuarios'] . "';";
            }

            if ($opcion === 5) {
                $this->sentencia = VRREQUERIM1;
                $this->sentencia .= "and vr_requerim.fechora BETWEEN '" . $datos['dtRInicial'] . "' and '" . $datos['dtRFinal'] . "' "
                    . "and vr_requerim.estado=" . $datos['estadoRequerimiento'] . ";";
            }

            if ($opcion === 6) {
                //echo ':O';
                $this->sentencia = VRREQUERIM2;
                $this->sentencia .= "and vr_requerim.fechora BETWEEN '" . $datos['dtRInicial'] . "' and '" . $datos['dtRFinal'] . "' ";
                $this->sentencia .= "GROUP BY vr_requerim.id_requerim;";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion)
    {
        try {
            if ($opcion === 1) {

            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update vr_requerim set ";
            if ($opcion === 1) {
                $this->sentencia .= "observs='" . $datos["observs"] . "' ";
            }

            if ($opcion === 2) {
                $this->sentencia .= "estado='" . $datos["estado"] . "' ";
            }

            if ($opcion === 3) {
                $this->sentencia .= "asesor_asignd='" . $datos["asesor_asignd"] . "' ";
            }

            $this->sentencia .= "where id_requerim=" . $datos["id_requerim"] . ";";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
