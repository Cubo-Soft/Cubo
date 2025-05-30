let idmensaje = $("#idmensaje");
$(document).ready(function(){
    
})

function md_dato(obj_campo){  // modifica dato de la tabla con id _capo1_campo2_campo3
    console.log('Viene campo: '+obj_campo.id);
    /*if(vr_material == '' || vr_material.length == 0 || vr_material == null ){
        alert('No ha seleccionado el Material !!');
        inicio();    
    }*/
    let diametro = separa(obj_campo.id,"_",1);
    let aislamie = separa(obj_campo.id,"_",2);
    let id_vrais = separa(obj_campo.id,"_",3);
    console.log('Variables: diametro:'+diametro+' aislamiento:'+aislamie+' id:'+id_vrais);
    console.log('Valor digitado:'+obj_campo.value);
    let valor = parseFloat(obj_campo.value);
    if(isNaN(valor)){
        alert('Valor:->'+valor+'<- '+obj_campo.value+' NO ES VALIDO !');
        obj_campo.value='';
        obj_campo.focus();
    }else{
        console.log('Valor correcto, se procesa');
        const $dato = {'id':id_vrais,
                        'opcion':2,
                        'diametro':diametro,
                        'aislamiento':aislamie,
                        'valor':valor
               }
        $.ajax({
            async: true,
            data: $dato,
            type:'POST',
            dataType: 'json',
            url: '../ctr/ct_graislam_tb.php',
            beforeSend:function(){
      
            },
            success:function(rpta){
               console.log('Sale:'+JSON.parse(rpta)); //viene objeto
                if(rpta==1){
                    alert("Ok!");
                }else{
                    alert("Falló act !");
                }
            }
        })  
        .done( function(msg){
            //console.log('mensaje:'+msg);
        })           
    }
}