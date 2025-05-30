<?php
session_start();
$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
} 

include_once("../css/def.php");
define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include(C."/cls/clsTablam.php");
include(C."/cls/varios.php");
if($motor=="my"){
    include(C."/cls/clsBdmy.php");
}

/* Inicio */
/*  proceso
    1 - leo tabla temporal clientes_zona
    2 - busco por nombre en juridica / personas, el numid,
    3 - busco por numid en sucursal el id,
    4 - actualizo en nm_sucursal la subzona del cliente.
*/
$odb      = new Bd($h,$pto,$u,$p,$d);
$nits     = new Tabla($odb,"nm_nits");
$tiponits = new Tabla($odb,"np_tiponit");
$personas = new Tabla($odb,"nm_personas");
$juridicas= new Tabla($odb,"nm_juridicas");
$sucursal = new Tabla($odb,"nm_sucursal");
$contactos= new Tabla($odb,"nm_contactos");
$tmpnits  = new Tabla($odb,"tmp_clientes_zona");
$ciudades = new Tabla($odb,"np_ciudades");
$regiones = new Tabla($odb,"tmp_regiones");
$ar_regiones = $regiones->lee(" ORDER BY id_region",0,"A");
//echo "<pre>";print_r($ar_regiones);echo "</pre>";
  //$tmpnits->ver_campos(); 
?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <script src="../js/jquery_dvlp_3_7_1.js"></script>
    <script src='../js/ajax.js'></script>

    <title>Cargue de Nits por Region</title>
    <style>
       /* table tr th td {
        border: 1px solid;
       }
       table {
        border-collapse:collapse;
       } */
    </style>  
  </head>
  <body>
    <h1>Cargue de Nits por Region</h1>
    <?php
    $a_son = $tmpnits->qt("");
    echo "salen: <pre>";print_r($a_son); echo "</pre>";
    //echo " Son ".$a_son[0][0]." registros";
    $ar_tmpnits = $tmpnits->lee(" ORDER BY numid, nom_cliente, id ");
    //echo " Son: ".count($ar_tmpnits); 
    ?>
    <div class="container" >
      <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>id</th>
	        <th>Cliente</th>
          <th>Regional</th>
		      <th>Zona</th>
		      <th>Numid</th>
          <th>Sucursal</th>
          <th>id_region</th>
          <th>cod_ciudad</th>
          <th>Nom_Ciudad</th>
          <th>Ok</th>
          <th>Estado</th>
        </tr>
      </thead>
      <tbody >
      <?php
      $ar_tope =  [];
      for( $n=0; $n < count($ar_tmpnits); $n++ ){
        $ar_tope[$n] = '0';
        $nombre_actual = ""; $ok = "";
        if(empty($ar_tmpnits[$n]['numid'])){
          $tope=25; $existe = false;
          while(!$existe){
            $nom = substr($ar_tmpnits[$n]['nom_cliente'],0,$tope);
            $ar_juridica = $juridicas->lee(" WHERE razon_social LIKE '".$nom."%'");
            if( !empty($ar_juridica)){
              $ar_tmpnits[$n]['numid'] = $ar_juridica[0]['numid'];
              $nombre_actual = $ar_juridica[0]['razon_social'];
              $existe = true;
            }else{
              $ar_persona = $personas->lee(" WHERE apelli_nom LIKE '%".$nom."%'");
              if( !empty($ar_persona) ){
                  $ar_tmpnits[$n]['numid'] = $ar_persona[0]['numid'];
                  $nombre_actual = $ar_persona[0]['apelli_nom'];
                  $existe = true;
              }
            }
            $tope--;
            if($tope < 6 ){ $existe = true; }
          }
          $ar_tope[$n] = $tope+1;
        }
        $suc_region =  ""; $btn_act = $btn_add = $sele = "";
        if( !empty($ar_tmpnits[$n]['numid']) ){
            $w = " WHERE numid='".$ar_tmpnits[$n]['numid']."'";
            $ar_juridica = $juridicas->lee($w);
            if( !empty($ar_juridica) ){
              $nombre_actual = $ar_juridica[0]['razon_social'];
            }else{
              $ar_persona = $personas->lee($w);
              $nombre_actual = $ar_persona[0]['apelli_nom'];
            }
            $ar_suc = $sucursal->lee($w);
            if( !empty($ar_suc) ){
                $son = count($ar_suc);
                $suc_region =  $ar_suc[0]['id_region'];
                $ar_tmpnits[$n]['id_sucursal'] = $ar_suc[0]['id_sucursal']."-".$son." ";
                $ar_tmpnits[$n]['cod_ciudad'] = $ar_suc[0]['ciudad'];
                $ar_ciudad = $ciudades->lee(" WHERE id_ciudad = '".$ar_suc[0]['ciudad']."'");
                $ar_tmpnits[$n]['nom_ciudad'] = $ar_ciudad[0]['nom_ciudad'];
                if( $suc_region != $ar_tmpnits[$n]['id_region'] && $ar_tmpnits[$n]['ok'] == 1 ){
                    $btn_act = "<button id='btn_".$ar_tmpnits[$n]['id']."' class='btn btn-primary btn-sm' onclick='act(this,2);'>Actualiza</button>";   
                    $btn_add = "<button id='btn_".$ar_tmpnits[$n]['id']."' class='btn btn-primary btn-sm' onclick='act(this,1);'>Adiciona</button>";
                    $sele = "<select  id='select_".$ar_tmpnits[$n]['id']."'>";
                    for($i=0;$i<count($ar_regiones);$i++){
                      $sele .= "<option value='".$ar_regiones[$i]['id_region']."'
                          title='".$ar_regiones[$i]['id_region']."'>".$ar_regiones[$i]['nom_region']."</option>";
                    }
                    $sele .= "</select>";
                }
            }
            
        }
        if( $ar_tmpnits[$n]['nom_cliente'] == $nombre_actual){
          $ok = "1";
          if($nombre_actual == $ar_tmpnits[$n - 1]['nom_cliente']){
            $nombre_actual = "<B>".$nombre_actual."</B>";
          }
        }
        
        $ult_suc = $sucursal->max_tabla("orden"," WHERE numid='".$ar_tmpnits[$n]['numid']."'");
        if(empty($ult_suc)){
          $ult = 0;
          $nom_suc = "Sede Principal";
        }else{
          $ult = $ult_suc[0][0] + 1;
          $nom_suc = "Sede ".$ult;
        }

        try{
          $r = $nits->ejec('start transaction',0,'A');
          if( $ok && $ar_tmpnits[$n]['ok'] == 0 ){
            $arr = ['numid'=>$ar_tmpnits[$n]['numid'],'ok'=>$ok];
            $w = " WHERE id=".$ar_tmpnits[$n]['id'];
            $exito = $tmpnits->mod($arr,$w);
            if( $exito ){
              $ok = "Ok";
            }else{
              continue;
            }
          }          
        
          $r2 = $nits->ejec('commit work',0,'A');   
          
        }catch(Exception $e ){
          $r2 = $nits->ejec('rollback work',0,'A');
          exit("ERROR ".$e->getMessage());
        } 

        echo "<tr>
            <td>".$n."</td>
            <td>".$ar_tmpnits[$n]['id']."</td>
            <td>".$ar_tmpnits[$n]['nom_cliente']." <br>".$nombre_actual." ( tope:".$ar_tope[$n]." )</td>
            <td>".$ar_tmpnits[$n]['regional']."</td>
            <td>".$ar_tmpnits[$n]['zona']."</td>
            <td>".$ar_tmpnits[$n]['numid']."</td>
            <td><input type='text' id='idsuc_".$ar_tmpnits[$n]['id']."' value='".$ar_tmpnits[$n]['id_sucursal']."' size='3'></td>
            <td><input type='text' id='idreg_".$ar_tmpnits[$n]['id']."' value='".$ar_tmpnits[$n]['id_region']." - ".$suc_region."' size='18'> ".$sele." ".$btn_act." ".$btn_add." </td>
            <td>".$ar_tmpnits[$n]['cod_ciudad']."</td>
            <td>".$ar_tmpnits[$n]['nom_ciudad']."</td>
            <td>".$ar_tmpnits[$n]['ok']."</td>
            <td><input type='checkbox' class='form-check-input' id='".$ar_tmpnits[$n]['id']."ok' value'".$ar_tmpnits[$n]['ok']."'> </td>
        </tr>
        ";
      }   
      ?>
      </tbody>
      </table>
    </div>
    <script src='../js/bootstrap.bundle.min.js'></script>
    <script src='../js/vistas/carnitszona.js'></script>
  </body>
</html>