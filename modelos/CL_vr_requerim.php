<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

//inclusiones para la conversion del cliente Daniel2025
include_once '../modelos/CL_vm_clientesprov.php';
include_once '../modelos/CL_nm_nits.php';
include_once '../modelos/CL_nm_personas.php';
include_once '../modelos/CL_nm_sucursal.php';
include_once '../modelos/CL_nm_contactos.php';
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
                $this->sentencia = "
                SELECT 
                    vr_requerim.id_fuente,
                    vr_requerim.fechora,
                    vr_requerim.nom_cliente,
                    vr_requerim.nit_cliente,
                    vr_requerim.suc_cliente,
                    vr_requerim.id_contacto,
                    vr_requerim.clien_provis,
                    vr_requerim.de_linea,
                    vr_requerim.asesor_asignd,
                    vr_requerim.observs,
                    vr_requerim.estado,
                    vr_requerim.cod_grabador,
                    vr_requerim.area,
                    vr_requerim.id_requerim,
                    vr_requerim.cod_trans,
                    vr_requerim.grupo,

                    ip_lineas.descrip,
            
                    -- Contacto: cliente provisional o contacto normal
                    COALESCE(vm_clientesprov.contacto, nm_contactos.nom_contacto) AS nom_contacto,
            
                    -- Sucursal: si no hay, 'Cliente Provisional'
                    CASE 
                        WHEN nm_sucursal.nom_sucur IS NULL THEN 'Cliente '
                        ELSE UPPER(nm_sucursal.nom_sucur)
                    END AS nom_sucur,
            
                    -- Ciudad: si no hay, 'Cliente Provis'
                    CASE 
                        WHEN np_ciudades.nom_ciudad IS NULL THEN 'Cliente Provis'
                        ELSE np_ciudades.nom_ciudad
                    END AS nom_ciudad
            
                FROM 
                    vr_requerim
                LEFT JOIN 
                    ip_lineas ON vr_requerim.de_linea = ip_lineas.id_linea
                LEFT JOIN 
                    vm_clientesprov ON vr_requerim.nit_cliente = vm_clientesprov.nit_cliente
                LEFT JOIN 
                    nm_contactos ON vr_requerim.id_contacto = nm_contactos.id_contacto
                LEFT JOIN 
                    nm_sucursal ON vr_requerim.suc_cliente = nm_sucursal.id_sucursal
                LEFT JOIN 
                    np_ciudades ON nm_sucursal.ciudad = np_ciudades.id_ciudad
                WHERE 
                    vr_requerim.id_requerim = " . $datos["id_requerim"] . ";
                ";
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

            //if para conversion de cliente Daniel2025
            if ($opcion === 4) {
                // Actualizar sucursal, contacto y clien_provis
                $this->sentencia .= "suc_cliente='" . $datos["suc_cliente"] . "', ";
                $this->sentencia .= "id_contacto='" . $datos["id_contacto"] . "', ";
                $this->sentencia .= "clien_provis='" . $datos["clien_provis"] . "' ";
            }

            $this->sentencia .= "where id_requerim=" . $datos["id_requerim"] . ";";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    // 🛠 Convertir cliente provisional a cliente normal Daniel2025
    public function convertirClienteProvisional($id_requerim)
    {
        error_log(">>> Entró a convertirClienteProvisional con ID: $id_requerim");//borrar


        // Instancias necesarias de los modelos  a usar
        $this->OB_vm_clientesprov = new CL_vm_clientesprov();
        $this->OB_nm_nits = new CL_nm_nits();
        $this->OB_nm_personas = new CL_nm_personas();
        $this->OB_nm_sucursal = new CL_nm_sucursal();
        $this->OB_nm_contactos = new CL_nm_contactos();

        // 1. Leer requerimiento
        $datos["id_requerim"] = $id_requerim;
        $requerimiento = $this->leer($datos, 2);

        error_log("Contenido de \$requerimiento: " . print_r($requerimiento, true));//borrar


        if (!$requerimiento || intval($requerimiento[0]["clien_provis"]) !== 1) {
            error_log("No es cliente provisional o no encontró requerimiento");//borrar
            return false;
        }

        // 2. Leer cliente provisional por nit_cliente
        $datos["nit_cliente"] = $requerimiento[0]["nit_cliente"];

        error_log("Consulta a vm_clientesprov con nit_cliente = " . $datos["nit_cliente"]);//borrar

        $vm_clientesprov = $this->OB_vm_clientesprov->leer($datos, 3);

        error_log("Contenido de \$vm_clientesprov: " . print_r($vm_clientesprov, true));//borrar
        error_log("Resultado: " . print_r($vm_clientesprov, true));//borrar

        // 3. Validar que existe el cliente correcto
        if (count($vm_clientesprov) !== 1) {
            error_log("ERROR: Se esperaban 1 resultados en vm_clientesprov pero llegaron" . count($vm_clientesprov));//borrar
            return false;
        }

        $prov = $vm_clientesprov[0];
        if (!isset($prov["nit_cliente"])) {
            error_log("ERROR: 'nit_cliente' no definido en cliente provisional.");
            return false;
        }
        // 4. Verificar si ya existe en nm_nits
        $existe = $this->OB_nm_nits->leer(["numid" => $prov["nit_cliente"]], 4);

        if (count($existe) === 0) {
            // Insertar cliente en nm_nits
            $this->OB_nm_nits->insertar_nit([
                "numid" => $prov["nit_cliente"],
                "dv" => "0",
                "idclase" => "13",
                "stdnit" => "32",
                "tipo_per" => "23",
                "actividad" => "0001",
                "tipo_entidad" => "121"
            ]);
            error_log("Insertó nm_nits");// borrar

            $this->OB_nm_personas->insertar_persona([
                "numid" => $prov["nit_cliente"],
                "apellidos" => $prov["nombre"],
                "nombres" => $prov["nombre"],
                "sexo" => "1",
                "est_civil" => "4",
                "fecha_naci" => "1950-01-01",
                "tipo_sangre" => "10",
                "apelli_nom" => $prov["nombre"]
            ]);
            error_log("Insertó nm_personas");//borrar

            $id_sucursal_nuevo = $this->OB_nm_sucursal->insertar_sucursal([
                "numid" => $prov["nit_cliente"],
                "orden" => "1",
                "direccion" => $prov["direccion"],
                "telefono" => $prov["telefono"],
                "telefono2" => $prov["telefono"],
                "fax" => $prov["telefono"],
                "ciudad" => "11001",
                "pais" => "7",
                "nom_sucur" => "Sede 1",
                "cod_clie_helisa" => "0",
                "cod_prv_helisa" => "0",
                "estado" => "1",
                "id_region" => $prov["id_region"]
            ]);
            error_log("Insertó nm_sucursal con ID: $id_sucursal_nuevo");//borrar

            if (!$id_sucursal_nuevo) {
                error_log("ERROR: No se pudo obtener ID después de crear sucursal");
                return false;
            }

            $this->OB_nm_contactos->insertar_contacto([
                "id_sucursal" => $id_sucursal_nuevo,
                "cc_contacto" => $prov["nit_cliente"],
                "nom_contacto" => $prov["contacto"],
                "tel_contacto" => $prov["telefono"],
                "email" => $prov["email"],
                "estado" => "1"
            ]);
            error_log("Insertó nm_contactos");//borrar

        } else {
            error_log("Cliente ya existe en nm_nits");

            // 🔥 AJUSTE: Buscar sucursal y guardar ID o insertar y guardar ID
            $sucursal = $this->OB_nm_sucursal->leer(["numid" => $prov["nit_cliente"]], 7);
            if (!$sucursal) {
                $id_sucursal_nuevo = $this->OB_nm_sucursal->insertar_sucursal([
                    "numid" => $prov["nit_cliente"],
                    "orden" => "1",
                    "direccion" => $prov["direccion"],
                    "telefono" => $prov["telefono"],
                    "telefono2" => $prov["telefono"],
                    "fax" => $prov["telefono"],
                    "ciudad" => "11001",
                    "pais" => "7",
                    "nom_sucur" => "Sede 1",
                    "cod_clie_helisa" => "0",
                    "cod_prv_helisa" => "0",
                    "estado" => "1",
                    "id_region" => $prov["id_region"]
                ]);
                error_log("Insertó nm_sucursal (cliente existente, sin sucursal) con ID: $id_sucursal_nuevo");
                if (!$id_sucursal_nuevo) {
                    error_log("ERROR: No se pudo obtener ID después de crear sucursal");
                    return false;
                }
            } else {
                $id_sucursal_nuevo = $sucursal[0]["id_sucursal"];
            }

            // Si no existe contacto, insertar contacto
            $contacto = $this->OB_nm_contactos->leer([
                "cc_contacto" => $prov["nit_cliente"],
                "nom_contacto" => $prov["contacto"]
            ], 8);
            if (!$contacto) {
                if (!$id_sucursal_nuevo) {
                    error_log("❌ ERROR: No encontró ID de sucursal para insertar contacto");
                    return false;
                }

                $this->OB_nm_contactos->insertar_contacto([
                    "id_sucursal" => $id_sucursal_nuevo,
                    "cc_contacto" => $prov["nit_cliente"],
                    "nom_contacto" => $prov["contacto"],
                    "tel_contacto" => $prov["telefono"],
                    "email" => $prov["email"],
                    "estado" => "1"
                ]);
                error_log("Insertó nm_contactos (cliente existente, sin contacto)");
            }
        }

        // 🔥 AJUSTE: No volver a llamar leer sucursal, usamos $id_sucursal_nuevo directamente
        $contacto = $this->OB_nm_contactos->leer([
            "cc_contacto" => $prov["nit_cliente"],
            "nom_contacto" => $prov["contacto"]
        ], 8);

        if (!$id_sucursal_nuevo || !$contacto) {
            error_log("No encontró sucursal o contacto para actualizar requerimiento");//borrar
            return false;
        }

        // 7. Actualizar requerimiento con ID de sucursal y contacto
        $this->actualizar([
            "id_requerim" => $id_requerim,
            "suc_cliente" => $id_sucursal_nuevo,
            "id_contacto" => $contacto[0]["id_contacto"],
            "clien_provis" => "0"
        ], 4);

        error_log("Actualizó requerimiento con datos cliente normal");//borrar

        error_log("Preparado para eliminar cliente provisional con NIT: " . $prov["nit_cliente"]);
        // 8. Eliminar cliente provisional
        $this->OB_vm_clientesprov->eliminar(["nit_cliente" => $prov["nit_cliente"]]);

        error_log("Eliminó cliente provisional");//borrar

        return true;
    }

}


