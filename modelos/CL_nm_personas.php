<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_nm_personas
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * "
                    . "from nm_personas "
                    . "where nm_personas.numid=" . $datos["numid"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia = "select nm_sucursal.direccion,nm_sucursal.telefono,nm_sucursal.telefono2,"
                    . "nm_personas.apelli_nom, CONCAT(nm_personas.apellidos,' ',nm_personas.nombres) AS nombre,"
                    . "np_ciudades.nom_ciudad,nm_sucursal.numid "
                    . "from nm_personas,nm_sucursal,np_ciudades "
                    . "where nm_personas.numid=nm_sucursal.numid "
                    . "and nm_sucursal.ciudad=np_ciudades.id_ciudad "
                    . "and nm_personas.numid=" . $datos["numid"] . ";";
            }

            if ($opcion === 3) {
                $this->sentencia = NMEMPLEADOS1
                    . "AND nm_personas.apelli_nom like '%" . $datos["nombre_comercial"] . "%' "
                    . "ORDER BY apelli_nom;";
            }

            if ($opcion === 4) {
                $this->sentencia = NMEMPLEADOS1
                    . "AND nm_personas.apelli_nom = '" . $datos["nombre_comercial"] . "' ";
            }

            if ($opcion === 5) {
                $this->sentencia = NMPERSONAS1
                    . "AND nm_personas.apelli_nom like '%" . $datos["apelli_nom"] . "%';";
            }

            if ($opcion === 6) {
                $this->sentencia = NMPERSONAS1
                    . "AND nm_personas.apelli_nom='" . $datos["apelli_nom"] . "';";
            }

            //echo $this->sentencia;exit();

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
                $this->sentencia = "insert into nm_personas (numid,apellidos,nombres,sexo,est_civil,fecha_naci,tipo_sangre,apelli_nom) values "
                    . "('" . $datos["numid"] . "','" . $datos["apellidos"] . "','" . $datos["nombres"] . "'," . $datos["sexo"] . "," . $datos["est_civil"] . ",'" . $datos["fecha_naci"] . "'," . $datos["tipo_sangre"] . ",'" . $datos["apelli_nom"] . "');";
            }
            // echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update nm_personas set ";
            if ($opcion === 1) {
                $this->sentencia .= "apellidos='" . $datos["apellidos"] . "',"
                    . "nombres='" . $datos["nombres"] . "',"
                    . "sexo=" . $datos["sexo"] . ","
                    . "est_civil=" . $datos["est_civil"] . ","
                    . "fecha_naci='" . $datos["fecha_naci"] . "',"
                    . "tipo_sangre=" . $datos["tipo_sangre"] . ","
                    . "apelli_nom='" . $datos["apelli_nom"] . "' ";
                $this->sentencia .= "where numid='" . $datos["numid"] . "';";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //nueva función de conversion de cliente Daniel2025
    public function insertar_persona($datos)
    {
        try {
            $this->sentencia = "INSERT INTO nm_personas (numid, apellidos, nombres, sexo, est_civil, fecha_naci, tipo_sangre, apelli_nom) VALUES ('"
                . $datos["numid"] . "', '"
                . $datos["apellidos"] . "', '"
                . $datos["nombres"] . "', "
                . $datos["sexo"] . ", "
                . $datos["est_civil"] . ", '"
                . $datos["fecha_naci"] . "', "
                . $datos["tipo_sangre"] . ", '"
                . $datos["apelli_nom"] . "');";

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
