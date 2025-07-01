<?php

class Bd {  
   var $cn;
   var $ho;
   var $pu;
   var $us;
   var $pa;
   var $db;
  
   function __construct($ho,$pu,$us,$pa,$Db){
     $this->conecta($ho,$pu,$us,$pa,$Db);
   }

  function conecta($ho='192.168.0.92',$pu='3306',$us='root',$pa='ricardo',$Db='db_alfrio'){
    if( $this->cn = mysqli_connect($ho,$us,$pa,$Db)){
      $this->db = $Db;
    }else{
      die("Falla en conexion a DB");
    }
  }

  function cierra(){
     mysqli_close($this->cn);
  }
}
?>
