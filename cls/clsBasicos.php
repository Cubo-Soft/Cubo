<?php
include_once("clsTablam.php");

class clsBasicos extends Tabla{
 
    private $dtbasic;
    private $bsbasic;
    public function __construct($odb,$ntabla="ip_basicos"){
        parent::__construct($odb,$ntabla);
        $this->dtbasic = new Tabla($odb,"ip_dtbasicos");
        $this->bsbasic = new Tabla($odb,"ip_basicos_tab");
    }
    public function opc_tablas($odb,$ntabla,$campo,$opcion=""){
        $clase = " class='form-select form-select-sm' ";
        $w = " WHERE estado = true AND id_basico IN 
            (SELECT bst.id_basico FROM ip_basicos_tab bst WHERE bst.tabla='$ntabla' AND bst.campo='".$campo."') ";
        $r = $this->dtbasic->leec("sec_basico,dt_basico",$w,0,"C");
        $opciones = "<SELECT name='".$campo."' $clase onchange=\"cambia('".$campo."');\">
            <option value=''>Sin elegir </option>
            ";
        for( $x=0; $x < count( $r ); $x++ ){
            $opciones .= "<option value='".$r[$x][0]."'";
            if( $opcion != "" && $opcion == $r[$x][0] ){
                $opciones .= " selected='selected' ";
            }
            $opciones .= ">".$r[$x][0]." - ".$r[$x][1]."</option>
            ";
        }
        $opciones .= "</SELECT>
        ";
    return $opciones;
    }

    public function existe($odb,$objtab,$campo){
      $ar = $this->bsbasic->lee(" WHERE tabla='".$objtab->nomTabla."' AND campo='$campo'",0,"A");
      if(!empty($ar)){
        return true; 
      }else{
        return false;
      }      

    }

    public function getDtBasico($odb,$sec_basico){
        $ar = $this->dtbasic->lee1(" WHERE sec_basico=".$sec_basico,0,"A");
        if(!empty($ar)){ 
            return $ar['dt_basico'];
        }else{
            return false;
        }
    }
 }