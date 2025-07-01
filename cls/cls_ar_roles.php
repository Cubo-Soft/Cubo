<?php
include_once("clsTablam.php");
 
class cls_ar_roles extends Tabla{
 
    public function __construct($odb,$ntabla="ar_roles"){
        parent::__construct($odb,$ntabla);
    }
    public function permi($rol,$prog){  // Permiso a Programa.
        //echo "BASE:".$this->nomDb;
        $prog = basename($prog,".php");
        $sql = "SELECT pe.codprog,pe.permpro,pr.estado,dt.dt_basico,bs.descrip 
        FROM ar_roles r, ap_permpro pe,ap_programs pr, ip_dtbasicos dt,
        ip_basicos bs WHERE r.id_rol = ".$rol." AND 
        pe.id_permpro=r.id_permpro AND pr.codprog=pe.codprog AND 
        pr.codprog='$prog' AND
        dt.sec_basico=pr.estado AND bs.id_basico=dt.id_basico AND
        r.estado = 1";   // pr.path='carga.php?tabla=".$prog."' AND 
        //echo "sql:".$sql;
        $aper = $this->ejec($sql,"S","A");
        //print_r($aper);
        if(count($aper)<1 || strpos(strtoupper($aper[0]['dt_basico']),"ACTIVO") === false ){
            exit("Sin Permisos o NO ACTIVO");
        //header('location:index.php');  
        }else{
            if($aper[0]['descrip'] != "Estado de Programas"){
                exit("Programa: ".$aper[0]['codprog']." ERROR EN ESTADO !");
            }else{
                if(strpos(strtoupper($aper[0]['dt_basico']),"ACTIVO") === false ){
                    exit("Programa: ".$aper[0]['codprog']." estado: ".$aper[0]['dt_basico']);
                }
            }
        }
        $per = array();
        for($p=0;$p<count($aper);$p++){
        $per[] = $aper[$p]['permpro'];
        }
        return $per;
    }

    public function permiCarga($rol,$tabla){ // Permiso a Programa por Carga.
        if(strpos(C,"htdocs") !== false){
            echo "BASE:".$this->nomDb;
        }
        $sql = "SELECT pr.codprog,pr.estado as estado_prog,pe.permpro,
        pe.estado as estadopermpro,dt.dt_basico,bs.descrip 
        FROM ap_permpro pe,ap_programs pr, ip_dtbasicos dt, 
        ip_basicos bs, ar_roles r 
        WHERE r.id_rol = '".$rol."' AND 
        pe.id_permpro=r.id_permpro AND pr.codprog=pe.codprog AND 
        pr.path='carga.php?tabla=".$tabla->nomTabla."' AND 
        dt.sec_basico=pr.estado AND bs.id_basico=dt.id_basico";
 
        //echo $sql;
        $aper = $tabla->ejec($sql,"S","A");
        //print_r($aper);
        if(count($aper)<1 || strpos(strtoupper($aper[0]['dt_basico']),"ACTIVO") === false ){
        echo "Programa Sin Permisos o NO ACTIVO";
        //header('location:index.php');  
        }else{
            if($aper[0]['descrip'] != "Estado de Programas"){
                exit("Programa: ".$aper[0]['codprog']." ERROR EN ESTADO !");
            }else{
                if(strpos(strtoupper($aper[0]['dt_basico']),"ACTIVO") === false ){
                exit("Programa: ".$aper[0]['codprog']." estado: ".$aper[0]['dt_basico']);
                }
            }
        }
        $per = array();
        for($p=0;$p<count($aper);$p++){
           $per[] = $aper[$p]['permpro'];
        }
        return $per;
    }

}
?>