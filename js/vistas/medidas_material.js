let idmensaje = $("#idmensaje");
let idmaterial = document.getElementById("id_material");
let vr_material = '';
$(document).ready(function(){
    
})

function limpia(){
    console.log('Limpiando...');
    let comple = $("#totcomplem").val();
    let medida = $("#totmedidas").val();
    //console.log('comple:'+comple+' medida:'+medida);
    for($c=1;$c<=comple;$c++){
        for($d=1;$d<=medida;$d++){
            let nombreid = "_"+$c+"_"+$d;
            let idcelda = document.getElementById(nombreid);
            idcelda.value = '';
        }
    }
}

function cambia(campo){  // lee dato elegido mediante select del objeto tabla
    let idcampo = document.getElementById(campo);
    if( idcampo.id != idmaterial.id){
        console.log('Llamada desde campo diferente al Material');
        idmaterial.focus();    
    }
 
    limpia();
    //console.log('Viene id: '+idmaterial.id);
    //console.log('Valor:'+idmaterial.value); // opcion de material seleccionada
    vr_material = idmaterial.value;

    const $dato = {'material':vr_material,
                    'opcion':1}
    $.ajax({
        async: true,
        data: $dato,
        type:'POST',
        dataType: 'json',
        url: '../ctr/ct_grmedi_material.php',
        beforeSend:function(){
            console.log('Enviando opcion:'+$dato.opcion);
        },
        success:function(rpta){
            if(rpta==1){
                alert("Ok!");
            }else{                
                if(rpta==1){
                    alert("Ok!");
                }else{
                    if( Array.isArray(rpta) ){
                        ar_rpta = rpta;
                        for(let a=0; a< ar_rpta.length;a++){
                            if(ar_rpta[a]['id_material'] == vr_material){
                                let idcelda = document.getElementById("_"+ar_rpta[a]['id_complem']+"_"+ar_rpta[a]['id_medida'])
                                idcelda.value = (ar_rpta[a].valor);
                            }
                        }
                    }               
                }
            }
        }
    })  
}

function md_dato(obj_campo){  // modifica dato de la tabla con id _campo1_campo2
    console.log('Viene campo: '+obj_campo.id);
    vr_material =  idmaterial.value;
    console.log('con material:-> '+vr_material+' <-');
    if(vr_material == '' || vr_material.length == 0 || vr_material == null ){
        alert('No ha seleccionado el Material !!');
        inicio();    
    }else{
        let complem = separa(obj_campo.id,"_",1);
        let medida  = separa(obj_campo.id,"_",2);
        console.log('Variables: complemento:'+complem+' medida:'+medida+" material:"+vr_material);
        console.log('Valor digitado:'+obj_campo.value);
        let valor = parseFloat(obj_campo.value);
        if(isNaN(valor)){
            alert('Valor:->'+valor+'<- '+obj_campo.value+' NO ES VALIDO !');
            obj_campo.value='';
            obj_campo.focus();
        }else{
            console.log('Valor correcto, se procesa');
            const $dato = {'material':vr_material,
                            'opcion':2,
                            'complemento':complem,
                            'medida':medida,
                            'valor':valor
                   }
            $.ajax({
                async: true,
                data: $dato,
                type:'POST',
                dataType: 'json',
                url: '../ctr/ct_grmedi_material.php',
                beforeSend:function(){
                    console.log('Enviando opcion:'+$dato.opcion);
                },
                success:function(rpta){
                    if(rpta==1){
                        alert("Ok!");
                    }else{
                        alert("Falló act !");
                    }
                }                 
            })  
        }    
    }
}