let idmensaje = $("#idmensaje");
$(document).ready(function(){
    
})

function md_dato(obj_campo){  // modifica dato de la tabla con id _capo1_campo2_campo3
    console.log('Viene campo: '+obj_campo.id);
    let complem  = separa(obj_campo.id,"_",1);
    let diametro = separa(obj_campo.id,"_",2);
    let id_vrins = separa(obj_campo.id,"_",3);
    console.log('Variables: complem:'+complem+' diametro: '+diametro+'  id:'+id_vrins);
    console.log('Valor digitado:'+obj_campo.value);
    let valor = parseFloat(obj_campo.value);
    if(isNaN(valor)){
        alert('Valor:->'+valor+'<- '+obj_campo.value+' NO ES VALIDO !');
        obj_campo.value='';
        obj_campo.focus();
    }else{
        console.log('Valor correcto, se procesa');
        const $dato = { 'id':id_vrins,
                        'opcion':'actinsvalv',
                        'complem':complem,
                        'diametro':diametro,
                        'valor':valor
                    }
        $.ajax({
            async: true,
            data: $dato,
            type:'POST',
            dataType: 'json',
            url: '../ctr/ct_grinst_valvulas.php',
            beforeSend:function(){
                console.log("Saliendo: "+$dato);
            },
            success:function(rpta){
               //console.log('Regresa:'+rpta); //viene objeto
                if(rpta=='1'){
                    alert("Ok!");
                }else{
                    alert("Falló act !");
                }
            }
        })  
    }
}