<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_am_usuarios
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select am_usuarios.codusr,UPPER(am_usuarios.nombre) AS nombre,am_usuarios.numid,am_usuarios.email,am_usuarios.paswd,"
                    . "am_usuarios.id_rol,am_usuarios.estado,am_usuarios.grabador,am_usuarios.foto,ip_dtbasicos.dt_basico,"
                    . "ap_roles.descrip_rol,np_cargos.id_cargo "
                    . "from am_usuarios,ip_dtbasicos,ap_roles,np_cargos "
                    . "where am_usuarios.estado=ip_dtbasicos.sec_basico "
                    . "and ap_roles.id_cargo=np_cargos.id_cargo "
                    . "and am_usuarios.email='" . $datos["email"] . "' "
                    . "and am_usuarios.paswd='" . $datos["paswd"] . "' "
                    . "and ip_dtbasicos.dt_basico='Activo' "
                    . "and am_usuarios.id_rol=ap_roles.id_rol;";
            }

            if ($opcion === 2) {
                $this->sentencia = AMUSUARIOS1
                    . "ORDER BY am_usuarios.nombre;";
            }

            if ($opcion === 3) {
                $this->sentencia = AMUSUARIOS1 
                    . "WHERE am_usuarios.id_rol=5 OR am_usuarios.id_rol=4 "
                    . "ORDER BY am_usuarios.nombre;";
            }

            if ($opcion === 4) {
                $this->sentencia = "SELECT am_usuarios.codusr,UPPER(am_usuarios.nombre) as nombre "
                    . "from am_usuarios "
                    . "WHERE am_usuarios.codusr='" . $datos["codusr"] . "' "
                    . "ORDER BY am_usuarios.nombre;";
            }

            if($opcion===5){
                $this->sentencia=AMUSUARIOS1
                ."WHERE am_usuarios.numid=".$datos["numid"].";";
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
                $this->sentencia = "insert into am_usuarios (codusr,nombre,nit,email,paswd,id_rol,estado,grabador,fec_graba,foto) values "
                    . "('" . $datos["codusr"] . "','" . $datos["nombre"] . "','" . $datos["nit"] . "','" . $datos["email"] . "','" . $datos["paswd"] . "'," . $datos["id_rol"] . "," . $datos["estado"] . ",'" . $datos["grabador"] . "','" . $datos["fec_graba"] . "','" . $datos["foto"] . "');";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update am_usuarios set ";
            if ($opcion === 1) {
                $this->sentencia .= "paswd='" . $datos["paswd"] . "' "
                . "where codusr='" . $datos["codusr"] . "';";
            }

            if($opcion===2){
                $this->sentencia.="foto='".$datos["foto"]."' " 
                ."where numid=".$datos["numid"];
            }


            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
