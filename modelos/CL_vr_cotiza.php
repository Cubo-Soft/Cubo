<?php

include_once '../modelos/CL_Base.php';

class CL_vr_cotiza
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * "
                    . "from vr_cotiza "
                    . "where nro_cot=" . $datos["nro_cot"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia = "select vr_cotiza.id_consecot,vr_cotiza.nro_cot,vr_cotiza.version,vr_cotiza.fecha_ini,"
                    . "vr_cotiza.suc_cliente,vr_cotiza.id_contacto,vr_cotiza.fecha_vence,vr_cotiza.id_moneda,"
                    . "vr_cotiza.subtotal,vr_cotiza.iva,vr_cotiza.descuento,vr_cotiza.trans_base,"
                    . "vr_cotiza.termn_pago,vr_cotiza.autoriza,vr_cotiza.estado,vr_cotiza.cod_grabador,"
                    . "(SELECT numid FROM nm_sucursal WHERE id_sucursal=vr_cotiza.suc_cliente ) as numid,"
                    . "vp_terminospago.descrip as terminoPago,ip_dtbasicos.dt_basico as moneda,"
                    . "vr_cotiza.vigencia,vr_cotiza.sem_entrega,vr_cotiza.vr_descuento "
                    . "from vr_cotiza,vp_terminospago,ip_dtbasicos "
                    . "where vr_cotiza.termn_pago=vp_terminospago.id_termino "
                    . "and vr_cotiza.id_moneda=ip_dtbasicos.sec_basico "
                    . "and id_consecot=" . $datos["id_consecot"] . ";";
            }

            if ($opcion === 3) {
                $this->sentencia = "SELECT vr_cotiza.id_consecot "
                    . "FROM vr_cotiza "
                    . "WHERE vr_cotiza.estado=110 "
                    . "AND vr_cotiza.cod_grabador='" . $datos["usuario"] . "'";
            }

            if ($opcion === 4) {
                $this->sentencia = "SELECT vr_cotiza.id_consecot,vr_cotiza.nro_cot,vr_cotiza.version,DATE_FORMAT(vr_cotiza.fecha_ini,'%d-%m-%Y') as fecha_ini,"
                    . "vr_cotiza.suc_cliente,vr_cotiza.id_contacto,vr_cotiza.fecha_vence,vr_cotiza.id_moneda,vr_cotiza.subtotal,"
                    . "vr_cotiza.iva,vr_cotiza.descuento,vr_cotiza.termn_pago,vr_cotiza.autoriza,vr_cotiza.estado,vr_cotiza.cod_grabador,"
                    . "(SELECT nm_sucursal.numid FROM nm_sucursal WHERE nm_sucursal.id_sucursal=vr_cotiza.suc_cliente) as numid,"
                    . "(SELECT nm_juridicas.razon_social FROM nm_juridicas WHERE nm_juridicas.numid=(SELECT nm_sucursal.numid FROM nm_sucursal WHERE nm_sucursal.id_sucursal=vr_cotiza.suc_cliente)) as razon_social_empresa, "
                    . "(SELECT nm_personas.apelli_nom FROM nm_personas WHERE nm_personas.numid=(SELECT nm_sucursal.numid FROM nm_sucursal WHERE nm_sucursal.id_sucursal=vr_cotiza.suc_cliente)) as nombre_persona,"
                    . "(SELECT np_ciudades.nom_ciudad FROM np_ciudades WHERE np_ciudades.id_ciudad= (SELECT nm_sucursal.ciudad FROM nm_sucursal WHERE nm_sucursal.id_sucursal=vr_cotiza.suc_cliente)) as ciudad,"
                    . "(SELECT UPPER(am_usuarios.nombre) FROM am_usuarios WHERE am_usuarios.codusr=vr_cotiza.cod_grabador) as usuario,"
                    . "(SELECT UPPER(nm_sucursal.nom_sucur) FROM nm_sucursal WHERE nm_sucursal.id_sucursal=vr_cotiza.suc_cliente) as sucursal,"
                    . "ip_dtbasicos.dt_basico as nombreEstado,vr_cotizadet.misional "
                    . "FROM vr_cotiza,ip_dtbasicos,vr_cotizadet "
                    . "WHERE vr_cotiza.estado=ip_dtbasicos.sec_basico "
                    . "AND vr_cotiza.id_consecot=vr_cotizadet.id_consecot "
                    . "AND vr_cotiza.fecha_ini BETWEEN '" . $datos["fechaInicial"] . "' AND '" . $datos["fechaFinal"] . "' ";

                if ($datos["usuario"] !== '-2') {
                    $this->sentencia .= "AND vr_cotiza.cod_grabador='" . $datos["usuario"] . "'";
                }

                if ($datos["estado"] !== '-1' && $datos["estado"] !== '-2') {
                    $this->sentencia .= "AND vr_cotiza.estado='" . $datos["estado"] . "'";
                }

                $this->sentencia .= "GROUP BY vr_cotiza.id_consecot "
                    . "ORDER BY vr_cotiza.nro_cot;";

            }

            if ($opcion === 5) {
                $this->sentencia = "select * "
                    . "from vr_cotiza "
                    . "where vr_cotiza.id_consecot=" . $datos["id_consecot"] . ";";
            }

            if ($opcion === 6) {
                $this->sentencia = "select * "
                    . "from vr_cotiza "
                    . "where nro_cot=" . $datos["nro_cot"] . " "
                    //."and version=".$datos["version"]." "
                    . "order by id_consecot desc limit 1;";
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
                $this->sentencia = "insert into vr_cotiza (id_consecot,cod_trans,nro_cot,version,fecha_ini,trans_base,ctro_costo,suc_cliente,"
                    . "id_contacto,vigencia,fecha_vence,id_moneda,subtotal,iva,descuento,vr_descuento,termn_pago,"
                    . "autoriza,estado,sem_entrega,cod_grabador,cod_asesor) "
                    . "values(null,'" . $datos["cod_trans"] . "'," . $datos["nro_cot"] . "," . $datos["version"] . ",'" . $datos["fecha_ini"] . "','" . $datos["trans_base"] . "','" . $datos["ctro_costo"] . "'," . $datos["suc_cliente"] . ","
                    . "" . $datos["id_contacto"] . "," . $datos["vigencia"] . ",'" . $datos["fecha_vence"] . "'," . $datos["id_moneda"] . ","
                    . "" . $datos["subtotal"] . "," . $datos["iva"] . "," . $datos["descuento"] . "," . $datos["vr_descuento"] . "," . $datos["termn_pago"] . ","
                    . "'" . $datos["autoriza"] . "'," . $datos["estado"] . "," . $datos["sem_entrega"] . ",'" . $datos["cod_grabador"] . "',0);";
            }
            /*echo $this->sentencia; 
            exit();*/
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {

            $this->sentencia = "update vr_cotiza set ";

            if ($opcion === 1) {
                $this->sentencia .= "termn_pago=" . $datos["termn_pago"] . ",estado=" . $datos["estado"] . ","
                    . "id_moneda=" . $datos["id_moneda"] . ",vigencia=" . $datos["vigencia"] . ",fecha_vence='" . $datos["fecha_vence"] . "',"
                    . "sem_entrega=" . $datos["sem_entrega"] . ",suc_cliente=" . $datos["suc_cliente"] . ",id_contacto=" . $datos["id_contacto"] . " ";
            }

            if ($opcion === 2) {
                $this->sentencia .= "subtotal=" . $datos["subtotal"] . ",iva=" . $datos["iva"] . ",descuento=" . $datos["descuento"] . ",vr_descuento=" . $datos["vr_descuento"] . ",cod_asesor='" . $datos["cod_asesor"] . "' ";
            }

            if ($opcion === 3) {
                $this->sentencia .= "subtotal=" . $datos["subtotal"] . ",iva=" . $datos["iva"] . ",descuento=" . $datos["descuento"] . ",vr_descuento=" . $datos["vr_descuento"] . ",cod_asesor='" . $datos["cod_asesor"] . "',estado=113 ";
            }

            if($opcion===4){
                $this->sentencia.="estado=111 ";
            }

            $this->sentencia .= "where id_consecot=" . $datos["id_consecot"] . ";";

            //echo $this->sentencia; exit();           

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
