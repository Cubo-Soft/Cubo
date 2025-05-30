let idmensaje = $("#idmensaje");
let idconduleta = document.getElementById("id_conduleta");
let vr_conduleta = '';
//$(document).ready(function(){
$(function(){
})
    
function limpia(){
    console.log('Limpiando...');
    /* const $dato = {'material':vr_material,
                    'opcion':0}
    $.ajax({
        async: true,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_grcost_elem.php',
        beforeSend:function(){

        },
        success:function(rpta){
			//console.log('Sale en limpia:'+rpta); //viene objeto
            
			if(rpta==0){
				alert("Err !");
			}else{
        */        
                let elemen = $("#totelemen").val();
                let comple = $("#totcomplem").val();
                let diamet = $("#totdiametro").val();
                for($e=1;$e<=elemen;$e++){
                    for($c=1;$c<=comple;$c++){
                        for($d=1;$d<=diamet;$d++){
                            let nombreid = "_"+$e+"_"+$c+"_"+$d;
                            let idcelda = document.getElementById(nombreid);
                            //let idcelda = $("#"+nombreid);
                            idcelda.value = '';
                            console.log('Celda:'+nombreid);
                        }
                    }
                }
			//}
        //}
    //})  
}

function cambia(campo){  // lee dato elegido mediante select del objeto tabla
    let idcampo = document.getElementById(campo);
    //let idcampo = $("#"+campo);
    if( idcampo.id != idconduleta.id){
        console.log('Llamada desde campo diferente a Conduleta idcampo.id:'+idcampo.id);
        idconduleta.focus();    
    }
 
    //limpia();
    console.log('Viene id: '+idconduleta.id);
    console.log('Valor:'+idconduleta.value); // opcion de material seleccionada
    vr_conduleta = idconduleta.value;

    const $dato = {'conduleta':vr_conduleta,
                    'opcion':1}
    $.ajax({
        async: false,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_grcost_condule.php',
        //beforeSend:function(){
        //},
        success:function(rpta){
			//console.log('Sale en cambia:'+rpta); //viene objeto
			if(rpta==1){
				alert("Ok!");
			}else{
                if( Array.isArray(rpta) ){
                    ar_rpta = rpta;
                    for(let a=0; a< ar_rpta.length;a++){
                        if(ar_rpta[a]['id_conduleta'] == vr_conduleta){
                            let celda = "_"+ar_rpta[a]['id_elemen']+"_"+ar_rpta[a]['id_complem']+"_"+ar_rpta[a]['id_diametro'];
                            //let idcelda = $("#"+celda);
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
    console.log('con conduleta:->'+idconduleta.value+'<-');
    if(vr_conduleta == '' || vr_conduleta.length == 0 || vr_conduleta == null ){
        alert('No ha seleccionado la Conduleta !!');
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
        const $dato = {'conduleta':vr_conduleta,
                        'opcion':2,
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
            url: '../ctr/ct_grcost_condule.php',
            //beforeSend:function(){
            //},
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