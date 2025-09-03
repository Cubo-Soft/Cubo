<?php

include_once '../modelos/CL_conexion.php';
include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_im_items
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                /*$this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                    . "FROM im_items,ip_grupos "
                    . "WHERE im_items.grup_item=ip_grupos.cod_grupo "
                    . "AND ip_grupos.cod_grupo LIKE '" . $datos["ip_grupos"] . "%' "
                    . "AND ip_grupos.subdivide='N' "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "GROUP BY ip_grupos.cod_grupo;";
                 */

                //20240103 se crea esta instrucción para permitir la opción "NO EXISTE" dentro de los grupos
                //se quitó la relación con im_items para permitir el resultado                
                $this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                    . "FROM ip_grupos "
                    . "WHERE ip_grupos.cod_grupo LIKE '" . $datos["ip_grupos"] . "%' "
                    . "AND ip_grupos.subdivide='N' "
                    . "GROUP BY ip_grupos.cod_grupo "
                    . "ORDER BY ip_grupos.nom_grupo ";
                //echo $this->sentencia;
                //exit();
            }

            //busca el tipo 
            if ($opcion === 2) {
                $this->sentencia = "SELECT ip_tipos.id_tipo,UPPER(ip_tipos.descrip) as descrip "
                    . "FROM im_items,ip_tipos "
                    . "WHERE im_items.tipo_item=ip_tipos.id_tipo "
                    . "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea='" . $datos["ip_lineas"] . "' "
                    . "GROUP BY ip_tipos.id_tipo;";
                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 3) {
                $this->sentencia = "SELECT ip_marcas.id_marca,UPPER(ip_marcas.nom_marca) as nom_marca "
                    . "FROM im_items,ip_marcas "
                    . "WHERE im_items.id_marca=ip_marcas.id_marca "
                    . "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea='" . $datos["ip_lineas"] . "' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "GROUP BY ip_marcas.id_marca;";
                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 4) {
                $this->sentencia = "SELECT ip_modelos.id_modelo,UPPER(ip_modelos.descrip_modelo)  as descrip_modelo "
                    . "FROM im_items,ip_modelos "
                    . "WHERE im_items.modelo=ip_modelos.id_modelo "
                    . "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea='" . $datos["ip_lineas"] . "' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marca"] . " "
                    . "GROUP BY ip_modelos.id_modelo;";
                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 5) {
                $this->sentencia = "SELECT ip_dimen.id_dimen,UPPER(ip_dimen.nom_dimen)  as nom_dimen "
                    . "FROM im_items,ip_dimen "
                    . "WHERE im_items.dimensiones=ip_dimen.id_dimen "
                    . "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marca"] . " "
                    . "AND im_items.modelo=" . $datos["modelo"] . " "
                    . "GROUP BY ip_dimen.id_dimen;";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 6) {
                $this->sentencia = "SELECT ip_unidades.cod_unidad,UPPER(ip_unidades.nom_unidad)  as nom_unidad "
                    . "FROM im_items,ip_unidades "
                    . "WHERE im_items.unidad=ip_unidades.cod_unidad "
                    . "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marca"] . " "
                    . "AND im_items.modelo=" . $datos["modelo"] . " "
                    . "AND im_items.dimensiones=" . $datos["dimensiones"] . " "
                    . "GROUP BY ip_unidades.cod_unidad;";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 7) {
                //$this->sentencia = "SELECT im_items.cod_item,im_items.alter_item,CONCAT(im_items.cod_item,' - ',im_items.alter_item) as codigoItem "
                $this->sentencia = "SELECT im_items.cod_item,im_items.alter_item,im_items.cod_item as codigoItem "
                    . "FROM im_items "
                    . "WHERE im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marca"] . " "
                    . "AND im_items.modelo=" . $datos["modelo"] . " "
                    . "AND im_items.dimensiones=" . $datos["dimensiones"] . " "
                    . "AND im_items.unidad='" . $datos["unidad"] . "';";

                //echo $this->sentencia;
                //exit();
            }

            // Ajuste Diego B 17-07-2025 - Valor USD real con fallback a cp_precios_provee por alter_item
            if ($opcion === 8) {
                $this->sentencia = "SELECT * FROM im_items WHERE cod_item='" . $datos["cod_item"] . "'";
                $OB_CL_Base = new CL_Base();
                $resultado = $OB_CL_Base->leer($this->sentencia);

                if (isset($resultado[0])) {
                    $alterItem = trim($resultado[0]["alter_item"]);

                    // Paso 1: Obtener grupo_provee y vr_provee del item
                    $this->sentencia = "SELECT grupo_provee, vr_provee FROM cp_precios_provee WHERE ref_provee = '$alterItem' ORDER BY fecha_ultima DESC LIMIT 1";
                    $datosProvee = $OB_CL_Base->leer($this->sentencia);

                    if (isset($datosProvee[0])) {
                        $grupo = $datosProvee[0]['grupo_provee'];
                        $vr_provee = floatval($datosProvee[0]['vr_provee']);

                        // Paso 2: Obtener id_fact de factor 'salem'
                        $this->sentencia = "SELECT id_fact FROM cp_factor_provee WHERE fact_corto = 'salem' LIMIT 1";
                        $resFactor = $OB_CL_Base->leer($this->sentencia);

                        if (isset($resFactor[0]['id_fact'])) {
                            $id_fact = $resFactor[0]['id_fact'];

                            // Paso 3: Obtener multiplicador para ese grupo y factor
                            $this->sentencia = "SELECT valor FROM cp_multi_provee WHERE cod_grupo = '$grupo' AND id_fact = $id_fact LIMIT 1";
                            $resMulti = $OB_CL_Base->leer($this->sentencia);

                            if (isset($resMulti[0]['valor'])) {
                                $multiplicador = floatval($resMulti[0]['valor']);
                                $precioUSD = $vr_provee * $multiplicador;

                                if ($precioUSD > 0) {
                                    $resultado[0]['precio_vta_usd'] = $precioUSD;
                                }
                            } else {
                                // ❗ No hay multiplicador => llamar SP como fallback
                                $this->sentencia = "CALL spDaPrecioUsd('$datos[cod_item]', $vr_provee)";
                                $resSP = $OB_CL_Base->leer($this->sentencia);

                                if (isset($resSP[0]['valor_final'])) {
                                    $resultado[0]['precio_vta_usd'] = floatval($resSP[0]['valor_final']);
                                }
                            }
                        }
                    }

                    // Compatibilidad: igualar a precio_vta
                    $resultado[0]['precio_vta'] = $resultado[0]['precio_vta_usd'] ?? 0;
                }

                return $resultado;
            }
            //Fin ajuste 

            if ($opcion === 9) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . ";";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 10) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item='" . $datos["grup_item"] . "' "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marcas"] . ";";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 11) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marcas"] . " "
                    . "AND im_items.modelo=" . $datos["ip_modelos"] . ";";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 12) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marcas"] . " "
                    . "AND im_items.modelo=" . $datos["ip_modelos"] . " "
                    . "AND im_items.dimensiones=" . $datos["ip_dimens"] . ";";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 13) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marcas"] . " "
                    . "AND im_items.modelo=" . $datos["ip_modelos"] . " "
                    . "AND im_items.dimensiones=" . $datos["ip_dimens"] . " "
                    . "AND im_items.unidad='" . $datos["unidad"] . "';";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 14) {

                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND im_items.tipo_item=" . $datos["tipo_item"] . " "
                    . "AND im_items.linea=" . $datos["ip_lineas"] . " "
                    . "AND im_items.id_marca=" . $datos["ip_marcas"] . " "
                    . "AND im_items.modelo=" . $datos["ip_modelos"] . " "
                    . "AND im_items.dimensiones=" . $datos["ip_dimens"] . " "
                    . "AND im_items.unidad='" . $datos["unidad"] . "' "
                    . "AND im_items.cod_item='" . $datos["cod_item"] . "';";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 15) {
                $this->sentencia = IM_ITEMS1;
                $this->sentencia .= "AND im_items.cod_item='" . $datos["cod_item"] . "';";
                //echo $this->sentencia;
            }

            if ($opcion === 16) {
                $this->sentencia = IM_ITEMS2
                    . "where im_items.cod_item like '%" . $datos["cod_item"] . "%';";
            }

            if ($opcion === 17) {
                $this->sentencia = IM_ITEMS1;
            }

            if ($opcion === 18) {
                $this->sentencia = IM_ITEMS2
                    . "where im_items.alter_item like '%" . $datos["alter_item"] . "%';";
            }

            if ($opcion === 19) {
                $this->sentencia = IM_ITEMS2
                    . "where im_items.alter_item ='" . $datos["alter_item"] . "';";
                //echo $this->sentencia;
            }

            if ($opcion === 20) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.cod_item LIKE '%" . $datos["cod_item"] . "%' "
                    . "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    //. "AND linea='" . $datos["linea"] . "';";
                    . ";";
                //echo $this->sentencia; 
            }

            if ($opcion === 21) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.cod_item='" . $datos["cod_item"] . "' ";
            }

            if ($opcion === 22) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.alter_item LIKE '%" . $datos["alter_item"] . "%' "
                    . "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' ";
					//. "AND linea='" . $datos["linea"] . "';";
            }

            if ($opcion === 23) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.alter_item='" . $datos["alter_item"] . "' ";
            }

            if ($opcion === 24) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.nom_item LIKE '%" . $datos["nom_item"] . "%' "
                    . "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND linea='" . $datos["linea"] . "';";
                //echo $this->sentencia;
            }

            if ($opcion === 25) {
                $this->sentencia = IM_ITEMS1
                    . "AND im_items.nom_item='" . $datos["nom_item"] . "' ";
                //echo $this->sentencia;             
            }

            if ($opcion === 26) {
                $this->sentencia = IM_ITEMS3
                    . "AND im_items.cod_item='" . $datos["cod_item"] . "';";
            }

            if ($opcion === 27) {
				$this->sentencia = "SELECT 
					i.cod_item,
					i.alter_item,
					i.nom_item,
					i.unidad,
					i.grup_item,
					i.id_marca,
					i.tipo_item,
					i.modelo,
					i.dimensiones,
					i.precio_vta,
					i.precio_vta_usd,
					COALESCE(i.foto, '../img_inve/sin_imagen.jpg') AS foto,
					i.minimo,
					i.maximo,
					COALESCE(s.saldo, 0) AS saldo,
					CONCAT('Grupo ', i.grup_item) AS nom_grupo,
					CASE 
						WHEN i.id_marca > 0 THEN CONCAT('Marca ID:', i.id_marca) 
						ELSE 'Marca N/A' 
					END AS nom_marca,
					'Sin descripción' AS descrip,
					'N/A' AS descrip_modelo,
					'N/A' AS nom_dimen
				FROM im_items i
				LEFT JOIN ir_salinve s ON i.cod_item = s.cod_item AND s.codbodeg = 1
				WHERE i.cod_item = '" . $datos["cod_item"] . "'";
			}

            
            // if ($opcion === 27) {
            //     $sql = "SELECT ii.cod_item, ii.alter_item, ii.nom_item, 'Repuestos' AS nom_grupo, ii.nom_item AS descrip, 
            //                         COALESCE(m.nom_marca, 'GENÉRICO') AS nom_marca, 'N/A' AS descrip_modelo, 'N/A' AS nom_dimen, ii.unidad AS nom_unidad, 0 AS saldo, ii.precio_vta_usd AS precio_vta,
            //                         COALESCE(ii.foto, '../img_inve/sin_imagen.jpg') AS foto, ii.grup_item AS cod_grupo FROM im_items ii LEFT JOIN im_marca m ON m.id_marca = ii.id_marca
            //                         WHERE ii.cod_item = '" . $datos["cod_item"] . "' LIMIT 1 ";

            //     $base = new CL_Base();
            //     return $base->leer($sql);
            // }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //Nuevo aujste en crear para inserción de productos Diego B 14-07-2025
    public function crear($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "INSERT INTO im_items (
					cod_item, alter_item, nom_item, unidad, grup_item,
					id_proveedor, id_marca, unid_desgaste, cant_desgaste, facturable,
					area_item, articulo, tipo_item, num_parte, estado_item,
					iva, precio_vta, modelo, linea, peso,
					volumen, dimensiones, precio_vta_usd, minimo, maximo,
					foto
				) VALUES (
					'" . addslashes($datos["cod_item"]) . "',
					'" . addslashes($datos["alter_item"]) . "',
					'" . addslashes($datos["nom_item"]) . "',
					'" . addslashes($datos["unidad"]) . "',
					'" . addslashes($datos["grup_item"]) . "',
					" . (int) $datos["id_proveedor"] . ",
					" . (int) $datos["id_marca"] . ",
					'" . addslashes($datos["unid_desgaste"]) . "',
					" . (float) $datos["cant_desgaste"] . ",
					" . (int) $datos["facturable"] . ",
					" . (int) $datos["area_item"] . ",
					'" . addslashes($datos["articulo"]) . "',
					'" . addslashes($datos["tipo_item"]) . "',
					'" . addslashes($datos["num_parte"]) . "',
					" . (int) $datos["estado_item"] . ",
					" . (float) $datos["iva"] . ",
					" . (float) $datos["precio_vta"] . ",
					'" . addslashes($datos["modelo"]) . "',
					" . (int) $datos["linea"] . ",
					'" . addslashes($datos["peso"]) . "',
					'" . addslashes($datos["volumen"]) . "',
					'" . addslashes($datos["dimensiones"]) . "',
					" . (float) $datos["precio_vta_usd"] . ",
					" . (int) $datos["minimo"] . ",
					" . (int) $datos["maximo"] . ",
					'" . addslashes($datos["foto"]) . "'
				);";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo json_encode([
                "status" => "error",
                "mensaje" => "Error en la base de datos: " . $exc->getMessage()
            ]);
            exit;
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update im_items set ";
            if ($opcion === 1) {
                $this->sentencia .= "foto='" . $datos["foto"] . "' ";
            }

            if ($opcion === 2) {

                $this->sentencia .= "alter_item='" . $datos["alter_item"] . "',nom_item='" . $datos["nom_item"] . "',unidad='" . $datos["unidad"] . "',"
                    . "grup_item='" . $datos["grup_item"] . "',id_proveedor=" . $datos["id_proveedor"] . ",id_marca=" . $datos["id_marca"] . ",unid_desgaste=" . $datos["unid_desgaste"] . ","
                    . "cant_desgaste=" . $datos["cant_desgaste"] . ",facturable=" . $datos["facturable"] . ",area_item=" . $datos["area_item"] . ",articulo=" . $datos["articulo"] . ","
                    . "tipo_item=" . $datos["tipo_item"] . ",num_parte='" . $datos["num_parte"] . "',estado_item=" . $datos["estado_item"] . ",iva=" . $datos["iva"] . ","
                    . "precio_vta=" . $datos["precio_vta"] . ",modelo=" . $datos["modelo"] . ",linea='" . $datos["linea"] . "',peso='" . $datos["peso"] . "',volumen='" . $datos["volumen"] . "',"
                    . "dimensiones='" . $datos["dimensiones"] . "',precio_vta_usd=" . $datos["precio_vta_usd"] . ",minimo=" . $datos["minimo"] . ",maximo=" . $datos["maximo"] . " ";
            }

            if ($opcion === 3) {

                foreach ($datos as $clave => $valor) {
                    if ($clave !== 'ap_camposx' && $clave !== 'numid') {
                        $this->sentencia .= $clave . '="' . str_replace('"', "'", $valor) . '", ';
                    }
                }

                $this->sentencia = substr($this->sentencia, 0, -2);
                $this->sentencia .= " ";
            }

            $this->sentencia .= "where cod_item='" . $datos["cod_item"] . "';";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ejecutarPA($datos, $opcion)
    {
        try {
            $conexion = new CL_conexion();
            if ($opcion === 1) {
                $codigo_item = $datos["alter_item"];
                $conexion->ejecutarInsertUpdateDelete("CALL spDaPrecioUsd('$codigo_item', @valor)");
                // Recuperar el valor de salida del procedimiento almacenado
                $resultado = $conexion->retornar("SELECT @valor AS valor");
                $valor = $resultado[0]['valor'];
            }
            $conexion = null;

            return $valor;
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
