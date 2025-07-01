<?php
session_start();
//$_SESSION['id_rol']=1;
if(!isset($_SESSION['id_rol'])){
  unset($_SESSION);
  session_destroy();
  header("location:index.php");
}

include_once("../cls/carga_ini.php");
//include_once("../css/def.php");
//define("C",$_SERVER['DOCUMENT_ROOT'].$direc);
include_once(C."/cls/clsTablam.php");
include_once(C."/cls/cls_ar_roles.php");
include_once(C."/cls/clsBasicos.php");
//if($motor=="my"){
//    include_once(C."/cls/clsBdmy.php");
//}

function bustit($tabla,$cam){
  for($n=0;$n<$tabla->numCampos;$n++){
    if($tabla->Cam[$n] == $cam){
      return $tabla->Tit[$n];
    }
  }
}

function trae_dato($odb,$campo,$ar_tabforan,$valor){
  $t = $tab = "";
  for($n=0;$n<count($ar_tabforan);$n++){
    if($ar_tabforan[$n]['campo'] == $campo){
      $t = $ar_tabforan[$n]['tab_pri'];
      $tab = new Tabla($odb,$t);
      $ar_dato = $tab->lee($valor,1,"N");
      return $ar_dato[0][1];
    }
  }
}

function lista($odb,$tabla,$id_basico,$dtbasic){
  $r = $tabla->lee(" ORDER BY ".$tabla->Cam[0],0,"A");
  $titulo = $tabla->titTabla;
  $ntabla = $tabla->nomTabla;
  $basicos = new clsBasicos($odb);
  //$a_estados = $dtbasic->lee("WHERE id_basico=".$id_basico,0,"A");
  $ar_foraneas = $ar_tabforan = array(); $l=0;
  for($i=0;$i<$tabla->numCampos;$i++){
    if( $tabla->Key[$i] == "MUL" ){
      $ar_foraneas[$l] = $tabla->Cam[$i];
      $ar_tabforan[$l]['campo'] = $tabla->Cam[$i];
      $ar_tabforan[$l]['tab_pri'] = $tabla->tab_pri[$i];
      $l++;
    }    
  }
  //echo "Son foraneas: ";print_r($ar_foraneas);
  echo "
  <!DOCTYPE html>
  <html lang='es'>
  <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>". $titulo ."</title>
      <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
      <style type='text/css'>
      body{
        /* background-color:#CFCFCF; */
      }  
      .btn-flota{
        position: fixed;
        width:100px;
        left:50px;
      }
      .marco_pal {
        width:100%;
        height:700px;
        margin-left: 10px;
        /* background-color: #256E8A; */
        overflow-x: hidden;
        overflow-y: scroll;
      }
      </style>
      <script >
      function inicio(){
        document.location.href='".$_SERVER['PHP_SELF']."?tabla=".$ntabla."';
      }
      </script >
   </head>
   <body>";
	if(count($r)<1){
		$boton = "<input type='button' value='Regresar' onclick='document.location.href=\"".$_SERVER['PHP_SELF']."?tabla=".$ntabla."\"' class='btn btn-primary'>";
		exit("Sin Registros ".$boton);
	}else{
	  $t ="";
	  foreach($r[0] as $cam=>$vr){
      $tit = bustit($tabla,$cam);
      $t .= "<th>".$tit."</th>";
	  }
	}
	echo "
  <div class='marco_pal'>
  <div class='btn-flota'>
      <button type='button' onclick='inicio();' class='btn btn-primary' >Regresar</button>
  </div>
  <div style=\"width:80%;text-align:center;\" >
  <H2>Listado de ".$titulo."</H2>
  
  <table class='table table-striped table-bordered'>
    <thead class='bg-primary' style='color:#FFF'>
    <tr>".$t."</tr></thead>
     <tbody>";
     //echo "reg: 0 <pre>";print_r($r[0]);echo "</pre>";
  for($x=0; $x<count($r);$x++){
    echo "<tr>";
    foreach($r[$x] as $campo=>$valor){
      if( $campo == 'password' || $campo == 'paswd'){ $valor = '*****';
      }else
      if(array_search($campo,$ar_foraneas,true) !== false){
        $vale = trae_dato($odb,$campo,$ar_tabforan,$valor);
        $valor .= " - ".$vale;
      }else 
      if($basicos->existe($odb,$tabla,$campo)){
        $valor = $basicos->getDtBasico($odb,$valor);
      }else
      if(strpos($campo,"estado") !== false ){
        if($valor){$valor="ACtivo";}else{$valor="BLoqueado";}
      } 
      echo "<td>".$valor."</td>";
    }
    echo "</tr>";
  }
  echo "</tbody>
    </table>
	  </div>
    <div style='position:right'>
      <input type='button' value='Regresar' onclick='inicio();' class='btn btn-primary'>
    </div>
  </div>";
  exit();
}

if( isset($arv) ){
    $ntabla = $arv[1];
    $nprog  = $arv[2];
}elseif(isset($_REQUEST['tabla'])){
    $ntabla = $_REQUEST['tabla'];
    unset($_REQUEST['tabla']);
    if(isset($_REQUEST['nomprg']) && !empty($_REQUEST['nomprg'])){
      $nprog  = $_REQUEST['nomprg'];
      unset($_REQUEST['nomprg']);
    }else{
      $nprog = $ntabla;
    }
}else{
    exit("Falta la tabla");
}

if( isset( $_REQUEST['op'] ) ){
	$op = $_REQUEST['op'];
  unset($_REQUEST['op']);
}else{
	$op = "";
}
if( isset( $_REQUEST['btsav'] ) ){
	$btsav = $_REQUEST['btsav'];
  unset($_REQUEST['btsav']);
}else{
	$btsav = "";
}

/* Inicio */
if(isset($op) && $op> 4 ){
  exit('Viene '.$op);
}

$odb = new Bd($h,$pto,$u,$p,$d);
$tabla = new Tabla($odb,$ntabla);
$existe = $tabla->ejec("show tables LIKE '".$tabla->nomTabla."'","S");
$tparam = new Tabla($odb,"ap_param");
$aempre = $tparam->leec("valor"," WHERE variable='nomempre'"); 
$basicos = new clsBasicos($odb);
$dtbasic = new Tabla($odb,"ip_dtbasicos");
$bsbasic = new Tabla($odb,"ip_basicos_tab");
$trroles = new cls_ar_roles($odb);
//$trroles->ver_campos();
$ab = $basicos->lee(" where descrip ='Estado de Programas'");
if(count($ab)>0){  
  $tiene_estado = true;
  $id_basico = $ab[0]['id_basico']; 
}else{
  $tiene_estado = false;
  $id_basico = null;
} 
$campos = "sec_basico,dt_basico";
$aopc = $dtbasic->leec($campos,' where id_basico='.$id_basico,0,"A"); // opciones de estado de Programas.
//$tabla->ver_campos();
$aper = $trroles->permiCarga($_SESSION['id_rol'],$tabla);
if(strpos(C,"htdocs") !== false){
  echo " Variable C:".C."   ";
  echo " Permisos: ";foreach($aper AS $k=>$v){echo $v." ";};
}

$campo = "";  
$disa=$dise=$disl=" disabled ";
if(array_search('L',$aper)){$disl="";} 

switch($op){
  case '0': // Consulta 
      if($_REQUEST[$tabla->Cam[0]] != "" ){
        $arr = $tabla->lee(" WHERE ".$tabla->Cam[0]." = '".$_REQUEST[$tabla->Cam[0]]."'","S");
        if(is_array($arr) ){
          if( isset($arr[0]) ){  //
            $op='2';
            if(array_search('M',$aper)){$disa="";}
            if(array_search('E',$aper)){$dise="";}
          }else{
            $arr = array();$arr[0] = array();
            $arr[0][$tabla->Cam[0]] = $_REQUEST[$tabla->Cam[0]];
            $op='1';
            if(array_search('A',$aper)){$disa="";}
          }
        }
        $campo = $tabla->Cam[1];
      }
      break;
  case '1': // Adicionar
      $tabla->inst($_REQUEST);
      $op=0;

      break;
  case '2': // Modificar
      $tabla->mod($_REQUEST," WHERE ".$tabla->Cam[0]." = '".$_REQUEST[$tabla->Cam[0]]."'");
      $op=0;
      break;
  case '3': // Eliminar
      $tabla->bor(" WHERE ".$tabla->Cam[0]." = '".$_REQUEST[$tabla->Cam[0]]."'");
      echo "Borrado";
      $op=0;
      break;
  case '4': // Listar
      lista($odb,$tabla,$id_basico,$dtbasic);
      //$tabla->lis();
      $op=0;
      break; 
  //default : exit('viene '.$op);
}

$titulo = $tabla->titTabla;
$salida ="<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>". $titulo ."</title>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <!-- <link rel='stylesheet' type='text/css' href='../css/ppal.css'> -->
    <style>
     body{
        background-color:#FAF6F6F6;
     }
    .fondo_gris{
      background-color:#CCC;
    }

    .fondo_negro{
      background-color: #256E8A;
    }

    .letras_blancas{
      color:#EEE;
    }

    .marco_ppal{
      width:50%;
      margin-top: 10px;
      margin-left: 10px;
      /* margin:auto; */
      background-color:rgb(150,201, 252); /* #ABE3FB; */ 
      padding:1.5em; 
      border-radius:20px;
    }
  
    .titulo_empresa{
      background-color:#EEE;
      font-size:1.8em;
      text-align:center;
      border-radius:13px;
    }

    .etiqueta {
      background-color:#EADEC2;
    } 
    </style>
    <script >
        
        function mode(op){
          //alert('Opcion: '+op);
          document.forms[0].op.value = op;
          ejec();
        }   

        function ejec(){
          document.forms[0].submit();
        }
        
        function inicio(){
          document.location.href='".$_SERVER['PHP_SELF']."?tabla=".$ntabla."';
        }

        function sale(){
          document.location.href='index.php';
        }

        function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
        }

        function vaciar(obj){
          obj.value = '';
        }  
    </script>
    
</head>
<body  >        
  <div class='conteiner marco_ppal' >
  <div class='row' >
  <div class='col-sm-3'></div>  
  <div class='col-sm-6 titulo_empresa' >".$aempre[0][0]."</div>
  <div class='col-sm-3'></div>
  </div>
    <form name='Interface' method='post' onkeypress='return anular(event)' enctype='multipart/form-data'>
    <input type='hidden' name='tabla' value='".$ntabla."'>
    <input type='hidden' name='nomprg' value='".$nprog."'>
    <div class='row fondo_negro'>
    <div class='col-sm-5 letras_blancas' ><H3>".$tabla->titTabla."</H3></div>
    <div class='col-sm-3 letras_blancas' id='accion'></div>
    <div class='col-sm-4'></div>
    </div>";
	
  for($i=0;$i<$tabla->numCampos;$i++){
    if(strpos($tabla->Cam[$i],"estado") !== false && $tabla->Tip[$i] !== "int"){
      $tabla->sel_dep[$i] = "S";
    } 
    //REVISANDO EL VALOR DE CAMPOS ESTADO QUE QUEDA EN 0.
    if($tabla->sel[$i] == "N"){ 
      $salida .= "<input name='".$tabla->Cam[$i]."' type='hidden' id='".$tabla->Cam[$i]."' 
                  value='".$tabla->Dfl[$i]."' tabindex='".$i."' >";
      continue;
    }
    $salida .= "
      <div class='row'>
      <div class='col-sm-4 etiqueta' > <!-- style='background-color:#EADEC2' -->
      <label for='".$tabla->Cam[$i]."' ><B> ".$tabla->Tit[$i]." :</B></label></div>
      ";
    $place="";$pater="";
    if($tabla->sel_dep[$i] == "N"){
      switch($tabla->Tip[$i]){
        case 'date' : $tipo='date';break; 	
        case 'int'  : $tipo='int';$pater="pattern='[0-9]'";$place="placeholder='Numero'";
                      $r = $basicos->existe($odb,$tabla,$tabla->Cam[$i]);
                      if( $r ){ 
                          $tipo = "select";
                      }
                      break;
        case 'varchar':if($tabla->Cam[$i]=='email' ){ $tipo = 'email';
                        }elseif($tabla->Cam[$i]=='password' || $tabla->Cam[$i]=='paswd'){
                          $tipo = 'password';
                        }elseif($tabla->Cam[$i]=='foto' || $tabla->Cam[$i]=='imagen'){
                          $tipo='file';
                        }else{ $tipo='text';  
                        } break;
        case 'text' : $tipo='texto';break;
        case 'tinyint':$tipo='boolean';break;
        default     : $tipo='text';break;
      }

      if($tipo=='texto'){
        $salida .= "<div class='col-sm-8'>
        <textarea id='".$tabla->Cam[$i]."' name='".$tabla->Cam[$i]."' class='form-control' 
                    maxlength='".$tabla->Tam[$i]."'>";
        if(isset($arr[0][$tabla->Cam[$i]]) && $arr[0][$tabla->Cam[$i]] != ""){
          $salida .= $arr[0][$tabla->Cam[$i]];
        } 
        $salida .= "</textarea>
        </div>
        ";
      }elseif($tipo == "select"){
        $clase = " class='form-select form-select-sm' ";
        if(isset($arr[0][$i]) ){
              $opcion = $arr[0][$i];
        }else{
              $opcion = "";
        }
        $salida .= "<div class='col-sm-8'>".$basicos->opc_tablas($odb,$tabla->nomTabla,$tabla->Cam[$i],$opcion)."</div>";  
      }elseif($tipo == "file"){
        $salida .= "<div class='col-sm-8'>
            <input type='text' id='".$tabla->Cam[$i]."' name='".$tabla->Cam[$i]."' class='form-control' 
                        maxlength='".$tabla->Tam[$i]."' ".$place;
        if(isset($arr[0][$tabla->Cam[$i]]) && $arr[0][$tabla->Cam[$i]] != ""){
              $salida .= " value='".$arr[0][$tabla->Cam[$i]]."' ";
        } 
        $salida .= " tabindex='".$i."' ></div>";

        //$salida .= " tabindex='".$i."' ><input type='file' id='".$tabla->Cam[$i]."_foto' name='".$tabla->Cam[$i]."_foto' 
        //            class='form-control' maxlength='".$tabla->Tam[$i]."' ".$place." > </div>";
      }else{
        $place = "";
        if(strtoupper($tabla->Cam[$i])=="USUARIO"){ $place = " placeholder='Sugerencia: User###'";}
        $salida .= "<div class='col-sm-8'>
            <input type='$tipo' id='".$tabla->Cam[$i]."' name='".$tabla->Cam[$i]."' class='form-control' 
                        maxlength='".$tabla->Tam[$i]."' ".$place;
        
        if( $tabla->Key[$i] == "PRI" ){
          if($op=="")$op="0";
          if($tabla->Tip[$i]=='int' && $op=='0'){
            $ult=$tabla->max_tabla($tabla->Cam[$i],"");
            $signum = ((int)$ult[0][0] + 1);
            $place = "placeholder='$signum'";
          }
          $salida .= " ".$pater." ".$place." onblur='ejec();' onfocus='vaciar(this);'"; // id='prim' 
        }

        if(isset($arr[0][$tabla->Cam[$i]]) && $arr[0][$tabla->Cam[$i]] != ""){
          $salida .= " value='".$arr[0][$tabla->Cam[$i]]."' ";
        } 

        $salida .= " tabindex='".$i."' ></div>";
      }
    }else if( $tabla->Key[$i] == "MUL" ){
          $otab2 = new Tabla($odb,$tabla->tab_pri[$i]);
          $clase = " class='form-select form-select-sm' ";
          if(isset($arr[0][$i]) ){
            $opcion = $arr[0][$i];
          }else{
            $opcion = "";
          }
          $salida .= "<div class='col-sm-8'>".$otab2->selecc($tabla->Cam[$i],$clase,$opcion)."</div>";
    
    }else{  // el campo contiene el texto estado
      $clase = " class='form-select form-select-sm' ";
      if(isset($arr[0][$i]) ){
        $opcion = $arr[0][$i];
      }else{
        $opcion = "";
      }
      $salida .= "<div class='col-sm-8'>
      <select name='".$tabla->Cam[$i]."' ".$clase." onchange=\"cambia('".$tabla->Cam[$i]."');\">  
      "; 
      $salida .= "<option value='1'>ACtivo</option>
                  <option value='0' ";
      if( $opcion != "" && $opcion == '0' ){
        $salida .= " selected='selected' ";
      }
      $salida .= ">BLoqueado</option>
      ";
      // if($valor){$valor="ACtivo";}else{$valor="BLoqueado";}
      /*
      for( $o=0; $o < count( $aopc ); $o++ ){
        $salida .= "<option value='".$aopc[$o]['sec_basico']."'";
        if( $opcion != "" && $opcion == $aopc[$o]['sec_basico'] ){
          $salida .= " selected='selected' ";
        }
        $salida .= ">".$aopc[$o]['dt_basico']."</option>
        "; 
      } */
      $salida .= "</select>
      </div>";
    }
      
    $salida .= "</div>";
}
// quito la opcion salir -- <button type='button' name='btsal' class='btn btn-dark btn-sm' onclick='javascript:sale()' >Salir</buton> 
$salida .= "
  <div class='btn-group'>
    <button type='button' name='btsav' class='btn btn-primary btn-sm' onclick='javascript:mode(".$op.")' id='btsav' ".$disa." >Guardar</button>
    <button type='reset' name='btcan' class='btn btn-primary btn-sm' onclick='javascript:inicio()' >Cancelar</buton>
    <button type='button' name='bteli' class='btn btn-danger btn-sm' onclick='javascript:mode(3)' id='bteli' ".$dise." >Eliminar</buton>
    <button type='button' name='btlis' class='btn btn-success btn-sm' onclick=\"javascript:mode(4);\" id='btlis' ".$disl." >Listar</buton>
    
  </div>
  <input type='text' name='op' value='".$op."' size='1'>
</form> 
</div>
<script src='../js/bootstrap.bundle.min.js'></script>
<script>
 
  var op = document.forms[0].op.value ;
  var accion = document.getElementById('accion');
  var btsav = document.getElementById('btsav');
  var bteli = document.getElementById('bteli');
  var btlis = document.getElementById('btlis');
  const a_per = ".json_encode($aper).";

  switch(op){
    case '0': accion.innerHTML= '<H4>Consultar</H4>';
              if(a_per.includes('L')){btlis.disabled ='';}
              break;
    case '1': accion.innerHTML = '<H4>Adicionar</H4>';btsav.innerHTML='Adicionar';
              if(a_per.includes('A')){btsav.disabled ='';}break;
    case '2': accion.innerHTML = '<H4>Modificar</H4>';btsav.innerHTML='Modificar';
              if(a_per.includes('M')){btsav.disabled ='';}
              if(a_per.includes('E')){bteli.disabled ='';}
              break;
  } 
  
  let campo = '".$campo."';
  if(campo != '' ){
    document.getElementById(campo).focus();   
  }
</script>
</body>
</html>
";
$odb->cierra();
echo $salida;  
