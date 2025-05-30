<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>permisos programa</title>
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
          document.location.href='/alfrio/view/genera.php?tabla=ap_permpro';
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
    <input type='hidden' name='tabla' value='ap_permpro'>
    <input type='hidden' name='nomprg' value='permpro'>
    <div class='row' style='background-color:#000;'>
    <div class='col-sm-5 letras_blancas' ><H3>permisos programa</H3></div>
    <div class='col-sm-3 letras_blancas' id='accion'></div>
    <div class='col-sm-4'></div>
    </div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='id_permpro' class='form-label'><B> id_permpro :</B></label></div>
    <div class='col-sm-8'>
          <input type='int' id='id_permpro' name='id_permpro' class='form-control' 
                      maxlength='10'  id='prim' pattern='[0-9]' placeholder='Numero' onblur='ejec();'  value='36' tabindex='0' ></div></div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='codprog' class='form-label'><B> codprog :</B></label></div>
    <div class='col-sm-8'><SELECT name='codprog'  class='form-select'  onchange="cambia('codprog');">
			<option value=''>Sin elegir </option>
	 <option value='centroscostos'>centroscostos - Centros de costos</option>
			<option value='gruposprog'>gruposprog - Grupos de Programa</option>
			<option value='nits'>nits - Nits</option>
			<option value='opc_per_pro'>opc_per_pro - Opciones Permisos a Programas</option>
			<option value='perm_roles'>perm_roles - Permisos a Roles</option>
			<option value='perm_programas'>perm_programas - Permisos de Programa</option>
			<option value='programas'>programas - Programas</option>
			<option value='tipo_alerta'>tipo_alerta - Tipos de Alerta</option>
			<option value='usuarios'>usuarios - usuarios</option>
			</SELECT>
	 </div></div>
    <div class='row'>
    <div class='col-sm-4' style='background-color:#EADEC2'> <!-- #ccc -->
    <label for='permpro' class='form-label'><B> permpro :</B></label></div>
    <div class='col-sm-8'><SELECT name='permpro'  class='form-select'  onchange="cambia('permpro');">
			<option value=''>Sin elegir </option>
	 <option value='A'>A - Adicionar</option>
			<option value='C'>C - Consultar</option>
			<option value='E'>E - Eliminar</option>
			<option value='L'>L - Listar</option>
			<option value='M'>M - Modificar</option>
			</SELECT>
	 </div></div>
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
  const a_per = ["A","C","E","L","M"];

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
