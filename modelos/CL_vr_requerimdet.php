<?php

include_once '../modelos/CL_Base.php';

class CL_vr_requerimdet
{

    private $sentencia;

    public function leer($datos, $opcion)
    {
        try {
            if ($opcion === 1) {
                $this->sentencia = "SELECT vr_requerimdet.id_requerim,vr_requerimdet.id_reqdet,vr_requerimdet.linea,"
                    . "vr_requerimdet.misional,vr_requerimdet.articulo,vr_requerimdet.tipo,vr_requerimdet.marca,"
                    . "vr_requerimdet.cod_item,vr_requerimdet.cantidad,vr_requerimdet.observs,vr_requerimdet.a_compras,"
                    ."CAST((SELECT saldo FROM ir_salinve WHERE ir_salinve.cod_item=vr_requerimdet.cod_item AND ir_salinve.codbodeg=1) AS INT) as saldo,"
                    ."CAST((SELECT minimo FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) AS INT) as minimo,"
                    ."UPPER(ip_grupos.nom_grupo) as nom_grupo,vr_requerimdet.modo_import "
                    . "from vr_requerimdet,ip_grupos "                    
                    ."where vr_requerimdet.misional=ip_grupos.cod_grupo "
                    . "and id_requerim=" . $datos["id_requerim"] . ";";
            }

            if ($opcion === 2) {
                $this->sentencia = "SELECT vr_requerimdet.id_requerim,vr_requerimdet.id_reqdet,vr_requerimdet.linea,"
                    . "vr_requerimdet.misional,vr_requerimdet.articulo,vr_requerimdet.tipo,vr_requerimdet.marca,"
                    . "vr_requerimdet.cod_item,vr_requerimdet.cantidad,vr_requerimdet.observs,"
                    . "(SELECT im_items.iva FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as iva,"
                    . "(SELECT im_items.precio_vta FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as precio_vta,"
                    . "(SELECT nom_item FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as nom_item,"
                    . "ir_salinve.saldo,vr_requerimdet.modo_import "
                    . "FROM vr_requerimdet,ir_salinve "
                    . "WHERE vr_requerimdet.cod_item=ir_salinve.cod_item "                    
                    . "AND vr_requerimdet.id_requerim=" . $datos["id_requerim"] . " "
                    . "AND ir_salinve.codbodeg=1;";
            }

            
            if ($opcion === 3) {
                $this->sentencia = "SELECT vr_requerimdet.id_requerim,vr_requerimdet.id_reqdet,vr_requerimdet.linea,"
                ."vr_requerimdet.misional,vr_requerimdet.articulo,vr_requerimdet.tipo,vr_requerimdet.marca,vr_requerimdet.cod_item,"
                ."vr_requerimdet.cantidad,vr_requerimdet.observs,"
                ."(SELECT im_items.iva FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as iva,"
                ."(SELECT im_items.precio_vta FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as precio_vta,"
                ."(SELECT nom_item FROM im_items WHERE im_items.cod_item=vr_requerimdet.cod_item) as nom_item,vr_requerimdet.modo_import "
                ."FROM vr_requerimdet "
                ."WHERE  vr_requerimdet.id_requerim=" . $datos["id_requerim"] . " ";
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
                $this->sentencia = "insert into vr_requerimdet (id_requerim,id_reqdet,linea,misional,articulo,tipo,marca,cod_item,cantidad,observs,a_compras,modo_import) "
                    . "values(" . $datos["id_requerim"] . ",null,'" . $datos["linea"] . "','" . $datos["misional"] . "','" . $datos["articulo"] . "'," . $datos["tipo"] . "," . $datos["marca"] . ",'" . $datos["cod_item"] . "'," . $datos["cantidad"] . ",'" . $datos["observs"] . "',0,1)";
            }
            //echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function borrar($datos, $opcion)
    {
        try {

            if ($opcion === 1) {
                $this->sentencia = "delete from vr_requerimdet where id_reqdet=" . $datos["id_reqdet"] . ";";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->borrar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function actualizar($datos, $opcion)
    {
        try {
            $this->sentencia = "update vr_requerimdet set ";
            if ($opcion === 1) {
                $this->sentencia .= " a_compras=" . $datos["a_compras"] . " ";
            }

            if($opcion===2){
                $this->sentencia .= " modo_import=" . $datos["modo_import"] . " ";
            }

            $this->sentencia .= "where id_reqdet=" . $datos["id_reqdet"] . ";";
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ejecutarPA($datos, $opcion)
    {
        try {

            if ($opcion === 1) {
                $this->sentencia = " CALL " . $datos["nombrePA"] . "(" . $datos["id_requerim"] . ");";
            }

            //echo $this->sentencia; exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->ejecutarPA($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}
