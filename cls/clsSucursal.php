<?php
include_once("clsTablam.php");

class clsSucursal extends Tabla{
 
    public function __construct($odb,$ntabla="nm_sucursal"){
        parent::__construct($odb,$ntabla);
    }
 
    public function modCampo($arr,$vrLlave){
		  // actualizar la tabla nm_sucursal actualizando el campo en $arr
      $where = " WHERE id_sucursal = ".$vrLlave;
      return $this->mod($arr,$where);
    }

    public function addsucursal($numid=""){
      // $a_ultsuc = $this->max_tabla('id_sucursal',"");
      if($numid != ""){
        $a_ultord = $this->max_tabla('orden'," WHERE numid='".$numid."'");
        if(empty($a_ultord)){
          $orden = '0';
          $nom_sucur = "Sede Principal";
        }else{
          $orden = $a_ultord[0][0] + 1;
          $nom_sucur = "Sede Nro. ".$orden;
        }
        // falta el resto de campos.
      }

    }

}