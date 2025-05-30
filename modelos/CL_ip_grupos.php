<?php

include_once '../modelos/CL_Base.php';

class CL_ip_grupos {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                        . "FROM ip_grupos "
                        . "WHERE LENGTH(ip_grupos.cod_grupo)=2; ";
            }

            if ($opcion === 2) {
                $this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                        . "FROM ip_grupos "
                        . "WHERE  ip_grupos.cod_grupo LIKE '01%' "
                        . "AND ip_grupos.subdivide='N' "
                        . "ORDER BY ip_grupos.nom_grupo;";

                //echo $this->sentencia; exit();
            }
            
            if($opcion===3){
                $this->sentencia="SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                        . "from ip_grupos "
                        . "where cod_grupo='".$datos["cod_grupo"]."';";
                
                //echo $this->sentencia;
            }
            if ($opcion === 4) {
                $this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                        . "FROM ip_grupos "
                        . "WHERE  ip_grupos.cod_grupo LIKE '03%' "
                        . "AND ip_grupos.subdivide='N' "
                        . "ORDER BY ip_grupos.nom_grupo;";

                //echo $this->sentencia; exit();
            }

            if($opcion===5){
                $this->sentencia = "SELECT ip_grupos.cod_grupo,UPPER(ip_grupos.nom_grupo) as nom_grupo "
                . "FROM ip_grupos "
                . "WHERE ip_grupos.cod_grupo LIKE '02%' "
                . "AND ip_grupos.subdivide='N' "
                . "GROUP BY ip_grupos.cod_grupo "
                ."ORDER BY ip_grupos.nom_grupo ";
            }
           
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

//    public function crear($datos, $opcion) {
//        try {
//            if ($opcion === 1) {
//                $this->sentencia = "insert into ip_articulos (id_articulo,descrip) values "
//                        . "('" . $datos["id_articulo"] . "','" . $datos["descrip"] . "');";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->crear($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
//
//    public function actualizar($datos, $opcion) {
//        try {
//            $this->sentencia = "update ip_articulos set ";
//            if ($opcion === 1) {
//                $this->sentencia .= "descrip='" . $datos["descrip"] . "' ";
//                $this->sentencia .= "where id_articulo='" . $datos["id_articulo"] . "';";
//            }
//            $OB_CL_Base = new CL_Base();
//            return $OB_CL_Base->actualizar($this->sentencia);
//        } catch (PDOException $exc) {
//            echo $exc->getTraceAsString();
//        }
//    }
}
