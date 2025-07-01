let idmensaje = $("#idmensaje");
let idmaterial = document.getElementById("id_material");
let vr_material = '';
//$(document).ready(function(){
$(function(){
})
    
function limpia(){
    console.log('Limpiando...');
    let elemen = $("#totelemen").val();
    let comple = $("#totcomplem").val();
    let diamet = $("#totdiametro").val();
    for($e=1;$e<=elemen;$e++){
        for($c=1;$c<=comple;$c++){
            for($d=1;$d<=diamet;$d++){
                let nombreid = "_"+$e+"_"+$c+"_"+$d;
                let idcelda = document.getElementById(nombreid);
                idcelda.value = '';
                //console.log('Celda:'+nombreid);
            }
        }
    }
}

function cambia(campo){  // lee dato elegido mediante select del objeto tabla
    let idcampo = document.getElementById(campo);
    if( idcampo.id != idmaterial.id){
        //console.log('Llamada desde campo diferente al Material idcampo.id:'+idcampo.id);
        idmaterial.focus();    
    }
 
    //console.log('Viene id: '+idmaterial.id);
    //console.log('Valor:'+idmaterial.value); // opcion de material seleccionada
    vr_material = idmaterial.value;

    const $dato = {'material':vr_material,
                    'opcion':1}
    $.ajax({
        async: false,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_grcost_elem.php',
        //beforeSend:function(){
        //},
        success:function(rpta){
			if(rpta==1){
				alert("Ok!");
			}else{
                if( Array.isArray(rpta) ){
                    ar_rpta = rpta;
                    for(let a=0; a< ar_rpta.length;a++){
                        if(ar_rpta[a]['id_material'] == vr_material){
                            let celda = "_"+ar_rpta[a]['id_elemen']+"_"+ar_rpta[a]['id_complem']+"_"+ar_rpta[a]['id_diametro'];
                            let idcelda = document.getElementById(celda);
                            idcelda.value = (ar_rpta[a].valor);
                        }
                    }
                }               
			}
        }
    })  
	//.done( function(msg){
		//console.log('mensaje:'+msg);
	//})    
}

function md_dato(obj_campo){  // modifica dato de la tabla con id _capo1_campo2_campo3
    console.log('Viene campo: '+obj_campo.id);
    console.log('con material:->'+idmaterial.value+'<-');
    if(vr_material == '' || vr_material.length == 0 || vr_material == null ){
        alert('No ha seleccionado el Material !!');
        inicio();    
    }
    let elemen = separa(obj_campo.id,"_",1);
    let complem = separa(obj_campo.id,"_",2);
    let diametr = separa(obj_campo.id,"_",3);
    console.log('Variables: Elemento:'+elemen+' complemento:'+complem+' diametro:'+diametr);
    console.log('Valor digitado:'+obj_campo.value);
    let valor = parseFloat(obj_campo.value);
    if(isNaN(valor)){
        alert('Valor:->'+valor+'<- '+obj_campo.value+' NO ES VALIDO !');
        obj_campo.value='';
        obj_campo.focus();
    }else{
        console.log('Valor correcto, se procesa');
        const $dato = {'material':vr_material,
                        'opcion':1,
                        'elemento':elemen,
                        'complemento':complem,
                        'diametro':diametr,
                        'valor':valor
               }
        $.ajax({
            async: true,
            data: $dato,
            type:'POST',
            dataType: 'json',
            url: '../ctr/ct_grcost_elem.php',
            beforeSend:function(){
      
            },
            success:function(rpta){
               //console.log('Sale:'+rpta); viene objeto
                if(rpta==1){
                    alert("Ok!");
                }else{
                    alert("Falló act !");
                }
            }
        })  
    }
}