<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_nm_contactos
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = RETORNARCONTACTOS1;
                $this->sentencia .= "AND nm_contactos.nom_contacto like '%" . $datos["nom_contacto"] . "%' ";
                $this->sentencia .= "ORDER BY nm_contactos.nom_contacto;";
            }

            if ($opcion === 2) {
                $this->sentencia = "select * "
                    . "from nm_contactos "
                    . "where nm_contactos.cc_contacto like '%" . $datos["cc_contacto"] . "%';";
            }

            if ($opcion === 3) {
                $this->sentencia = RETORNARCONTACTOS1;
                $this->sentencia .= "AND nm_contactos.nom_contacto='" . $datos["nom_contacto"] . "' ";
                $this->sentencia .= "ORDER BY nm_contactos.nom_contacto;";
            }

            if ($opcion === 4) {
                $this->sentencia = "select nm_contactos.id_sucursal,nm_contactos.id_contacto,nm_contactos.cc_contacto,nm_contactos.nom_contacto,"
                    . "nm_contactos.cargo,nm_contactos.tel_contacto,nm_contactos.email,nm_contactos.estado as estadoContacto,nm_sucursal.* "
                    . "from nm_contactos,nm_sucursal "
                    . "where nm_contactos.id_sucursal=nm_sucursal.id_sucursal "
                    . "and nm_contactos.id_sucursal='" . $datos["id_sucursal"] . "';";
            }

            if ($opcion === 5) {
                $this->sentencia = "select * "
                    . "from nm_contactos "
                    . "where nm_contactos.id_contacto='" . $datos["id_contacto"] . "';";
            }

            if ($opcion === 6) {
                $this->sentencia = "SELECT * "
                    . "FROM nm_contactos,nm_sucursal,nm_nits "
                    . "WHERE nm_contactos.id_sucursal=nm_sucursal.id_sucursal "
                    . "AND nm_sucursal.numid=nm_nits.numid "
                    . "AND nm_contactos.id_contacto=" . $datos["id_contacto"] . ";";
            }

            if ($opcion === 8) {
                if (isset($datos["cc_contacto"], $datos["nom_contacto"])) {
                    $this->sentencia = "SELECT * FROM nm_contactos 
                            WHERE cc_contacto = '" . $datos["cc_contacto"] . "'  AND nom_contacto = '" . $datos["nom_contacto"] . "';";
                } else {
                    error_log("❌ [CL_nm_contactos] Faltan parámetros: numid o nom_contacto no definidos para opción 8");
                    $this->sentencia = ""; // Previene error en prepare('')
                }
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
                $this->sentencia = "insert into nm_contactos (id_sucursal,id_contacto,cc_contacto,nom_contacto,cargo,tel_contacto,email,estado) values "
                    . "(" . $datos["id_sucursal"] . ",null," . $datos["cc_contacto"] . ",'" . $datos["nom_contacto"] . "','" . $datos["cargo"] . "','" . $datos["tel_contacto"] . "','" . $datos["email"] . "',1);";
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
            $this->sentencia = "update nm_contactos set ";
            if ($opcion === 1) {
                $this->sentencia .= "nom_contacto='" . $datos["nom_contacto"] . "',tel_contacto='" . $datos["tel_contacto"] . "',"
                    . "email='" . $datos["email"] . "',estado=" . $datos["estado"] . ",cc_contacto=" . $datos["cc_contacto"] . " ";
                $this->sentencia .= "where id_contacto=" . $datos["id_contacto"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia .= "nom_contacto='" . $datos["nom_contacto"] . "',tel_contacto='" . $datos["tel_contacto"] . "',"
                    . "email='" . $datos["email"] . "',cargo='" . $datos["cargo"] . "',estado=" . $datos["estado"] . " ";
                $this->sentencia .= "where id_contacto=" . $datos["id_contacto"] . ";";
            }





            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //nueva función de conversion de cliente Daniel2025
    public function insertar_contacto($datos)
    {
        try {
            $this->sentencia = "INSERT INTO nm_contactos (id_sucursal, cc_contacto, nom_contacto, tel_contacto, email, estado) VALUES ('"
                . $datos["id_sucursal"] . "', '"
                . $datos["cc_contacto"] . "', '"
                . $datos["nom_contacto"] . "', '"
                . $datos["tel_contacto"] . "', '"
                . $datos["email"] . "', "
                . $datos["estado"] . ");";

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
