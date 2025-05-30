<?php

include_once '../modelos/CL_Base.php';

class CL_vr_cotizadet
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select vr_cotizadet.*,im_items.alter_item "
                    . "from vr_cotizadet,im_items "
                    . "where vr_cotizadet.cod_item=im_items.cod_item "
                    ."AND vr_cotizadet.id_consecot=" . $datos["id_consecot"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia = "SELECT vr_cotizadet.id_consecot,vr_cotizadet.version,"
                    . "vr_cotizadet.id_orden,vr_cotizadet.opcion,vr_cotizadet.linea,vr_cotizadet.misional,"
                    . "vr_cotizadet.articulo,vr_cotizadet.tipo,vr_cotizadet.marca,vr_cotizadet.cod_item,"
                    . "vr_cotizadet.cod_item,vr_cotizadet.descrip,vr_cotizadet.cantidad,"
                    . "vr_cotizadet.valor_unit,vr_cotizadet.iva_referencia,vr_cotizadet.observs,ip_lineas.descrip as descripLinea "
                    . "FROM vr_cotizadet,ip_lineas "
                    . "WHERE vr_cotizadet.linea=ip_lineas.id_linea "
                    . "and vr_cotizadet.id_consecot=" . $datos["id_consecot"] . ";";
            }

            if ($opcion === 3) {
                $this->sentencia = "SELECT vr_cotizadet.id_consecot,vr_cotizadet.version,"
                    . "vr_cotizadet.id_orden,vr_cotizadet.opcion,vr_cotizadet.linea,vr_cotizadet.misional,"
                    . "vr_cotizadet.articulo,vr_cotizadet.tipo,vr_cotizadet.marca,vr_cotizadet.cod_item,"
                    . "vr_cotizadet.cod_item,vr_cotizadet.descrip,vr_cotizadet.cantidad,vr_cotizadet.dscto_item,"
                    . "vr_cotizadet.valor_unit,vr_cotizadet.iva_referencia,vr_cotizadet.observs,vr_cotizadet.sem_dispo,ip_lineas.descrip as descripLinea,"
                    . "UPPER(ip_grupos.nom_grupo) as descripcionArticulo, UPPER(ip_tipos.descrip) as descripcionTipo,"
                    . "(SELECT nom_marca FROM ip_marcas WHERE ip_marcas.id_marca=vr_cotizadet.marca ) as nom_marca "
                    . "FROM vr_cotizadet,ip_lineas,ip_grupos,ip_tipos "
                    . "WHERE vr_cotizadet.articulo=ip_grupos.cod_grupo "
                    . "and vr_cotizadet.tipo=ip_tipos.id_tipo "
                    . "and vr_cotizadet.linea=ip_lineas.id_linea "
                    . "and vr_cotizadet.id_consecot=" . $datos["id_consecot"] . ";";
            }

            if($opcion===4){
                $this->sentencia="select * 
                from vr_cotizadet 
                where vr_cotizadet.id_consecot=". $datos["id_consecot"] . ";";
            }

            if($opcion===5){
                $this->sentencia="select misional "
                ."from vr_cotiza,vr_cotizadet "
                ."where vr_cotiza.id_consecot=vr_cotizadet.id_consecot "
                ."and vr_cotiza.id_consecot=".$datos["id_consecot"].";";
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
                $this->sentencia = "insert into vr_cotizadet (id_consecot,version,id_orden,opcion,linea,misional,articulo,tipo,marca,cod_item,descrip,cantidad,valor_unit,dscto_item,iva_referencia,observs,sem_dispo) "
                    . "values(" . $datos["id_consecot"] . "," . $datos["version"] . ",null," . $datos["opcion"] . ",'" . $datos["linea"] . "','" . $datos["misional"] . "','" . $datos["articulo"] . "'," . $datos["tipo"] . "," . $datos["marca"] . ",'" . $datos["cod_item"] . "','" . $datos["descrip"] . "'," . $datos["cantidad"] . "," . $datos["valor_unit"] . "," . $datos["dscto_item"] . "," . $datos["iva_referencia"] . ",'" . $datos["observs"] . "'," . $datos["sem_dispo"] . ");";
            }
            //echo $this->sentencia;
            //exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {

            $this->sentencia = "update vr_cotizadet set ";
            if ($opcion === 1) {
                $this->sentencia .= "vr_cotizadet.cantidad=" . $datos["cantidad"] . " ";
            }

            if ($opcion === 2) {
                $this->sentencia .= "vr_cotizadet.observs='" . $datos["observs"] . "' ";
            }

            if ($opcion === 3) {
                $this->sentencia .= "valor_unit=" . $datos["valor_unit"] . " ";
            }

            if ($opcion === 4) {
                $this->sentencia .= "tipo=" . $datos["tipo"] . ",marca=" . $datos["marca"] . " ";
            }

            if ($opcion === 5) {
                $this->sentencia .= "dscto_item=" . $datos["dscto_item"] . " ";
            }

            if ($opcion === 6) {
                $this->sentencia .= "sem_dispo=" . $datos["sem_dispo"] . " ";
            }

            $this->sentencia .= "where id_orden=" . $datos["id_orden"] . ";";

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function borrar($datos, $opcion)
    {
        try {

            if ($opcion === 1) {
                $this->sentencia = "delete from vr_cotizadet where id_orden=" . $datos["id_orden"] . ";";
            }

            //echo $this->sentencia; 
            //exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
