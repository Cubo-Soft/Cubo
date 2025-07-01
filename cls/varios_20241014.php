<?php

function calcularDV($nit) {  // Digito Verificacion Nit-Colombia. Junio 05-2014 
// suministrado por  http://www.forosdelweb.com/f18/digito-verificacion-colombia-938744/ 
    if (! is_numeric($nit)) {
        return false;
    }
 
    $arr = array(1 => 3, 4 => 17, 7 => 29, 10 => 43, 13 => 59, 2 => 7, 5 => 19,
    8 => 37, 11 => 47, 14 => 67, 3 => 13, 6 => 23, 9 => 41, 12 => 53, 15 => 71);
    $x = 0;
    $y = 0;
    $z = strlen($nit);
    $dv = '';
   
    for ($i=0; $i<$z; $i++) {
        $y = substr($nit, $i, 1);
        $x += ($y*$arr[$z-$i]);
    }
   
    $y = $x%11;
   
    if ($y > 1) {
        $dv = 11-$y;
        return $dv;
    } else {
        $dv = $y;
        return $dv;
    }
}

function lee_trm($t,$dias,$id_mon=35){ // lee ultimos trm
    $a = $t->lee(" WHERE id_moneda=$id_mon ORDER BY fecha DESC LIMIT ".$dias,0,"A");
    $son = count($a);
    if($son <1){
        return false;
    }
    if( $dias < 2){
        return $a[0]['trm'];
    }
    $total = 0;
    for($n=0;$n<$son;$n++){
        $total += $a[$n]['trm'];
    }
    return ( $total / $son );
}

function lee_politrm($moneda="USD"){ // lee politica de trm
    // mientras la prueba, despues se inhabilita.
    require_once("carga_ini.php");
    $dtbasicos = new tabla($odb,"ip_dtbasicos");
    $cmtrm = new Tabla($odb,"cm_trm");
    $tpoli  = new Tabla($odb,"vp_poli_trm");
    $a_mon = $dtbasicos->leec("dt_basico,sec_basico"," WHERE id_basico=11 ORDER BY sec_basico",0,"A");
    $existe = false;$id ="";
    for($n=0;$n<count($a_mon);$n++){
        if($a_mon[$n]['dt_basico']==$moneda){
            $existe = true; $id = $a_mon[$n]['sec_basico'];
        }
    }
    if(!$existe){
        return "NO EXISTE moneda ".$moneda;
    }
    $sql = "SELECT * FROM ".$tpoli->nomTabla." WHERE id_poli IN (SELECT valor FROM ap_param WHERE variable='trmempre')";
    $a_po = $tpoli->ejec($sql,"S","A");
    if(!$trm_act = lee_trm($cmtrm,1,$id)){
        return "Sin datos en moneda ".$moneda;
    }
    switch($a_po[0]['manejo']){
        case "porcentaje": $trm = ($trm_act * ( 1 + ($a_po[0]['valor']/100)));$opcion="porctje";break;
        case "dias": $trm = lee_trm($cmtrm,(int)$a_po[0]['valor'],$id);$opcion="dias";break;
        default: $trm = $trm_act;$opcion="actual";break;
    }    
    return $trm;
}

function act_asesor($idreq=0){
    // ### Rutina que reemplaza el Trigger que actualiza el Asesor y crea la alerta al asesor asignado. ###
	require_once("carga_ini.php");
    include_once("clsParam.php");
	if( $idreq < 1 ){
        exit('Falta el id_requerim ');
    }else{
        $tb_req    = new Tabla($odb,"vr_requerim");
        $tb_param  = new clsParam($odb);
        $tb_emple  = new Tabla($odb,"nm_empleados");
        $tb_suc    = new Tabla($odb,"nm_sucursal");
        $tb_asezo  = new Tabla($odb,"vp_asesor_zona");
        $tb_cargos = new Tabla($odb,"np_cargos");
        $tb_region = new Tabla($odb,"ap_regiones");
        $tb_jefear = new Tabla($odb,"vp_jefe_grupo");

        //$id_cargo_dir  = $tb_param->getDato("cargo_dir");
        $id_region_def = $tb_param->getDato("region_def");
        //echo "Cargo Dir Comercial:".$id_cargo_dir." Region Default:".$id_region_def."<br>";
            
        //$ar_cod_asesor_dir = $tb_emple->leec("codemple"," WHERE id_cargo='$id_cargo_dir'",0,"A");
        //$cod_asesor_dir = $ar_cod_asesor_dir[0]['codemple'];
        //echo "Asesor Director:".$cod_asesor_dir."<br>";
        
        $ar_req = $tb_req->leec("suc_cliente,grupo,de_linea,cod_trans"," WHERE id_requerim='$idreq'",0,"A");
        //echo "<pre>";print_r($ar_req);echo "</pre>";
        $id_suc      = $ar_req[0]['suc_cliente'];
        $codgrupo    = $ar_req[0]['grupo'];
        $id_de_linea = $ar_req[0]['de_linea'];
        $codtrans    = $ar_req[0]['cod_trans'];
        $cmps = "codemple,id_estado";$w = " WHERE id_cargo IN ( SELECT idcargo FROM vp_jefe_grupo WHERE codgrupo='$codgrupo') ";
        $ar_emple    = $tb_emple->leec($cmps,$w,0,"A");
        $cod_asesor_dir = $ar_emple[0]['codemple'];
        
        $ar_suc = $tb_suc->ejec("SELECT s.id_region FROM nm_sucursal s WHERE s.id_sucursal = $id_suc","S","A");
        $ar_reg = $tb_region->lee(" WHERE id_region='".$ar_suc[0]['id_region']."'",0,"A");
        if(!empty($ar_reg)){
            $id_region = $ar_suc[0]['id_region']; 
        } else{
            $id_region = $id_region_def;
        }

        $ar_asezo = $tb_asezo->lee(" WHERE linea='$id_de_linea' AND region='$id_region'");
        
        if(!empty($ar_asezo)){
            $cod_asesor = $ar_asezo[0]['asesor'];    
        }else{
            $cod_asesor = $cod_asesor_dir; 
        }
        //echo "Asesor FINAL:".$cod_asesor."<br>";

        $ar_emple = $tb_emple->leec("id_cargo"," WHERE codemple='$cod_asesor'",0,"A");
        $id_cargo = $ar_emple[0]['id_cargo'];
        //echo "Cargo del asesor $cod_asesor :".$id_cargo."<br>"; 

        $ar_cargos = $tb_cargos->leec("area_cargo"," WHERE id_cargo='$id_cargo'",0,"A");
        $idarea = $ar_cargos[0]['area_cargo'];
        //echo "Area del asesor $cod_asesor :".$idarea."<br>"; 

        $ar_req = array('asesor_asignd'=>$cod_asesor,'area'=>$idarea);
        $r = $tb_req->mod($ar_req," WHERE id_requerim='$idreq'");
        //echo "resultado:".$r;
        $sql = "CALL spAddAlerta('".$tb_req->nomTabla."','".$codtrans."',".$idreq.",'".$cod_asesor."');";
        //echo "Sale: ".$sql."<br>";
        $r = $tb_req->ejec($sql,0);
        //echo "resultado 2 :".$r;
    }
}

?>