<?php

include_once '../modelos/CL_Base.php';

class CL_vm_clientesprov
{

    private $sentencia;

    /*public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia="select nombre "
                        . "from vm_clientesprov "
                        . "where nombre like '%".$datos["nombre"]."%' "
                        . "order by vm_clientesprov.nombre";
            }
            
            if($opcion===2){
                $this->sentencia="select * "
                        . "from vm_clientesprov "
                        . "where nombre='".$datos["nombre"]."';";
            }
            
            if($opcion===3){
                $this->sentencia="select * "
                        . "from vm_clientesprov "
                        . "where nit_cliente='".$datos["nit_cliente"]."';";
            }
            
            //echo $this->sentencia; exit();
            
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }*/

    // Nueva función leer Daniel 2025
    public function leer($datos, $opcion)
    {
        try {
            // Filtro por nombre (LIKE)
            if ($opcion === 1) {
                $nombre = isset($datos["nombre"]) ? $datos["nombre"] : '';
                $this->sentencia = "SELECT nombre FROM vm_clientesprov WHERE nombre LIKE '%$nombre%' ORDER BY nombre";
            }

            // Búsqueda exacta por nombre
            if ($opcion === 2) {
                $nombre = isset($datos["nombre"]) ? $datos["nombre"] : '';
                $this->sentencia = "SELECT * FROM vm_clientesprov WHERE nombre = '$nombre'";
            }

            // Búsqueda exacta por NIT (opción 3)
            if ($opcion === 3) {
                $nit = isset($datos["nit_cliente"]) ? $datos["nit_cliente"] : '';
                $this->sentencia = "SELECT * FROM vm_clientesprov WHERE nit_cliente = '$nit'";
            }

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);

        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    /*public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into vm_clientesprov (id_provis,nit_cliente,nombre,direccion,telefono,email,contacto,grabador,fechora) values "
                        . "(null,'".$datos["nit_cliente"]."','".$datos["nombre"]."','".$datos["direccion"]."','".$datos["telefono"]."','".$datos["email"]."','".$datos["contacto"]."','".$datos["grabador"]."','".$datos["fechora"]."');";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }*/



    /* Nueva Función crear Daniel2025*/
    public function crear($datos, $opcion)
    {
        try {
            // Validación para evitar la creación de clientes duplicados por NIT
            if ($opcion === 1) {
                // Consulta para verificar si ya existe un cliente con el NIT
                $this->sentencia = "SELECT * FROM vm_clientesprov WHERE nit_cliente = '" . $datos["nit_cliente"] . "';";

                $OB_CL_Base = new CL_Base();
                $resultado = $OB_CL_Base->leer($this->sentencia);

                // Si ya existe un cliente con ese NIT, actualizamos los datos
                if (count($resultado) > 0) {
                    // Actualizamos el cliente existente con los nuevos datos
                    $this->sentencia = "UPDATE vm_clientesprov SET 
                    nombre = '" . $datos["nombre"] . "', 
                    direccion = '" . $datos["direccion"] . "', 
                    telefono = '" . $datos["telefono"] . "', 
                    email = '" . $datos["email"] . "', 
                    contacto = '" . $datos["contacto"] . "',
                    id_region = '" . $datos["id_region"] . "', 
                    grabador = '" . $datos["grabador"] . "',
                    fechora = '" . $datos["fechora"] . "'
                    WHERE nit_cliente = '" . $datos["nit_cliente"] . "';";

                    // Ejecutamos el UPDATE
                    $OB_CL_Base->crear($this->sentencia);

                    // Mensaje para cuando es una actualización
                    return 'Cliente actualizado correctamente. Ya puede continuar con la toma del Requerimiento...';
                } else {
                    // Si el NIT no existe, procedemos a insertar el nuevo cliente
                    $this->sentencia = "INSERT INTO vm_clientesprov (id_provis, nit_cliente, nombre, direccion, telefono, email, contacto, id_region, grabador, fechora) 
                    VALUES (null, '" . $datos["nit_cliente"] . "', '" . $datos["nombre"] . "', '" . $datos["direccion"] . "', '" . $datos["telefono"] . "', '" . $datos["email"] . "', '" . $datos["contacto"] . "', '" . $datos["id_region"] . "', '" . $datos["grabador"] . "', '" . $datos["fechora"] . "');";

                    // Ejecutamos el INSERT
                    $OB_CL_Base->crear($this->sentencia);

                    // Mensaje para cuando es una inserción
                    return 'Cliente provisional creado exitosamente. Ya puedes continuar con la toma del Requerimiento...';
                }
            }
        } catch (PDOException $exc) {
            // Si ocurre un error, mostrar la traza del error
            echo $exc->getTraceAsString();
        }
    }

    /* Nueva Función eliminar Daniel2025*/
    public function eliminar($datos)
    {
        try {
            if (!isset($datos['nit_cliente'])) {
                throw new Exception("Falta el nit_cliente para eliminar cliente provisional");
            }

            $nit = $datos['nit_cliente'];
            $this->sentencia = "DELETE FROM vm_clientesprov WHERE nit_cliente = '$nit';";

            error_log("🧹 Ejecutando DELETE en vm_clientesprov para nit_cliente: $nit");

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (Exception $e) {
            error_log("❌ Error al eliminar cliente provisional: " . $e->getMessage());
            return false;
        }
    }


    //
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update am_usuarios set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "paswd='" . $datos["paswd"] . "' ";
//                $this->sentencia .= "where codusr='" . $datos["codusr"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }

}
