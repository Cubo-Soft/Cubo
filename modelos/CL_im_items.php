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
                    ."ORDER BY ip_grupos.nom_grupo ";
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

            if ($opcion === 8) {

                $this->sentencia = "select * "
                    . "from im_items "
                    . "where im_items.cod_item='" . $datos["cod_item"] . "';";

                //echo $this->sentencia;
                //exit();
            }

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
                    . "AND linea='" . $datos["linea"] . "';";
                //echo $this->sentencia; 
            }

            if ($opcion === 21) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.cod_item='" . $datos["cod_item"] . "' ";
            }

            if ($opcion === 22) {
                $this->sentencia = IM_ITEMS2
                    . "WHERE im_items.alter_item LIKE '%" . $datos["alter_item"] . "%' "
                    . "AND im_items.grup_item LIKE '" . $datos["grup_item"] . "%' "
                    . "AND linea='" . $datos["linea"] . "';";
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
                $this->sentencia = "insert into im_items (cod_item,alter_item,nom_item,unidad,grup_item,
               id_proveedor,id_marca,unid_desgaste,cant_desgaste,facturable,
               area_item,articulo,tipo_item,num_parte,estado_item,
               iva,precio_vta,modelo,linea,peso,
               volumen,dimensiones,precio_vta_usd,minimo,maximo,
               foto) values "
                    . "('" . $datos["cod_item"] . "','" . $datos["alter_item"] . "','" . $datos["nom_item"] . "','" . $datos["unidad"] . "','" . $datos["grup_item"] . "',"
                    . $datos["id_proveedor"] . "," . $datos["id_marca"] . "," . $datos["unid_desgaste"] . "," . $datos["cant_desgaste"] . "," . $datos["facturable"] . ","
                    . $datos["area_item"] . "," . $datos["articulo"] . "," . $datos["tipo_item"] . ",'" . $datos["num_parte"] . "'," . $datos["estado_item"] . ","
                    . $datos["iva"] . "," . $datos["precio_vta"] . "," . $datos["modelo"] . ",'" . $datos["linea"] . "','" . $datos["peso"] . "','"
                    . $datos["volumen"] . "','" . $datos["dimensiones"] . "'," . $datos["precio_vta_usd"] . "," . $datos["minimo"] . "," . $datos["maximo"] . ",'"
                    . $datos["foto"] . "');";
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
