<?php
include_once '../modelos/CL_Base.php';

class CL_cp_precios_provee {
    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "
                SELECT 
                    g.cod_grupo,
                    g.numid_prov,
                    g.idmarca,
                    m.nom_marca,
                    p.ref_provee,
                    p.descrip,
                    p.estado AS std_precio,
                    p.vr_provee,
                    p.fecha_ultima,
                    p.id_moneda,
                    mon.alf_codigo AS abr_moneda
                FROM cp_grupos_provee g
                JOIN cp_precios_provee p ON g.cod_grupo = p.grupo_provee
                JOIN ip_marcas m ON g.idmarca = m.id_marca
                JOIN am_monedas mon ON p.id_moneda = mon.id
                WHERE p.ref_provee = '" . $datos["ref_provee"] . "'
                LIMIT 1;";
            }

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
}