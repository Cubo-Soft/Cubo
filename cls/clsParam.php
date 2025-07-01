<?php
include_once("clsTablam.php");

class clsParam extends Tabla{
 
    public function __construct($odb,$ntabla="ap_param"){
        parent::__construct($odb,$ntabla);
    }

    function getDato($vari=""){
        $a_val = $this->leec("valor"," WHERE variable='$vari'",0,"A");
        return $a_val[0]['valor'];
    }
}    
