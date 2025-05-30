<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Permisos a Roles</title>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <!-- <link rel='stylesheet' type='text/css' href='../css/ppal.css'> -->
    <style>
     
    .fondo_gris{
      background-color:#CCC;
    }

    .fondo_negro{
      background-color:black;
    }

    .letras_blancas{
      color:#EEE;
    }

    .marco_ppal{
      width:50%;
      /* margin:auto; */
      background-color:rgb(150,201, 252);   /* rgb(171, 219, 37); */
      /* padding:1em; */
      border-radius:20px;
    }
  
    .titulo_empresa{
      background-color:#EEE;
      font-size:1.8em;
      text-align:center;
      border-radius:13px;
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
          document.location.href='/alfrio/view/genera.php?tabla=ar_roles';
        }

        function sale(){
          document.location.href='index.php';
        }

        function anular(e) {
          tecla = (document.all) ? e.keyCode : e.which;
          return (tecla != 13);
     }
    </script>
    
</head>
<body  >        
  <!--   rgb(226, 231, 250) -->
  <!-- style='background-color:rgb(150,201, 252);width:50%;border-radius:20px;' -->
  <div class='container-fluid marco_ppal' >
  <div class='row' >
  <div class='col-sm-3'></div>  
  <div class='col-sm-6 titulo_empresa' >Alfrio S.A.S.</div>
  <div class='col-sm-3'></div>
  </div>
    <form name='Interface' method='post' onkeypress='return anular(event)'>
    <input type='hidden' name='tabla' value='ar_roles'>
    <input type='hidden' name='nomprg' value='roles'>
    <div class='row' style='background-color:#000;'>
    <div class='col-sm-5 letras_blancas' ><H3>Permisos a Roles</H3></div>
    <div class='col-sm-3 letras_blancas' id='accion'></div>
    <div class='col-sm-4'></div>
    </div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='id_rrol' class='form-label'><B> id_rrol :</B></label></div>
    <div class='col-sm-8'>
          <input type='int' id='id_rrol' name='id_rrol' class='form-control' 
                      maxlength='10'  id='prim' pattern='[0-9]' placeholder='Numero' onblur='ejec();'  value='41' tabindex='0' ></div></div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='id_rol' class='form-label'><B> id_rol :</B></label></div>
    <div class='col-sm-8'><SELECT name='id_rol'  class='form-select'  onchange="cambia('id_rol');">
			<option value=''>Sin elegir </option>
	 <option value='2'>2 - Administrador</option>
			<option value='4'>4 - Director comercial</option>
			<option value='3'>3 - Presidencia</option>
			<option value='1'>1 - Superadministrador</option>
			</SELECT>
	 </div></div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='id_permpro' class='form-label'><B> id_permpro :</B></label></div>
    <div class='col-sm-8'><SELECT name='id_permpro'  class='form-select'  onchange="cambia('id_permpro');">
			<option value=''>Sin elegir </option>
	 <option value='20'>20 - centroscostos</option>
			<option value='5'>5 - centroscostos</option>
			<option value='6'>6 - centroscostos</option>
			<option value='7'>7 - centroscostos</option>
			<option value='8'>8 - centroscostos</option>
			<option value='26'>26 - nits</option>
			<option value='27'>27 - nits</option>
			<option value='28'>28 - nits</option>
			<option value='29'>29 - nits</option>
			<option value='30'>30 - nits</option>
			<option value='14'>14 - perm_programas</option>
			<option value='15'>15 - perm_programas</option>
			<option value='16'>16 - perm_programas</option>
			<option value='17'>17 - perm_programas</option>
			<option value='18'>18 - perm_programas</option>
			<option value='31'>31 - perm_roles</option>
			<option value='32'>32 - perm_roles</option>
			<option value='33'>33 - perm_roles</option>
			<option value='34'>34 - perm_roles</option>
			<option value='35'>35 - perm_roles</option>
			<option value='9'>9 - programas</option>
			<option value='10'>10 - programas</option>
			<option value='11'>11 - programas</option>
			<option value='13'>13 - programas</option>
			<option value='12'>12 - programas</option>
			<option value='25'>25 - tipo_alerta</option>
			<option value='24'>24 - tipo_alerta</option>
			<option value='23'>23 - tipo_alerta</option>
			<option value='22'>22 - tipo_alerta</option>
			<option value='21'>21 - tipo_alerta</option>
			<option value='2'>2 - usuarios</option>
			<option value='3'>3 - usuarios</option>
			<option value='4'>4 - usuarios</option>
			<option value='19'>19 - usuarios</option>
			<option value='1'>1 - usuarios</option>
			</SELECT>
	 </div></div><input name='estado' type='hidden' id='estado' tabindex='3' >
  <div class='btn-group'>
    <button type='submit' name='btsav' class='btn btn-primary btn-sm' id='btsav'  disabled  >Guardar</button>
    <button type='reset' name='btcan' class='btn btn-primary btn-sm' onclick='javascript:inicio()' >Cancelar</buton>
    <button type='button' name='bteli' class='btn btn-danger btn-sm' onclick='javascript:mode(3)' id='bteli'  disabled  >Eliminar</buton>
    <button type='button' name='btlis' class='btn btn-success btn-sm' onclick="javascript:mode(4);" id='btlis'  >Listar</buton>
    <button type='button' name='btsal' class='btn btn-dark btn-sm' onclick='javascript:sale()' >Salir</buton>
  </div>
<input type='text' name='op' value='0' size='1'>
</form> 
</div>
<script src='js/bootstrap.bundle.min.js'></script>
<script>
 
  var op = document.forms[0].op.value ;
  var accion = document.getElementById('accion');
  var btsav = document.getElementById('btsav');
  var bteli = document.getElementById('bteli');
  var btlis = document.getElementById('btlis');
  const a_per = ["A","C","E","L"];

  switch(op){
    case '0': accion.innerHTML= '<H4>Consultar</H4>';
              if(a_per.includes('L')){btlis.disabled ='';}break;
    case '1': accion.innerHTML = '<H4>Adicionar</H4>';btsav.innerHTML='Adicionar';
              if(a_per.includes('A')){btsav.disabled ='';}break;
    case '2': accion.innerHTML = '<H4>Modificar</H4>';btsav.innerHTML='Modificar';
              if(a_per.includes('M')){btsav.disabled ='';}
              if(a_per.includes('E')){bteli.disabled ='';}
              break;
  } 
  
  let campo = '';
  if(campo != '' ){
    document.getElementById(campo).focus();   
  }
</script>
</body>
</html>
