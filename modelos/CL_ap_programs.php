<?php

include_once '../modelos/CL_Base.php';

class CL_ap_programs {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1 || $opcion === 2) {
                $this->sentencia = "SELECT ap_programs.nomprog,ip_dtbasicos.dt_basico,ap_programs.path,ap_grupos.descrip,"
                        . "ap_programs.codprog,ap_programs.path "
                        . "FROM ap_grupos,ap_programs,ap_permpro,ar_roles,ap_roles,ip_dtbasicos "
                        . "WHERE ap_grupos.cod_grupo=ap_programs.grupo "
                        . "AND ap_programs.codprog=ap_permpro.codprog "
                        . "AND ap_permpro.id_permpro=ar_roles.id_permpro "
                        . "AND ar_roles.id_rol=ap_roles.id_rol "
                        . "AND ap_programs.estado=ip_dtbasicos.sec_basico "
                        . "AND ap_roles.id_rol=" . $datos["id_rol"] . " "
                        . "AND ip_dtbasicos.dt_basico='Activo' "
                        . "AND ar_roles.estado=1 ";
            }

            if ($opcion === 1) {
                //retorna las opciones del grupo
                $this->sentencia .= "GROUP BY ap_permpro.codprog "
                        . "ORDER BY ap_grupos.descrip,ap_programs.nomprog;";
            }
            if ($opcion === 2) {
                //retorna los grupos                 
                $this->sentencia .= "GROUP BY ap_grupos.descrip "
                        . "ORDER BY ap_grupos.descrip,ap_programs.nomprog;";
            }

            if($opcion===3){
                $this->sentencia="SELECT ap_programs.codprog,CONCAT(ap_programs.nomprog,' - ',ap_programs.codprog) as nomprog "
                        . "FROM ap_programs ORDER BY ap_programs.nomprog;";
            }    
            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($data, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into ap_programs (codprog,nomprog,estado,path,grupo) values "
                        . "('" . $data["codprog"] . "','" . $data["nomprog"] . "'," . $data["estado"] . ",'" . $data["path"] . "','" . $data["grupo"] . ");";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
