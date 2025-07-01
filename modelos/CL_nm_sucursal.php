<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_nm_sucursal
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {

            if ($opcion === 1) {
                $this->sentencia = SUCURSALES1;
                $this->sentencia .= "and numid=" . $datos["numid"] . ";";
                //echo $this->sentencia; 
            }

            if ($opcion === 2) {
                $this->sentencia = SUCURSALES1;
                $this->sentencia .= "and id_sucursal=" . $datos["id_sucursal"] . ";";
            }

            if ($opcion === 7) {
                $this->sentencia = "SELECT * FROM nm_sucursal WHERE numid = '" . $datos["numid"] . "' AND nom_sucur = 'Cliente';";
            }


            //echo $this->sentencia; 
            //exit();

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
                $this->sentencia = "insert into nm_sucursal (id_sucursal,numid,orden,direccion,telefono,telefono2,fax,"
                    . "ciudad,pais,nom_sucur,suc_lat_gps,suc_lng_gps,cod_clie_helisa,cod_prv_helisa,estado,id_region) values "
                    . "(null,'" . $datos["numid"] . "'," . $datos["orden"] . ",'" . $datos["direccion"] . "',"
                    . "'" . $datos["telefono"] . "','" . $datos["telefono2"] . "','" . $datos["fax"] . "',"
                    . "'" . $datos["ciudad"] . "'," . $datos["pais"] . ",'" . $datos["nom_sucur"] . "','" . $datos["suc_lat_gps"] . "',"
                    . "'" . $datos["suc_lng_gps"] . "','" . $datos["cod_clie_helisa"] . "','" . $datos["cod_prv_helisa"] . "',1,'" . $datos["id_region"] . "');";
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
            $this->sentencia = "update nm_sucursal set ";
            if ($opcion === 1) {
                $this->sentencia .= "direccion='" . $datos["direccion"] . "',"
                    . "telefono='" . $datos["telefono"] . "',"
                    . "ciudad='" . $datos["ciudad"] . "',"
                    . "pais=" . $datos["pais"] . ","
                    . "nom_sucur='" . $datos["nom_sucur"] . "',"
                    . "suc_lat_gps='" . $datos["suc_lat_gps"] . "',"
                    . "suc_lng_gps='" . $datos["suc_lng_gps"] . "',"
                    . "estado=" . $datos["estado"] . ","
                    . "cod_clie_helisa='" . $datos["cod_clie_helisa"] . "', "
                    . "id_region='" . $datos["id_region"] . "' "
                    . "where id_sucursal=" . $datos["id_sucursal"] . ";";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //nueva función de conversion de cliente Daniel2025
    public function insertar_sucursal($datos)
    {
        try {
            $this->sentencia = "INSERT INTO nm_sucursal (numid, orden, direccion, telefono, telefono2, fax, ciudad, pais, nom_sucur, cod_clie_helisa, cod_prv_helisa, estado, id_region) VALUES ('"
                . $datos["numid"] . "', "
                . $datos["orden"] . ", '"
                . $datos["direccion"] . "', '"
                . $datos["telefono"] . "', '"
                . $datos["telefono2"] . "', '"
                . $datos["fax"] . "', '"
                . $datos["ciudad"] . "', '"
                . $datos["pais"] . "', '"
                . $datos["nom_sucur"] . "', "
                . $datos["cod_clie_helisa"] . ", "
                . $datos["cod_prv_helisa"] . ", "
                . $datos["estado"] . ", "
                . $datos["id_region"] . ");";

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia); // <<< ✅ aquí se devuelve el ID insertado
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
