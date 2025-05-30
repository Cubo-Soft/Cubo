<?php
include_once("clsTablam.php");

class clsPrecioProvee extends Tabla {
  private $rol;
  private $multi;   
  private $grupos;

  public function __construct($odb,$ntabla="cp_precios_provee"){
    parent::__construct($odb,$ntabla);
    $this->rol = new Tabla($odb,"cp_rol_precio");
    $this->multi = new Tabla($odb,"cp_multi_provee");
    $this->grupos= new Tabla($odb,"cp_grupos_provee");
  }

  public function leePrecioVta($arr,$opcion=0){
    // debe venir $arr['ref_provee'], $arr['linea'], $arr['id_rol']
    // cp_precios_provee = ref_provee, grupo_provee, estado, vr_provee, descrip, id_moneda
    // cp_multi_provee   = id_fact, cod_grupo, valor
    // cp_grupos_provee  = cod_grupo, numid_prov, id_marca
    // cp_rol_precio     = id_precio, id_rol, fact_corto

    $w  =" SELECT g.cod_grupo, g.numid_prov, g.idmarca, m.nom_marca, p.ref_provee, p.descrip, p.estado AS std_precio, ";
    $w .=" p.vr_provee, p.fecha_ultima, p.id_moneda, mon.alf_codigo AS abr_moneda FROM cp_grupos_provee g , cp_precios_provee p , ";
    $w .=" ip_marcas m , am_monedas mon ";
    $w .=" WHERE g.cod_grupo = p.grupo_provee AND g.idmarca = m.id_marca AND mon.id = p.id_moneda AND ";
    $w .=" p.ref_provee = '".$arr['ref_provee']."'";

    $a_precio = $this->ejec($w,"S","A");
    if( empty($a_precio) ){
      $a_precio[0]['precio'] = 0 ; 
      $a_precio[0]['abr_moneda'] = "";
    }else{
      if( $arr['id_rol'] <= '3' ){
        $w2 = " <= 3 ";
      }else{
        $w2 = " = ".$arr['id_rol'];
      }
      $a_rol = $this->ejec(" SELECT fact_corto FROM cp_rol_precio WHERE id_rol ".$w2,"S","A");
      $fact_corto = $a_rol[0]['fact_corto'];
      $a_precio[0]['fact_corto'] = $fact_corto;
      $campo = "valor AS factor";
      $w = " WHERE cod_grupo = '".$a_precio[0]['cod_grupo']."' AND id_fact = ( SELECT id_fact FROM cp_factor_provee WHERE fact_corto='".$fact_corto."')";
      $a_pventa = $this->multi->leec($campo,$w,"S","A");
      if( empty( $a_pventa ) ){
        $a_precio[0]['factor'] = 0;
        $a_precio[0]['precio'] = 0;
      }else{
        $a_precio[0]['factor'] = $a_pventa[0]['factor'];
        $a_precio[0]['precio'] = round(( $a_precio[0]['vr_provee'] * $a_precio[0]['factor'] ),2);   
      }
    }  
    return $a_precio;
  }

  private function reemp_carac($texto,$carac){
    return str_replace($carac,$carac.$carac,$texto);
  }

  public function act_precio($tmp_Precios,$fechaCarga,$id_moneda){
    $sql = "SELECT referencia AS ref_provee, nombre AS descrip, codigo_grupo AS grupo_provee,";
    $sql .=" '1' AS estado, '$fechaCarga' AS fecha_ultima, precio_usd AS vr_provee, ";
    $sql .=" '$id_moneda' AS id_moneda, id_marca FROM ".$tmp_Precios->nomTabla;
    //echo "SQL: ".$sql."<br>";
    $a_nprecios = $tmp_Precios->ejec($sql,"S","A");
    //echo " ACTUALIZANDO PRECIOS !!! <br>";
    for($x=0; $x < count( $a_nprecios ); $x++ ){
      $a_nprecios[$x]['id_moneda'] = $id_moneda;
      $a_nprecios[$x]['fecha_ultima'] = $fechaCarga;
      if( strpos($a_nprecios[$x]['ref_provee'],"'") !== false){
        $a_nprecios[$x]['ref_provee'] = $this->reemp_carac($a_nprecios[$x]['ref_provee'],"'");
      }
      if( strpos($a_nprecios[$x]['descrip'],"'") !== false){
        $a_nprecios[$x]['descrip'] = $this->reemp_carac($a_nprecios[$x]['descrip'],"'");
      }

      $ar_ex = $this->lee(" WHERE ref_provee='".$a_nprecios[$x]['ref_provee']."'",0,"A");
      if( empty($ar_ex) ){
        $ag_ex = $this->grupos->lee(" WHERE cod_grupo='".$a_nprecios[$x]['grupo_provee']."'",0,"A");
        if( empty( $ag_ex )){
          $am_ex = $this->grupos->lee(" WHERE idmarca=".$a_nprecios[$x]['id_marca']." ORDER BY orden DESC LIMIT 1",0,"A");
          $am_ex[0]['cod_grupo'] = $a_nprecios[$x]['grupo_provee'];
          $am_ex[0]['orden'] = ( ( $am_ex[0]['orden'] ) + 1);
          $resp = $this->grupos->ins( $am_ex[0] );
          unset( $a_nprecios[$x]['id_marca']);
          if( !$resp ){
            return $resp;
          }
        }
        $resp = $this->inst($a_nprecios[$x]);
      }else{
        $ag_ex = $this->grupos->lee(" WHERE cod_grupo='".$a_nprecios[$x]['grupo_provee']."'",0,"A");
        if( empty( $ag_ex )){
          $am_ex = $this->grupos->lee(" WHERE idmarca=".$a_nprecios[$x]['id_marca']." ORDER BY orden DESC LIMIT 1",0,"A");
          $am_ex[0]['cod_grupo'] = $a_nprecios[$x]['grupo_provee'];
          $am_ex[0]['orden'] = ( ( $am_ex[0]['orden'] ) + 1);
          $resp = $this->grupos->ins( $am_ex[0] );
          unset( $a_nprecios[$x]['id_marca']);
          if( !$resp ){
            return $resp;
          }
        }

        $resp = $this->mod($a_nprecios[$x]," WHERE ref_provee='".$a_nprecios[$x]['ref_provee']."'" );
        if( !$resp ){
          return $resp;
        }  
      }
    }
    return true;    
  }
}
?>