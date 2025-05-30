<?php

include_once '../modelos/CL_Base.php';

class CL_nm_empleados {

    private $sentencia;

    public function leer($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "select * "
                        . "from nm_empleados "
                        . "where nm_empleados.numid=" . $datos["numid"] . ";";
            }
            
            if($opcion===2){
                $this->sentencia = "select nm_empleados.codemple,CONCAT(nm_personas.apellidos,' ',nm_personas.nombres) as nombreEmpleado,"
                        ."np_cargos.nom_cargo,nm_sucursal.telefono,nm_personas.nombres,nm_personas.apellidos "
                        . "from nm_empleados,nm_personas,np_cargos,nm_sucursal "
                        . "where nm_empleados.numid=nm_personas.numid "
                        . "and nm_empleados.id_cargo=np_cargos.id_cargo "
                        . "and nm_empleados.numid=nm_sucursal.numid "
                        . "and nm_empleados.codemple='" . $datos["codemple"] . "';";
            }

            if($opcion===3){
                //cargo_dicom
                $this->sentencia="SELECT e.codemple INTO usudircompras FROM nm_empleados e "
                ."WHERE id_cargo IN ( SELECT valor FROM ap_param WHERE variable='".$datos["variable"]."' );";
            }

            //echo $this->sentencia;exit();

            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->leer($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function crear($datos, $opcion) {
        try {
            if ($opcion === 1) {
                $this->sentencia = "insert into nm_empleados (codemple,fecha_ingreso,fecha_retiro,id_estado,numid,id_cargo,id_nivel,contrato,cesantias,pension,eps,usuario) values "
                        . "('".$datos["codemple"]."','".$datos["fecha_ingreso"]."','".$datos["fecha_retiro"]."',".$datos["id_estado"].",'".$datos["numid"]."','".$datos["id_cargo"]."',".$datos["id_nivel"].",".$datos["contrato"].",".$datos["cesantias"].",".$datos["pension"].",".$datos["eps"].",'".$datos["usuario"]."');";
            }
           // echo $this->sentencia; exit();
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->crear($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
/*
    public function actualizar($datos, $opcion) {
        try {
            $this->sentencia = "update nm_empleados set ";
            if ($opcion === 1) {
                $this->sentencia .= "apellidos='" . $datos["apellidos"] . "',"
                        . "nombres='".$datos["nombres"]."',"
                        . "sexo=".$datos["sexo"].","
                        . "est_civil=".$datos["est_civil"].","
                        . "fecha_naci='".$datos["fecha_naci"]."',"
                        . "tipo_sangre=".$datos["tipo_sangre"].","
                        . "apelli_nom='".$datos["apelli_nom"]."' ";
                $this->sentencia .= "where numid='" . $datos["numid"] . "';";
            }
            
            //echo $this->sentencia; exit();
            
            $OB_CL_Base = new CL_Base();
            return $OB_CL_Base->actualizar($this->sentencia);
        } catch (PDOException $exc) {
            echo $exc->getTraceAsString();
        }
    }
    */
}
