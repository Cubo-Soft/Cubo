<?php

include_once '../modelos/CL_Base.php';
include_once '../modelos/consultas_constantes.php';

class CL_ir_operaciones
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {

            if ($opcion === 1) {

                $this->sentencia = "SELECT * "
                    . "FROM ir_operaciones "
                    . "WHERE num_antiguo_trans=" . $datos["num_antiguo_trans"] . " "
                    . "AND trans_base='" . $datos["trans_base"] . "';";

                //echo $this->sentencia;
                //exit();
            }

            if ($opcion === 2) {
                    $this->sentencia="SELECT CASE "
                    ."WHEN nm_personas.apelli_nom IS NOT NULL THEN nm_personas.apelli_nom "
                    ."ELSE nm_juridicas.razon_social "
                    ."END AS nombre_persona,nm_nits.numid,ir_operaciones.id_suc_cliente  "
                    ."FROM nm_nits "
                    ."LEFT JOIN nm_personas ON nm_personas.numid=nm_nits.numid "
                    ."LEFT JOIN nm_juridicas ON nm_juridicas.numid=nm_nits.numid " 
                    ."LEFT JOIN nm_sucursal ON nm_sucursal.numid=nm_nits.numid "
                    ."LEFT JOIN ir_operaciones ON ir_operaciones.id_suc_cliente=nm_sucursal.id_sucursal "
                    ."WHERE ir_operaciones.estado=120 "
                    ."AND ir_operaciones.cod_trans='REQ' "
                  ."GROUP BY nm_nits.numid ;";
            }

            if ($opcion === 3) {
                $this->sentencia = "SELECT nm_personas.apelli_nom,ir_operaciones.codemple,ir_operaciones.id_operacion "
                    . "FROM ir_operaciones,nm_empleados,nm_personas "
                    . "WHERE ir_operaciones.codemple=nm_empleados.codemple "
                    . "AND nm_empleados.numid=nm_personas.numid "
                    . "AND ir_operaciones.estado=120 "
                    . "AND ir_operaciones.cod_trans='REQ' "
                    . "GROUP BY nm_personas.apelli_nom;";
            }

            if ($opcion === 4) {
                $this->sentencia = "SELECT ir_operaciones.id_operacion,CONCAT('COD ITEM: ',im_items.cod_item,' - DESCRIP: ',im_items.nom_item) as cod_item_concat,im_items.cod_item "
                    . "FROM ir_operaciones,im_items,ir_detalle_oper "
                    . "WHERE ir_operaciones.id_operacion=ir_detalle_oper.id_operacion "
                    . "AND ir_detalle_oper.cod_item=im_items.cod_item "
                    . "AND ir_operaciones.estado=120 "
                    . "AND ir_operaciones.cod_trans='REQ' "
                    ."GROUP BY im_items.cod_item;";
            }

            if ($opcion === 5) {
                $this->sentencia = "SELECT ir_operaciones.id_operacion "
                    . "FROM ir_operaciones "
                    . "WHERE ir_operaciones.estado=120 "
                    . "AND ir_operaciones.cod_trans='REQ';";
            }

            if ($opcion === 6) {
                $this->sentencia = IROPERACIONES1;
                $this->sentencia .= "and ir_operaciones.id_suc_cliente=" . $datos["id_suc_cliente"] . " ";
            }

            if ($opcion === 7) {
                $this->sentencia = IROPERACIONES1;
                $this->sentencia .= "and ir_operaciones.codemple='" . $datos["codemple"] . "' ";
            }

            if ($opcion === 8) {
                $this->sentencia = IROPERACIONES1;
                $this->sentencia .= "and im_items.cod_item='" . $datos["cod_item"] . "' ";
            }

            if ($opcion === 9) {
                $this->sentencia = IROPERACIONES1;
                $this->sentencia .= "and ir_operaciones.id_operacion=" . $datos["id_operacion"] . " ";
            }

            if ($opcion === 6 || $opcion === 7 || $opcion === 8 || $opcion === 9) {
                $this->sentencia .= "AND ir_operaciones.estado=" . $datos["estado"] . " "
                    . "AND ir_operaciones.fecha_registro BETWEEN '" . $datos["fechaInicial"] . " 01:00:00' AND '" . $datos["fechaFinal"] . " 23:59:00';";
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
                $this->sentencia = "insert into ir_resinve (id_operacion,cod_trans,numero_trans,version,fecha_registro,fecha_entrega,"
                    . "fecha_vence,trans_base,id_suc_cliente,codemple,id_area,"
                    . "c_costo,origen,destino,id_moneda,trm,subtotal,"
                    . "iva_total,descuento,cod_grabador,num_antiguo_trans,"
                    . "estado,id_financia,terminospago,vr_descuento) values "
                    . "(null,'" . $datos["cod_trans"] . "'," . $datos["numero_trans"] . "," . $datos["version"] . ",'" . $datos["fecha_registro"] . "','" . $datos["fecha_entrega"] . "',
                       '" . $datos["fecha_vence"] . "','" . $datos["trans_base"] . "'," . $datos["id_suc_cliente"] . ",'" . $datos["codemple"] . "'," . $datos["id_area"] . ","
                    . $datos["c_costo"] . "," . $datos["origen"] . "," . $datos["destino"] . "," . $datos["id_moneda"] . "," . $datos["trm"] . "," . $datos["subtotal"] . ","
                    . $datos["iva_total"] . "," . $datos["descuento"] . ",'" . $datos["cod_grabador"] . "','" . $datos["num_antiguo_trans"] . "',"
                    . $datos["estado"] . "," . $datos["id_financia"] . "," . $datos["terminospago"] . "," . $datos["vr_descuento"] . ");";
            }
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    //    public function borrar($datos, $opcion)
    //     {
    //         try {
    //             if ($opcion === 1) {
    //                 $this->sentencia = "delete from ";
    //             }
    //             //echo $this->sentencia; exit();
    //             $OB_CL_Base = new CL_Base();
    //             return $OB_CL_Base->borrar($this->sentencia);
    //         } catch (PDOException $exc) {
    //             echo $exc->getTraceAsString();
    //         }
    //     }
    //
       public function actualizar($datos, $opcion) {
           try {
               $this->sentencia = "update ir_operaciones set ";
               if ($opcion === 1) {
                   $this->sentencia .= "estado=120 ";
                   $this->sentencia .= "where estado=1;";
               }
               $OB_CL_Base = new CL_Base();
               return $OB_CL_Base->actualizar($this->sentencia);
           } catch (PDOException $exc) {
               echo $exc->getTraceAsString();
           }
       }
}
